<?php

setlocale(LC_MONETARY, 'en_US');
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 1) {
        $tareas = new Tareas();
        $idSubcategoria = $_POST['idSubcategoria'];
        $resp = $tareas->insertarTarea($idSubcategoria);
        echo $resp;
    }

    if ($action == 2) {
        $idUsuario = $_POST['idUsuario'];
        $idTarea = $_POST['idTarea'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecI = $_POST['fecI'];
        $fecF = $_POST['fecF'];
        $tipo = $_POST['tipo'];
        $aImgU = $_POST['aImgU'];
        $aImgS = ""; //json_decode($_POST['aImgS']);
        $cap = $_POST['cap'];
        $numHab = $_POST['numHab'];
        $mc = $_POST['mc'];
        $equipos = json_decode($_POST['equipos']);
        $empresa = $_POST['empresa'];
        $coste = $_POST['coste'];
        $objT = new Tareas();
        $resp = $objT->crearTarea($idTarea, $titulo, $descripcion, $fecI, $fecF, $idUsuario, $aImgU, $aImgS, $idDestino, $idSeccion, $tipo, $cap, $numHab, $mc, $equipos, $empresa, $coste);
        echo $resp;
    }

    if ($action == 3) {
        $idTarea = $_POST['idTarea'];
        $objTareas = new Tareas();
        $resp = $objTareas->borarTareaVacia($idTarea);
        echo $resp;
    }

    if ($action == 4) {
        $idTarea = $_POST['idTarea'];
        if (isset($_POST['idSubtarea'])) {
            $idSubtarea = $_POST['idSubtarea'];
        } else {
            $idSubtarea = 0;
        }
        $idUsuario = $_POST['idUsuario'];
        $comentario = $_POST['comentario'];
        $objTarea = new Tareas();
        $resp = $objTarea->insertarComentario($idTarea, $idSubtarea, $idUsuario, $comentario);
        echo $resp;
    }

    //Actualiza la caja de comentarios
    if ($action == 5) {
        $idTarea = $_POST['idTarea'];
        $pagina = $_POST['pagina'];
        if ($_POST['idSubtarea'] != "0") {
            $idSubtarea = $_POST['idSubtarea'];
        } else {
            $idSubtarea = 0;
        }
        $objTarea = new Tareas();
        $resp = $objTarea->actualizarCajaComentarios($idTarea, $pagina, $idSubtarea);
        echo $resp;
    }

    if ($action == 6) {
        $idTarea = $_POST['idTarea'];
        $planaccion = $_POST['planaccion'];
//        $duracion = $_POST['duracion'];
//        $fechaL = $_POST['fechaL'];
//        $aImgU = json_decode($_POST['aImgU']);
        $idUsuario = $_POST['idUsuario'];
        if (isset($_POST['empresaE'])) {
            $empresaE = $_POST['empresaE'];
        } else {
            $empresaE = 0;
        }
        $obj = new Tareas();
        $resp = $obj->insertarSubtarea($idTarea, $planaccion, $idUsuario);
        echo $resp;
    }

    if ($action == 7) {
        $idTarea = $_POST['idTarea'];
        $pagina = $_POST['pagina'];
        $objTarea = new Tareas();
        $resp = $objTarea->actualizarCajaSubtareas($idTarea, $pagina);
        echo $resp;
    }

    if ($action == 8) {
        $idSubtarea = $_POST['idSubtarea'];
        $status = $_POST['status'];
        $obj = new Tareas();
        $resp = $obj->completarSubtarea($idSubtarea, $status);
        echo $resp;
    }

    if ($action == 12) {
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];
        $idUsuario = $_POST['idUsuario'];
        $obj = new Tareas();
        $resp = $obj->accesoTablero($idDestino, $idSeccion, $idUsuario);
        echo $resp;
    }

    if ($action == 13) {
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];
        $status = $_POST['statusTask'];
        $word = $_POST['word'];
        $obj = new Tareas();
        $resp = $obj->buscarTareasPorPalabra($word, $idSeccion, $idDestino, $status);
        echo $resp;
    }

    if ($action == 14) {
        $idSeccion = $_POST['idSeccion'];
        $idGrupo = $_POST['idGrupo'];
        $obj = new Tareas();
        $resp = $obj->obtEquipoxGrupo($idGrupo, $idSeccion);
        echo $resp;
    }

    if ($action == 23) {
        $idSubtarea = $_POST['idSubtarea'];
        $evento = $_POST['evento'];
        $obj = new Tareas();
        $subtarea = $_POST['titulo'];
        $fechaL = $_POST['fechaLimite'];
        switch ($evento) {
            case 'delete':
                $resp = $obj->eliminarSubtarea($idSubtarea);
                break;
            case 'update':
                $resp = $obj->actualizarSubtarea($idSubtarea, $subtarea, $fechaL);
                break;
        }
        echo $resp;
    }

    if ($action == 24) {
        $idSubtarea = $_POST['idSubtarea'];
        $obj = new Tareas();
        $resp = $obj->obtenerSubtarea($idSubtarea);
        echo json_encode($resp);
    }

    if ($action == 26) {
        $idDestino = $_POST['idDestino'];
        $idTarea = $_POST['idTarea'];
        $pagina = $_POST['pagina'];
        $modal = $_POST['modal'];
        $obj = new Tareas();
        $resp = $obj->getUserByDestiny($idDestino, $idTarea, $pagina, $modal);
        echo $resp;
    }

    if ($action == 31) {
        $idTarea = $_POST['idTarea'];
        $columnaDestino = $_POST['columnaDestino'];
        $destino = $_POST['destino'];
        $obj = new Tareas();
        $resp = $obj->copiarTarea($idTarea, $columnaDestino, $destino);
        echo $resp;
    }

    if ($action == 32) {
        $idTarea = $_POST['idTarea'];
        $obj = new Tareas();
        $resp = $obj->eliminarTarea($idTarea);
        echo $resp;
    }

    if ($action == 34) {
        $idDestino = $_POST['idDestino'];

        $obj = new Tareas();
        $resp = $obj->crearTableros($idDestino);
        echo $resp;
    }

    if ($action == 37) {
        $idSubcategoria = $_POST['idSubcategoria'];
        $idSeccion = $_POST['idSeccion'];
        $obj = new Tareas();
        $resp = $obj->cargarHabitaciones($idSubcategoria, $idSeccion);
        echo $resp;
    }

    if ($action == 38) {
        $tipo = $_POST['tipo'];
        $idDestino = $_POST['idDestino'];
        $idUsuario = $_POST['idUsuario'];
        $obj = new Tareas();
        $resp = $obj->obtMisTareas($tipo, $idDestino, $idUsuario);
        echo $resp;
    }

    if ($action == 39) {
        $idTarea = $_POST['idTarea'];
        $seccion = $_POST['seccion'];
        $tareas = new Tareas();
        $resp = $tareas->cambiarSeccion($idTarea, $seccion);
        echo $resp;
    }

    if ($action == 41) {
        $idTarea = $_POST['idTarea'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $obj = new Tareas();
        $resp = $obj->cambiarSubcategoria($idTarea, $idSubcategoria);
        echo $resp;
    }

    if ($action == 42) {
        $idUsuario = $_POST['idUsuario'];
        $idSecciones = $_POST['idSeccion'];
        $tipo = $_POST['tipo'];
        $idPermiso = $_POST['idPermiso'];
        $obj = new Tareas();
        $resp = $obj->showHideCols($idSecciones, $idUsuario);
        $resp = $obj->recargarCols($idPermiso, $idUsuario, $tipo);
        echo $resp;
    }

    if ($action == 43) {
        $idTarea = $_POST['idTarea'];
        $pagina = $_POST['pagina'];
        $obj = new Tareas();
        $resp = $obj->obtDetalleTarea($idTarea, $pagina);
        echo json_encode($resp);
    }

    if ($action == 44) {
        $idTarea = $_POST['idTarea'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $obj = new Tareas();
        $resp = $obj->actualizarTarea($idTarea, $titulo, $descripcion);
        echo $resp;
    }

    if ($action == 45) {
        $idTarea = $_POST['idTarea'];
        $tipo = $_POST['tipo'];
        $tareas = new Tareas();
        $resp = $tareas->cambiarTipo($idTarea, $tipo);
        echo $resp;
    }

    if ($action == 46) {
        $idTarea = $_POST['idTarea'];
        $col = $_POST['col'];
        $tareas = new Tareas();
        $resp = $tareas->cambiarCol($idTarea, $col);
        echo $resp;
    }

    if ($action == 47) {
        $idTarea = $_POST['idTarea'];
        $idUsuario = $_POST['idUsuario'];
        $pagina = $_POST['pagina'];
        $modal = $_POST['modal'];
        $resp = $_POST['resp']; //Responsable 1 o 2
        $obj = new Tareas();
        $resp = $obj->actualizarResponsable($idTarea, $idUsuario, $pagina, $modal, $resp);
        echo $resp;
    }

    if ($action == 48) {
        $idTarea = $_POST['idTarea'];
        $tipoFec = $_POST['tipoFec'];
        $fecha = $_POST['fecha'];
        $obj = new Tareas();
        $resp = $obj->cambiarFecha($idTarea, $tipoFec, $fecha);
        echo $resp;
    }

    if ($action == 49) {
        $idTarea = $_POST['idTarea'];
        $estado = $_POST['estado'];
        $obj = new Tareas();
        $resp = $obj->cambiarEstado($idTarea, $estado);
        echo $resp;
    }

    if ($action == 50) {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $obj = new Tareas();
        $resp = $obj->obtUserSeccion($idDestino, $idSeccion);
        echo $resp;
    }

    if ($action == 51) {
        $idSP = $_POST['idSP'];
        $obj = new Tareas();
        $resp = $obj->obtUserSP($idSP);
        echo json_encode($resp);
    }

    if ($action == 52) {
        $idSP = $_POST['idSP'];
        $obj = new Tareas();
        $resp = $obj->removerPermitido($idSP);
        echo $resp;
    }

    if ($action == 53) {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $obj = new Tareas();
        $resp = $obj->obtPermitidosDestino($idDestino, $idSeccion);
        echo $resp;
    }

    if ($action == 54) {
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];
        $obj = new Tareas();
        $resp = $obj->obtenerPlanAccion($idSeccion, $idDestino);
        echo $resp;
    }

    if ($action == 55) {
        $idTarea = $_POST['idTarea'];
        $pagina = $_POST['pagina'];
        $idSubtarea = $_POST['idSubtarea'];
        $obj = new Tareas();
        $resp = $obj->obtenerAdjuntosTarea($idTarea, $idSubtarea, $pagina);
        echo $resp;
    }

    if ($action == 56) {
        $idDestino = $_POST['idDestino'];
        $obj = new Tareas();
        $resp = $obj->obtUsuariosPorDestino($idDestino);
        echo $resp;
    }

    if ($action == 57) {
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];
        $status = $_POST['status'];

        $obj = new Tareas();
        $resp = $obj->showColsPendFin($idSeccion, $idDestino, $status);
        echo $resp;
    }

    if ($action == 58) {
        $idTarea = $_POST['idTarea'];
        $año = $_POST['año'];
        $total = $_POST['total'];
        $obj = new Tareas();
        $resp = $obj->actualizarTareaCap($idTarea, $año, $total);
        echo $resp;
    }
}

Class Tarea {

    public $id;
    public $titulo;
    public $descripcion;
    public $tipo;
    public $idSeccion;
    public $logoSeccion;
    public $idSubcategoria;
    public $status;
    public $fechaI;
    public $fechaF;
    public $responsable;
    public $responsable2;
    public $comentarios;
    public $adjuntos;
    public $planAccion;
    public $habitacion;
    public $numHabitacion;
    public $tipoCap;
    public $año;
    public $total;
    public $mc;
    public $empresaEx;
    public $costeMC;
    public $equiposMC;
    public $listaSubcategorias;
    public $idDestinoCreador;
    public $creador;

}

Class UsuarioSP {

    public $idSP;
    public $nombre;
    public $seccion;

}

Class Subtarea {

    public $id;
    public $idTarea;
    public $subtarea;
    public $duracion;
    public $status;
    public $responsable;
    public $fecCreacion;
    public $fecLimite;
    public $reprogramado;
    public $fecReprogramado;
    public $reprogramadoPor;

}

Class Tareas {

    public function actualizarTarea($idTarea, $titulo, $descripcion) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM t_tareas WHERE id = $idTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $tipoTarea = $dts['tipo'];
                    $tituloTarea = $dts['titulo'];
                    $tituloProyecto = $dts['titulo_proyecto'];
                }
                if ($tipoTarea == 1 || $tipoTarea == 3) {
                    $query = "UPDATE t_tareas SET titulo = '$titulo', descripcion = '$descripcion' WHERE id = $idTarea";
                } else {
                    $query = "UPDATE t_tareas SET titulo_proyecto = '$titulo', descripcion = '$descripcion' WHERE id = $idTarea";
                }
                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function actualizarTareaCap($idTarea, $año, $total) {
        $conn = new Conexion();
        $conn->conectar();
        $totalCAP = explode("$", $total);
        if (count($totalCAP) > 1) {
            $totalCAP = str_replace(',', '', $totalCAP[1]);
        } else {
            $totalCAP = str_replace(',', '', $totalCAP[0]);
        }
        $pptoFinal = number_format($totalCAP, 2, '.', '');

        $query = "UPDATE t_tareas SET año_proyecto = '$año', total = $pptoFinal WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function accesoTablero($idDestino, $idSeccion, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();


        $query = "INSERT INTO t_tareas_secciones_permitidos(id_destino, id_seccion, id_usuario) "
                . "VALUES($idDestino, $idSeccion, $idUsuario)";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $conn->cerrar();
        return $resp;
    }

    public function obtUserSP($idSP) {
        $conn = new Conexion();
        $conn->conectar();
        $usuarioSP = new UsuarioSP();
        $query = "SELECT * FROM t_tareas_secciones_permitidos WHERE id = $idSP";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $usuarioSP->idSP = $dts['id'];
                    $idSeccion = $dts['id_seccion'];
                    $idUser = $dts['id_usuario'];

                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $usuarioSP->seccion = $dts['seccion'];
                            }
                        }
                    } catch (Exception $ex) {
                        $resp = $ex;
                    }
                    $query = "SELECT * FROM t_users WHERE id = $idUser";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id_colaborador'];

//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre = $dts['nombre'];
                                            $apellido = $dts['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $resp = $ex;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $resp = $ex;
                    }
                    $usuarioSP->nombre = $nombre . " " . $apellido;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $usuarioSP;
    }

    public function removerPermitido($idSP) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "DELETE FROM t_tareas_secciones_permitidos WHERE id = $idSP";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    public function insertarTarea($subcategoria) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "INSERT INTO t_tareas(subcategoria, status, activo) VALUES($subcategoria, 'N', 0)";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $query = "SELECT LAST_INSERT_ID(id) AS LAST FROM t_tareas ORDER BY id DESC LIMIT 0,1";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['LAST'];
                }
                $resp = $id;
            } else {
                $resp = "-1";
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    public function crearTarea($idTarea, $titulo, $descripcion, $fechaI, $fechaF, $usuario, $aImgU, $aImgS, $idDestino, $idSeccion, $tipo, $cap, $numHab, $mc, $equipos, $empresa, $coste) {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');
        $fecI = date("Y-m-d H:i:s", strtotime($fechaI));
        $fecF = date("Y-m-d H:i:s", strtotime($fechaF));
        $now = date("Y-m-d H:i:s");

        if ($numHab != 0) {
            $habitacion = "SI";
        } else {
            $habitacion = "NO";
        }

        if ($tipo == 1 || $tipo == 3) {
            $query = "UPDATE t_tareas SET titulo = '$titulo', status='N', tipo = $tipo, fecha_i = '$fecI', fecha_f = '$fecF', "
                    . "descripcion = '$descripcion', creado = '$usuario', fecha_creacion = '$now', activo = 1, "
                    . "id_destino = $idDestino, id_seccion = $idSeccion, habitacion = '$habitacion', idNumHab = $numHab, "
                    . "mc = '$mc', empresa_externa = $empresa, coste_mc = '$coste' WHERE id = $idTarea";
        } else {
            if ($cap == "capex") {
                $query = "UPDATE t_tareas SET titulo_proyecto = '$titulo', status='N', tipo = $tipo, fecha_i = '$fecI', fecha_f = '$fecF', "
                        . "descripcion = '$descripcion', creado = '$usuario', fecha_creacion = '$now', "
                        . "capex = 'SI', activo = 1, id_destino = $idDestino, id_seccion = $idSeccion, habitacion = '$habitacion', "
                        . "idNumHab = $numHab, mc = '$mc', empresa_externa = $empresa, coste_mc = '$coste' WHERE id = $idTarea";
            } else if ($cap == "capin") {
                $query = "UPDATE t_tareas SET titulo_proyecto = '$titulo', status='N', tipo = $tipo, fecha_i = '$fecI', fecha_f = '$fecF', "
                        . "descripcion = '$descripcion', creado = '$usuario', fecha_creacion = '$now', "
                        . "capin = 'SI', activo = 1, id_destino = $idDestino, id_seccion = $idSeccion, "
                        . "habitacion = '$habitacion', idNumHab = $numHab, mc = '$mc', empresa_externa = $empresa, coste_mc = '$coste' WHERE id = $idTarea";
            } else {
                $query = "UPDATE t_tareas SET titulo_proyecto = '$titulo', status='N', tipo = $tipo, fecha_i = '$fecI', fecha_f = '$fecF', "
                        . "descripcion = '$descripcion', creado = '$usuario', fecha_creacion = '$now', "
                        . "activo = 1, id_destino = $idDestino, id_seccion = $idSeccion, "
                        . "habitacion = '$habitacion', idNumHab = $numHab, mc = '$mc', empresa_externa = $empresa, coste_mc = '$coste' WHERE id = $idTarea";
            }
        }


        try {
            $resp = $conn->consulta($query);
            //Insertar asignaciones

            $query = "INSERT INTO t_tareas_asignaciones(id_tarea, id_usuario)"
                    . "VALUES($idTarea, $aImgU)";
            try {
                $resp = $conn->consulta($query);
            } catch (Exception $ex) {
                $resp = $ex;
            }
            $query = "UPDATE t_tareas SET responsable = $aImgU WHERE id = $idTarea";
            try {
                $resp = $conn->consulta($query);
            } catch (Exception $ex) {
                $resp = $ex;
            }

            if ($mc == "SI") {
                for ($i = 0; $i < count($equipos); $i++) {
                    $query = "INSERT INTO t_tareas_mc_equipos(id_tarea, id_equipo)"
                            . "VALUES($idTarea, $equipos[$i])";
                    try {
                        $resp = $conn->consulta($query);
                    } catch (Exception $ex) {
                        $resp = $ex;
                    }
                }
            }

            $query = "INSERT INTO t_notificaciones(fecha, status, action, id_usuario, id_destino, id_seccion, id_tarea)"
                    . "VALUES('$now', 'N', 'Tarea creada', $usuario, $idDestino, $idSeccion, $idTarea)";
            try {
                $resp = $conn->consulta($query);
            } catch (Exception $ex) {
                $resp = $ex;
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    public function borarTareaVacia($idTarea) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "DELETE FROM t_tareas WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtDetalleTarea($idTarea, $pagina) {
        $tarea = new Tarea();
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_tareas WHERE id = $idTarea";
        try {
            $tareas = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tareas as $dts) {
                    $tarea->id = $dts['id'];
                    if ($dts['tipo'] != 2) {
                        $tarea->titulo = $dts['titulo'];
                    } else {
                        $tarea->titulo = $dts['titulo_proyecto'];
                    }
                    $tarea->descripcion .= $dts['descripcion'];
                    $idCreador = $dts['creado'];
                    $tarea->tipo = $dts['tipo'];
                    $tarea->idSubcategoria = $dts['subcategoria'];
                    $tarea->fechaI = $dts['fecha_i'];
                    $tarea->fechaF = $dts['fecha_f'];
                    $responsable = $dts['responsable'];
                    $responsable2 = $dts['responsable2'];
                    $tarea->status = $dts['status'];
                    $tarea->habitacion = $dts['habitacion'];
                    $idHab = $dts['idNumHab'];
                    $capex = $dts['capex'];
                    $capin = $dts['capin'];
                    $tarea->año = $dts['año_proyecto'];
                    $tarea->mc = $dts['mc'];
                    $tarea->idSeccion = $dts['id_seccion'];
                    $idSeccion = $dts['id_seccion'];


                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $seccion) {
                                $imgSeccion = $seccion['url_image'];
                            }
                        }
                        $tarea->logoSeccion = $imgSeccion;
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }

                    $query = "SELECT * FROM t_users WHERE id = $idCreador";
                    try {
                        $datoUsuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($datoUsuario as $u) {
                                $idDestinoCreador = $u['id_destino'];
                                $idEmpleado = $u['id_colaborador'];
                            }
                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                            try {
                                $empleado = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($empleado as $u) {
                                        $nombreEmpleado = $u['nombre'];
                                        $apellidoEmpleado = $u['apellido'];
                                    }
                                } else {
                                    $nombreEmpleado = "";
                                    $apellidoEmpleado = "";
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                            }
                        } else {
                            $nombreEmpleado = "";
                            $apellidoEmpleado = "";
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }
                    $tarea->idDestinoCreador = $idDestinoCreador;
                    $tarea->creador = "$nombreEmpleado $apellidoEmpleado";

                    $query = "SELECT * FROM c_grupos WHERE id_seccion = $idSeccion";
                    try {
                        $grupos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($grupos as $campo) {
                                $idGrupo = $campo['id'];
                                $grupo = $campo['grupo'];

                                $tarea->listaSubcategorias .= "<option value=\"$idGrupo\">$grupo</option>";
                            }
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }

                    if ($dts['total'] != "") {
                        $total = $dts['total'];
                        $tarea->total = money_format("%.2n", $total);
                    } else {
                        $tarea->total = "";
                    }

                    if ($tarea->habitacion == "SI") {
                        $query = "SELECT * FROM c_ubicaciones_entregas WHERE id = $idHab";
                        try {
                            $hab = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($hab as $dts) {
                                    $numHab = $dts['ubicacion'];
                                    $tarea->numHabitacion .= "<strong>Habitacion: $numHab</strong> ";
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                        }
                    }

                    if ($tarea->mc == "SI") {
                        $idEmpresa = $dts['empresa_externa'];
                        if ($idEmpresa != 0) {
                            $query = "SELECT * FROM c_empresas WHERE id = $idEmpresa";
                            try {
                                $resp1 = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp1 as $dtsEmp) {
                                        $tarea->empresaEx = $dtsEmp['empresa'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                            }
                            $tarea->costeMC = $dts['coste_mc'];
                        }

                        $query = "SELECT * FROM t_tareas_mc_equipos WHERE id_tarea = $idTarea";
                        try {
                            $result = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($result as $dtsEqMC) {
                                    $idEquipo = $dtsEqMC['id_equipo'];
                                    $query = "SELECT * FROM t_equipos WHERE id = $idEquipo";
                                    try {
                                        $r = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($r as $dtsEq) {
                                                $equipo = $dtsEq['equipo'];
                                                $tarea->equiposMC .= "<div class=\"row\">"
                                                        . "<div class=\"col-12\">"
                                                        . "<h1 class=\"fs-11 display-1 text-uppercase\">$equipo</h1>"
                                                        . "</div>"
                                                        . "</div>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        $tarea = $ex;
                                    }
                                }
                            }
                        } catch (Exception $ex) {
                            $tarea = $ex;
                        }
                    }

                    $query = "SELECT * FROM t_users WHERE id = $responsable";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre = $dts['nombre'];
                                            $apellido = $dts['apellido'];
                                            $foto = $dts['foto'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $tarea = $ex;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }


                    if ($pagina == 0) {
                        if ($foto == "") {
                            $tarea->responsable = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                        } else {
                            $tarea->responsable = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"img/users/$foto\">";
                        }
                    } else {
                        if ($foto == "") {
                            $tarea->responsable = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                        } else {
                            $tarea->responsable = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"../img/users/$foto\">";
                        }
                    }

                    //REsponsable 2
                    $query = "SELECT * FROM t_users WHERE id = $responsable2";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador2 = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador2";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre2 = $dts['nombre'];
                                            $apellido2 = $dts['apellido'];
                                            $foto2 = $dts['foto'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $tarea = $ex;
                                }
                            }
                        } else {
                            $nombre2 = "";
                            $apellido2 = "";
                            $foto2 = "";
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }

                    if ($pagina == 0) {
                        if ($foto2 == "") {
                            $tarea->responsable2 = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre2 $apellido2\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre2+$apellido2&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                        } else {
                            $tarea->responsable2 = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre2 $apellido2\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"img/users/$foto2\">";
                        }
                    } else {
                        if ($foto2 == "") {
                            $tarea->responsable2 = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre2 $apellido2\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre2+$apellido2&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                        } else {
                            $tarea->responsable2 = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre2 $apellido2\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"../img/users/$foto2\">";
                        }
                    }

                    $query = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                    try {
                        $coments = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($coments as $dts) {
                                $idComent = $dts['id'];
                                $idUserComent = $dts['id_usuario'];
                                $fechaComent = $dts['fecha'];
                                $comentario = $dts['comentario'];

                                $query = "SELECT * FROM t_users WHERE id = $idUserComent";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $nombre = $dts['nombre'];
                                                        $apellido = $dts['apellido'];
                                                        $idCargo = $dts['id_cargo'];
                                                        $foto = $dts['foto'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $tarea = $ex;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $tarea = $ex;
                                }

                                $tarea->comentarios .= "<div class=\"row justify-content-center rounded-3\">"
                                        . "<div class=\"col-11 my-1 px-1\" >"
                                        . "<div class=\"media\">";
//                                if ($pagina == 0) {
//                                    $tarea->comentarios .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                } else {
//                                    $tarea->comentarios .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"../img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                }

                                if ($idCargo == 51) {
                                    $tarea->comentarios .= "<div class=\"media-body bg-rojoc rounded py-2 px-2 shadow-sm\" >";
                                } else {
                                    $tarea->comentarios .= "<div class=\"media-body bg-white border-normal rounded py-2 px-2 shadow-sm\" >";
                                }


                                $tarea->comentarios .= "<h5 class=\"my-0 fs-10 spdisplaybold text-negron\">$nombre $apellido: </h5>"
                                        . "<h5 class=\"fs-10 mt-1 spdisplayregular text-negron\">$comentario</h5>"
                                        . "<h5 class=\"fs-8 mt-1 spdisplaybold text-negron text-right mb-0 pb-0\">$fechaComent</h5>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }

                    $query = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                    try {
                        $adjuntos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($adjuntos as $dts) {
                                $documento = $dts['url_doc'];

                                if ($documento != "") {
                                    $url = "";
                                    $info = new SplFileInfo($documento);
                                    $ext = $info->getExtension();
                                    switch ($ext) {
                                        case 'docx':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
                                        case 'DOCX':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
                                        case 'pdf':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/pdf.svg";
                                            } else {
                                                $url = "../svg/formatos/pdf.svg";
                                            }
                                            break;
                                        case 'PDF':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/pdf.svg";
                                            } else {
                                                $url = "../svg/formatos/pdf.svg";
                                            }
                                            break;
                                        case 'jpg':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'JPG':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'jpeg':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'JPEG':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'svg':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'SVG':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'xlsx':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/xls.svg";
                                            } else {
                                                $url = "../svg/formatos/xls.svg";
                                            }
                                            break;
                                        case 'XLSX':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/xls.svg";
                                            } else {
                                                $url = "../svg/formatos/xls.svg";
                                            }
                                            break;
                                        case 'csv':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/xls.svg";
                                            } else {
                                                $url = "../svg/formatos/xls.svg";
                                            }
                                            break;
                                        case 'CSV':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/xls.svg";
                                            } else {
                                                $url = "../svg/formatos/xls.svg";
                                            }
                                            break;
                                        case 'pptx':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/ppt.svg";
                                            } else {
                                                $url = "../svg/formatos/ppt.svg";
                                            }
                                            break;
                                        case 'PPTX':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/ppt.svg";
                                            } else {
                                                $url = "../svg/formatos/ppt.svg";
                                            }
                                            break;
                                        case 'msg':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/txt.svg";
                                            } else {
                                                $url = "../svg/formatos/txt.svg";
                                            }
                                            break;
                                        case 'MSG':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/txt.svg";
                                            } else {
                                                $url = "../svg/formatos/txt.svg";
                                            }
                                            break;
                                        case 'png':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'PNG':
                                            if ($pagina == 0) {
                                                $url = "tareas/adjuntos/$documento";
                                            } else {
                                                $url = "../tareas/adjuntos/$documento";
                                            }
                                            break;
                                        case 'rar':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/zip.svg";
                                            } else {
                                                $url = "../svg/formatos/zip.svg";
                                            }
                                            break;
                                        case 'RAR':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/zip.svg";
                                            } else {
                                                $url = "../svg/formatos/zip.svg";
                                            }
                                        case 'zip':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/zip.svg";
                                            } else {
                                                $url = "../svg/formatos/zip.svg";
                                            }
                                            break;
                                        case 'ZIP':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/zip.svg";
                                            } else {
                                                $url = "../svg/formatos/zip.svg";
                                            }
                                            break;
                                        case 'DWG':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/zip.svg";
                                            } else {
                                                $url = "../svg/formatos/zip.svg";
                                            }
                                            break;
                                        case 'dwg':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/dwg.svg";
                                            } else {
                                                $url = "../svg/formatos/dwg.svg";
                                            }
                                            break;
                                        case 'Isc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/isc.png";
                                            } else {
                                                $url = "../svg/formatos/isc.png";
                                            }
                                            break;
                                        case 'isc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/isc.png";
                                            } else {
                                                $url = "../svg/formatos/isc.png";
                                            }
                                            break;
                                        case 'lsc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/isc.png";
                                            } else {
                                                $url = "../svg/formatos/isc.png";
                                            }
                                            break;
                                    }

//                                $tarea->adjuntos .= $ext;
                                    if ($pagina == 0) {
                                        $href = "tareas/adjuntos/$documento";
                                    } else {
                                        $href = "../tareas/adjuntos/$documento";
                                    }

                                    $tarea->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 text-center\">"
                                            . "<a href=\"$href\" target=\"_blank\" class=\"justify-content-center\">"
                                            . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                            . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$documento\">$documento</p>"
                                            . "</a>"
                                            . "</div>";
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }

                    if ($capin == "SI" || $capex == "SI") {
                        $query = "SELECT * FROM t_tareas_cap_adjuntos WHERE id_tarea = $idTarea";
                        if ($capex == "SI") {
                            $tarea->tipoCap = "capex";
                        }
                        if ($capin == "SI") {
                            $tarea->tipoCap = "capin";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                $contador = 0;
                                foreach ($resp as $dts) {
                                    $contador++;
                                    $tipoCap = $dts['tipo'];
                                    $coste1 = $dts['costo1'];
                                    $urlCot1 = $dts['url_doc1'];
                                    $coste2 = $dts['costo2'];
                                    $urlCot2 = $dts['url_doc2'];
                                    $coste3 = $dts['costo3'];
                                    $urlCot3 = $dts['url_doc3'];

                                    if ($pagina == 0) {
                                        $path1 = "tareas/$tipoCap/$urlCot1";
                                        $path2 = "tareas/$tipoCap/$urlCot2";
                                        $path3 = "tareas/$tipoCap/$urlCot3";
                                        $url1 = "svg/cap/COT-01.svg";
                                        $url2 = "svg/cap/COT-02.svg";
                                        $url3 = "svg/cap/COT-03.svg";
                                    } else {
                                        $path1 = "../tareas/$tipoCap/$urlCot1";
                                        $path2 = "../tareas/$tipoCap/$urlCot2";
                                        $path3 = "../tareas/$tipoCap/$urlCot3";
                                        $url1 = "../svg/cap/COT-01.svg";
                                        $url2 = "../svg/cap/COT-02.svg";
                                        $url3 = "../svg/cap/COT-03.svg";
                                    }

                                    if ($urlCot1 != "") {
                                        $tarea->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 rounded text-center\">"
                                                . "<a href=\"$path1\" target=\"_blank\" class=\"justify-content-center\">"
                                                . "<img src=\"$url1\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot1\">$urlCot1</p>"
                                                . "</a>"
                                                . "</div>";
                                    }
                                    if ($urlCot2 != "") {
                                        $tarea->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 rounded text-center\">"
                                                . "<a href=\"$path2\" target=\"_blank\" class=\"justify-content-center\">"
                                                . "<img src=\"$url2\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot2\">$urlCot2</p>"
                                                . "</a>"
                                                . "</div>";
                                    }

                                    if ($urlCot3 != "") {
                                        $tarea->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 rounded text-center\">"
                                                . "<a href=\"$path3\" target=\"_blank\" class=\"justify-content-center\">"
                                                . "<img src=\"$url3\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot3\">$urlCot3</p>"
                                                . "</a>"
                                                . "</div>";
                                    }
                                }
                            }
                        } catch (Exception $ex) {
                            $tarea = $ex;
                        }
                    }

                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                    try {
                        $accion = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($accion as $dts) {
                                $idAccion = $dts['id'];
                                $tituloAccion = $dts['subtarea'];
                                $responsableAccion = $dts['responsable'];
                                $statusAccion = $dts['status'];
                                $fechaLimite = date('m-d-Y', strtotime($dts['fecha_limite']));

                                $query = "SELECT * FROM t_users WHERE id = $responsableAccion";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $nombre = $dts['nombre'];
                                                        $apellido = $dts['apellido'];
                                                        $foto = $dts['foto'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $tarea = $ex;
                                            }
                                        }
                                    } else {
                                        $nombre = "No";
                                        $apellido = "Asignado";
                                        $foto = "advertencia2.svg";
                                    }
                                } catch (Exception $ex) {
                                    $tarea = $ex;
                                }
// plan de accion
                                $tarea->planAccion .= "<div class=\"row pda rounded-3 spdisplaysemibold fs-10 text-uppercase justify-content-center\">"
                                        . "<div class=\"col-12\">"
                                        . "<div class=\"row pb-1 mb-1 mx-1\">"
                                        . "<div class=\"col-8 col-md-10 col-lg-10\">"
                                        . "<div class=\"row\">"
                                        . "<div class=\"col-10 col-md-11\">"
                                        . "<div class=\"custom-control custom-checkbox checklist mt-2\">";
                                if ($statusAccion == "F") {
                                    $tarea->planAccion .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
                                } else {
                                    $tarea->planAccion .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
                                }

                                $tarea->planAccion .= "<label class=\"custom-control-label fs-11 checklist pt-1\" for=\"chkb_$idAccion\">$tituloAccion</label>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "<div class=\"col-2 col-md-1 col-lg-1 text-center\">"
                                        . "<a href=\"#\" class=\"rounded-circle btn2 \" data-toggle=\"\" data-placement=\"top\" title=\"Responsable: $nombre $apellido\">";
                                if ($pagina == 0) {
                                    if ($foto == "advertencia.svg") {
                                        $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                    } else {
                                        if ($foto == "") {
                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                        } else {
                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                        }
                                    }
                                } else {
                                    if ($foto == "advertencia.svg") {
                                        $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                    } else {
                                        if ($foto == "") {
                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                        } else {
                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                                        }
                                    }
                                }

//                                        $tarea->planAccion .= "<img class=\"rounded-circle img-fluid\" width=\"40px\" src=\"https://picsum.photos/id/870/300/300?grayscale&blur=2\">";

                                if ($pagina == 1) {
                                    $more = "../svg/more.svg";
                                } else {
                                    $more = "svg/more.svg";
                                }
                                $tarea->planAccion .= "</a></div>"
                                        . "<div class=\"col-2 col-md-1 col-lg-1  text-left px-0\">"
                                        . "<img class=\"rounded-circle img-fluid text-left mt-3\" width=\"10px\" src=\"$more\" data-toggle=\"collapse\" data-target=\"#collapse_$idAccion\" aria-expanded=\"false\" aria-controls=\"collapseExample\" onclick=\"obtenerComentariosSubtarea($idTarea, $pagina, $idAccion);\">"
                                        . "</div>"
                                        . "<div class=\"col-12\">"
                                        . "<div class=\"collapse\" id=\"collapse_$idAccion\" data-parent=\"#planAccion\">"
                                        . "<div class=\"card card-body border-0 bg-white\">"
                                        . "<div class=\"row justify-content-center\">"
                                        . "<div class=\"col-12 col-md-12 col-lg-9\">"
                                        . "<input id=\"txtComentarioST$idAccion\" type=\"text\" class=\"form-control form-control-sm border-0 fs-10\" placeholder=\"Escriba aqui sus comentarios, al terminar presione ENTER\" onkeypress=\"agregarComentarioST($pagina, $idTarea, $idAccion, " . $_SESSION["usuario"] . ");\">"
                                        . "</div>"
                                        . "<div class=\"col-12 col-md-4 col-lg-1 mt-2\">"
                                        . "<div class=\"btn-group btn-block\" role=\"group\" >"
                                        . "<div class=\"upload-btn-wrapper\"><button class=\"btn btn-sm bg-body text-negron fs-10\">Adjuntar</button><input type=\"file\" id=\"tareaDoc$idAccion\" name=\"tareaDoc$idAccion\" onchange=\"tarea_subir_doc(1, $idTarea, $idAccion);\"/></div>"
                                        . "<button onclick=\"obtenerSubtarea($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\" class=\"btn btn-sm bg-body text-negron fs-10 ml-1\">Editar</button>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";

//                                $tarea->planAccion .= "<div class=\"row fs-12\">"
//                                        . "<div class=\"col-6 col-md-6 col-lg-6 mt-1 rounded\">"
//                                        . "<div class=\"custom-control custom-checkbox\">";
//                                if ($statusAccion == "F") {
//                                    $tarea->planAccion .= "<input class=\"custom-control-input\" type=\"checkbox\" value=\"\" id=\"chkb_$idAccion\" checked onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
//                                } else {
//                                    $tarea->planAccion .= "<input class=\"custom-control-input\" type=\"checkbox\" value=\"\" id=\"chkb_$idAccion\" onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
//                                }
//
//                                $tarea->planAccion .= "<label class=\"custom-control-label my-checkbox-label fs-9\" for=\"chkb_$idAccion\">"
//                                        . "$tituloAccion"
//                                        . "</label>"
//                                        . "</div>"
//                                        . "</div>"
//                                        . "<div class=\"col-5 col-md-5 col-lg-5 mt-1 text-center\">"
//                                        . "<div class=\"row justify-content-end\">";
//                                if ($pagina == 0) {
//                                    $tarea->planAccion .= "<div class=\"col-2 col-md-2 col-lg-2\">"
//                                            . "<a href=\"#\" class=\"btn2 \" "
//                                            . "data-toggle=\"tooltip\" "
//                                            . "data-placement=\"top\" "
//                                            . "title=\"Responsable: $nombre $apellido\">";
//                                    if ($foto == "advertencia.svg") {
//                                        $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                    } else {
//                                        if ($foto == "") {
//                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                        } else {
//                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                        }
//                                    }
//
//                                    $tarea->planAccion .= "</div>";
//                                } else {
//                                    $tarea->planAccion .= "<div class=\"col-2 col-md-2 col-lg-2\">"
//                                            . "<a href=\"#\" class=\"rounded-circle btn2 \" "
//                                            . "data-toggle=\"tooltip\" "
//                                            . "data-placement=\"top\" "
//                                            . "title=\"Responsable: $nombre $apellido\">";
//                                    if ($foto == "advertencia.svg") {
//                                        $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                    } else {
//                                        if ($foto == "") {
//                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                        } else {
//                                            $tarea->planAccion .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                                        }
//                                    }
//
//                                    $tarea->planAccion .= "</div>";
//                                }
//
//                                $tarea->planAccion .= "<div class=\"col-4 col-md-4 col-lg-4\">"
//                                        . "<button onclick=\"obtenerSubtarea($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\"class=\"btn  my-btn-sm\"><i class=\"ti-pencil\"></i></button>"
//                                        //. "<button onclick=\"obtenerSubtarea($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\"class=\"btn  my-btn-sm\"><i class=\"ti-trash\"></i></button>"
//                                        . "</div>"
//                                        . "</div>"
//                                        . "</div>"
//                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $tarea = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $tarea = $ex;
        }

        $conn->cerrar();
        return $tarea;
    }

    public function eliminarTarea($idTarea) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_tareas SET activo = 0 WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function showHideCols($idSecciones, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_users SET DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0, ZHPGP = 0, ZHPTRS = 0,"
                . "ZIA = 0, ZIC = 0, ZIE = 0, ZIL = 0, OMA = 0, DEP = 0, AUTO = 0, "
                . "ZHA = 0, ZHC = 0, ZHP = 0, SEG = 0 WHERE id = $idUsuario";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        try {
            $secciones = explode(",", $idSecciones);
            for ($i = 0; $i < count($secciones); $i++) {
                if ($secciones[$i] != "") {
                    $query = "SELECT * FROM c_secciones WHERE id = $secciones[$i]";
                } else {
                    $query = "SELECT * FROM c_secciones WHERE id = 0";
                }

                try {
                    $seccs = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($seccs as $dts) {
                            $nombreSeccion = $dts['seccion'];
                        }
                        switch ($nombreSeccion) {
                            case 'AUTO':
                                $query = "UPDATE t_users SET AUTO = 1 WHERE id = $idUsuario";
                                break;
                            case 'DEC':
                                $query = "UPDATE t_users SET DECC = 1 WHERE id = $idUsuario";
                                break;
                            case 'DEP':
                                $query = "UPDATE t_users SET DEP = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZHA':
                                $query = "UPDATE t_users SET ZHA = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZHC':
                                $query = "UPDATE t_users SET ZHC = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZHP':
                                $query = "UPDATE t_users SET ZHP = 1 WHERE id = $idUsuario";
                                break;
//                            case 'ZHA-GP':
//                                $query = "UPDATE t_users SET ZHAGP = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHA-TRS':
//                                $query = "UPDATE t_users SET ZHATRS = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHC-GP':
//                                $query = "UPDATE t_users SET ZHCGP = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHC-TRS':
//                                $query = "UPDATE t_users SET ZHCTRS = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHH-GP':
//                                $query = "UPDATE t_users SET ZHHGP = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHH-TRS':
//                                $query = "UPDATE t_users SET ZHHTRS = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHP-GP':
//                                $query = "UPDATE t_users SET ZHPGP = 1 WHERE id = $idUsuario";
//                                break;
//                            case 'ZHP-TRS':
//                                $query = "UPDATE t_users SET ZHPTRS = 1 WHERE id = $idUsuario";
//                                break;
                            case 'ZIA':
                                $query = "UPDATE t_users SET ZIA = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZIC':
                                $query = "UPDATE t_users SET ZIC = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZIE':
                                $query = "UPDATE t_users SET ZIE = 1 WHERE id = $idUsuario";
                                break;
                            case 'ZIL':
                                $query = "UPDATE t_users SET ZIL = 1 WHERE id = $idUsuario";
                                break;
                            case 'OMA':
                                $query = "UPDATE t_users SET OMA = 1 WHERE id = $idUsuario";
                                break;
                            case 'SEG':
                                $query = "UPDATE t_users SET SEG = 1 WHERE id = $idUsuario";
                                break;
                        }
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $conn->cerrar();
        return $resp;
    }

    public function recargarCols($idPermiso, $idUsuario, $tipo) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $auto = $dts['AUTO'];
                    $dec = $dts['DECC'];
                    $dep = $dts['DEP'];
                    $zhagp = $dts['ZHAGP'];
                    $zhatrs = $dts['ZHATRS'];
                    $zhcgp = $dts['ZHCGP'];
                    $zhctrs = $dts['ZHCTRS'];
                    $zhhgp = $dts['ZHHGP'];
                    $zhhtrs = $dts['ZHHTRS'];
                    $zhpgp = $dts['ZHPGP'];
                    $zhptrs = $dts['ZHPTRS'];
                    $zia = $dts['ZIA'];
                    $zic = $dts['ZIC'];
                    $zie = $dts['ZIE'];
                    $zil = $dts['ZIL'];
                    $oma = $dts['OMA'];
                    $zha = $dts['ZHA'];
                    $zhc = $dts['ZHC'];
                    $zhp = $dts['ZHP'];
                    $seg = $dts['SEG'];
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }
        if ($idPermiso == 1 || $idPermiso == 3) {
            $cols = new Tareas();
            $query = "SELECT * FROM c_secciones WHERE tareas = 'SI'";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idSeccionTarea = $dts['id'];
                        $seccionName = $dts['seccion'];
                        $fotoSeccion = $dts['url_tab_image'];
                        switch ($seccionName) {
                            case 'AUTO':
                                if ($auto == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'DEC':
                                if ($dec == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'DEP':
                                if ($dep == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'ZHA':
                                if ($zha == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
//                            case 'ZHA-TRS':
//                                if ($zhatrs == 1) {
//                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
//                                }
//                                break;
                            case 'ZHC':
                                if ($zhc == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
//                            case 'ZHC-TRS':
//                                if ($zhctrs == 1) {
//                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
//                                }
//                                break;
//                            case 'ZHH-GP':
//                                if ($zhhgp == 1) {
//                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
//                                }
//                                break;
//                            case 'ZHH-TRS':
//                                if ($zhhtrs == 1) {
//                                    echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
//                                }
//                                break;
                            case 'ZHP':
                                if ($zhp == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
//                            case 'ZHP-TRS':
//                                if ($zhptrs == 1) {
//                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
//                                }
//                                break;
                            case 'ZIA':
                                if ($zia == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'ZIC':
                                if ($zic == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'ZIE':
                                if ($zie == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'ZIL':
                                if ($zil == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'OMA':
                                if ($oma == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                            case 'SEG':
                                if ($seg == 1) {
                                    $salida .= $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo);
                                }
                                break;
                        }
                    }
                }
            } catch (Exception $ex) {
                echo $ex;
            }
        }
        $conn->cerrar();
        return $salida;
    }

    //REcarga las columnas que estan activadas para ser vistas en el dashboard
    public function mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion) {
        if (isset($_SESSION['idDestino'])) {
            $idDestino = $_SESSION['idDestino'];
        } else {
            $idDestino = 10;
        }


        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM c_secciones WHERE id = $idSeccionTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreSeccion = $dts['seccion'];
                    $tituloSeccion = $dts['titulo_seccion'];
                    $urlImage = $dts['url_image'];
                }
            } else {
                $tituloSeccion = "";
                $urlImage = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND activo = 1";
        }

        try {
            $tareas = $conn->obtDatos($query);
            $numeroTotalGeneral = 0;
            $numeroTotalPendientes = 0;
            $numeroTotalSolucionadas = 0;
            $numeroTotalNuevos = 0;
            $numeroFinalizadas = 0;
            $fecHoy = date("Y-m-d");
            $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));
            if ($conn->filasConsultadas > 0) {
                foreach ($tareas as $tarea) {
                    $idTarea = $tarea['id'];
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'N'";
                    try {
                        $totalTareasGeneral = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalPendientes += $conn->filasConsultadas;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'F'";
                    try {
                        $totalTareasGeneral = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalSolucionadas += $conn->filasConsultadas;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    //Contadores de tareas nuevas de 10 dias atras a la fecha actual
                    $query = "SELECT * FROM t_tareas_subtareas WHERE fecha_creacion >= '$fecAnterior' AND id_tarea = $idTarea";
                    try {
                        $numeroTareas = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalNuevos += $conn->filasConsultadas;
                            foreach ($numeroTareas as $nt) {
                                $estadoST = $nt['status'];
                                if ($estadoST == "F") {
                                    $numeroFinalizadas += 1;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    //Fin de contadores de tareas nuevas de 10 dias atras a la fecha actual
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }


        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND status != 'F' AND tipo = 1 AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND status != 'F' AND tipo = 1 AND activo = 1";
        }

// fondo de las columnas
        $salida = "<div class=\"col-12 col-md-5 col-lg-5 rounded ml-2\" >"
                . "<div class=\"row\">"
                . "<div class=\"col text-center mt-2 my-no-padding border-bottom\">"
                . "<a href=\"planner/tareas-seccion.php?idSeccion=$idSeccionTarea&idDestino=$idDestino\"><img class=\"img-fluid mb-2\" src=\"svg/$urlImage\" width=\"45\"></a><h6 class=\"text-n fs-13 text-wrap\">$tituloSeccion<span class=\"ml-2\"><a data-toggle=\"collapse\" href=\"#collapse$idSeccionTarea\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapseExample\"><img src=\"svg/nuevovideo2.svg\" width=\"22px;\" alt=\"\" /></a></span></h6>"
                . "<div class=\"row justify-content-center\">"
                . "<div class=\"col-5 text-right\">"
                . "<div class=\"row justify-content-end\">"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Pendientes\">$numeroTotalPendientes</h6>"
                . "</div>"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas\">$numeroTotalSolucionadas</h6>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class=\"col-1 text-center\">"
                . " - "
                . "</div>"
                . "<div class=\"col-5 text-left\">"
                . "<div class=\"row justify-content-start\">"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Nuevos pendientes en la ultimo mes\">$numeroTotalNuevos</h6>"
                . "</div>"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas en la ultimo mes\">$numeroFinalizadas</h6>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"//Fin del header
                . "<div class=\"row\">"//Inicio del collapse del video
                . "<div class=\"col-12\">"
                . "<div class=\"collapse\" id=\"collapse$idSeccionTarea\">"
                . "<div class=\"card card-body border-0 bg-verydark\">"
                . "<div class=\"row justify-content-center\">"
                . "<div class=\"col-12\">"
                . "<div class=\"embed-responsive embed-responsive-16by9\">"
                . "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/xwyeFfjtyx8\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"//Fin collapse video
                . "<div class=\"row\">"//inicia fila de las tarjetas
                . "<div class=\"col-12\" style=\"height: 580px; overflow: auto;\">";

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND status != 'F' AND tipo = 1 AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND status != 'F' AND tipo = 1 AND activo = 1";
        }

        try {
            $tareas = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tareas as $tarea) {
                    $idTarea = $tarea['id'];
                    $tituloSituacion = $tarea['titulo'];
                    $tituloProyecto = $tarea['titulo_proyecto'];
                    $descripcionTarea = $tarea['descripcion'];
                    $fecCreacion = $tarea['fecha_creacion'];
                    $tipo = $tarea['tipo'];
                    $statusTarea = $tarea['status'];
                    $capex = $tarea['capex'];
                    $statusCapex = $tarea['status_capex'];
                    $capin = $tarea['capin'];
                    $statusCapin = $tarea['status_capin'];
                    $responsableTarea = $tarea['responsable'];
                    $responsableTarea2 = $tarea['responsable2'];
                    $idDestinoTarea = $tarea['id_destino'];
                    $idSeccionTarea = $tarea['id_seccion'];
                    $idUsuarioCreador = $tarea['creado'];

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoTarea";
                    try {
                        $destinos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($destinos as $dts) {
                                $nombreDestino = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    $contF = 0;
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                    try {
                        $result = $conn->obtDatos($query);
                        $totalST = $conn->filasConsultadas;
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $statusST = $dts['status'];
                                if ($statusST == "F") {
                                    $contF ++;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    $query = "SELECT * FROM t_users WHERE id = $idUsuarioCreador";
                    try {
                        $creador = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($creador as $dts) {
                                $idDestinoCreador = $dts['id_destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
//tarjetas
                    if ($responsableTarea == $idUsuario || $responsableTarea2 == $idUsuario) {//Si es una tarea donde se es responsable
                        $salida .= "<div class=\"card mt-3 mb-3\">";

                        if ($idDestinoCreador == 10) {
                            $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                        } else {
                            $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                        }

                        $salida .= "<div class=\"row\">"
                                . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea2($idTarea)\">";

                        if ($capex == "SI") {
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capex.svg\" width=\"7.5\">";
                        } elseif ($capin == "SI") {
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capin.svg\" width=\"7.5\">";
                        } elseif ($tipo == 1) {//situacion
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                        } elseif ($tipo == 2) {//Proyecto
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                        }
//                                elseif ($tipo == 3) {//Pendiente
//                                    $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                }

                        $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                        if ($tituloSituacion != "") {
                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                            $salida .= $tituloSituacion;
                        } else {
                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                            $salida .= $tituloProyecto;
                        }
                        $salida .= "</span>";

                        $salida .= "</a></div>"
                                . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                        $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($queryAdjuntos);
                            if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                $hayAdjuntos = "SI";
                            } else {
                                $hayAdjuntos = "";
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($queryComentarios);
                            if ($conn->filasConsultadas > 0) {
                                $hayComentarios = "SI";
                            } else {
                                $hayComentarios = "";
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        $salida .= "</div>";

                        if ($statusTarea == "N") {
                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pac.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pa.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pc.svg\" width=\"25\">";
                            } else {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-p.svg\" width=\"25\">";
                            }
                        } else if ($statusTarea == "P") {
                            $salida .= "<img class=\"mx-2\" src=\"img/svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                        } elseif ($statusTarea == "F") {
                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rca.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-ra.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rc.svg\" width=\"25\">";
                            } else {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-r.svg\" width=\"25\">";
                            }
                        }

                        $salida .= "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                    } else {
                        $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $subtarea) {
                                    $responsableSubtarea = $subtarea['responsable'];
                                    if ($responsableSubtarea == $idUsuario) {

                                        $salida .= "<div class=\"card mt-3 mb-3\">";
                                        if ($idDestinoCreador == 10) {
                                            $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                                        } else {
                                            $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                                        }
                                        //. "<div class=\"card-body bg-white rounded my-no-padding shadow-sm\">"
                                        $salida .= "<div class=\"row\">"
                                                . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                                . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea2($idTarea)\">";

                                        if ($capex == "SI") {
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capex.svg\" width=\"7.5\">";
                                        } elseif ($capin == "SI") {
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capin.svg\" width=\"7.5\">";
                                        } elseif ($tipo == 1) {//situacion
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                                        } elseif ($tipo == 2) {//Proyecto
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                                        }
//                                                elseif ($tipo == 3) {//Pendiente
//                                                    $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                                }

                                        $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                                        if ($tituloSituacion != "") {
                                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                                            $salida .= $tituloSituacion;
                                        } else {
                                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                                            $salida .= $tituloProyecto;
                                        }
                                        $salida .= "</span>";

                                        $salida .= "</a></div>"
                                                . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                                . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                                . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                                        $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                                        try {
                                            $resp = $conn->obtDatos($queryAdjuntos);
                                            if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                                $hayAdjuntos = "SI";
                                                //$salida .= "<button type=\"button\" class=\"btn btn-link nav-link my-nav-link\"><img src=\"svg/adjuntos4.svg\" width=\"24\"></button>";
                                            } else {
                                                $hayAdjuntos = "";
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                                        try {
                                            $resp = $conn->obtDatos($queryComentarios);
                                            if ($conn->filasConsultadas > 0) {
                                                $hayComentarios = "SI";
                                                //$salida .= "<button type=\"button\" class=\"btn btn-link nav-link my-nav-link\"><img src=\"svg/mensajes4.svg\" width=\"24\"></button>";
                                            } else {
                                                $hayComentarios = "";
                                            }
                                        } catch (Exception $ex) {
                                            //$salida = $ex;
                                        }


                                        $salida .= "</div>";

                                        if ($statusTarea == "N") {
                                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pac.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pa.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pc.svg\" width=\"25\">";
                                            } else {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-p.svg\" width=\"25\">";
                                            }
                                            //$salida .= "<img class=\"mx-2\" src=\"img/svg/pendiente.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                        } else if ($statusTarea == "P") {
                                            $salida .= "<img class=\"mx-2\" src=\"img/svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                        } elseif ($statusTarea == "F") {
                                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rca.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-ra.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rc.svg\" width=\"25\">";
                                            } else {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-r.svg\" width=\"25\">";
                                            }
                                            //$salida .= "<img class=\"mx-2\" src=\"img/svg/solucionado.svg\" data-toggle=\"tooltip\" title=\"Finalizado\" alt=\"status\" style=\"height: 20px;\">";
                                        }

                                        $salida .= "</div>"
                                                . "</div>"//
                                                . "</div>"
                                                . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                                        break;
                                    }
                                }
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "</div>"
                . "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

    public function obtMisTareas($tipo, $idDestino, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();

        $cols = new Tareas();
        $salida = "";

        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
        try {
            $usuarios = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($usuarios as $usuario) {
                    $idPermiso = $usuario['id_permiso'];
                    $auto = $usuario['AUTO'];
                    $dec = $usuario['DECC'];
                    $dep = $usuario['DEP'];
                    $zhagp = $usuario['ZHAGP'];
                    $zhatrs = $usuario['ZHATRS'];
                    $zhcgp = $usuario['ZHCGP'];
                    $zhctrs = $usuario['ZHCTRS'];
                    $zhhgp = $usuario['ZHHGP'];
                    $zhhtrs = $usuario['ZHHTRS'];
                    $zhpgp = $usuario['ZHPGP'];
                    $zhptrs = $usuario['ZHPTRS'];
                    $zia = $usuario['ZIA'];
                    $zic = $usuario['ZIC'];
                    $zie = $usuario['ZIE'];
                    $zil = $usuario['ZIL'];
                    $oma = $usuario['OMA'];
                    $zha = $usuario['ZHA'];
                    $zhc = $usuario['ZHC'];
                    $zhp = $usuario['ZHP'];
                    $seg = $usuario['SEG'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idPermiso == 1 || $idPermiso == 3) {
            $cols = new Tareas();
            $query = "SELECT * FROM c_secciones WHERE tareas = 'SI'";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idSeccionTarea = $dts['id'];
                        $seccionName = $dts['seccion'];
                        $fotoSeccion = $dts['url_tab_image'];
                        switch ($seccionName) {
                            case 'AUTO':
                                if ($auto == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'DEC':
                                if ($dec == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'DEP':
                                if ($dep == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'ZHA':
                                if ($zha == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
//                            case 'ZHA-TRS':
//                                if ($zhatrs == 1) {
//                                    echo $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
//                                }
//                                break;
                            case 'ZHC':
                                if ($zhc == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
//                            case 'ZHC-TRS':
//                                if ($zhctrs == 1) {
//                                    echo $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
//                                }
//                                break;
//                            case 'ZHH-GP':
//                                if ($zhhgp == 1) {
//                                    echo $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
//                                }
//                                break;
//                            case 'ZHH-TRS':
//                                if ($zhhtrs == 1) {
//                                    echo $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
//                                }
//                                break;
                            case 'ZHP':
                                if ($zhp == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
//                            case 'ZHP-TRS':
//                                if ($zhptrs == 1) {
//                                    echo $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
//                                }
//                                break;
                            case 'ZIA':
                                if ($zia == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'ZIC':
                                if ($zic == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'ZIE':
                                if ($zie == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'ZIL':
                                if ($zil == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'OMA':
                                if ($oma == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                            case 'SEG':
                                if ($seg == 1) {
                                    $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                }
                                break;
                        }
                    }
                } else {
                    $salida = "Sin resultados";
                }
            } catch (Exception $ex) {
                $salida = $ex;
            }
        } else {
            $cols = new Tareas();
            $query = "SELECT * FROM t_tareas_secciones_permitidos WHERE id_usuario = $idUsuario";
            try {
                $seccionesPermitidas = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    $aux = "";
                    foreach ($seccionesPermitidas as $dts) {
                        $idSeccionPermitida = $dts['id_seccion'];
                        if ($aux != $idSeccionPermitida) {
                            $query = "SELECT * FROM c_secciones WHERE id = $idSeccionPermitida AND tareas = 'SI'";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idSeccionTarea = $dts['id'];
                                        $subcategoria = $dts['seccion'];
                                        $fotoSeccion = $dts['url_tab_image'];

                                        $salida .= $cols->mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino);
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                        }
                        $aux = $idSeccionPermitida;
                    }
                }
            } catch (Exception $ex) {
                $salida = $ex;
            }
        }
        $conn->cerrar();
        return $salida;
    }

    public function mostrarColsMisTareas($idUsuario, $idSeccionTarea, $fotoSeccion, $tipo, $idDestino) {

        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM c_secciones WHERE id = $idSeccionTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreSeccion = $dts['seccion'];
                    $tituloSeccion = $dts['titulo_seccion'];
                    $urlImage = $dts['url_image'];
                }
            } else {
                $tituloSeccion = "";
                $urlImage = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND activo = 1";
        }

        try {
            $tareas = $conn->obtDatos($query);
            $numeroTotalGeneral = 0;
            $numeroTotalPendientes = 0;
            $numeroTotalSolucionadas = 0;
            $numeroTotalNuevos = 0;
            $numeroFinalizadas = 0;
            $fecHoy = date("Y-m-d");
            $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));
            if ($conn->filasConsultadas > 0) {
                foreach ($tareas as $tarea) {
                    $idTarea = $tarea['id'];
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'N'";
                    try {
                        $totalTareasGeneral = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalPendientes += $conn->filasConsultadas;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'F'";
                    try {
                        $totalTareasGeneral = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalSolucionadas += $conn->filasConsultadas;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    //Contadores de tareas nuevas de 10 dias atras a la fecha actual
                    $query = "SELECT * FROM t_tareas_subtareas WHERE fecha_creacion >= '$fecAnterior' AND id_tarea = $idTarea";
                    try {
                        $numeroTareas = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $numeroTotalNuevos += $conn->filasConsultadas;
                            foreach ($numeroTareas as $nt) {
                                $estadoST = $nt['status'];
                                if ($estadoST == "F") {
                                    $numeroFinalizadas += 1;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    //Fin de contadores de tareas nuevas de 10 dias atras a la fecha actual
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND status != 'F' AND tipo = 1 AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND status != 'F' AND tipo = 1 AND activo = 1";
        }

        $salida = "<div class=\"col-12 col-md-5 col-lg-5 rounded ml-2\">"
                . "<div class=\"row\">"
                . "<div class=\"col text-center mt-2 my-no-padding border-bottom\">"
                . "<a href=\"planner/tareas-seccion.php?idSeccion=$idSeccionTarea&idDestino=$idDestino\"><img class=\"img-fluid mb-2\" src=\"svg/$urlImage\" width=\"45\"></a><h6 class=\"text-n fs-13 text-wrap\">$tituloSeccion<span class=\"ml-2\"><a data-toggle=\"collapse\" href=\"#collapse$idSeccionTarea\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapseExample\"><img src=\"svg/nuevovideo2.svg\" width=\"22px;\" alt=\"\" /></a></span></h6>"
                . "<div class=\"row justify-content-center\">"
                . "<div class=\"col-5 text-right\">"
                . "<div class=\"row justify-content-end\">"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Pendientes\">$numeroTotalPendientes</h6>"
                . "</div>"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas\">$numeroTotalSolucionadas</h6>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class=\"col-1 text-center\">"
                . " - "
                . "</div>"
                . "<div class=\"col-5 text-left\">"
                . "<div class=\"row justify-content-start\">"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Nuevos pendientes en la ultimo mes\">$numeroTotalNuevos</h6>"
                . "</div>"
                . "<div class=\"col-1 mt-1\">"
                . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas en la ultimo mes\">$numeroFinalizadas</h6>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"//Fin del header
                . "<div class=\"row\">"//Inicio del collapse del video
                . "<div class=\"col-12\">"
                . "<div class=\"collapse\" id=\"collapse$idSeccionTarea\">"
                . "<div class=\"card card-body border-0 bg-verydark\">"
                . "<div class=\"row justify-content-center\">"
                . "<div class=\"col-12\">"
                . "<div class=\"embed-responsive embed-responsive-16by9\">"
                . "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/xwyeFfjtyx8\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"//Fin collapse video
                . "<div class=\"row\">"//inicia fila de las tarjetas
                . "<div class=\"col-12\" style=\"height: 580px; overflow: auto;\">";

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND status != 'F' AND tipo = $tipo AND activo = 1";
        } else {
            $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccionTarea AND id_destino = $idDestino AND status != 'F' AND tipo = $tipo AND activo = 1";
        }

        try {
            $tareas = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tareas as $tarea) {
                    $idTarea = $tarea['id'];
                    $tituloSituacion = $tarea['titulo'];
                    $tituloProyecto = $tarea['titulo_proyecto'];
                    $descripcionTarea = $tarea['descripcion'];
                    $fecCreacion = $tarea['fecha_creacion'];
                    $tipo = $tarea['tipo'];
                    $statusTarea = $tarea['status'];
                    $capex = $tarea['capex'];
                    $statusCapex = $tarea['status_capex'];
                    $capin = $tarea['capin'];
                    $statusCapin = $tarea['status_capin'];
                    $idDestinoTarea = $tarea['id_destino'];
                    $idSeccionTarea = $tarea['id_seccion'];
                    $responsableTarea = $tarea['responsable'];
                    $responsableTarea2 = $tarea['responsable2'];
                    $idUsuarioCreador = $tarea['creado'];


                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoTarea";
                    try {
                        $destinos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($destinos as $dts) {
                                $nombreDestino = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    $contF = 0;
                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                    try {
                        $result = $conn->obtDatos($query);
                        $totalST = $conn->filasConsultadas;
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $statusST = $dts['status'];
                                if ($statusST == "F") {
                                    $contF ++;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $query = "SELECT * FROM t_users WHERE id = $idUsuarioCreador";
                    try {
                        $creador = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($creador as $dts) {
                                $idDestinoCreador = $dts['id_destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                    if ($responsableTarea == $idUsuario || $responsableTarea2 == $idUsuario) {//Si es una tarea donde se es responsable
                        $salida .= "<div class=\"card mt-3 mb-3\">";

                        if ($idDestinoCreador == 10) {
                            $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                        } else {
                            $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                        }

                        $salida .= "<div class=\"row\">"
                                . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea2($idTarea)\">";

                        if ($capex == "SI") {
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capex.svg\" width=\"7.5\">";
                        } elseif ($capin == "SI") {
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capin.svg\" width=\"7.5\">";
                        } elseif ($tipo == 1) {//situacion
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                        } elseif ($tipo == 2) {//Proyecto
                            $salida .= "<img class=\"\" src=\"svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                        }
//                                elseif ($tipo == 3) {//Pendiente
//                                    $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                }

                        $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                        if ($tituloSituacion != "") {
                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                            $salida .= $tituloSituacion;
                        } else {
                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                            $salida .= $tituloProyecto;
                        }
                        $salida .= "</span>";

                        $salida .= "</a></div>"
                                . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                        $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($queryAdjuntos);
                            if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                $hayAdjuntos = "SI";
                            } else {
                                $hayAdjuntos = "";
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($queryComentarios);
                            if ($conn->filasConsultadas > 0) {
                                $hayComentarios = "SI";
                            } else {
                                $hayComentarios = "";
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        $salida .= "</div>";

                        if ($statusTarea == "N") {
                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pac.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pa.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pc.svg\" width=\"25\">";
                            } else {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-p.svg\" width=\"25\">";
                            }
                        } else if ($statusTarea == "P") {
                            $salida .= "<img class=\"mx-2\" src=\"img/svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                        } elseif ($statusTarea == "F") {
                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rca.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-ra.svg\" width=\"25\">";
                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rc.svg\" width=\"25\">";
                            } else {
                                $salida .= "<img class=\"\" src=\"svg/banners/tag-r.svg\" width=\"25\">";
                            }
                        }

                        $salida .= "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                    } else {
                        $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $subtarea) {
                                    $responsableSubtarea = $subtarea['responsable'];
                                    if ($responsableSubtarea == $idUsuario) {

                                        $salida .= "<div class=\"card mt-3 mb-3\">";
                                        if ($idDestinoCreador == 10) {
                                            $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                                        } else {
                                            $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                                        }
                                        //. "<div class=\"card-body bg-white rounded my-no-padding shadow-sm\">"
                                        $salida .= "<div class=\"row\">"
                                                . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                                . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea2($idTarea)\">";

                                        if ($capex == "SI") {
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capex.svg\" width=\"7.5\">";
                                        } elseif ($capin == "SI") {
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-capin.svg\" width=\"7.5\">";
                                        } elseif ($tipo == 1) {//situacion
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                                        } elseif ($tipo == 2) {//Proyecto
                                            $salida .= "<img class=\"\" src=\"svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                                        }
//                                                elseif ($tipo == 3) {//Pendiente
//                                                    $salida .= "<img class=\"\" src=\"svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                                }

                                        $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                                        if ($tituloSituacion != "") {
                                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                                            $salida .= $tituloSituacion;
                                        } else {
                                            $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                                            $salida .= $tituloProyecto;
                                        }
                                        $salida .= "</span>";

                                        $salida .= "</a></div>"
                                                . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                                . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                                . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                                        $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                                        try {
                                            $resp = $conn->obtDatos($queryAdjuntos);
                                            if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                                $hayAdjuntos = "SI";
                                                //$salida .= "<button type=\"button\" class=\"btn btn-link nav-link my-nav-link\"><img src=\"svg/adjuntos4.svg\" width=\"24\"></button>";
                                            } else {
                                                $hayAdjuntos = "";
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                                        try {
                                            $resp = $conn->obtDatos($queryComentarios);
                                            if ($conn->filasConsultadas > 0) {
                                                $hayComentarios = "SI";
                                                //$salida .= "<button type=\"button\" class=\"btn btn-link nav-link my-nav-link\"><img src=\"svg/mensajes4.svg\" width=\"24\"></button>";
                                            } else {
                                                $hayComentarios = "";
                                            }
                                        } catch (Exception $ex) {
                                            //$salida = $ex;
                                        }


                                        $salida .= "</div>";

                                        if ($statusTarea == "N") {
                                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pac.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pa.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-pc.svg\" width=\"25\">";
                                            } else {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-p.svg\" width=\"25\">";
                                            }
                                            //$salida .= "<img class=\"mx-2\" src=\"img/svg/pendiente.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                        } else if ($statusTarea == "P") {
                                            $salida .= "<img class=\"mx-2\" src=\"img/svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                        } elseif ($statusTarea == "F") {
                                            if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rca.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-ra.svg\" width=\"25\">";
                                            } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-rc.svg\" width=\"25\">";
                                            } else {
                                                $salida .= "<img class=\"\" src=\"svg/banners/tag-r.svg\" width=\"25\">";
                                            }
                                            //$salida .= "<img class=\"mx-2\" src=\"img/svg/solucionado.svg\" data-toggle=\"tooltip\" title=\"Finalizado\" alt=\"status\" style=\"height: 20px;\">";
                                        }

                                        $salida .= "</div>"
                                                . "</div>"//
                                                . "</div>"
                                                . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                                        break;
                                    }
                                }
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "</div>"
                . "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

    public function showColsPendFin($idSeccion, $idDestino, $status) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $destino = $dts['destino'];
                    $bandera = $dts['bandera'];
                    $gp = $dts['gp'];
                    $trs = $dts['trs'];
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
            if ($gp == "SI" && $trs == "SI") {
                $query = "SELECT * FROM c_subcategorias_zh WHERE id_seccion = $idSeccion ORDER BY grupo";
            } elseif ($gp == "SI" && $trs == "NO") {
                $query = "SELECT * FROM c_subcategorias_zh WHERE marca = 'GP' AND id_seccion = $idSeccion ORDER BY grupo";
            } elseif ($gp == "NO" && $trs == "SI") {
                $query = "SELECT * FROM c_subcategorias_zh WHERE marca = 'TRS' AND id_seccion = $idSeccion ORDER BY grupo";
            }
        } elseif ($idSeccion == 23) {
            $query = "SELECT * FROM c_subcategorias WHERE id_seccion = $idSeccion";
        } else {
            $query = "SELECT * FROM c_grupos WHERE id_seccion = $idSeccion ORDER BY grupo";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSubcategoria = $dts['id'];
                    $subcategoria = $dts['grupo'];

                    if ($idDestino == 10) {
                        $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 ORDER BY tipo";
                    } else {
                        $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND id_destino = $idDestino ORDER BY tipo";
                    }

                    try {
                        $tareas = $conn->obtDatos($query);
                        $numeroTotalGeneral = 0;
                        $numeroTotalPendientes = 0;
                        $numeroTotalSolucionadas = 0;
                        $numeroTotalNuevos = 0;
                        $numeroFinalizadas = 0;
                        $fecHoy = date("Y-m-d");
                        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));
                        if ($conn->filasConsultadas > 0) {
                            foreach ($tareas as $tarea) {
                                $idTarea = $tarea['id'];
                                $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'N'";
                                try {
                                    $totalTareasGeneral = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        $numeroTotalPendientes += $conn->filasConsultadas;
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                                $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea AND status = 'F'";
                                try {
                                    $totalTareasGeneral = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        $numeroTotalSolucionadas += $conn->filasConsultadas;
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                                //Contadores de tareas nuevas de 10 dias atras a la fecha actual
                                $query = "SELECT * FROM t_tareas_subtareas WHERE fecha_creacion >= '$fecAnterior' AND id_tarea = $idTarea";
                                try {
                                    $numeroTareas = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        $numeroTotalNuevos += $conn->filasConsultadas;
                                        foreach ($numeroTareas as $nt) {
                                            $estadoST = $nt['status'];
                                            if ($estadoST == "F") {
                                                $numeroFinalizadas += 1;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                                //Fin de contadores de tareas nuevas de 10 dias atras a la fecha actual
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    if ($idDestino == 10) {
                        $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND status != 'F' ORDER BY tipo";
                    } else {
                        $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND id_destino = $idDestino AND status != 'F' ORDER BY tipo";
                    }



                    $salida .= "<div id=\"$idSubcategoria\" class=\"col-12 col-md-5 col-lg-5 rounded bg-boddy2 ml-2 mr-2 columnas\" ondrop=\"drop(this, event)\" ondragenter=\"return false\" ondragover=\"return false\" style=\"height: 580px; overflow: auto;\">"//colunmas de subcategorias
                            . "<p class=\"text-center\">$subcategoria</p>"
                            . "<div class=\"row\">"
                            . "<div class=\"col-12 text-center\">"
                            . "<div class=\"row justify-content-center\">"
                            . "<div class=\"col-5 text-right\">"
                            . "<div class=\"row justify-content-end\">"
                            . "<div class=\"col-1 mt-1\">"
                            . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Pendientes\">$numeroTotalPendientes</h6>"
                            . "</div>"
                            . "<div class=\"col-1 mt-1\">"
                            . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas\">$numeroTotalSolucionadas</h6>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "<div class=\"col-1 text-center\">"
                            . " - "
                            . "</div>"
                            . "<div class=\"col-5 text-left\">"
                            . "<div class=\"row justify-content-start\">"
                            . "<div class=\"col-1 mt-1\">"
                            . "<h6 class=\"pendientes spcondbold\" data-toggle=\"tooltip\" title=\"Nuevos pendientes en la ultimo mes\">$numeroTotalNuevos</h6>"
                            . "</div>"
                            . "<div class=\"col-1 mt-1\">"
                            . "<h6 class=\"solucionadas spcondbold\" data-toggle=\"tooltip\" title=\"Solucionadas en la ultimo mes\">$numeroFinalizadas</h6>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "<div class=\"row\">"
                            . "<div class=\"col text-center\">"
                            . "<img src=\"../svg/agregar.svg\" width=\"27\" data-toggle=\"modal\" data-target=\"#modal-agregar-tarea\" onclick=\"insertarTarea($idSubcategoria, $idSeccion);\">"
                            //. "<button type=\"button\" class=\"btn btn-primary btn-sm rounded-circle\" data-toggle=\"modal\" data-target=\"#modal-agregar-tarea\" onclick=\"insertarTarea($idSubcategoria, $idSeccion);\"><i class=\"ti-plus\"></i></button>"
                            . "</div>"
                            . "</div>";
                    //. "<div class=\"row\">"
                    //. "<div class=\"col\" style=\"height: 300px; overflow: auto;\">";
                    if ($idDestino == 10) {
                        if ($status == "true") {
                            $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND status != 'F' ORDER BY tipo";
                        } else {
                            $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND status = 'F' ORDER BY tipo";
                        }
                    } else {
                        if ($status == "true") {
                            $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND id_destino = $idDestino AND status != 'F' ORDER BY tipo";
                        } else {
                            $query = "SELECT * FROM t_tareas WHERE subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND id_destino = $idDestino AND status = 'F' ORDER BY tipo";
                        }
                    }

                    try {
                        $tareas = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($tareas as $tarea) {
                                $idTarea = $tarea['id'];
                                $tituloSituacion = $tarea['titulo'];
                                $tituloProyecto = $tarea['titulo_proyecto'];
                                $descripcionTarea = $tarea['descripcion'];
                                $fecCreacion = $tarea['fecha_creacion'];
                                $tipo = $tarea['tipo'];
                                $statusTarea = $tarea['status'];
                                $capex = $tarea['capex'];
                                $statusCapex = $tarea['status_capex'];
                                $capin = $tarea['capin'];
                                $statusCapin = $tarea['status_capin'];
                                $idDestinoTarea = $tarea['id_destino'];
                                $idSeccionTarea = $tarea['id_seccion'];
                                $idUsuarioCreador = $tarea['creado'];

                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoTarea";
                                try {
                                    $destinos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($destinos as $dts) {
                                            $nombreDestino = $dts['destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                $contF = 0;
                                $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                                try {
                                    $result = $conn->obtDatos($query);
                                    $totalST = $conn->filasConsultadas;
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $dts) {
                                            $statusST = $dts['status'];
                                            if ($statusST == "F") {
                                                $contF ++;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $query = "SELECT * FROM t_users WHERE id = $idUsuarioCreador";
                                try {
                                    $creador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($creador as $dts) {
                                            $idDestinoCreador = $dts['id_destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }


                                $salida .= "<div id=\"$idTarea\" class=\"card mt-3 mb-3\"draggable=\"true\" ondragstart=\"dragstart(this, event)\">";

                                if ($idDestinoCreador == 10) {
                                    $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                                } else {
                                    $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                                }

                                $salida .= "<div class=\"row\">"
                                        . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                        . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea($idTarea)\">";

                                if ($capex == "SI") {
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-capex.svg\" width=\"7.5\">";
                                } elseif ($capin == "SI") {
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-capin.svg\" width=\"7.5\">";
                                } elseif ($tipo == 1) {//situacion
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                                } elseif ($tipo == 2) {//Proyecto
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                                }
//                                elseif ($tipo == 3) {//Pendiente
//                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                }

                                $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                                if ($tituloSituacion != "") {
                                    $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                                    $salida .= $tituloSituacion;
                                } else {
                                    $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                                    $salida .= $tituloProyecto;
                                }
                                $salida .= "</span>";

                                $salida .= "</a></div>"
                                        . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                        . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                        . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                                $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                                try {
                                    $resp = $conn->obtDatos($queryAdjuntos);
                                    if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                        $hayAdjuntos = "SI";
                                    } else {
                                        $hayAdjuntos = "";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                                try {
                                    $resp = $conn->obtDatos($queryComentarios);
                                    if ($conn->filasConsultadas > 0) {
                                        $hayComentarios = "SI";
                                    } else {
                                        $hayComentarios = "";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                $salida .= "</div>";

                                if ($statusTarea == "N") {
                                    if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pac.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pa.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pc.svg\" width=\"25\">";
                                    } else {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-p.svg\" width=\"25\">";
                                    }
                                } else if ($statusTarea == "P") {
                                    $salida .= "<img class=\"mx-2\" src=\"img/../svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                } elseif ($statusTarea == "F") {
                                    if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-rca.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-ra.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-rc.svg\" width=\"25\">";
                                    } else {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-r.svg\" width=\"25\">";
                                    }
                                }

                                $salida .= "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                            }
                        }
                    } catch (Exception $ex) {
                        $salida .= $ex;
                    }
                    $salida .= ""
                            . ""
                            . "</div>"; //fin colunmas de subcategorias
                }
            }
        } catch (Exception $ex) {
            $salida .= $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function crearTableros($idDestino) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $_SESSION['idDestino'] = $idDestino;

        $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreDestino = $dts['destino'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        //Obtener el nombre de la seccion
        $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSeccion = $dts['id'];
                    $nombreSeccion = $dts['seccion'];
                    $logoSec = $dts['url_image'];
                    $salida .= "<div class=\"col-12 col-md-6 col-lg-3 mb-4\">"
                            . "<a href=\"tareas-seccion.php?idSeccion=$idSeccion&idDestino=$idDestino\">";

                    $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccion AND id_destino = $idDestino AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $tTotal = $conn->filasConsultadas;
                        $tNI = 0;
                        $tP = 0;
                        $tF = 0;
                        $tCEx = 0;
                        $tCIn = 0;
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $tStatus = $dts['status'];
                                $tCapex = $dts['capex'];
                                $tCapin = $dts['capin'];

                                if ($tStatus == "N" && $tCapex == "NO" && $tCapin == "NO") {
                                    $tNI += 1;
                                } elseif ($tStatus == "P" && $tCapex == "NO" && $tCapin == "NO") {
                                    $tP += 1;
                                } elseif ($tStatus == "F" && $tCapex == "NO" && $tCapin == "NO") {
                                    $tF += 1;
                                }

                                if ($tCapex == "SI") {
                                    $tCEx += 1;
                                }if ($tCapin == "SI") {
                                    $tCIn += 1;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    try {
                        if ($tTotal > 0) {
                            $tPor = ($tF * 100) / $tTotal;
                        } else {
                            $tPor = 100;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    $salida .= "<div class=\"media border bg-white rounded\">
                        <img class=\"align-self-center mr-3\" src=\"img/svg/$logoSec\" width=\"80px\" alt=\"LogoZI\">
                        <div class=\"media-body text-center \">
                            <h4 class=\"mt-0\">$nombreSeccion</h4>
                            <p>$nombreDestino</p>
                            <p class=\"my-2\" style=\"font-size: 40px;\">" . round($tPor) . "%</p>
                            <div class=\"row justify-content-center flex-row flex-nowrap no-gutters\">
                                <div class=\"col-2 my-0 mr-2\">
                                    <p style=\"font-size: 6px;\" class=\"mb-1\">Pendientes</p>
                                    <img src=\"img/svg/pendiente.svg\" width=\"30%\" alt=\"\">
                                    <p style=\"font-size: 15px;\" class=\"mt-1\">$tNI</p>
                                </div>
                                <div class=\"col-2 my-0 mr-2\">
                                    <p style=\"font-size: 6px;\" class=\"mb-1\">En Proceso</p>
                                    <img src=\"img/svg/proceso.svg\" width=\"30%\" alt=\"\">
                                    <p style=\"font-size: 15px;\" class=\"mt-1\">$tP</p>
                                </div>
                                <div class=\"col-2 my-0 mr-2\">
                                    <p style=\"font-size: 6px;\" class=\"mb-1\">Solucionadas</p>
                                    <img src=\"img/svg/solucionado.svg\" width=\"30%\" alt=\"\">
                                    <p style=\"font-size: 15px;\" class=\"mt-1\">$tF</p>
                                </div>
                                <div class=\"col-2 my-0 mr-2\">
                                    <p style=\"font-size: 6px;\" class=\"mb-1\">CAP-EX</p>
                                    <img src=\"img/svg/capex.svg\" width=\"30%\" alt=\"\">
                                    <p style=\"font-size: 15px;\" class=\"mt-1\">$tCEx</p>
                                </div>
                                <div class=\"col-2 my-0\">
                                    <p style=\"font-size: 6px;\" class=\"mb-1\">CAP-IN</p>
                                    <img src=\"img/svg/capin.svg\" width=\"30%\" alt=\"\">
                                    <p style=\"font-size: 15px;\" class=\"mt-1\">$tCIn</p>
                                </div>
                            </div>
                        </div>
                    </div>";

                    $salida .= "</a>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function cambiarSubcategoria($idTarea, $idSubcategoria) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_tareas SET subcategoria = $idSubcategoria WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    public function cargarHabitaciones($idSubcategoria, $idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idSeccion == 13 || $idSeccion == 14) {
            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idSubcategoria ORDER BY grupo";
        } else {
            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idSubcategoria ORDER BY grupo";
        }
        try {
            $subcategorias = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($subcategorias as $dts) {
                    $idLocalizacionSubCat = $dts['id_localizacion'];
                    $query = "SELECT * FROM c_ubicaciones_entregas WHERE id_localizacion = $idLocalizacionSubCat ORDER BY ubicacion";
                    try {
                        $ubicaciones = $conn->obtDatos($query);
                        $salida .= "<div class=\"col-10\">"
                                . "<select id=\"cbHab\" class=\"form-control form-control-sm\">";
                        if ($conn->filasConsultadas > 0) {
                            foreach ($ubicaciones as $dts) {
                                $idUbicacion = $dts['id'];
                                $nombreUbicacion = $dts['ubicacion'];

                                $salida .= "<option value=\"$idUbicacion\">$nombreUbicacion</option>";
                            }
                        }
                        $salida .= "</select>"
                                . "</div>";
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        $conn->cerrar();
        return $salida;
    }

    public function getUserByDestiny($idDestino, $idTarea, $pagina, $modal) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idDestino == 10) {
            $query = "SELECT * FROM t_users WHERE status = 'A' ORDER BY username";
        } else {
            $query = "SELECT * FROM t_users WHERE id_destino = $idDestino AND status = 'A' ORDER BY username";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuarioU = $dts['id'];
                    $idColaboradorU = $dts['id_colaborador'];
                    $idPermisoU = $dts['id_permiso'];
                    $idDestinoU = $dts['id_destino'];
                    $idFaseU = $dts['fase'];

                    //Obtener datos del colaborador
                    $query = "SELECT * FROM t_colaboradores WHERE id = $idColaboradorU";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreU = $dts['nombre'];
                                $apellidoU = $dts['apellido'];
                                $telefonoU = $dts['telefono'];
                                $emailU = $dts['email'];
                                $idCargoU = $dts['id_cargo'];
                                $fotoU = $dts['foto'];
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $salida .= "<button type=\"button\" class=\"list-group-item list-group-item-action\" onclick=\"actualizarResponsable($idTarea, $idUsuarioU, $pagina, $modal);\">";
                    if ($fotoU != "") {
                        if ($pagina == 0) {
                            $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"img/users/$fotoU\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                        } else {
                            $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"../img/users/$fotoU\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                        }
                    } else {
                        if ($pagina == 0) {
                            $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombreU+$apellidoU&background=d8e6ff&rounded=true&color=4886ff&size=100%\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                        } else {
                            $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombreU+$apellidoU&background=d8e6ff&rounded=true&color=4886ff&size=100%\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                        }
                    }

                    $salida .= " <span class=\"small\">$nombreU $apellidoU</span>"
                            . "</button>";
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }
        $conn->cerrar();

        return $salida;
    }

    public function obtUserSeccion($idDestino, $idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idDestino == 10) {
            $query = "SELECT * FROM t_users WHERE status = 'A' ORDER BY username";
        } else {
            $query = "SELECT * FROM t_users WHERE id_destino = $idDestino AND status = 'A' ORDER BY username";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuarioU = $dts['id'];
                    $idColaboradorU = $dts['id_colaborador'];
                    $idPermisoU = $dts['id_permiso'];
                    $idDestinoU = $dts['id_destino'];
                    $idFaseU = $dts['fase'];

                    //Obtener datos del colaborador
                    $query = "SELECT * FROM t_colaboradores WHERE id = $idColaboradorU";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreU = $dts['nombre'];
                                $apellidoU = $dts['apellido'];
                                $telefonoU = $dts['telefono'];
                                $emailU = $dts['email'];
                                $idCargoU = $dts['id_cargo'];
                                $fotoU = $dts['foto'];
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $salida .= "<button type=\"button\" class=\"list-group-item list-group-item-action\" onclick=\"agregarUsuarioPermitido($idDestino, $idSeccion, $idUsuarioU);\">";
                    if ($fotoU != "") {

                        $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"../img/users/$fotoU\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                    } else {

                        $salida .= "<img id=\"$idUsuarioU\" name=\"u$idUsuarioU\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombreU+$apellidoU&background=d8e6ff&rounded=true&color=4886ff&size=100%\" data-provide=\"tooltip\" data-placement=\"top\" title=\"$nombreU $apellidoU\">";
                    }

                    $salida .= " <span class=\"small\">$nombreU $apellidoU</span>"
                            . "</button>";
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }
        $conn->cerrar();

        return $salida;
    }

    public function actualizarResponsable($idTarea, $idUsuario, $pagina, $modal, $resp) {
        $conn = new Conexion();
        $conn->conectar();
        if ($modal == 1) {
            $query = "UPDATE t_tareas_subtareas SET responsable = $idUsuario WHERE id = $idTarea";
        } else {
            if ($resp == 1) {
                $query = "UPDATE t_tareas SET responsable = $idUsuario WHERE id = $idTarea";
            } else {
                $query = "UPDATE t_tareas SET responsable2 = $idUsuario WHERE id = $idTarea";
            }
        }

        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {
                $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                            $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombre = $dts['nombre'];
                                        $apellido = $dts['apellido'];
                                        $foto = $dts['foto'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $resp = $ex;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }

                if ($pagina == 0) {
                    if ($foto == "") {
                        $resp = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\"  class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                    } else {
                        $resp = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\"  class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"img/users/$foto\">";
                    }
                } else {
                    if ($foto == "") {
                        $resp = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\">";
                    } else {
                        $resp = "<img data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Responsable principal: $nombre $apellido\" class=\"rounded-circle\" width=\"24px\" height=\"24px\" src=\"../img/users/$foto\">";
                    }
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    //Insertar comentarios
    public function insertarComentario($idTarea, $idSubtarea, $idUsuario, $comentario) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "INSERT INTO t_tareas_comentarios(id_tarea, id_subtarea, id_usuario, comentario) "
                . "VALUES($idTarea, $idSubtarea, $idUsuario, '$comentario')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    //Actualizar la caja de comentarios
    public function actualizarCajaComentarios($idTarea, $pagina, $idSubtarea) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idSubtarea != "") {
            $query = "SELECT * FROM t_tareas_comentarios WHERE id_subtarea = $idSubtarea";
        } else {
            $query = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
        }

        try {
            $coments = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($coments as $dts) {
                    $idComent = $dts['id'];
                    $idUserComent = $dts['id_usuario'];
                    $fechaComent = $dts['fecha'];
                    $comentario = $dts['comentario'];

                    $query = "SELECT * FROM t_users WHERE id = $idUserComent";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre = $dts['nombre'];
                                            $apellido = $dts['apellido'];
                                            $foto = $dts['foto'];
                                            $idCargo = $dts['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    $salida .= "<div class=\"row justify-content-center rounded-3\">"
                            . "<div class=\"col-11 my-1 px-1\" >"
                            . "<div class=\"media\">";
//                                if ($pagina == 0) {
//                                    $salida .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                } else {
//                                    $salida .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"../img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                }

                    if ($idCargo == 51) {
                        $salida .= "<div class=\"media-body bg-rojoc rounded py-2 px-2 shadow-sm\" >";
                    } else {
                        $salida .= "<div class=\"media-body bg-white border-normal rounded py-2 px-2 shadow-sm\" >";
                    }


                    $salida .= "<h5 class=\"my-0 fs-10 spdisplaybold text-negron\">$nombre $apellido: </h5>"
                            . "<h5 class=\"fs-10 mt-1 spdisplayregular text-negron\">$comentario</h5>"
                            . "<h5 class=\"fs-8 mt-1 spdisplaybold text-negron text-right mb-0 pb-0\">$fechaComent</h5>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    //insertar subtarea
    public function insertarSubtarea($idTarea, $subtarea, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
//        $fecL = date("Y-m-d H:i:s", strtotime($fechaL));
        $now = date("Y-m-d H:i:s");
//        for ($i = 0; $i < count($aImgU); $i++) {
//            $responsable = $aImgU[$i];
//        }
        $query = "INSERT INTO t_tareas_subtareas(id_tarea, subtarea, status, creado_por, fecha_creacion) "
                . "VALUES($idTarea, '$subtarea', 'N', $idUsuario, '$now')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    //Obtiene los datos de una subtarea especifica
    public function obtenerSubtarea($idSubtarea) {
        $conn = new Conexion();
        $subtarea = new Subtarea();
        $conn->conectar();
        $query = "SELECT * FROM t_tareas_subtareas WHERE id = $idSubtarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $subtarea->id = $dts['id'];
                    $subtarea->idTarea = $dts['id_tarea'];
                    $subtarea->subtarea = $dts['subtarea'];
                    $subtarea->duracion = $dts['duracion'];
                    $subtarea->status = $dts['status'];
                    $subtarea->responsable = $dts['responsable'];
                    $subtarea->fecCreacion = $dts['fecha_creacion'];
                    $subtarea->fecLimite = $dts['fecha_limite'];
                    $subtarea->reprogramado = $dts['reprogramado'];
                    $subtarea->fecReprogramado = $dts['fecha_reprogramacion'];
                    $idRep = $dts['reprogramado_por'];

                    $query = "SELECT * FROM t_users WHERE id = $idRep";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id_colaborador'];
                                $idPermiso = $dts['id_permiso'];
                                $idDestino = $dts['id_destino'];
                                $idFase = $dts['fase'];

                                //Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre = $dts['nombre'];
                                            $apellido = $dts['apellido'];
                                            $telefono = $dts['telefono'];
                                            $email = $dts['email'];
                                            $idCargo = $dts['id_cargo'];
                                            $foto = $dts['foto'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $subtarea = $ex;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $subtarea = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $subtarea = $ex;
        }

        $conn->cerrar();
        return $subtarea;
    }

    //actualizar subtarea
    public function actualizarSubtarea($idSubtarea, $subtarea, $fechaLimite) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fechaLimite = date("Y-m-d", strtotime($fechaLimite));

        $query = "UPDATE t_tareas_subtareas SET subtarea = '$subtarea', fecha_limite = '$fechaLimite' WHERE id = $idSubtarea";


        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    //Eliminar subtarea
    public function eliminarSubtarea($idSubtarea) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "DELETE FROM t_tareas_subtareas WHERE id = $idSubtarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    //Actualizar la caja de subtareas
    public function actualizarCajaSubtareas($idTarea, $pagina) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
        try {
            $accion = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($accion as $dts) {
                    $idAccion = $dts['id'];
                    $tituloAccion = $dts['subtarea'];
                    $responsableAccion = $dts['responsable'];
                    $statusAccion = $dts['status'];
                    $fechaLimite = $dts['fecha_limite'];

                    $query = "SELECT * FROM t_users WHERE id = $responsableAccion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombre = $dts['nombre'];
                                            $apellido = $dts['apellido'];
                                            $foto = $dts['foto'];

                                            if ($foto == "") {
                                                $foto = "";
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                            }
                        } else {
                            $nombre = "No";
                            $apellido = "Asignado";
                            $foto = "advertencia2.svg";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }

                    $salida .= "<div class=\"row pda rounded-3 spdisplaysemibold fs-10 text-uppercase justify-content-center\">"
                            . "<div class=\"col-12\">"
                            . "<div class=\"row pb-1 mb-1 mx-1\">"
                            . "<div class=\"col-8 col-md-10 col-lg-10\">"
                            . "<div class=\"row\">"
                            . "<div class=\"col-10 col-md-11\">"
                            . "<div class=\"custom-control custom-checkbox checklist mt-2\">";
                    if ($statusAccion == "F") {
                        $salida .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
                    } else {
                        $salida .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
                    }

                    $salida .= "<label class=\"custom-control-label fs-11 checklist pt-1\" for=\"chkb_$idAccion\">$tituloAccion</label>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "<div class=\"col-2 col-md-1 col-lg-1 text-center\">"
                            . "<a href=\"#\" class=\"rounded-circle btn2 \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Responsable: $nombre $apellido\">";
                    if ($pagina == 0) {
                        if ($foto == "advertencia.svg") {
                            $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                        } else {
                            if ($foto == "") {
                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            } else {
                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            }
                        }
                    } else {
                        if ($foto == "advertencia.svg") {
                            $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                        } else {
                            if ($foto == "") {
                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            } else {
                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            }
                        }
                    }

//                                        $salida .= "<img class=\"rounded-circle img-fluid\" width=\"40px\" src=\"https://picsum.photos/id/870/300/300?grayscale&blur=2\">";

                    if ($pagina == 1) {
                        $more = "../svg/more.svg";
                    } else {
                        $more = "svg/more.svg";
                    }
                    $salida .= "</a></div>"
                            . "<div class=\"col-2 col-md-1 col-lg-1  text-left px-0\">"
                            . "<img class=\"rounded-circle img-fluid text-left mt-3\" width=\"10px\" src=\"$more\" data-toggle=\"collapse\" data-target=\"#collapse_$idAccion\" aria-expanded=\"false\" aria-controls=\"collapseExample\" onclick=\"obtenerComentariosSubtarea($idTarea, $pagina, $idAccion);\">"
                            . "</div>"
                            . "<div class=\"col-12\">"
                            . "<div class=\"collapse\" id=\"collapse_$idAccion\" data-parent=\"#planAccion\">"
                            . "<div class=\"card card-body border-0 bg-white\">"
                            . "<div class=\"row justify-content-center\">"
                            . "<div class=\"col-12 col-md-12 col-lg-9\">"
                            . "<input id=\"txtComentarioST$idAccion\" type=\"text\" class=\"form-control form-control-sm border-0 fs-10\" placeholder=\"Escriba aqui sus comentarios, al terminar presione ENTER\" onkeypress=\"agregarComentarioST($pagina, $idTarea, $idAccion, " . $_SESSION["usuario"] . ");\">"
                            . "</div>"
                            . "<div class=\"col-12 col-md-4 col-lg-1 mt-2\">"
                            . "<div class=\"btn-group btn-block\" role=\"group\" >"
                            . "<div class=\"upload-btn-wrapper\"><button class=\"btn btn-sm bg-body text-negron fs-10\">Adjuntar</button><input type=\"file\" id=\"tareaDoc$idAccion\" name=\"tareaDoc$idAccion\" onchange=\"tarea_subir_doc(1, $idTarea, $idAccion);\"/></div>"
                            . "<button onclick=\"obtenerSubtarea($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\" class=\"btn btn-sm bg-body text-negron fs-10 ml-1\">Editar</button>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";

//                    $salida .= "<div class=\"row justify-content-center\">"
//                            . "<div class=\"col-12\">"
//                            . "<div class=\"row rounded border-bottom\">"
//                            . "<div class=\"col-8 col-md-10 col-lg-10\">"
//                            . "<div class=\"row\">"
//                            . "<div class=\"col-10 col-md-11\">"
//                            . "<div class=\"custom-control custom-checkbox checklist mt-2\">";
//                    if ($statusAccion == "F") {
//                        $salida .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
//                    } else {
//                        $salida .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarSubTarea(this, $idTarea, $pagina);\">";
//                    }
//
//                    $salida .= "<label class=\"custom-control-label fs-11 \" for=\"chkb_$idAccion\">$tituloAccion</label>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "<div class=\"col-2 col-md-1 col-lg-1 text-center\">"
//                            . "<a href=\"#\" class=\"rounded-circle btn2 \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Responsable: $nombre $apellido\">";
//                    if ($pagina == 0) {
//                        if ($foto == "advertencia.svg") {
//                            $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                        } else {
//                            if ($foto == "") {
//                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                            } else {
//                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                            }
//                        }
//                    } else {
//                        if ($foto == "advertencia.svg") {
//                            $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                        } else {
//                            if ($foto == "") {
//                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombre+$apellido&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                            } else {
//                                $salida .= "<img onclick=\"setIdSubtarea($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-resp-accion\" src=\"../img/users/$foto\" class=\"rounded-circle\" width=\"20px\" height=\"20px\"></a>";
//                            }
//                        }
//                    }
//
////                                        $salida .= "<img class=\"rounded-circle img-fluid\" width=\"40px\" src=\"https://picsum.photos/id/870/300/300?grayscale&blur=2\">";
//
//                    $salida .= "</a></div>"
//                            . "<div class=\"col-2 col-md-1 col-lg-1  text-left px-0\">"
//                            . "<img class=\"rounded-circle img-fluid text-left mt-3\" width=\"10px\" src=\"../svg/more.svg\" data-toggle=\"collapse\" data-target=\"#collapse_$idAccion\" aria-expanded=\"false\" aria-controls=\"collapseExample\" onclick=\"obtenerComentariosSubtarea($idTarea, $pagina, $idAccion);\">"
//                            . "</div>"
//                            . "<div class=\"col-12\">"
//                            . "<div class=\"collapse\" id=\"collapse_$idAccion\" data-parent=\"#planAccion\">"
//                            . "<div class=\"card card-body border-0 bg-white\">"
//                            . "<div class=\"row justify-content-center\">"
//                            . "<div class=\"col-12 col-md-12 col-lg-9\">"
//                            . "<input id=\"txtComentarioST$idAccion\" type=\"text\" class=\"form-control form-control-sm border-0 fs-10\" placeholder=\"Escriba aqui sus comentarios, al termonar presione ENTER\" onkeypress=\"agregarComentarioST($idTarea, $idAccion, " . $_SESSION["usuario"] . ");\">"
//                            . "</div>"
//                            . "<div class=\"col-12 col-md-4 col-lg-1 mt-2\">"
//                            . "<div class=\"btn-group btn-block\" role=\"group\" >"
//                            . "<div class=\"upload-btn-wrapper\"><button class=\"btn btn-sm bg-body text-negron fs-10\">Adjuntar</button><input type=\"file\" id=\"tareaDoc$idAccion\" name=\"tareaDoc$idAccion\" onchange=\"tarea_subir_doc(1, $idTarea, $idAccion);\"/></div>"
//                            . "<button onclick=\"obtenerSubtarea($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\" class=\"btn btn-sm bg-body text-negron fs-10 ml-1\">Editar</button>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>"
//                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function completarSubtarea($idSubtarea, $status) {
        $conn = new Conexion();
        $conn->conectar();
        if ($idSubtarea == 0) {
            $query = "UPDATE t_tareas_subtareas SET status = '$status'";
        } else {
            $query = "UPDATE t_tareas_subtareas SET status = '$status' WHERE id = $idSubtarea";
        }

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    public function cambiarTipo($idTarea, $tipo) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_tareas WHERE id = $idTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $tipoTarea = $dts['tipo'];
                    $titulo = $dts['titulo'];
                    $tituloProyecto = $dts['titulo_proyecto'];
                }
                switch ($tipo) {
                    case 1://Pendiente
                        if ($tipoTarea == 1) {
                            $query = "UPDATE t_tareas SET titulo = '$titulo', titulo_proyecto = '', tipo = $tipo, capin = 'NO', capex = 'NO' WHERE id = $idTarea";
                        } else {
                            $query = "UPDATE t_tareas SET titulo = '$tituloProyecto', titulo_proyecto = '', tipo = $tipo, capin = 'NO', capex = 'NO' WHERE id = $idTarea";
                        }
                        break;
                    case 2://Proyecto
                        if ($tipoTarea == 1) {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$titulo', tipo = $tipo, capin = 'NO', capex = 'NO' WHERE id = $idTarea";
                        } else {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$tituloProyecto', tipo = $tipo, capin = 'NO', capex = 'NO' WHERE id = $idTarea";
                        }

                        break;
                    case 3://Proyecto capin
                        if ($tipoTarea == 1) {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$titulo', tipo = 2,  capin = 'SI', capex = 'NO' WHERE id = $idTarea";
                        } else {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$tituloProyecto', tipo = 2,  capin = 'SI', capex = 'NO' WHERE id = $idTarea";
                        }

                        break;
                    case 4://Proyecto Capex
                        if ($tipoTarea == 1) {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$titulo', tipo = 2,  capin = 'NO', capex = 'SI' WHERE id = $idTarea";
                        } else {
                            $query = "UPDATE t_tareas SET titulo = '', titulo_proyecto = '$tituloProyecto', tipo = 2,  capin = 'NO', capex = 'SI' WHERE id = $idTarea";
                        }

                        break;
                }


                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $conn->cerrar();
        return $resp;
    }

    public function cambiarCol($idTarea, $col) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_tareas SET subcategoria = $col WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    public function cambiarSeccion($idTarea, $seccion) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM c_secciones WHERE id = $seccion";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $imgSeccion = $dts['url_image'];
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }


        if ($seccion == 5 || $seccion == 6 || $seccion == 12) {
            $query = "SELECT * FROM c_subcategorias_zh WHERE id_seccion = $seccion ORDER BY grupo LIMIT 1";
        } else {
            $query = "SELECT * FROM c_grupos WHERE id_seccion = $seccion ORDER BY grupo LIMIT 1";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idGrupo = $dts['id'];
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $query = "UPDATE t_tareas SET id_seccion = $seccion, subcategoria = $idGrupo WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
            $resp = $imgSeccion;
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $conn->cerrar();
        return $resp;
    }

    public function cambiarFecha($idTarea, $tipoFec, $fecha) {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');
        $fec = date("Y-m-d", strtotime($fecha));
        switch ($tipoFec) {
            case 'i':
                $query = "UPDATE t_tareas SET fecha_i = '$fec' WHERE id = $idTarea";
                break;
            case 'f':
                $query = "UPDATE t_tareas SET fecha_f = '$fec' WHERE id = $idTarea";
                break;
        }
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    public function cambiarEstado($idTarea, $estado) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_tareas SET status = '$estado' WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {
                $query = "UPDATE t_tareas_subtareas SET status = '$estado' WHERE id_tarea = $idTarea";
                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    public function obtPermitidosDestino($idDestino, $idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        $query = "SELECT * FROM t_tareas_secciones_permitidos WHERE id_seccion = $idSeccion AND id_destino = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUserPermitido = $dts['id_usuario'];
                    $query = "SELECT * FROM t_users WHERE id = $idUserPermitido";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColP = $dts['id_colaborador'];

                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColP";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombreP = $dts['nombre'];
                                            $apellidoP = $dts['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                    $salida .= "<option value=\"$idUserPermitido\">$nombreP $apellidoP</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        $conn->cerrar();
        return $salida;
    }

    public function obtenerPlanAccion($idSeccion, $idDestino) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $query = "SELECT * FROM t_tareas WHERE id_seccion = $idSeccion AND id_destino = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idTarea = $dts['id'];
                    $tipoTarea = $dts['tipo'];
                    if ($tipoTarea == 1 || $tipoTarea == 3) {
                        $titulo = $dts['titulo'];
                    } else {
                        $titulo = $dts['titulo_proyecto'];
                    }

                    $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idResponsable = $dts['responsable'];
                                $subtarea = $dts['subtarea'];
                                $fechaLimite = $dts['fecha_limite'];
                                $status = $dts['status'];
                                $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $nombre = $dts['nombre'];
                                                        $apellido = $dts['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $salida = $ex;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                                switch ($status) {
                                    case 'N':
                                        $status = "PENDIENTE";
                                        break;
                                    case 'F':
                                        $status = "FINALIZADA";
                                        break;
                                }

                                $salida .= "<tr>"
                                        . "<td class=\"fs-10\">$subtarea</td>"
                                        . "<td class=\"fs-10\">$nombre $apellido</td>"
                                        . "<td class=\"fs-10\">$titulo</td>"
                                        . "<td class=\"fs-10\">$status</td>"
                                        . "</tr>";
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        $conn->cerrar();
        return $salida;
    }

    public function obtenerAdjuntosTarea($idTarea, $idSubtarea, $pagina) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idSubtarea == 0) {
            $query = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
        } else {
            $query = "SELECT * FROM t_tareas_adjuntos WHERE id_subtarea = $idSubtarea";
        }

        try {
            $adjuntos = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($adjuntos as $dts) {
                    $documento = $dts['url_doc'];

                    if ($documento != "") {
                        $info = new SplFileInfo($documento);
                        $ext = $info->getExtension();

                        switch ($ext) {
                            case 'docx':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'DOCX':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'pdf':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/pdf.svg";
                                } else {
                                    $url = "../svg/formatos/pdf.svg";
                                }
                                break;
                            case 'PDF':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/pdf.svg";
                                } else {
                                    $url = "../svg/formatos/pdf.svg";
                                }
                                break;
                            case 'jpg':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'JPG':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'jpeg':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'JPEG':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'svg':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'SVG':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'xlsx':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/xls.svg";
                                } else {
                                    $url = "../svg/formatos/xls.svg";
                                }
                                break;
                            case 'XLSX':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/xls.svg";
                                } else {
                                    $url = "../svg/formatos/xls.svg";
                                }
                                break;
                            case 'csv':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/xls.svg";
                                } else {
                                    $url = "../svg/formatos/xls.svg";
                                }
                                break;
                            case 'CSV':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/xls.svg";
                                } else {
                                    $url = "../svg/formatos/xls.svg";
                                }
                                break;
                            case 'pptx':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/ppt.svg";
                                } else {
                                    $url = "../svg/formatos/ppt.svg";
                                }
                                break;
                            case 'PPTX':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/ppt.svg";
                                } else {
                                    $url = "../svg/formatos/ppt.svg";
                                }
                                break;
                            case 'msg':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/txt.svg";
                                } else {
                                    $url = "../svg/formatos/txt.svg";
                                }
                                break;
                            case 'MSG':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/txt.svg";
                                } else {
                                    $url = "../svg/formatos/txt.svg";
                                }
                                break;
                            case 'png':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'PNG':
                                if ($pagina == 0) {
                                    $url = "tareas/adjuntos/$documento";
                                } else {
                                    $url = "../tareas/adjuntos/$documento";
                                }
                                break;
                            case 'rar':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/zip.svg";
                                } else {
                                    $url = "../svg/formatos/zip.svg";
                                }
                                break;
                            case 'RAR':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/zip.svg";
                                } else {
                                    $url = "../svg/formatos/zip.svg";
                                }
                            case 'zip':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/zip.svg";
                                } else {
                                    $url = "../svg/formatos/zip.svg";
                                }
                                break;
                            case 'ZIP':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/zip.svg";
                                } else {
                                    $url = "../svg/formatos/zip.svg";
                                }
                                break;
                            case 'DWG':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/zip.svg";
                                } else {
                                    $url = "../svg/formatos/zip.svg";
                                }
                                break;
                            case 'dwg':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/dwg.svg";
                                } else {
                                    $url = "../svg/formatos/dwg.svg";
                                }
                                break;
                        }

//                                $tarea->adjuntos .= $ext;

                        $salida .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
                                . "<a href=\"../tareas/adjuntos/$documento\" target=\"_blank\" class=\"justify-content-center\">"
                                . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$documento\">$documento</p>"
                                . "</a>"
                                . "</div>";
                    }
                }
            }
            $query = "SELECT * FROM t_tareas_cap_adjuntos WHERE id_tarea = $idTarea";

            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    $contador = 0;
                    foreach ($resp as $dts) {
                        $contador++;
                        $tipoCap = $dts['tipo'];
                        $coste1 = $dts['costo1'];
                        $urlCot1 = $dts['url_doc1'];
                        $coste2 = $dts['costo2'];
                        $urlCot2 = $dts['url_doc2'];
                        $coste3 = $dts['costo3'];
                        $urlCot3 = $dts['url_doc3'];

                        if ($urlCot1 != "") {
                            $salida .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
                                    . "<a href=\"../tareas/$tipoCap/$urlCot1\" target=\"_blank\" class=\"justify-content-center\">"
                                    . "<img src=\"../svg/cap/COT-01.svg\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                    . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot1\">$urlCot1</p>"
                                    . "</a>"
                                    . "</div>";
                        }

                        if ($urlCot2 != "") {
                            $salida .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
                                    . "<a href=\"../tareas/$tipoCap/$urlCot2\" target=\"_blank\" class=\"justify-content-center\">"
                                    . "<img src=\"../svg/cap/COT-02.svg\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                    . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot2\">$urlCot2</p>"
                                    . "</a>"
                                    . "</div>";
                        }
                        if ($urlCot3 != "") {
                            $salida .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
                                    . "<a href=\"../tareas/$tipoCap/$urlCot3\" target=\"_blank\" class=\"justify-content-center\">"
                                    . "<img src=\"../svg/cap/COT-03.svg\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                    . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlCot3\">$urlCot3</p>"
                                    . "</a>"
                                    . "</div>";
                        }
                    }
                }
            } catch (Exception $ex) {
                $salida = $ex;
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function obtUsuariosPorDestino($idDestino) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<option value=\"0\">TODOS</option>";
        if ($idDestino != "") {
            if ($idDestino != 0 && $idDestino != 10) {
                $query = "SELECT * FROM t_users WHERE id_destino = $idDestino ORDER BY username";
            } else {
                $query = "SELECT * FROM t_users ORDER BY username";
            }

            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idUsuario = $dts['id'];
                        $idCol = $dts['id_colaborador'];

                        $query = "SELECT * FROM t_colaboradores WHERE id = $idCol";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $nombre = $dts['nombre'];
                                    $apellido = $dts['apellido'];
                                }
                                $salida .= "<option value=\"$idUsuario\">$nombre $apellido</<option>";
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }
                    }
                }
            } catch (Exception $ex) {
                $salida = $ex;
            }
        }
        $conn->cerrar();
        return $salida;
    }

    public function buscarTareasPorPalabra($word, $idSeccion, $idDestino, $status) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12 || $idSeccion == 18 || $idSeccion == 21 || $idSeccion == 22 || $idSeccion == 15 || $idSeccion == 16) {
            $query = "SELECT * FROM c_subcategorias_zh WHERE id_seccion = $idSeccion ORDER BY grupo";
        } else {
            $query = "SELECT * FROM c_grupos WHERE id_seccion = $idSeccion ORDER BY grupo";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSubcategoria = $dts['id'];
                    $subcategoria = $dts['grupo'];

                    $salida .= "<div id=\"$idSubcategoria\" class=\"col-12 col-md-5 col-lg-5 bg-boddy2 rounded ml-2 mr-2 columnas\" ondrop=\"drop(this, event)\" ondragenter=\"return false\" ondragover=\"return false\" style=\"height: 580px; overflow: auto;\">"//colunmas de subcategorias
                            . "<p class=\"text-center small\">$subcategoria</p>"
                            . "<div class=\"row\">"
                            . "<div class=\"col text-center\">"
                            . "<img src=\"../svg/agregar.svg\" width=\"27\" data-toggle=\"modal\" data-target=\"#modal-agregar-tarea\" onclick=\"insertarTarea($idSubcategoria, $idSeccion);\">"
                            . "</div>"
                            . "</div>";
                    if ($idDestino == 10) {

                        $query = "SELECT * FROM t_tareas WHERE (titulo LIKE '%$word%' OR titulo_proyecto LIKE '%$word%' OR descripcion LIKE '%$word%') "
                                . "AND (subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND status = '$status') ORDER BY tipo";
                    } else {
                        $query = "SELECT * FROM t_tareas WHERE (titulo LIKE '%$word%' OR titulo_proyecto LIKE '%$word%' OR descripcion LIKE '%$word%')"
                                . "AND (subcategoria = $idSubcategoria AND id_seccion = $idSeccion AND activo = 1 AND id_destino = $idDestino AND status = '$status') ORDER BY tipo";
                    }

                    try {
                        $tareas = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($tareas as $tarea) {
                                $idTarea = $tarea['id'];
                                $tituloSituacion = $tarea['titulo'];
                                $tituloProyecto = $tarea['titulo_proyecto'];
                                $descripcionTarea = $tarea['descripcion'];
                                $fecCreacion = $tarea['fecha_creacion'];
                                $tipo = $tarea['tipo'];
                                $statusTarea = $tarea['status'];
                                $capex = $tarea['capex'];
                                $statusCapex = $tarea['status_capex'];
                                $capin = $tarea['capin'];
                                $statusCapin = $tarea['status_capin'];
                                $idDestinoTarea = $tarea['id_destino'];
                                $idSeccionTarea = $tarea['id_seccion'];
                                $idUsuarioCreador = $tarea['creado'];

                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoTarea";
                                try {
                                    $destinos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($destinos as $dts) {
                                            $nombreDestino = $dts['destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                $contF = 0;
                                $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                                try {
                                    $result = $conn->obtDatos($query);
                                    $totalST = $conn->filasConsultadas;
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $dts) {
                                            $statusST = $dts['status'];
                                            if ($statusST == "F") {
                                                $contF ++;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }


                                $query = "SELECT * FROM t_users WHERE id = $idUsuarioCreador";
                                try {
                                    $creador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($creador as $dts) {
                                            $idDestinoCreador = $dts['id_destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }


                                $salida .= "<div id=\"$idTarea\" class=\"card mt-3 mb-3\"draggable=\"true\" ondragstart=\"dragstart(this, event)\">";

                                if ($idDestinoCreador == 10) {
                                    $salida .= "<div class=\"card-body rounded bg-rojoc my-no-padding shadow-sm\">";
                                } else {
                                    $salida .= "<div class=\"card-body rounded bg-white my-no-padding shadow-sm\">";
                                }

                                $salida .= "<div class=\"row\">"
                                        . "<div class=\"col-8 col-md-8 col-lg-8 text-truncate\">"
                                        . "<a href=\"#\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleTarea($idTarea)\">";

                                if ($capex == "SI") {
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-capex.svg\" width=\"7.5\">";
                                } elseif ($capin == "SI") {
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-capin.svg\" width=\"7.5\">";
                                } elseif ($tipo == 1) {//situacion
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-pendiente.svg\" width=\"7.5\">";
                                } elseif ($tipo == 2) {//Proyecto
                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-proyecto.svg\" width=\"7.5\">";
                                }
//                                elseif ($tipo == 3) {//Pendiente
//                                    $salida .= "<img class=\"\" src=\"../svg/banners/tag-pendiente.svg\" width=\"15\">";
//                                }

                                $salida .= " <span class=\"no-gutters fs-10 spSemibold\">$nombreDestino</span> ";

                                if ($tituloSituacion != "") {
                                    $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloSituacion\">";
                                    $salida .= $tituloSituacion;
                                } else {
                                    $salida .= "<span class=\"no-gutters fs-10 spSemibold crop-text-1\" data-toggle=\"tooltip\" title=\"$tituloProyecto\">";
                                    $salida .= $tituloProyecto;
                                }
                                $salida .= "</span>";

                                $salida .= "</a></div>"
                                        . "<div class=\"col-4 col-md-4 col-lg-4 text-right\">"
                                        . "<div class=\"btn-group mt-4 mr-3\" role=\"group\" aria-label=\"Basic example\">"
                                        . "<p class=\"no-gutters fs-10 spSemibold\">$contF/$totalST</p>";

                                $queryAdjuntos = "SELECT * FROM t_tareas_adjuntos WHERE id_tarea = $idTarea";
                                try {
                                    $resp = $conn->obtDatos($queryAdjuntos);
                                    if ($conn->filasConsultadas > 0) {//Si la tarea tiene datos adjuntos
                                        $hayAdjuntos = "SI";
                                    } else {
                                        $hayAdjuntos = "";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                $queryComentarios = "SELECT * FROM t_tareas_comentarios WHERE id_tarea = $idTarea";
                                try {
                                    $resp = $conn->obtDatos($queryComentarios);
                                    if ($conn->filasConsultadas > 0) {
                                        $hayComentarios = "SI";
                                    } else {
                                        $hayComentarios = "";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                $salida .= "</div>";

                                if ($statusTarea == "N") {
                                    if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pac.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pa.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-pc.svg\" width=\"25\">";
                                    } else {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-p.svg\" width=\"25\">";
                                    }
                                } else if ($statusTarea == "P") {
                                    $salida .= "<img class=\"mx-2\" src=\"img/../svg/proceso.svg\" data-toggle=\"tooltip\" title=\"En proceso\" alt=\"status\" style=\"height: 20px;\">";
                                } elseif ($statusTarea == "F") {
                                    if ($hayAdjuntos == "SI" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-rca.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "SI" && $hayComentarios == "") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-ra.svg\" width=\"25\">";
                                    } elseif ($hayAdjuntos == "" && $hayComentarios == "SI") {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-rc.svg\" width=\"25\">";
                                    } else {
                                        $salida .= "<img class=\"\" src=\"../svg/banners/tag-r.svg\" width=\"25\">";
                                    }
                                }

                                $salida .= "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div><!--Fin de la tarjeta-->"; //Fin de tarjetas
                            }
                        }
                    } catch (Exception $ex) {
                        $salida .= $ex;
                    }
                    $salida .= ""
                            . ""
                            . "</div>"; //fin colunmas de subcategorias
                }
            }
        } catch (Exception $ex) {
            $salida .= $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function obtEquipoxGrupo($idGrupo, $idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $idDestino = $_SESSION['idDestino'];
        $salida = "";
        if ($idDestino == 10) {
            $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo";
        } else {
            if ($idSeccion == 6) {
                $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND id_destino = $idDestino";
            } else {
                $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];
                    $equipo = $dts['equipo'];

                    $salida .= "<option value=\"$idEquipo\">$equipo</option>";
                }
            } else {
                $salida .= "<option value=\"0\">Sin resultados</option>";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function copiarTarea($idTarea, $columnaDestino, $destino) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_tareas WHERE id = $idTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $tipo = $dts['tipo'];
                    $titulo = $dts['titulo'];
                    $tituloProyecto = $dts['titulo_proyecto'];
                    $subcategoria = $dts['subcategoria'];
                    $status = $dts['status'];
                    $fechaI = $dts['fecha_i'];
                    $fechaF = $dts['fecha_f'];
                    $descripcion = $dts['descripcion'];
                    $creado = $dts['creado'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $solucionado = $dts['solucionado'];
                    $fechaSolucionado = $dts['fecha_solucionado'];
                    $actualizado = $dts['actualizado'];
                    $envioCap = $dts['enviocap'];
                    $capex = $dts['capex'];
                    $statusCapex = $dts['status_capex'];
                    $capin = $dts['capin'];
                    $statusCapin = $dts['status_capin'];
                    $activo = $dts['activo'];
                    $idDestino = $dts['id_destino'];
                    $idSeccion = $dts['id_seccion'];
                    $responsable = $dts['responsable'];
                    $habitacion = $dts['habitacion'];
                    $idNumHab = $dts['idNumHab'];
                    $bloqueado = $dts['bloqueado'];
                    $fechaBloqueo = $dts['fecha_bloqueo'];
                    $fechaDesbloqueo = $dts['fecha_desbloqueo'];
                    $motivoBloqueo = $dts['motivo_bloqueo'];
                    $motivoDesbloqueo = $dts['motivo_desbloqueo'];
                    $responsable2 = $dts['responsable2'];
                    $añoProyecto = $dts['año_proyecto'];
                    $total = $dts['total'];
                    $mc = $dts['mc'];
                    $empresaExterna = $dts['empresa_externa'];
                    $costeMC = $dts['coste_mc'];
                }

                if ($destino != "") {
                    $idDestino = $destino;
                }

                if ($columnaDestino != "") {
                    $subcategoria = $columnaDestino;
                }

                $query = "INSERT INTO t_tareas(tipo, titulo, titulo_proyecto, subcategoria, status, fecha_i, fecha_f, descripcion, "
                        . "creado, fecha_creacion, solucionado, fecha_solucionado, enviocap, capex, status_capex, capin, "
                        . "status_capin, activo, id_destino, id_seccion, responsable, habitacion, idNumHab, bloqueado, fecha_bloqueo, "
                        . "fecha_desbloqueo, motivo_bloqueo, motivo_desbloqueo, responsable2, año_proyecto, total, mc, empresa_externa, coste_mc) "
                        . "VALUES($tipo, '$titulo', '$tituloProyecto', $subcategoria, 'N', '$fechaI', '$fechaF', '$descripcion', "
                        . "'$creado', '$fechaCreacion', $solucionado, '$fechaSolucionado', $envioCap, '$capex', '', '$capin', "
                        . "'', $activo, $idDestino, $idSeccion, $responsable, '$habitacion', $idNumHab, $bloqueado, '$fechaBloqueo', "
                        . "'$fechaDesbloqueo', '$motivoBloqueo', '$motivoDesbloqueo', $responsable2, '$añoProyecto', '$total', '$mc', $empresaExterna, '$costeMC')";

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        $query = "SELECT LAST_INSERT_ID(id) AS LAST FROM t_tareas ORDER BY id DESC LIMIT 0,1";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $NuevoIdTarea = $dts['LAST'];
                                }

                                $query = "SELECT * FROM t_tareas_subtareas WHERE id_tarea = $idTarea";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $subtarea = $dts['subtarea'];
                                            $statusST = $dts['status'];
                                            $duracion = $dts['duracion'];
                                            $creadoPor = $dts['creado_por'];
                                            $responsableST = $dts['responsable'];
                                            $fechaCreacionST = $dts['fecha_creacion'];
                                            $fechaLimite = $dts['fecha_limite'];
                                            $reprogramado = $dts['reprogramado'];
                                            $fechaReprogramacion = $dts['fecha_reprogramacion'];
                                            $reprogramadoPor = $dts['reprogramado_por'];
                                            $ultimaActualizacion = $dts['ultima_actualizacion'];
                                            $empresaExternaST = $dts['empresa_externa'];

                                            $query = "INSERT INTO t_tareas_subtareas(id_tarea, subtarea, status, duracion, creado_por, "
                                                    . "responsable, fecha_creacion, fecha_limite, reprogramado, fecha_reprogramacion, "
                                                    . "reprogramado_por, empresa_externa) "
                                                    . "VALUES($NuevoIdTarea, '$subtarea', 'N', $duracion, $creadoPor, "
                                                    . "$responsableST, '$fechaCreacionST', '$fechaLimite', $reprogramado, '$fechaReprogramacion', "
                                                    . "$reprogramadoPor, $empresaExterna)";
                                            try {
                                                $resp = $conn->consulta($query);
                                            } catch (Exception $ex) {
                                                $resp = $ex;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $resp = $ex;
                                }
                            } else {
                                $resp = "-1";
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    } else {
                        $resp = "Sin resultados";
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

}

?>
