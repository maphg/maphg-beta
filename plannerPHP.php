<?php

setlocale(LC_MONETARY, 'en_US');
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if($action == "actualizarTarea"){
        $idTarea = $_POST['idTarea'];
        $titulo = $_POST['titulo'];
        $obj = new Planner();
        $resp = $obj->actualizarTarea($idTarea, $titulo);
        echo $resp;
    }
    
    if($action == "eliminarTarea"){
        $idTarea = $_POST['idTarea'];
        $obj = new Planner();
        $resp = $obj->eliminarTarea($idTarea);
        echo $resp;
    }
    
    if ($action == 1) {
        $idDestino = $_POST['idDestino'];

        $obj = new Planner();
        $resp = $obj->crearTableros($idDestino);
        echo $resp;
    }

    if ($action == 2) {
        $idUsuario = $_POST['idUsuario'];
        $idSecciones = $_POST['idSeccion'];
        $tipo = $_POST['tipo'];
        $idPermiso = $_POST['idPermiso'];
        $obj = new Planner();
        $resp = $obj->showHideCols($idSecciones, $idUsuario);
        $resp = $obj->recargarCols($idPermiso, $idUsuario, $tipo);
        echo $resp;
    }

    if ($action == 3) {
        $idGrupo = $_POST['idGrupo'];
        $idDestino = $_POST['idDestino'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $idRelCatSubcat = $_POST['idRelCatSubcat'];
        $obj = new Planner();
        $resp = $obj->obtenerEquipos($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat);
        echo json_encode($resp);
    }

    if ($action == 4) {
        $idSubseccion = $_POST['idSubseccion'];
        $idDestino = $_POST['idDestino'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $idRelSubcategoria = $_POST['idRelSubcategoria'];
        $obj = new Planner();
        $resp = $obj->obtDetalleSubcategoria($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);
        echo json_encode($resp);
    }

    if ($action == 5) {
        $idDestino = $_POST['idDestino'];
        $idSubseccion = $_POST['idSubseccion'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->recargarMCPAPF($idDestino, $idSubseccion, $idCategoria, $idSubcategoria, $status);
        echo $resp;
    }

    if ($action == 6) {
        $idTarea = $_POST['idTarea'];
        $obj = new Planner();
        $resp = $obj->obtDetalleTarea($idTarea);
        echo json_encode($resp);
    }

    if ($action == 7) {
        $idTarea = $_POST['idTarea'];
        $comentario = $_POST['comentario'];
        $obj = new Planner();
        $resp = $obj->insertarComentario($idTarea, $comentario);
        echo $resp;
    }

    if ($action == 8) {
        $idTarea = $_POST['idTarea'];
        $obj = new Planner();
        $resp = $obj->obtenerTimeLine($idTarea);
        echo $resp;
    }

    if ($action == 9) {
        $idTarea = $_POST['idTarea'];
        $fechas = $_POST['fechas'];
        $obj = new Planner();
        $resp = $obj->actualizarRangoFechas($idTarea, $fechas);
        echo $resp;
    }

    if ($action == 10) {
        $idDestino = $_POST['idDestino'];
        $palabra = $_POST['palabra'];

        if (isset($_POST['proyecto'])) {
            $proyecto = "SI";
        } else {
            $proyecto = "NO";
        }

        $obj = new Planner();
        $resp = $obj->buscarUsuarios($idDestino, $palabra, $proyecto);
        echo $resp;
    }

    if ($action == 11) {
        $idActividad = $_POST['idActividad'];
        $idUsuario = $_POST['idUsuario'];
        $obj = new Planner();
        $resp = $obj->agregarResponsableActividad($idUsuario, $idActividad);
        echo $resp;
    }

    if ($action == 12) {
        $idActividad = $_POST['idActividad'];
        $status = $_POST['status'];
        $idUsuario = $_POST['completo'];
        $obj = new Planner();
        $resp = $obj->completarTarea($idActividad, $status, $idUsuario);
        echo $resp;
    }

    if ($action == 13) {
        $idEquipo = $_POST['idEquipo'];
        $actividad = $_POST['actividad'];
        $idGrupo = $_POST['idGrupo'];
        $idDestino = $_POST['idDestino'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $usuario = $_SESSION['usuario'];
        $obj = new Planner();
        $resp = $obj->agregarTarea($idEquipo, $actividad, $usuario, $idGrupo, $idDestino, $idCategoria, $idSubcategoria);
        echo $resp;
    }

    if ($action == 14) {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtDetalleEquipo($idEquipo);
        echo json_encode($resp);
    }

    if ($action == 15) {
        $idEquipo = $_POST['idEquipo'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->recargarMCEq($idEquipo, $status);
        echo $resp;
    }

    if ($action == 16) {
        $idPlan = $_POST['idPlan'];
        $obj = new Planner();
        $resp = $obj->obtDetallePlan($idPlan);
        echo $resp;
    }

    if ($action == 17) {
        $idPlaneacion = $_POST['idPlaneacion'];
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtDetalleOT($idPlaneacion, $idEquipo);
        echo json_encode($resp);
    }

    if ($action == 18) {
        $idOT = $_POST['idOT'];
        $comentario = $_POST['comentario'];
        $obj = new Planner();
        $resp = $obj->insertarComentarioOT($idOT, $comentario);
        echo $resp;
    }

    if ($action == 19) {
        $idOT = $_POST['idOT'];
        $obj = new Planner();
        $resp = $obj->obtenerTimeLineOT($idOT);
        echo $resp;
    }

    if ($action == 20) {
        $idOT = $_POST['idOT'];
        $realizadoPor = $_POST['realizadoPor'];
        $fechaRealizado = $_POST['fechaRealizado'];
        $lstActividades = $_POST['lstActividades'];
        $obj = new Planner();
        $resp = $obj->cerrarOT($idOT, $realizadoPor, $fechaRealizado, $lstActividades);
        echo $resp;
    }

    if ($action == 21) {
        $equipo = $_POST['equipo'];
        $idDestino = $_POST['idDestino'];
        $idSubseccion = $_POST['idSubseccion'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $obj = new Planner();
        $resp = $obj->buscarEquipo($equipo, $idDestino, $idSubseccion, $idCategoria, $idSubseccion);
        echo $resp;
    }

    //PROYECTOS
    if ($action == 22) {
        $idProyecto = $_POST['idProyecto'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];

        $obj = new Planner();
        $resp = $obj->obtenerDetalleProyecto($idProyecto);
        echo json_encode($resp);
    }

    if ($action == 23) {
        $idProyecto = $_POST['idProyecto'];
        $actividad = $_POST['actividad'];
//        $idGrupo = $_POST['idGrupo'];
//        $idDestino = $_POST['idDestino'];
//        $idCategoria = $_POST['idCategoria'];
//        $idSubcategoria = $_POST['idSubcategoria'];
        $usuario = $_SESSION['usuario'];
        $obj = new Planner();
        $resp = $obj->agregarActividadProyecto($idProyecto, $actividad, $usuario);
        echo $resp;
    }

    if ($action == 24) {
        $idActividad = $_POST['idActividad'];
        $idUsuario = $_SESSION['usuario'];
        $comentario = $_POST['comentario'];
        $obj = new Planner();
        $resp = $obj->agregarComentariosProy($idActividad, $idUsuario, $comentario);
        echo $resp;
    }

    if ($action == 25) {
        $idProyecto = $_POST['idProyecto'];
        $tipo = $_POST['tipo'];
        $obj = new Planner();
        $resp = $obj->cambiarTipoProyecto($idProyecto, $tipo);
        echo $resp;
    }

    if ($action == 26) {
        $idProyecto = $_POST['idProyecto'];
        $titulo = $_POST['titulo'];
        $justificacion = $_POST['justificacion'];
        $año = $_POST['año'];
        $coste = $_POST['coste'];
        $obj = new Planner();
        $resp = $obj->actualizarDatosProyecto($idProyecto, $titulo, $justificacion, $año, $coste);
        echo $resp;
    }

    if ($action == 27) {
        $idActividad = $_POST['idActividad'];
        $idUsuario = $_POST['idUsuario'];
        $obj = new Planner();
        $resp = $obj->agregarResponsableActividadProyecto($idUsuario, $idActividad);
        echo $resp;
    }

    if ($action == 28) {
        $idProyecto = $_POST['idProyecto'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->recargarPAProyecto($idProyecto, $status);
        echo $resp;
    }

    if ($action == 29) {
        $idActividad = $_POST['idActividad'];
        $status = $_POST['status'];
        $idUsuario = $_POST['completo'];
        $obj = new Planner();
        $resp = $obj->completarTareaProyecto($idActividad, $status, $idUsuario);
        echo $resp;
    }

    if ($action == 30) {
        $idProyecto = $_POST['idProyecto'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->completarProyecto($idProyecto, $status);
        echo $resp;
    }

    if ($action == 31) {
        $idActividad = $_POST['idActividad'];
        $obj = new Planner();
        $resp = $obj->eliminarActividadProyecto($idActividad);
        echo $resp;
    }

    if ($action == 32) {
        $idAdjunto = $_POST['idAdjunto'];
        $tipo = $_POST['tipo'];
        $obj = new Planner();
        $resp = $obj->eliminarAdjuntoProyecto($idAdjunto, $tipo);
        echo $resp;
    }

    if ($action == 33) {
        $idActividad = $_POST['idActividad'];
        $obj = new Planner();
        $resp = $obj->obtenerComentariosActividad($idActividad);
        echo $resp;
    }

    if ($action == 34) {
        $tipoProyecto = $_POST['tipoProyecto'];

        $obj = new Planner();
        $resp = $obj->setTipoProyecto($tipoProyecto);
        echo $resp;
    }

    if ($action == 35) {
        $idSeccion = $_POST['idSeccion'];

        $obj = new Planner();
        $resp = $obj->setSeccion($idSeccion);
        echo $resp;
    }

    if ($action == 36) {
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idEquipo = $_POST['idEquipo'];
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $estado = $_POST['estado'];

        $obj = new Planner();
        $resp = $obj->buscarMC($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado);
        echo $resp;
    }

    if ($action == 37) {
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];


        $obj = new Planner();
        $resp = $obj->buscarEquipos($idSeccion, $idSubseccion);
        echo $resp;
    }

    if ($action == 38) {
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idEquipo = $_POST['idEquipo'];
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $status = $_POST['estatus'];
        $obj = new Planner();
        $resp = $obj->buscarOTS($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $status);
        echo $resp;
    }

    if ($action == 39) {
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idEquipo = $_POST['idEquipo'];
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $estado = $_POST['estado'];
        $idResponsable = $_POST['idResponsable'];
        $obj = new Planner();
        $resp = $obj->buscarMisPendientes($idResponsable, $idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado);
        echo $resp;
    }

    if ($action == 40) {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        //$idCategoria = $_POST['idCategoria'];
        $tituloProyecto = $_POST['tituloProyecto'];
        $justificacion = $_POST['justificacion'];
        $tipoProyecto = $_POST['tipoProyecto'];
        $coste = $_POST['coste'];
        $año = $_POST['año'];

        if (!empty($_FILES)) {
            $storeFolder = '../planner/proyectos/'; //2
            //Tratar la imagen para renombrarla y subirla al servidor, guardar el nombre de archivo enviarlo
            //al metodo para el registro en la base de datos.
            $tempFile = $_FILES['fileToUpload']['tmp_name'];
            $realFileName = $_FILES['fileToUpload']['name'];
            $file = pathinfo($realFileName);
            $fileExtension = $file['extension'];
            $targetPath = $storeFolder;
            $fileName = "$tipoProyecto_$realFileName";
            $targetFile = $targetPath . $fileName;
            move_uploaded_file($tempFile, $targetFile);
        } else {
            $fileName = "";
        }

        $obj = new Planner();
        $resp = $obj->agregarProyecto($idDestino, $idSeccion, $idSubseccion, $tituloProyecto, $justificacion, $tipoProyecto, $coste, $año, $fileName);
        echo $resp;
    }
}

Class Equipo {

    public $idEquipo;
    public $nombreEquipo;
    public $idTipoEquipo;
    public $infoEquipo;
    public $planMC;
    public $comentariosMC;
    public $planMP;
    public $historicoMP;
    public $historicoOT;
    public $test;
    public $idDestino;
    public $idSubseccion;
    public $idSubcategoria;
    public $adjuntos;
    public $comentarios;
    public $comentariosTest;
    public $adjuntosTest;
    public $graficaGant;

}

Class Proyecto {

    public $id;
    public $titulo;
    public $justificacion;
    public $tipo;
    public $año;
    public $coste;
    public $status;
    public $planAccion;
    public $adjuntos;
    public $justificaciones;
    public $comentarios;
    public $idDestino;
    public $idSeccion;
    public $idSubseccion;
    public $destinoProyecto;
    public $seccionProyecto;
    public $subseccionProyecto;

}

Class DetalleEquipo {

    public $idEquipo;
    public $cod2bend;
    public $nombre;
    public $matricula;
    public $marca;
    public $modelo;
    public $serie;
    public $tipo;
    public $CECO;
    public $idDestino;
    public $destino;
    public $seccion;
    public $subseccion;
    public $area;
    public $localizacion;
    public $ubicacion;
    public $sububicacion;
    public $statusEquipo;
    public $jerarquia;
    public $unidades;
    public $imagenes;
    public $urlArchivos;
    public $tareasMC;
    public $planeacionMP;
    public $historialOT;
    public $adjuntos;

}

Class TareaMC {

    public $id;
    public $idTarea;
    public $idEquipo;
    public $actividad;
    public $status;
    public $creadoPor;
    public $responsable;
    public $fechaInicio;
    public $fechaFin;
    public $fechaRealizado;
    public $realizadoPor;
    public $fechaCreacion;
    public $ultimaModificacion;
    public $activo;
    public $idDestino;
    public $idSeccion;
    public $idSubseccion;
    public $idCategoria;
    public $idSubcategoria;
    public $semanInicion;
    public $semanFin;
    public $timeLine;

}

Class OrdenTrabajo {

    public $id;
    public $folio;
    public $idPlaneacion;
    public $idEquipo;
    public $fechaCreacion;
    public $creadoPor;
    public $listActividades;
    public $idDestino;
    public $equipo;
    public $nombrePlan;
    public $status;
    public $timeLine;
    public $idPlan;
    public $realizadoPor;
    public $fechaRealizado;

}

Class DetalleMPRealizado {

    public $listActividades;
    public $comentarios;
    public $adjuntos;

}

Class ListaEquipo {

    public $idSeccion;
    public $nombreSeccion;
    public $idSubseccion;
    public $nombreSubseccion;
    public $listaEquipos;

}

Class Planner {

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
            exit($ex);
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
                        exit($ex);
                    }

                    try {
                        if ($tTotal > 0) {
                            $tPor = ($tF * 100) / $tTotal;
                        } else {
                            $tPor = 100;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
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
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function setTipoProyecto($tipoProyecto) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $_SESSION['tipoProyecto'] = $tipoProyecto;

        $conn->cerrar();
        return $salida;
    }

    public function setSeccion($idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $_SESSION['idSeccion'] = $idSeccion;

        $conn->cerrar();
        return $salida;
    }

    public function showHideCols($idSecciones, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_users SET DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0, ZHPGP = 0, ZHPTRS = 0,"
                . "ZIA = 0, ZIC = 0, ZIE = 0, ZIL = 0, OMA = 0, DEP = 0, AUTO = 0, "
                . "ZHA = 0, ZHC = 0, ZHP = 0, SEG = 0, ZHH = 0 WHERE id = $idUsuario";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
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
                            case 'ZHH':
                                $query = "UPDATE t_users SET ZHH = 1 WHERE id = $idUsuario";
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
                            exit($ex);
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($ex);
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
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
                    $zhh = $dts['ZHH'];
                    $seg = $dts['SEG'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        if ($idPermiso == 1 || $idPermiso == 3) {
            $cols = new Planner();
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
                            case 'ZHH':
                                if ($zhh == 1) {
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
                $salida = $ex;
                exit($ex);
            }
        }
        $conn->cerrar();
        return $salida;
    }

    public function mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion) {
        $salida = "";
        $lstSecciones = [];
        if (isset($_SESSION['idDestino'])) {
            $idDestino = $_SESSION['idDestino'];
        } else {
            $idDestino = 10;
        }

        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        try {
            $out = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($out as $s) {
                    $destino = $s['destino'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $query = "SELECT seccion, titulo_seccion, url_image, url_video FROM c_secciones WHERE id = $idSeccionTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreSeccion = $dts['seccion'];
                    $tituloSeccion = $dts['titulo_seccion'];
                    $urlImage = $dts['url_image'];
                    $urlVideo = $dts['url_video'];
                }
            } else {
                $tituloSeccion = "";
                $urlImage = "";
                $urlVideo = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $numeroTotalPendientes = 0;
        $numeroTotalSolucionadas = 0;
        $numeroTotalNuevos = 0;
        $numeroFinalizadas = 0;
        $fecHoy = date("Y-m-d");
        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));

        //obtener el numero total de tareas pendientes y solucionadas
        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalPendientes += 1;
                    } else if ($statusTask == "F") {
                        $numeroTotalSolucionadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalNuevos += 1;
                    } else if ($statusTask == "F") {
                        $numeroFinalizadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "<div class=\"column is-3 has-text-centered mr-5\">"
                . "<img src=\"svg/secciones/$urlImage\" class=\"mb-4\" width=\"40px\" alt=\"\">"
                . "<div class=\"columnaTarea\">";

        //Se buscan las subsecciones que esten asociadas a la seccion segun el destino
        if ($idDestino == 10) {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_seccion = $idSeccionTarea";
        } else {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idRelDestSecc = $dts['id'];
                }
                $query = "SELECT id, id_subseccion FROM c_rel_seccion_subseccion WHERE id_rel_seccion = $idRelDestSecc";
                try {
                    $rels = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($rels as $d) {
                            $idRelSubseccionCat = $d['id'];
                            $idSubseccion = $d['id_subseccion'];
                            $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombreSubsecion = $dts['grupo'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            //Agregar las subsecciones a un arreglo para ordenarlos por orden alfabetico
                            $subSeccion = ["idSubseccion" => $idSubseccion, "nombreSubseccion" => $nombreSubsecion, "idRelSubseccionCat" => $idRelSubseccionCat];
                            $lstSecciones[] = $subSeccion;
                        }
                    }
                } catch (Exception $ex) {
                    $salida = $ex;
                }

                foreach ($lstSecciones as $key => $row) {
                    $aux[$key] = $row['nombreSubseccion'];
                }
                if (count($lstSecciones) > 0 && count($aux) > 0) {
                    array_multisort($aux, SORT_ASC, $lstSecciones);
                    foreach ($lstSecciones as $subseccion) {
                        $idRelSubseccionCat = $subseccion['idRelSubseccionCat'];
                        $query = "SELECT id, grupo FROM c_subsecciones WHERE id = " . $subseccion['idSubseccion'] . "";
                        try {
                            $resultsSS = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resultsSS as $ss) {
                                    $idSubseccion = $ss['id'];
                                    $nombreSubseccion = $ss['grupo'];
                                }
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        //obtener total de tareas por subseccion
                        if ($idDestino == 10) {
                            $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                        } else {
                            $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            $penSubseccion = $conn->filasConsultadas;
                        } catch (Exception $ex) {
                            echo $ex;
                        }

                        //********SECCION PROYECTOS************
                        if ($nombreSubseccion == "PROYECTOS") {//Si la subseccion son los proyectos
                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            } else {
                                $query = "SELECT id FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            }
                            try {
                                $proyectos = $conn->obtDatos($query);
                                $totalProys = $conn->filasConsultadas;
                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    //Titulo de la subseccion
                                    . "<div class=\"column has-text-left is-11 pad-03 manita\">"
                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    //Contador de tareas
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($totalProys > 0) {
                                $salida .= "<span class=\"tag is-danger\">";
                                $numeroDigitos = strlen($totalProys);
                                if ($numeroDigitos > 1) {
                                    $salida .= $totalProys;
                                } else {
                                    $salida .= "0$totalProys";
                                }
                                $salida .= "</span>";
                            }

                            $salida .= "</div>"
                                    . "</div>"//Fin del contador de tareas
                                    . "</div>";
                            //Seccion del collapse
                            //*******LISTADO DE LOS PROYECTOS*********
                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    . "<div class=\"columns is-mobile mb-2\">"
                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                    . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
                                    . "</div>"
                                    . "</div>";
                            if ($idDestino == 10) {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
                            } else {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
                            }

                            try {
                                $proyectos = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($proyectos as $pr) {
                                        $idProyecto = $pr['id'];
                                        $tituloProyecto = $pr['titulo'];
                                        $tipoProyecto = $pr['tipo'];
                                        $idDestinoProyecto = $pr['id_destino'];

                                        $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
                                        try {
                                            $out = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($out as $s) {
                                                    $destinoProy = $s['destino'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }
                                        if ($tipoProyecto == "CAPEX") {
                                            $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
                                        } else if ($tipoProyecto == "CAPIN") {
                                            $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
                                        } else {
                                            $imgTipo = "";
                                        }

                                        $query = "SELECT id FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            $totalPA = $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
                                                . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                                . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
                                                . "</div>"
                                                . "<div class=\"column is-1 pad-03\">"
                                                . "<div class=\"tags has-addons\">";
                                        if ($totalPA > 0) {
                                            $salida .= "<span class=\"tag is-danger\">";
                                            $numeroDigitos = strlen($totalPA);
                                            if ($numeroDigitos > 1) {
                                                $salida .= $totalPA;
                                            } else {
                                                $salida .= "0$totalPA";
                                            }
                                            $salida .= "</span>";
                                        }
                                        $salida .= "</div>"
                                                . "</div>"
                                                . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            $salida .= "</div>";
                        }
                        //******** RESTO DE LAS SECCIONES **********
                        else {//Las demas subsecciones
                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\" >"
                                    . "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\">"
                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    . "<div class=\"column pad-03\" onclick=\"mostrarMapa('$destino', '$nombreSeccion', '$nombreSubseccion');\">"
                                    . "<h7 class=\"title is-7 manita\"><span></span> Ver Mapa</h7>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($penSubseccion > 0) {
                                $salida .= "<span class=\"tag is-danger\">";
                                $numeroDigitos = strlen($penSubseccion);
                                if ($numeroDigitos > 1) {
                                    $salida .= $penSubseccion;
                                } else {
                                    $salida .= "0$penSubseccion";
                                }
                                $salida .= "</span>";
                            }
                            $salida .= "</div>"
                                    . "</div>"
                                    . "</div>";

                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">";
                            $query = "SELECT id, id_categoria FROM c_rel_subseccion_categoria WHERE id_rel_subseccion = $idRelSubseccionCat";

                            try {
                                $relcategorias = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($relcategorias as $c) {
                                        $idRelSubcategoria = $c['id'];
                                        $idCategoria = $c['id_categoria'];

                                        $query = "SELECT categoria, equipos FROM c_categorias_planner WHERE id = $idCategoria";
                                        try {
                                            $cats = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($cats as $cc) {
                                                    $nombreCategoria = $cc['categoria'];
                                                    $verEquipos = $cc['equipos'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        //*************PREVENTIVO CORRECTIVO Y EQUIPOS****************
                                        if ($nombreCategoria == "MP/MC - EQUIPOS") {//Equipos y tareas
                                            //obtener total por categoria
                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            } else {
                                                $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $penCategoria = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }

                                            //obtener total de tareas generales 
                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_categoria = 6 AND activo = 1 AND status = 'N'";
                                            } else {
                                                $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_categoria = 6 AND activo = 1 AND status = 'N'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $totalTareas = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }


                                                    $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";


                                                    $salida .= "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>"
                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                                    try {
                                                        $relSC = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($relSC as $sc) {
                                                                $idRelCatSubcat = $sc['id'];
                                                                $idSubcategoria = $sc['id_subcategoria'];

                                                                $query = "SELECT subcategoria, equipos FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                                                                try {
                                                                    $subcategorias = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($subcategorias as $scs) {
                                                                            $nombreSubcategoria = $scs['subcategoria'];
                                                                            $verEquipo = $scs['equipos'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                //Obtener pendientes po subcategoria
                                                                if ($idDestino == 10) {
                                                                    $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                } else {
                                                                    $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                }
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    $penSubcategoria = $conn->filasConsultadas;
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                                if ($verEquipos == 1) {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                } else {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                }


                                                                $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span>" . strtoupper($nombreSubcategoria) . "</h1>";


                                                                $salida .= "</div>";
                                                                $salida .= "<div class=\"column is-1 pad-03\">"
                                                                        . "<div class=\"tags has-addons\">";
                                                                if ($penSubcategoria > 0) {
                                                                    $salida .= "<span class=\"tag is-danger\">";
                                                                    $totalTareasGrales = $penSubcategoria + $totalTareas;
                                                                    $numeroDigitos = strlen($totalTareasGrales);
                                                                    if ($numeroDigitos > 1) {
                                                                        $salida .= $totalTareasGrales;
                                                                    } else {
                                                                        $salida .= "0$totalTareasGrales";
                                                                    }
                                                                    $salida .= "</span>";
                                                                }
                                                                $salida .= "</div>"
                                                                        . "</div>";
                                                                $salida .= "</div>";
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        $salida = $ex;
                                                    }
                                                    $salida .= "</div>";
                                                } else {
                                                    $idSubcategoria = 0;
                                                    $salida .= "<div class=\"columns is-mobile mb-2 \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
                                                    }
                                                    $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>"
                                                            . "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>";
                                                }
                                            } catch (Exception $ex) {
                                                $salida = $ex;
                                            }
                                        }
                                        //**********+BITACORAS STOCK INFORMACION*********************
                                        elseif ($nombreCategoria == "BITACORAS" || $nombreCategoria == "STOCK - PEDIDOS" || $nombreCategoria == "INFORMACION") {
                                            //obtener total por categoria
                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            } else {
                                                $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $penCategoria = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }

                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
                                                    } else {
                                                        $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
                                                    }

                                                    $salida .= "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>"
                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                                    try {
                                                        $relSC = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($relSC as $sc) {
                                                                $idRelCatSubcat = $sc['id'];
                                                                $idSubcategoria = $sc['id_subcategoria'];

                                                                $query = "SELECT * FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                                                                try {
                                                                    $subcategorias = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($subcategorias as $scs) {
                                                                            $nombreSubcategoria = $scs['subcategoria'];
                                                                            $verEquipo = $scs['equipos'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                //Obtener pendientes po subcategoria
                                                                if ($idDestino == 10) {
                                                                    $query = "SELECT * FROM t_mc WHERE id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                } else {
                                                                    $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                }
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    $penSubcategoria = $conn->filasConsultadas;
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                                if ($verEquipos == 1) {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                } else {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                }


                                                                $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a href=\"file-explorer.php?p=/$destino/$nombreSubcategoria/$nombreSeccion/$nombreSubseccion\">" . strtoupper($nombreSubcategoria) . "</a></h1>";


                                                                $salida .= "</div>";
                                                                $salida .= "<div class=\"column is-1 pad-03\">"
                                                                        . "<div class=\"tags has-addons\">";
                                                                if ($penSubcategoria > 0) {
                                                                    $salida .= "<span class=\"tag is-danger\">";
                                                                    $totalTareasGrales = $penSubcategoria + $totalTareas;
                                                                    $numeroDigitos = strlen($totalTareasGrales);
                                                                    if ($numeroDigitos > 1) {
                                                                        $salida .= $totalTareasGrales;
                                                                    } else {
                                                                        $salida .= "0$totalTareasGrales";
                                                                    }
                                                                    $salida .= "</span>";
                                                                }
                                                                $salida .= "</div>"
                                                                        . "</div>";
                                                                $salida .= "</div>";
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        $salida = $ex;
                                                    }
                                                    $salida .= "</div>";
                                                } else {
                                                    $idSubcategoria = 0;
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }

                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
                                                    } else {
                                                        $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
                                                    }

                                                    $salida .= "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>";
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

                            $salida .= "</div>";
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

    public function obtenerEquipos($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat) {
        $listaEquipo = new ListaEquipo();
        date_default_timezone_set('America/Mexico_City');
        $currentWeek = date("W");
        $conn = new Conexion();
        $conn->conectar();
        $lstEquipo = [];

        $listaEquipo->idSubseccion = $idGrupo;
        $query = "SELECT id_seccion, grupo FROM c_subsecciones WHERE id = $idGrupo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSeccion = $dts['id_seccion'];
                    $listaEquipo->idSeccion = $idSeccion;
                    $listaEquipo->nombreSubseccion = $dts['grupo'];
                }
            }
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        if ($idDestino == 10) {
            $query = "SELECT id FROM t_mc WHERE id_subseccion = $idGrupo AND id_categoria = 6 AND activo = 1 AND status = 'N'";
        } else {
            $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idGrupo AND id_categoria = 6 AND activo = 1 AND status = 'N'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $penCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        //Fila de las tareas generales del area
        $listaEquipo->listaEquipos = "<div class=\"columns tg mx-2 is-centered mb-0 pb-0\">"
                . "<div class=\"column manita is-3\" onclick=\"showListaTareas('show'); obtDetalleSubcategoria($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat);\">"
                . "<h6 class=\"title is-6 has-text-right text-truncate\"> <span><i class=\"fas fa-star-of-life has-text-danger\"></i></span> " . strtoupper("Tareas generales del area") . "</h6>"
                . "</div>"
                . "<div class=\"column is-1\">"
                . "<span class=\"tag is-danger\">$penCategoria</span>"
                . "</div>"
                //Columna de la grafica gant
                . "<div class=\"column is-three-fifths\">";
        for ($i = 1; $i <= 52; $i++) {
            $listaEquipo->listaEquipos .= "<img class=\"mr-1\" src=\"svg/semanas/s-$i.svg\" width=\"15px\" alt=\"\">";
        }
        $listaEquipo->listaEquipos .= "</div>"
                . "</div>";

        //Filas de la lista de equipos
        if ($idDestino == 10) {
            if ($idCategoria == 1) {
                if ($idGrupo == 12) {
                    $query = "SELECT subcategoria FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT id FROM c_hoteles WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo AND id_hotel = $idHotel ORDER BY id_destino";
                } else {
                    $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo ORDER BY id_destino";
                }
            } else {
                $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo AND categoria = $idCategoria AND pap = $idSubcategoria ORDER BY id_destino";
            }
        } else {
            if ($idCategoria == 1) {
                if ($idGrupo == 12) {
                    $query = "SELECT subcategoria FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT id FROM c_hoteles WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino AND id_hotel = $idHotel ORDER BY equipo";
                } else {
                    $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino ORDER BY equipo";
                }
            } else {
                $query = "SELECT id FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino AND categoria = $idCategoria AND pap = $idSubcategoria ORDER BY equipo";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];

                    $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroPendientes = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    $equipo = ["idEquipo" => $idEquipo, "cantPendientes" => $numeroPendientes];

                    $lstEquipo[] = $equipo;
                }
            }
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }
        $conn->cerrar();
        foreach ($lstEquipo as $key => $row) {
            $aux[$key] = $row['cantPendientes'];
        }
        if (count($lstEquipo) > 0 && count($aux) > 0) {
            array_multisort($aux, SORT_DESC, $lstEquipo);

            foreach ($lstEquipo as $eq) {
                $conn->conectar();
                $idEq = $eq['idEquipo'];
                $query = "call obtenerEquipo($idEq, $idGrupo)";
                //$query = "SELECT id, equipo, id_destino FROM t_equipos WHERE id = " . $eq['idEquipo'] . " AND id_subseccion = $idGrupo AND status = 'A' ORDER BY equipo";

                try {
                    $equipos = $conn->obtDatos($query);
                    $conn->cerrar();
                    if ($conn->filasConsultadas > 0) {
                        foreach ($equipos as $e) {
                            $idEquipo = $e['ID'];
                            $equipo = $e['EQUIPO'];
                            $idDestinoEquipo = $e['IDDESTINOEQ'];
                            $destinoEquipo = $e['DESTINOEQ'];

                            $conn->conectar();
                            $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalPenEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            $listaEquipo->listaEquipos .= "<div class=\"columns mx-2 is-centered mb-0 pb-0\">"
                                    . "<div class=\"column manita is-3\" onclick=\"showMPMC('show'); obtDetalleEquipo($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">"
                                    . "<h6 class=\"title is-6 has-text-right text-truncate\">" . strtoupper($equipo) . "</h6>"
                                    . "</div>"
                                    . "<div class=\"column is-1\">";
                            if ($totalPenEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<span class=\"tag is-danger\">$totalPenEquipo</span>";
                            }
                            $listaEquipo->listaEquipos .= "</div>"
                                    //Columna de las graficas
                                    . "<div class=\"column is-three-fifths\">";
                            for ($i = 1; $i <= 52; $i++) {
                                $finalizados = 0;
                                $programados = 0;
                                $proceso = 0;
                                $query = "SELECT status FROM t_mp_planeacion WHERE id_equipo = $idEquipo AND semana = $i AND activo = 1";
                                try {
                                    $result = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $d) {
                                            $statusPMP = $d['status'];
                                            switch ($statusPMP) {
                                                case 'N':
                                                    $programados += 1;
                                                    break;
                                                case 'P':
                                                    $proceso += 1;
                                                    break;
                                                case 'F':
                                                    $finalizados += 1;
                                                    break;
                                            }
                                        }
                                        if ($programados > 0 && $proceso > 0 && $finalizados > 0) {
                                            $colors = "PPRF.svg";
                                        } else if ($programados > 0 && $proceso > 0 && $finalizados == 0) {
                                            $colors = "PPR.svg";
                                        } else if ($programados > 0 && $proceso == 0 && $finalizados > 0) {
                                            $colors = "PF.svg";
                                        } else if ($programados > 0 && $proceso == 0 && $finalizados == 0) {
                                            $colors = "P.svg";
                                        } else if ($programados == 0 && $proceso > 0 && $finalizados == 0) {
                                            $colors = "PR.svg";
                                        } else if ($programados == 0 && $proceso == 0 && $finalizados > 0) {
                                            $colors = "F.svg";
                                        } else if ($programados == 0 && $proceso > 0 && $finalizados > 0) {
                                            $colors = "PRF.svg";
                                        }

                                        $listaEquipo->listaEquipos .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\">";
                                    } else {
                                        $listaEquipo->listaEquipos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    }
                                } catch (Exception $ex) {
                                    $listaEquipo = $ex;
                                    exit($ex);
                                }
                            }


                            $listaEquipo->listaEquipos .= "</div>"
                                    . "</div>";
                        }
                    }
                } catch (Exception $ex) {
                    $listaEquipo = $ex;
                    exit($ex);
                }
            }
        }

        $conn->cerrar();
        return $listaEquipo;
    }

    public function buscarEquipo($equipo, $idDestino, $idGrupo, $idCategoria, $idSubcategoria) {
        $conn = new Conexion();
        $salida = "";
        $conn->conectar();

        if ($equipo != "") {
            $query = "SELECT id, equipo, id_destino FROM t_equipos WHERE equipo LIKE '%$equipo%' AND id_destino = $idDestino AND id_subseccion = $idGrupo AND status = 'A'";
        } else {
            $query = "SELECT id, equipo, id_destini FROM t_equipos WHERE id_destino = $idDestino AND id_subseccion = $idGrupo AND status = 'A'";
        }
        try {
            $equipos = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($equipos as $e) {
                    $idEquipo = $e['id'];
                    $equipo = $e['equipo'];
                    $idDestinoEquipo = $e['id_destino'];

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $d) {
                                $destinoEquipo = $d['destino'];
                            }
                        } else {
                            $destinoEquipo = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $totalPenEquipo = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $salida .= "<div class=\"columns mx-2 is-centered mb-0 pb-0\">"
                            . "<div class=\"column manita is-3\" onclick=\"showMPMC('show'); obtDetalleEquipo($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">"
                            . "<h6 class=\"title is-6 has-text-right text-truncate\">" . strtoupper($equipo) . "</h6>"
                            . "</div>"
                            . "<div class=\"column is-1\">";
                    if ($totalPenEquipo > 0) {
                        $salida .= "<span class=\"tag is-danger\">$totalPenEquipo</span>";
                    }
                    $salida .= "</div>"
                            //Columna de las graficas
                            . "<div class=\"column is-three-fifths\">";
                    for ($i = 1; $i <= 52; $i++) {
                        $finalizados = 0;
                        $programados = 0;
                        $proceso = 0;
                        $query = "SELECT status FROM t_mp_planeacion WHERE id_equipo = $idEquipo AND semana = $i AND activo = 1";
                        try {
                            $result = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($result as $d) {
                                    $statusPMP = $d['status'];
                                    switch ($statusPMP) {
                                        case 'N':
                                            $programados += 1;
                                            break;
                                        case 'P':
                                            $proceso += 1;
                                            break;
                                        case 'F':
                                            $finalizados += 1;
                                            break;
                                    }
                                }
                                if ($programados > 0 && $proceso > 0 && $finalizados > 0) {
                                    $colors = "PPRF.svg";
                                } else if ($programados > 0 && $proceso > 0 && $finalizados == 0) {
                                    $colors = "PPR.svg";
                                } else if ($programados > 0 && $proceso == 0 && $finalizados > 0) {
                                    $colors = "PF.svg";
                                } else if ($programados > 0 && $proceso == 0 && $finalizados == 0) {
                                    $colors = "P.svg";
                                } else if ($programados == 0 && $proceso > 0 && $finalizados == 0) {
                                    $colors = "PR.svg";
                                } else if ($programados == 0 && $proceso == 0 && $finalizados > 0) {
                                    $colors = "F.svg";
                                } else if ($programados == 0 && $proceso > 0 && $finalizados > 0) {
                                    $colors = "PRF.svg";
                                }

                                $salida .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\">";
                            } else {
                                $salida .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                            }
                        } catch (Exception $ex) {
                            $listaEquipo = $ex;
                            exit($ex);
                        }
                    }


                    $salida .= "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function obtenerInfoEquipo($idEquipo) {
        $equipo = new DetalleEquipo();
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $eq) {
                    $equipo->cod2bend = $eq['cod2bend'];
                    $equipo->nombre = $eq['equipo'];
                    $equipo->matricula = $eq['matricula'];
                    $idMarcaEq = $eq['id_marca']; //$idMarcaEq
                    $equipo->modelo = $eq['modelo'];
                    $equipo->serie = $eq['serie'];
                    $idTipoEq = $eq['id_tipo']; //$idTipoEq
                    $idCECO = $eq['id_ccoste']; //$idCECOEq
                    $idDestinoEq = $eq['id_destino'];
                    $equipo->idDestino = $idDestinoEq;
                    $idSeccionEq = $eq['id_seccion'];
                    $idSubseccionEq = $eq['id_subseccion'];
                    $idAreaEq = $eq['id_area'];
                    $idLocalizacionEq = $eq['id_localizacion'];
                    $idUbicacionEq = $eq['id_ubicacion'];
                    $idSububicacionEq = $eq['id_sububicacion'];
                    $statusEq = $eq['status_equipo']; //$statusEq
                    $statusRegistro = $eq['status'];
                    $jerarquia = $eq['jerarquia']; //$jerarquiaEq

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoEq";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $equipo->destino = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_marcas WHERE id = $idMarcaEq";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $equipo->marca = $dts['marca'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_tipos WHERE id = $idTipoEq";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $equipo->tipo = $dts['tipo'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionEq";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $equipo->seccion = $dts['seccion'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_grupos WHERE id = $idSubseccionEq";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $equipo->subseccion = $dts['grupo'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Obtener imagenes del equupo
                    $query = "SELECT * FROM t_equipos_img WHERE id_equipo = $idEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $img) {
                                $urlImage = $img['url_image'];

                                $equipo->imagenes .= "<div class=\"col-6 mt-1\">"
                                        . "<a href=\"../equipos/files/$urlImage\" target=\"_blank\" class=\"mr-1\" data-toggle=\"lightbox\" data-gallery=\"example-gallery5\">"
                                        . "<img src=\"../equipos/files/$urlImage\" alt=\"$urlImage\" class=\"rounded\" height=\"55px\" width=\"55px\">"
                                        . "</a></div>";
                            }
                        } else {
                            $equipo->imagenes .= "<div class=\"col-6 mt-1\">"
                                    . "<a href=\"#\" class=\"mr-1\" data-toggle=\"lightbox\" data-gallery=\"example-gallery5\">"
                                    . "<img src=\"../svg/noimg.svg\" height=\"55px\" width=\"55px\" alt=\"...\" class=\"shadow-sm rounded mr-2\">"
                                    . "</a></div>";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_equipos_documentos WHERE id_equipo = $idEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $img) {
                                $urlArchivo = $img['documento'];
                                $info = new SplFileInfo($urlArchivo);
                                $ext = $info->getExtension();
                                $pagina = 1;
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
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
                                        }
                                        break;
                                    case 'JPG':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
                                        }
                                        break;
                                    case 'jpeg':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
                                        }
                                        break;
                                    case 'JPEG':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
                                        }
                                        break;
                                    case 'svg':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
                                        }
                                        break;
                                    case 'SVG':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/jpg.svg";
                                        } else {
                                            $url = "../svg/formatos/jpg.svg";
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
                                            $url = "svg/formatos/png.svg";
                                        } else {
                                            $url = "../svg/formatos/png.svg";
                                        }
                                        break;
                                    case 'PNG':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/png.svg";
                                        } else {
                                            $url = "../svg/formatos/png.svg";
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
                                    case 'MOV':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mov':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'MP4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mp4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                }


                                $href = "../equipos/files/$urlArchivo";


                                $equipo->documentos .= "<div class=\"col-2 col-md-1 col-lg-1 rounded\">"
                                        . "<a href=\"$href\" target=\"_blank\" class=\"justify-content-center\">"
                                        . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                        . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlArchivo\">$urlArchivo</p>"
                                        . "</a>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_centro_costes WHERE id = $idCECO";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idCC = $dts['id'];
                                $ccoste = $dts['ccoste'];
                                $idDestinoCC = $dts['id_destino'];
                                $idFase = $dts['id_fase'];

                                $query = "SELECT * FROM c_departamentos WHERE id = $ccoste";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $car) {

                                            $depto = $car['departamento'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoCC";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $destinos) {

                                            $destinoCC = $destinos['destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $query = "SELECT * FROM c_fases WHERE id = $idFase";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $fases) {

                                            $fase = $fases['fase'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $equipo->CECO = "$depto $fase $destinoCC";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    switch ($statusEq) {
                        case 'U':
                            $equipo->statusEquipo = "Operativo";
                            break;
                        case 'T':
                            $equipo->statusEquipo = "Taller";
                            break;
                        case 'B':
                            $equipo->statusEquipo = "Baja";
                            break;
                    }

                    switch ($jerarquia) {
                        case 1:
                            $equipo->jerarquia = "Nivel 1 (Equipo Principal)";

                            break;
                        case 2:
                            $equipo->jerarquia = "Nivel 2 (Despiece)";


                            break;
                        case 3:
                            $equipo->jerarquia = "Nivel 3 (Componente)";

                            break;
                    }

                    //Obtener unidades del equipo
                    $query = "SELECT * FROM t_equipos_unidades WHERE id_equipo =$idEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $query = "SHOW COLUMNS FROM t_equipos_unidades";
                                try {
                                    $campos = $conn->obtDatos($query);
                                    for ($i = 2; $i < count($campos); $i++) {
                                        $campo = $campos[$i]['Field'];
                                        if ($dts[$campo] != "") {
                                            $equipo->unidades .= "<div class=\"col-12 text-uppercase text-left\">"
                                                    . "<h5 class=\"fs-12 spdisplaysemibold mb-0 pb-0\">$campo</h5>"
                                                    . "<h5 class=\"fs-12 text-truncate\">" . $dts[$campo] . "</h5>"
                                                    . "</div>";
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

//    **********************************************************************
//    ***************SECCION TAREAS GENERALES DE AREA***********************
//    **********************************************************************

    public function obtDetalleSubcategoria($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria) {
        $equipo = new Equipo();
        $equipo->planMC = "";
//        $equipo->historicoMP = "";
        $conn = new Conexion();
        $conn->conectar();
        //$pagina = 0;

        date_default_timezone_set('America/Mexico_City');
        $currentWeek = date("W");

        $equipo->idDestino = $idDestino;
        $equipo->idSubseccion = $idSubseccion;
        $equipo->idSubcategoria = $idSubcategoria;

        $query = "SELECT * FROM c_subcategorias_planner WHERE id = $idSubcategoria";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipo->nombreEquipo = $dts['subcategoria'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        //obtener mc
        if ($idDestino == 10) {
            $query = "SELECT t_mc.id 'ID', "
                    . "t_mc.id_tarea 'IDTAREA', "
                    . "t_mc.actividad 'ACTIVIDAD', "
                    . "t_mc.status 'STATUS', "
                    . "t_mc.responsable 'IDRESPONSABLE', "
                    . "t_mc.fecha_inicio 'FECHAI', "
                    . "t_mc.fecha_fin 'FECHAF', "
                    . "t_mc.fecha_realizado 'FECHAR', "
                    . "t_mc.realizado_por 'IDREALIZADO', "
                    . "t_mc.creador_por 'IDCREADOR', "
                    . "t_mc.id_destino 'IDDESTINO', "
                    . "t_mc.fecha_creacion 'FECHACR', "
                    . "t_mc.semana_inicio 'SEMANAI', "
                    . "t_mc.semana_fin 'SEMANAF', "
                    . "c_destinos.destino 'DESTINOS' "
                    . "FROM t_mc "
                    . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id"
                    . "WHERE t_mc.id_subseccion = $idSubseccion "
                    . "AND t_mc.id_categoria = $idCategoria "
                    . "AND t_mc.id_subcategoria = $idSubcategoria "
                    . "AND t_mc.status = 'N' "
                    . "AND t_mc.activo = 1 "
                    . "ORDER BY t_mc.id_destino";
        } else {
            if ($idSubseccion == 62 || $idSubseccion == 211 || $idSubseccion == 212 || $idSubseccion == 213 || $idSubseccion == 214) {
                $query = "SELECT t_mc.id 'ID', "
                        . "t_mc.id_tarea 'IDTAREA', "
                        . "t_mc.actividad 'ACTIVIDAD', "
                        . "t_mc.status 'STATUS', "
                        . "t_mc.responsable 'IDRESPONSABLE', "
                        . "t_mc.fecha_inicio 'FECHAI', "
                        . "t_mc.fecha_fin 'FECHAF', "
                        . "t_mc.fecha_realizado 'FECHAR', "
                        . "t_mc.realizado_por 'IDREALIZADO', "
                        . "t_mc.creador_por 'IDCREADOR', "
                        . "t_mc.id_destino 'IDDESTINO', "
                        . "t_mc.fecha_creacion 'FECHACR', "
                        . "t_mc.semana_inicio 'SEMANAI', "
                        . "t_mc.semana_fin 'SEMANAF', "
                        . "c_destinos.destino 'DESTINOS' "
                        . "FROM t_mc "
                        . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
                        . "WHERE (t_mc.id_destino = $idDestino) "
                        . "AND t_mc.id_subseccion = $idSubseccion "
                        . "AND t_mc.id_categoria = $idCategoria "
                        . "AND t_mc.id_subcategoria = $idSubcategoria "
                        . "AND t_mc.status = 'N' "
                        . "AND t_mc.activo = 1";
            } else {
                $query = "SELECT t_mc.id 'ID', "
                        . "t_mc.id_tarea 'IDTAREA', "
                        . "t_mc.actividad 'ACTIVIDAD', "
                        . "t_mc.status 'STATUS', "
                        . "t_mc.responsable 'IDRESPONSABLE', "
                        . "t_mc.fecha_inicio 'FECHAI', "
                        . "t_mc.fecha_fin 'FECHAF', "
                        . "t_mc.fecha_realizado 'FECHAR', "
                        . "t_mc.realizado_por 'IDREALIZADO', "
                        . "t_mc.creado_por 'IDCREADOR', "
                        . "t_mc.id_destino 'IDDESTINO', "
                        . "t_mc.fecha_creacion 'FECHACR', "
                        . "t_mc.semana_inicio 'SEMANAI', "
                        . "t_mc.semana_fin 'SEMANAF', "
                        . "c_destinos.destino 'DESTINO' "
                        . "FROM t_mc "
                        . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
                        . "WHERE (t_mc.id_destino = $idDestino OR t_mc.id_destino = 10) "
                        . "AND t_mc.id_subseccion = $idSubseccion "
                        . "AND t_mc.id_categoria = $idCategoria "
                        . "AND t_mc.id_subcategoria = $idSubcategoria "
                        . "AND t_mc.status = 'N' "
                        . "AND t_mc.activo = 1";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idAccion = $dts['ID'];
                    $idTarea = $dts['IDTAREA']; //Para las actividades del antiguo planner
                    $actividad = $dts['ACTIVIDAD'];
                    $statusAccion = $dts['STATUS'];
                    $idResponsable = $dts['IDRESPONSABLE'];
                    $fechaInicio = $dts['FECHAI'];
                    $fechaFin = $dts['FECHAF'];
                    $fechaRealizacion = $dts['FECHAR'];
                    $realizo = $dts['IDREALIZADO'];
                    $creado = $dts['IDCREADOR'];
                    $idDestinoActividad = $dts['IDDESTINO'];
                    $fechaCreacion = $dts['FECHACR'];
                    $semanaI = $dts['SEMANAI'];
                    $semanaF = $dts['SEMANAF'];
                    $des = $dts['DESTINO'];

                    if ($semanaI == "") {
                        $semanaI = date("W", strtotime($fechaCreacion));
                    }

                    if ($idTarea != 0) {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE (id_tarea = $idTarea OR id_mc = $idAccion)";
                    } else {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idAccion";
                    }

                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $tieneAdjuntos = "SI";
                        } else {
                            $tieneAdjuntos = "NO";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

//                    
                    //Datos de el usuario responsable
                    $query = "SELECT t_users.id_colaborador 'IDEMPLEADO', "
                            . "t_colaboradores.nombre 'NOMBRE', "
                            . "t_colaboradores.apellido 'APELLIDO', "
                            . "t_colaboradores.foto 'FOTO'"
                            . "FROM t_users "
                            . "INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id "
                            . "WHERE t_users.id = $idResponsable";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['IDEMPLEADO'];
                                $nombreR = $u['NOMBRE'];
                                $apellidoR = $u['APELLIDO'];
                                $fotoR = $u['FOTO'];
//                                
                            }
                        } else {
                            $fotoR = "advertencia2.svg";
                            $nombreR = "";
                            $apellidoR = "";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT t_users.id_colaborador 'IDEMPLEADO', "
                            . "t_colaboradores.nombre 'NOMBRE', "
                            . "t_colaboradores.apellido 'APELLIDO', "
                            . "t_colaboradores.foto 'FOTO'"
                            . "FROM t_users "
                            . "INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id "
                            . "WHERE t_users.id = $realizo";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['IDEMPLEADO'];
                                $nombreR = $u['NOMBRE'];
                                $apellidoR = $u['APELLIDO'];
                                $fotoRE = $u['FOTO'];
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreRE = "";
                            $apellidoRE = "";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que creador
                    $query = "SELECT t_users.id_colaborador 'IDEMPLEADO', "
                            . "t_users.id_destino 'IDDESTINO', "
                            . "t_colaboradores.nombre 'NOMBRE', "
                            . "t_colaboradores.apellido 'APELLIDO', "
                            . "t_colaboradores.foto 'FOTO' "
                            . "FROM t_users "
                            . "INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id "
                            . "WHERE t_users.id = $creado";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
//                                $idTrabajador = $u['id_colaborador'];
                                $destinoCreador = $u['IDDESTINO'];
                                $idTrabajador = $u['IDEMPLEADO'];
                                $fotoC = $u['FOTO'];
                                $nombreR = $u['NOMBRE'];
                                $apellidoR = $u['APELLIDO'];
                            }
                        } else {
                            $fotoC = "advertencia2.svg";
                            $nombreC = "";
                            $apellidoC = "";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $pagina = 0;

                    $equipo->planMC .= "<div class=\"columns hvr-float\">"
                            . "<div class=\"column is-8\">"
                            . "<div class=\"field text-truncate\">";
                    if ($statusAccion == "F") {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                            } else {
                                $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked disabled>";
                            }
                        } else {
                            $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                        }
                    } else {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                            } else {
                                $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                            }
                        } else {
                            $equipo->planMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                        }
                    }
                    $equipo->planMC .= "<label for=\"chkb_$idAccion\"></label>";
                    if ($destinoCreador == 10) {
                        $equipo->planMC .= "<span class=\"manita\" onclick=\"showDetallesTarea('show'); obtDetalleTarea($idAccion);\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> ($des) $actividad</span>";
                    } else {
                        $equipo->planMC .= "<span class=\"manita\" onclick=\"showDetallesTarea('show'); obtDetalleTarea($idAccion);\">($des) $actividad</span>";
                    }


                    $equipo->planMC .= "</div>"
                            . "</div>"
                            . "<div class=\"column is-4\">"
                            . "<div class=\"control\">"
                            . "<div class=\"tags has-addons\">";
                    if ($fotoR == "advertencia2.svg") {
                        $equipo->planMC .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">Sin responsable</span>";
                    } else {
                        $equipo->planMC .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                    }
                    if ($tieneAdjuntos == "SI") {
                        $equipo->planMC .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
                    }

                    //Seccion de planeacion de MC

                    if ($fechaInicio != null && $fechaFin != null) {
                        $equipo->planMC .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
                    } else {
                        $equipo->planMC .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
                    }

                    $equipo->planMC .= "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        //comentarios generales
        $query = "SELECT * FROM t_mc_subcategoria_comentarios_generales WHERE id_equipo = $idRelSubcategoria";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['usuario'];
                    $fecha = $dts['fecha'];
                    $comentario = $dts['comentario'];

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
                                            $idCargo = $dts['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $equipo->comentarios .= "<div class=\"row justify-content-center rounded-3\">"
                            . "<div class=\"col-11 my-1 px-1\" >"
                            . "<div class=\"media\">";
//                                if ($pagina == 0) {
//                                    $equipo->comentarios .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                } else {
//                                    $equipo->comentarios .= "<img class=\"align-self-center mr-3 rounded-circle\" src=\"../img/users/$foto\" width=\"30px\" height=\"30px\" alt=\"Usuario\">";
//                                }

                    if ($idCargo == 51) {
                        $equipo->comentarios .= "<div class=\"media-body bg-rojoc rounded py-2 px-2 shadow-sm\" >";
                    } else {
                        $equipo->comentarios .= "<div class=\"media-body bg-white border-normal rounded py-2 px-2 shadow-sm\" >";
                    }


                    $equipo->comentarios .= "<h5 class=\"my-0 fs-10 spdisplaybold text-negron\">$nombre $apellido: </h5>"
                            . "<h5 class=\"fs-10 mt-1 spdisplayregular text-negron\">$comentario</h5>"
                            . "<h5 class=\"fs-8 mt-1 spdisplaybold text-negron text-right mb-0 pb-0\">$fecha</h5>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $query = "SELECT * FROM t_mc_subcategoria_adjuntos_generales WHERE id_equipo = $idRelSubcategoria";

        try {
            $adjuntos = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($adjuntos as $dts) {
                    $urlArchivo = $dts['url_adjunto'];

                    if ($urlArchivo != "") {
                        $pagina = 0;
                        $info = new SplFileInfo($urlArchivo);
                        $ext = $info->getExtension();

                        switch ($ext) {
                            case 'doc':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'DOC':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
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
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'JPG':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'jpeg':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'JPEG':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'svg':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'SVG':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
                                }
                                break;
                            case 'PNG':
                                if ($pagina == 0) {
                                    $url = "planner/tareas/adjuntos/$urlArchivo";
                                } else {
                                    $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                            case 'MOV':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mov':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'MP4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mp4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                        }

//                                $tarea->adjuntos .= $ext;

                        $equipo->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
                                . "<a href=\"planner/tareas/adjuntos/$urlArchivo\" target=\"_blank\" class=\"justify-content-center\">"
                                . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$urlArchivo\">$urlArchivo</p>"
                                . "</a>"
                                . "</div>";
                    }
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

    public function recargarMCPAPF($idDestino, $idSubseccion, $idCategoria, $idSubcategoria, $status) {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');

        $currentWeek = date("W");

        //obtener mc
        if ($idDestino == 10) {
            $query = "SELECT * FROM t_mc WHERE id_subseccion = $idSubseccion "
                    . "AND id_categoria = $idCategoria AND id_subcategoria = $idSubcategoria AND status = '$status' AND activo = 1 ORDER BY id_destino";
        } else {
            if ($idSubseccion == 62 || $idSubseccion == 211 || $idSubseccion == 212 || $idSubseccion == 213 || $idSubseccion == 214) {
                $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion "
                        . "AND id_categoria = $idCategoria AND id_subcategoria = $idSubcategoria AND status = '$status' AND activo = 1";
            } else {
                $query = "SELECT * FROM t_mc WHERE (id_destino = $idDestino OR id_destino = 10) AND id_subseccion = $idSubseccion "
                        . "AND id_categoria = $idCategoria AND id_subcategoria = $idSubcategoria AND status = '$status' AND activo = 1";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idAccion = $dts['id'];
                    $actividad = $dts['actividad'];
                    $idTarea = $dts['id_tarea']; //Para las tareas del antiguo planner
                    $statusAccion = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $fechaInicio = $dts['fecha_inicio'];
                    $fechaFin = $dts['fecha_fin'];
                    $fechaRealizacion = $dts['fecha_realizado'];
                    $realizo = $dts['realizado_por'];
                    $creado = $dts['creado_por'];
                    $idDestinoActividad = $dts['id_destino'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $semanaI = $dts['semana_inicio'];
                    $semanaF = $dts['semana_fin'];

                    if ($semanaI == "") {
                        $semanaI = date("W", strtotime($fechaCreacion));
                    }

                    if ($idTarea != 0) {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE (id_tarea = $idTarea OR id_mc = $idAccion)";
                    } else {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idAccion";
                    }

                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $tieneAdjuntos = "SI";
                        } else {
                            $tieneAdjuntos = "NO";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

//Obtener destino de la actividad
                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoActividad";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $des = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Datos de el usuario responsable
                    $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoR = $t['foto'];
                                            $nombreR = $t['nombre'];
                                            $apellidoR = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoR = "advertencia2.svg";
                            $nombreR = "";
                            $apellidoR = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT * FROM t_users WHERE id = $realizo";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoRE = $t['foto'];
                                            $nombreRE = $t['nombre'];
                                            $apellidoRE = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreRE = "";
                            $apellidoRE = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT * FROM t_users WHERE id = $creado";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajadorC = $u['id_colaborador'];
                                $destinoCreador = $u['id_destino'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajadorC";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoC = $t['foto'];
                                            $nombreC = $t['nombre'];
                                            $apellidoC = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreC = "";
                            $apellidoC = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $pagina = 0;

                    $salida .= "<div class=\"columns hvr-float\">"
                            . "<div class=\"column is-8\">"
                            . "<div class=\"field text-truncate\">";
                    if ($statusAccion == "F") {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                            } else {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked disabled>";
                            }
                        } else {
                            $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                        }
                    } else {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                            } else {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                            }
                        } else {
                            $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                        }
                    }
                    $salida .= "<label for=\"chkb_$idAccion\"></label>";
                    if ($destinoCreador == 10) {
                        $salida .= "<span class=\"manita\" onclick=\"showDetallesTarea('show'); obtDetalleTarea($idAccion);\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> ($des) $actividad</span>";
                    } else {
                        $salida .= "<span class=\"manita\" onclick=\"showDetallesTarea('show'); obtDetalleTarea($idAccion);\">($des) $actividad</span>";
                    }


                    $salida .= "</div>"
                            . "</div>"
                            . "<div class=\"column is-4\">"
                            . "<div class=\"control\">"
                            . "<div class=\"tags has-addons\">";
                    if ($fotoR == "advertencia2.svg") {
                        $salida .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">Sin responsable</span>";
                    } else {
                        $salida .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                    }
                    if ($tieneAdjuntos == "SI") {
                        $salida .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
                    }

                    //Seccion de planeacion de MC
                    if ($fechaInicio != null && $fechaFin != null) {
                        $salida .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
                    } else {
                        $salida .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
                    }
//                    $query = "SELECT * FROM t_mc_planeacion WHERE id_mc = $idAccion";
//                    try {
//                        $resp = $conn->obtDatos($query);
//                        if ($conn->filasConsultadas > 0) {
//                            $salida .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
//                        } else {
//                            $salida .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
//                        }
//                    } catch (Exception $ex) {
//                        $equipo = $ex; exit($ex);
//                    }



                    $salida .= "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $salida;
    }

    public function obtDetalleTarea($idTarea) {
        $tarea = new TareaMC();
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_mc WHERE id = $idTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $tarea->idTarea = $dts['id_tarea'];
                    $tarea->idEquipo = $dts['id_equipo'];
                    $tarea->actividad = $dts['actividad'];
                    $tarea->status = $dts['status'];
                    $tarea->creadoPor = $dts['creado_por'];
                    $tarea->responsable = $dts['responsable'];
                    if ($dts['fecha_inicio'] != "" && $dts['fecha_fin'] != "") {
                        if ($dts['fecha_inicio'] != "0000-00-00" && $dts['fecha_fin'] != "0000-00-00") {
                            $tarea->fechaInicio = date_format(date_create($dts['fecha_inicio']), "m/d/Y");
                            $tarea->fechaFin = date_format(date_create($dts['fecha_fin']), "m/d/Y");
                        }
                    }

                    $tarea->fechaRealizado = $dts['fecha_realizado'];
                    $tarea->realizadoPor = $dts['realizado_por'];
                    $tarea->fechaCreacion = $dts['fecha_creacion'];
                    $tarea->ultimaModificacion = $dts['ultima_modificacion'];
                    $tarea->activo = $dts['activo'];
                    $tarea->idDestino = $dts['id_destino'];
                    $tarea->idSeccion = $dts['id_seccion'];
                    $tarea->idSubseccion = $dts['id_subseccion'];
                    $tarea->idCategoria = $dts['id_categoria'];
                    $tarea->idSubcategoria = $dts['id_subcategoria'];
                    $tarea->semanInicion = $dts['semana_inicio'];
                    $tarea->semanFin = $dts['semana_fin'];
                }

                //obtener datos del usuario que creo la tarea
                $query = "SELECT * FROM t_users WHERE id = $tarea->creadoPor";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idEmpleado = $dts['id_colaborador'];
                            //Obtener datos del colaborador
                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombreCreador = $dts['nombre'];
                                        $apellidoCreador = $dts['apellido'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                                exit($ex);
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $tarea = $ex;
                    exit($ex);
                }

                $tarea->timeLine .= "<header class=\"timeline-header\">"
                        . "<span class=\"tag is-small is-info\">Inicio</span>"
                        . "</header>"
                        //Datos de creacion
                        . "<div class=\"timeline-item is-danger\">"
                        . "<div class=\"timeline-marker is-danger is-icon\">"
                        . "<i class=\"fa fa-plus\"></i>"
                        . "</div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\">Creada por: <strong>$nombreCreador $apellidoCreador</strong></p>"
                        . "<p class=\"heading\">$tarea->fechaCreacion</p>"
                        . "</div>"
                        . "</div>";

                //obtener comentarios y adjuntos para añadirlos al timeline
                if ($tarea->idTarea == 0) {
                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idTarea";
                } else {
                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idTarea OR id_tarea = $tarea->idTarea";
                }
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idUsuario = $dts['id_usuario'];
                            $fecha = $dts['fecha'];
                            $comentario = $dts['comentario'];

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
                                                    $idCargo = $dts['id_cargo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $tarea = $ex;
                                            exit($ex);
                                        }
                                    }
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                                exit($ex);
                            }

                            $tarea->timeLine .= "<div class=\"timeline-item is-info\">"
                                    . "<div class=\"timeline-marker is-info\"></div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fecha</p>"
                                    . "<p class=\"heading\">$comentario</p>"
                                    . "</div>"
                                    . "</div>";
                        }
                    }
                } catch (Exception $ex) {
                    $tarea = $ex;
                    exit($ex);
                }

                if ($tarea->idTarea == 0) {
                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idTarea";
                } else {
                    //$query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idActividad";
                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_tarea = $tarea->idTarea OR id_mc = $idTarea";
                }

                $pagina = 0;
                try {
                    $adjuntos = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($adjuntos as $dts) {
                            $urlArchivo = $dts['url_adjunto'];
                            $fecha = $dts['fecha'];
                            if ($dts['subido_por'] != "") {
                                $subido = $dts['subido_por'];
                            } else {
                                $subido = 0;
                            }
                            $query = "SELECT * FROM t_users WHERE id = $subido";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                        $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                            $tarea = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $nombre = "";
                                    $apellido = "";
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                                exit($ex);
                            }

                            if ($urlArchivo != "") {
                                $info = new SplFileInfo($urlArchivo);
                                $ext = $info->getExtension();

                                switch ($ext) {
                                    case 'doc':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/doc.svg";
                                        } else {
                                            $url = "../svg/formatos/doc.svg";
                                        }
                                        break;
                                    case 'DOC':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/doc.svg";
                                        } else {
                                            $url = "../svg/formatos/doc.svg";
                                        }
                                        break;
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
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'JPG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'jpeg':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'JPEG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'svg':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'SVG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'PNG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                                    case 'MOV':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mov':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'MP4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mp4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                }

//                                $tarea->adjuntos .= $ext;
                                if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                                    $tarea->timeLine .= "<div class=\"timeline-item is-danger\">"
                                            . "<div class=\"timeline-marker is-danger is-icon\">"
                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                            . "</div>"
                                            . "<div class=\"timeline-content\">"
                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                            . "<a class=\"example-image-link\" href=\"planner/tareas/adjuntos/$urlArchivo\" data-lightbox=\"adjuntos-mc-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                            . "</div>"
                                            . "</div>";
                                } else {
                                    $tarea->timeLine .= "<div class=\"timeline-item is-danger\">"
                                            . "<div class=\"timeline-marker is-danger is-icon\">"
                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                            . "</div>"
                                            . "<div class=\"timeline-content\">"
                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                            . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/tareas/adjuntos/$urlArchivo\" ><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                            . "</div>"
                                            . "</div>";
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $tarea = $ex;
                    exit($ex);
                }

                $tarea->timeLine .= "<header class=\"timeline-header\">"
                        . "<span class=\"tag is-small is-info\">Fin</span>"
                        . "</header>";
            } else {
                $tarea = "SIN RESULTADOS";
            }
        } catch (Exception $ex) {
            $tarea = $ex;
            exit($ex);
        }

        $conn->cerrar();

        return $tarea;
    }
    
    public function actualizarTarea($idTarea, $titulo){
        $conn = new Conexion();
        $conn->conectar();
        
        $query = "UPDATE t_mc SET actividad = '$titulo' WHERE id = $idTarea";
        try{
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        
        $conn->cerrar();
        return $resp;
    }
    
    public function eliminarTarea($idTarea){
        $conn = new Conexion();
        $conn->conectar();
        
        $query = "UPDATE t_mc SET activo = 0 WHERE id = $idTarea";
        try{
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }
        
        $conn->cerrar();
        return $resp;
    }

    public function insertarComentario($idTarea, $comentario) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");
        $idUsuario = $_SESSION['usuario'];
        $query = "INSERT INTO t_mc_comentarios (id_mc, comentario, id_usuario, fecha) "
                . "VALUES($idTarea, '$comentario', $idUsuario, '$fecha')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function obtenerTimeLine($idTarea) {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_mc WHERE id = $idTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idTareaMC = $dts['id_tarea'];
                    $idEquipo = $dts['id_equipo'];
                    $creadoPor = $dts['creado_por'];
                    $fechaCreacion = $dts['fecha_creacion'];
                }

                //obtener datos del usuario que creo la tarea
                $query = "SELECT * FROM t_users WHERE id = $creadoPor";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idEmpleado = $dts['id_colaborador'];
                            //Obtener datos del colaborador
                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombreCreador = $dts['nombre'];
                                        $apellidoCreador = $dts['apellido'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $tarea = $ex;
                                exit($ex);
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $tarea = $ex;
                    exit($ex);
                }

                $salida .= "<header class=\"timeline-header\">"
                        . "<span class=\"tag is-small is-info\">Inicio</span>"
                        . "</header>"
                        //Datos de creacion
                        . "<div class=\"timeline-item is-danger\">"
                        . "<div class=\"timeline-marker is-danger is-icon\">"
                        . "<i class=\"fa fa-plus\"></i>"
                        . "</div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\">Creada por: <strong>$nombreCreador $apellidoCreador</strong></p>"
                        . "<p class=\"heading\">$fechaCreacion</p>"
                        . "</div>"
                        . "</div>";

                //obtener comentarios y adjuntos para añadirlos al timeline
                if ($idTareaMC == 0) {
                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idTarea";
                } else {
                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idTarea OR id_tarea = $idTareaMC";
                }
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idUsuario = $dts['id_usuario'];
                            $fecha = $dts['fecha'];
                            $comentario = $dts['comentario'];

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
                                                    $idCargo = $dts['id_cargo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                            exit($ex);
                                        }
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            $salida .= "<div class=\"timeline-item is-info\">"
                                    . "<div class=\"timeline-marker is-info\"></div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fecha</p>"
                                    . "<p class=\"heading\">$comentario</p>"
                                    . "</div>"
                                    . "</div>";
                        }
                    }
                } catch (Exception $ex) {
                    $tarea = $ex;
                    exit($ex);
                }

                if ($idTareaMC == 0) {
                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idTarea";
                } else {
                    //$query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idActividad";
                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_tarea = $idTareaMC OR id_mc = $idTarea";
                }

                $pagina = 0;
                try {
                    $adjuntos = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($adjuntos as $dts) {
                            $urlArchivo = $dts['url_adjunto'];
                            $fecha = $dts['fecha'];
                            if ($dts['subido_por'] != "") {
                                $subido = $dts['subido_por'];
                            } else {
                                $subido = 0;
                            }
                            $query = "SELECT * FROM t_users WHERE id = $subido";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                        $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                            exit($ex);
                                        }
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            if ($urlArchivo != "") {
                                $info = new SplFileInfo($urlArchivo);
                                $ext = $info->getExtension();

                                switch ($ext) {
                                    case 'doc':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/doc.svg";
                                        } else {
                                            $url = "../svg/formatos/doc.svg";
                                        }
                                        break;
                                    case 'DOC':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/doc.svg";
                                        } else {
                                            $url = "../svg/formatos/doc.svg";
                                        }
                                        break;
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
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'JPG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'jpeg':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'JPEG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'svg':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'SVG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
                                        }
                                        break;
                                    case 'PNG':
                                        if ($pagina == 0) {
                                            $url = "planner/tareas/adjuntos/$urlArchivo";
                                        } else {
                                            $url = "../planner/tareas/adjuntos/$urlArchivo";
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
                                    case 'MOV':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mov':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'MP4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                    case 'mp4':
                                        if ($pagina == 0) {
                                            $url = "svg/formatos/mp4.svg";
                                        } else {
                                            $url = "../svg/formatos/mp4.svg";
                                        }
                                        break;
                                }

//                                $tarea->adjuntos .= $ext;

                                if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                                    $salida .= "<div class=\"timeline-item is-danger\">"
                                            . "<div class=\"timeline-marker is-danger is-icon\">"
                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                            . "</div>"
                                            . "<div class=\"timeline-content\">"
                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                            . "<a class=\"example-image-link\" href=\"planner/tareas/adjuntos/$urlArchivo\" data-lightbox=\"adjuntos-mc-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                            . "</div>"
                                            . "</div>";
                                } else {
                                    $salida .= "<div class=\"timeline-item is-danger\">"
                                            . "<div class=\"timeline-marker is-danger is-icon\">"
                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                            . "</div>"
                                            . "<div class=\"timeline-content\">"
                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                            . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/tareas/adjuntos/$urlArchivo\" ><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                            . "</div>"
                                            . "</div>";
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $salida = $ex;
                    exit($ex);
                }

                $salida .= "<header class=\"timeline-header\">"
                        . "<span class=\"tag is-small is-info\">Fin</span>"
                        . "</header>";
            } else {
                $salida = "SIN RESULTADOS";
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function actualizarRangoFechas($idTareas, $fechas) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = explode(" - ", $fechas);
        $fechaI = date("Y-m-d", strtotime($fecha[0]));
        $fechaF = date("Y-m-d", strtotime($fecha[1]));

        //$resp = "$fechaI - $fechaF - $fecha[0] - $fecha[1]";

        $query = "UPDATE t_mc SET fecha_inicio = '$fechaI', fecha_fin = '$fechaF' WHERE id = $idTareas";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function buscarUsuarios($idDestino, $palabra, $proyecto) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_colaboradores WHERE (nombre LIKE '%$palabra%' OR apellido LIKE '%$palabra%') AND status = 'A' ORDER BY nombre";
        } else {
            $query = "SELECT * FROM t_colaboradores WHERE (id_destino = $idDestino OR id_destino = 10) AND (nombre LIKE '%$palabra%' OR apellido LIKE '%$palabra%') AND status = 'A' ORDER BY nombre";
        }

        try {
            $trabajador = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($trabajador as $t) {
                    $idTrabajador = $t['id'];
                    $nombreT = $t['nombre'];
                    $apellidoT = $t['apellido'];
                    $fotoT = $t['foto'];

                    $query = "SELECT * FROM t_users WHERE id_colaborador = $idTrabajador";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idUsuario = $u['id'];
                            }
                            if ($fotoT != "") {
                                $urlFoto = "img/users/$fotoT";
                            } else {
                                $urlFoto = "https://ui-avatars.com/api/?uppercase=false&name=$nombreT+$apellidoT&background=d8e6ff&rounded=true&color=4886ff&size=100%";
                            }
                            if ($proyecto == "SI") {
                                $salida .= "<h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"agregarResponsableProyecto($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
                            } else {
                                $salida .= "<h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"agregarResponsable($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }
                }
            } else {
                $nombreT = "";
                $apellidoT = "";
                $fotoT = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $salida;
    }

    public function agregarResponsableActividad($idUsuario, $idActividad) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_mc SET responsable = $idUsuario WHERE id = $idActividad";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function completarTarea($idActividad, $status, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');
        $fecF = date("Y-m-d H:i:s");

        $query = "UPDATE t_mc SET status = '$status', realizado_por = $idUsuario, fecha_realizado = '$fecF' WHERE id = $idActividad";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function agregarTarea($idEquipo, $actividad, $usuario, $idGrupo, $idDestino, $idCategoria, $idSubcategoria) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");
        $semanaI = date("W");

        $query = "SELECT * FROM c_subsecciones WHERE id = $idGrupo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSeccion = $dts['id_seccion'];
                }
            } else {
                $idSeccion = 0;
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $query = "INSERT INTO t_mc (id_equipo, actividad, status, creado_por, fecha_creacion, id_destino, id_seccion, id_subseccion, id_categoria, id_subcategoria, semana_inicio) "
                . "VALUES($idEquipo, '$actividad', 'N', $usuario, '$fecha', $idDestino, $idSeccion, $idGrupo, $idCategoria, $idSubcategoria, $semanaI)";
        try {
            $resp = $conn->consulta($query);
            $query = "SELECT LAST_INSERT_ID(id) AS LAST FROM t_mc ORDER BY id DESC LIMIT 0,1";
            try {
                $result = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($result as $dts) {
                        $idMC = $dts['LAST'];
                    }
                }
            } catch (Exception $ex) {
                $resp = $ex;
                exit($ex);
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

//    **********************************************************************
//    ***************SECCION TAREAS MC Y MP DE EQUIPOS**********************
//    **********************************************************************

    public function obtDetalleEquipo($idEquipo) {
        $idUsuario = $_SESSION['usuario'];
        $conn = new Conexion();
        $equipo = new DetalleEquipo();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');
        $fechaHoy = date("Y-m-d H:i:s");
        $año = date("Y");
        $currentWeek = date("W");

        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idColaborador = $dts['id_colaborador'];
                    $idPermiso = $dts['id_permiso'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipo->idEquipo = $dts['id'];
                    $equipo->cod2bend = $dts['cod2bend'];
                    $equipo->nombre = $dts['equipo'];
                    $equipo->matricula = $dts['matricula'];
                    $idMarca = $dts['id_marca'];
                    $equipo->modelo = $dts['modelo'];
                    $equipo->serie = $dts['serie'];
                    $idTipo = $dts['id_tipo'];
                    $idCeco = $dts['id_ccoste'];
                    $idDestino = $dts['id_destino'];
                    $idSeccion = $dts['id_seccion'];
                    $idSubseccion = $dts['id_subseccion'];
                    $statusEquipo = $dts['status_equipo'];
                    $jerarquia = $dts['jerarquia'];

                    switch ($statusEquipo) {
                        case 'U':
                            $equipo->statusEquipo = "Operativo";
                            break;
                        case 'T':
                            $equipo->statusEquipo = "Taller";
                            break;
                        case 'B':
                            $equipo->statusEquipo = "Baja";
                            break;
                    }

                    switch ($jerarquia) {
                        case 1:
                            $equipo->jerarquia = "Nivel 1 (Equipo Principal)";
                            break;
                        case 2:
                            $equipo->jerarquia = "Nivel 2 (Despiece)";
                            break;
                        case 3:
                            $equipo->jerarquia = "Nivel 3 (Componente)";
                            break;
                    }

                    //obtener nombre de marca
                    $query = "SELECT * FROM c_marcas WHERE id = $idMarca";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $equipo->marca = $dts['marca'];
                            }
                        } else {
                            $equipo->marca = "NA";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //obtener clave destino
                    $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $equipo->destino = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //obtener nombre seccion
                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $equipo->seccion = $dts['seccion'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //obtener nombre subseccion
                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccion";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $equipo->subseccion = $dts['grupo'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //obtener tipo equipos
                    $query = "SELECT * FROM c_tipos WHERE id = $idTipo";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $equipo->tipo = $dts['tipo'];
                            }
                        } else {
                            $equipo->tipo = "NA";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //obtener ceco
                    $query = "SELECT * FROM c_centro_costes WHERE id = $idCeco";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idCC = $dts['id'];
                                $ccoste = $dts['ccoste'];
                                $idDestinoCC = $dts['id_destino'];
                                $idFase = $dts['id_fase'];

                                $query = "SELECT * FROM c_departamentos WHERE id = $ccoste";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $car) {

                                            $depto = $car['departamento'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoCC";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $destinos) {

                                            $destinoCC = $destinos['destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $query = "SELECT * FROM c_fases WHERE id = $idFase";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $fases) {

                                            $fase = $fases['fase'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $equipo->CECO = "$depto $fase $destinoCC";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Obtener las tareas de correctivo del equipo
                    $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $idAccion = $dts['id'];
                                $idTarea = $dts['id_tarea']; //Para las actividades del antiguo planner
                                $actividad = $dts['actividad'];
                                $statusAccion = $dts['status'];
                                $idResponsable = $dts['responsable'];
                                $fechaInicio = $dts['fecha_inicio'];
                                $fechaFin = $dts['fecha_fin'];
                                $fechaRealizacion = $dts['fecha_realizado'];
                                $realizo = $dts['realizado_por'];
                                $creado = $dts['creado_por'];
                                $idDestinoActividad = $dts['id_destino'];
                                $fechaCreacion = $dts['fecha_creacion'];
                                $semanaI = $dts['semana_inicio'];
                                $semanaF = $dts['semana_fin'];

                                if ($semanaI == "") {
                                    $semanaI = date("W", strtotime($fechaCreacion));
                                }

                                if ($idTarea != 0) {
                                    $query = "SELECT * FROM t_mc_adjuntos WHERE (id_tarea = $idTarea OR id_mc = $idAccion)";
                                } else {
                                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idAccion";
                                }

                                try {
                                    $result = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        $tieneAdjuntos = "SI";
                                    } else {
                                        $tieneAdjuntos = "NO";
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                //Obtener destino de la actividad
                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoActividad";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $des = $dts['destino'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                //Datos de el usuario responsable
                                $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                                try {
                                    $usuario = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($usuario as $u) {
                                            $idTrabajador = $u['id_colaborador'];
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                            try {
                                                $trabajador = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($trabajador as $t) {
                                                        $fotoR = $t['foto'];
                                                        $nombreR = $t['nombre'];
                                                        $apellidoR = $t['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $equipo = $ex;
                                                exit($ex);
                                            }
                                        }
                                    } else {
                                        $fotoR = "advertencia2.svg";
                                        $nombreR = "";
                                        $apellidoR = "";
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                //Datos del usuario que realizo
                                $query = "SELECT * FROM t_users WHERE id = $realizo";
                                try {
                                    $usuario = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($usuario as $u) {
                                            $idTrabajador = $u['id_colaborador'];
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                            try {
                                                $trabajador = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($trabajador as $t) {
                                                        $fotoRE = $t['foto'];
                                                        $nombreRE = $t['nombre'];
                                                        $apellidoRE = $t['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $equipo = $ex;
                                                exit($ex);
                                            }
                                        }
                                    } else {
                                        $foto = "advertencia2.svg";
                                        $nombreRE = "";
                                        $apellidoRE = "";
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                //Datos del usuario que creador
                                $query = "SELECT * FROM t_users WHERE id = $creado";
                                try {
                                    $usuario = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($usuario as $u) {
                                            $idTrabajador = $u['id_colaborador'];
                                            $destinoCreador = $u['id_destino'];
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                            try {
                                                $trabajador = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($trabajador as $t) {
                                                        $fotoC = $t['foto'];
                                                        $nombreC = $t['nombre'];
                                                        $apellidoC = $t['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $equipo = $ex;
                                                exit($ex);
                                            }
                                        }
                                    } else {
                                        $fotoC = "advertencia2.svg";
                                        $nombreC = "";
                                        $apellidoC = "";
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $pagina = 0;

                                $equipo->tareasMC .= "<div class=\"columns hvr-float\">"
                                        . "<div class=\"column is-8\">"
                                        . "<div class=\"field text-truncate\">";
                                if ($statusAccion == "F") {
                                    if ($idDestinoActividad == 10) {
                                        if ($_SESSION['usuario'] == 4) {
                                            $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                                        } else {
                                            $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked disabled>";
                                        }
                                    } else {
                                        $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                                    }
                                } else {
                                    if ($idDestinoActividad == 10) {
                                        if ($_SESSION['usuario'] == 4) {
                                            $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                                        } else {
                                            $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                                        }
                                    } else {
                                        $equipo->tareasMC .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                                    }
                                }
                                $equipo->tareasMC .= "<label for=\"chkb_$idAccion\"></label>";
                                if ($destinoCreador == 10) {
                                    $equipo->tareasMC .= "<span class=\"manita\" onclick=\"showDetallesTareaMC('show'); obtDetalleTareaMC($idAccion);\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> ($des) $actividad</span>";
                                } else {
                                    $equipo->tareasMC .= "<span class=\"manita\" onclick=\"showDetallesTareaMC('show'); obtDetalleTareaMC($idAccion);\">($des) $actividad</span>";
                                }


                                $equipo->tareasMC .= "</div>"
                                        . "</div>"
                                        . "<div class=\"column is-4\">"
                                        . "<div class=\"control\">"
                                        . "<div class=\"tags has-addons\">";
                                if ($fotoR == "advertencia2.svg") {
                                    $equipo->tareasMC .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">Sin responsable</span>";
                                } else {
                                    $equipo->tareasMC .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                                }
                                if ($tieneAdjuntos == "SI") {
                                    $equipo->tareasMC .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
                                }

                                //Seccion de planeacion de MC

                                if ($fechaInicio != null && $fechaFin != null) {
                                    $equipo->tareasMC .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
                                } else {
                                    $equipo->tareasMC .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
                                }
                                $equipo->tareasMC .= "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    //Obtener grafica de planeacion mp
                    $equipo->planeacionMP .= "<div class=\"columns mx-2 manita is-centered mb-0 pb-0\">"
                            . "<div class=\"column is-2\">"
                            . "</div>"
                            . "<div class=\"column\">";
                    for ($i = 1; $i <= 52; $i++) {
                        $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/semanas/s-$i.svg\" width=\"15px\" alt=\"\">";
                    }
                    $equipo->planeacionMP .= "</div>"
                            . "</div>";

                    $query = "SELECT * FROM t_planes_destinos WHERE id_destino = $idDestino";
                    try {
                        $planesDestinos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($planesDestinos as $pd) {
                                $idPlanMantto = $pd['id_mantto'];
                                $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlanMantto AND id_tipo_equipo = $idTipo";
                                try {
                                    $planes = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($planes as $p) {
                                            $idPlan = $p['id'];
                                            $planMantto = $p['nombre'];

                                            $query = "SELECT * FROM t_mp_planeacion WHERE id_equipo = $idEquipo AND id_plan = $idPlan AND año = '$año' AND activo = 1";
                                            try {
                                                $planeacion = $conn->obtDatos($query);
                                            } catch (Exception $ex) {
                                                $equipo = $ex;
                                                exit($ex);
                                            }

                                            $equipo->planeacionMP .= "<div class=\"columns mx-2 manita is-centered\">"
                                                    . "<div class=\"column is-2\">"
                                                    . "<h6 class=\"title is-6 has-text-right \">$planMantto</h6>"
                                                    . "</div>"
                                                    . "<div class=\"column\">";
//                                            for ($i = 1; $i <= 52; $i++) {
//                                                $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
//                                            }

                                            for ($i = 1; $i <= 52; $i++) {
                                                if ($currentWeek == $i) {
                                                    $aux = false;
                                                    foreach ($planeacion as $pl) {
                                                        $idPlaneacion = $pl['id'];
                                                        $statusMP = $pl['status'];
                                                        $semanaMP = $pl['semana'];
                                                        $semanaMPR = $pl['semana_realizado'];

                                                        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion";
                                                        try {
                                                            $resultado = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($resultado as $d) {
                                                                    $idOT = $d['id'];
                                                                }
                                                            } else {
                                                                $idOT = 0;
                                                            }
                                                        } catch (Exception $ex) {
                                                            $equipo = $ex;
                                                            exit($ex);
                                                        }

                                                        switch ($statusMP) {
                                                            case 'N':
                                                                if ($semanaMP < $currentWeek) {
                                                                    $colors = "P.svg";
                                                                    $bg = 'bg-danger';
                                                                    $bgbtn = "btn-danger";
                                                                } else {
                                                                    $colors = "P.svg";
                                                                    $bg = 'bg-primary';
                                                                    $bgbtn = "btn-primary";
                                                                }
                                                                $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion);\"";
                                                                break;
                                                            case 'P':
                                                                $colors = "PR.svg";
                                                                $bg = 'bg-warning';
                                                                $bgbtn = "btn-warning";
                                                                $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo);\"";
                                                                break;
                                                            case 'F':
                                                                if ($semanaMP < $semanaMPR) {
                                                                    $colors = "F.svg";
                                                                    $bg = 'bg-morado';
                                                                    $bgbtn = "btn-morado";
                                                                } else {
                                                                    $colors = "F.svg";
                                                                    $bg = 'bg-success';
                                                                    $bgbtn = "btn-success";
                                                                }
                                                                $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo);\"";

                                                                break;
                                                        }

                                                        if ($semanaMP == $i) {
                                                            $aux = true;
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
//                                                                $equipo->graficaGant .= "<td class=\"manita\">"
//                                                                        . "<div class=\"btn-group\">"
//                                                                        . "<img data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" src=\"svg/$colors\" width=\"15\">"
//                                                                        //. "<button class=\"btn $bgbtn btn-sm fs-9\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Ver</button>"
//                                                                        . "<div class=\"dropdown-menu\">"
//                                                                        . "<a class=\"dropdown-item\" href=\"#\" onclick=\"openmodaldetalleMP($idPlan);\">Ver Detalles</a>";
//                                                                if ($statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"generarOrdenTrabajo($idPlan, $idPlaneacion, '$modal');\">Generar OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" tabindex=\"-1\" aria-disabled=\"true\">Generar OT</a>";
//                                                                }
//
//                                                                if ($statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" >Ver OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"verOT($idEquipo, $idOT);\">Ver OT</a>";
//                                                                }
//
//
//                                                                if ($statusMP == "F" || $statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" >Cerrar OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#modal-cerrar-ot\" onclick=\"cerrarOT($idOT, '$modal');\">Cerrar OT</a>";
//                                                                }
//
//
//                                                                if ($idPermiso == 3) {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\">Eliminar Programacion</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\">Eliminar Programacion</a>";
//                                                                }
//                                                                $equipo->graficaGant .= "</div>"
//                                                                        . "</div>"
//                                                                        . "</td>";
                                                        } else {
                                                            //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                                        }
                                                    }
                                                    if ($aux != true) {
                                                        if ($idPermiso == 3) {
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
//                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                                        } else {
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
//                                                                $equipo->graficaGant .= "<td class=\"manita\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                                        }
                                                    }
                                                } else {
                                                    $aux = false;
                                                    foreach ($planeacion as $pl) {
                                                        $idPlaneacion = $pl['id'];
                                                        $statusMP = $pl['status'];
                                                        $semanaMP = $pl['semana'];
                                                        $semanaMPR = $pl['semana_realizado'];

                                                        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion";
                                                        try {
                                                            $resultado = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($resultado as $d) {
                                                                    $idOT = $d['id'];
                                                                }
                                                            } else {
                                                                $idOT = 0;
                                                            }
                                                        } catch (Exception $ex) {
                                                            $equipo = $ex;
                                                            exit($ex);
                                                        }

                                                        switch ($statusMP) {
                                                            case 'N':
                                                                if ($semanaMP < $currentWeek) {
                                                                    $colors = "P.svg";
                                                                    $bg = 'bg-danger';
                                                                    $bgbtn = "btn-danger";
                                                                } else {
                                                                    $colors = "P.svg";
                                                                    $bg = 'bg-primary';
                                                                    $bgbtn = "btn-primary";
                                                                }
                                                                $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion);\"";
                                                                break;
                                                            case 'P':
                                                                $colors = "PR.svg";
                                                                $bg = 'bg-warning';
                                                                $bgbtn = "btn-warning";
                                                                $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo);\"";
                                                                break;
                                                            case 'F':
                                                                if ($semanaMP < $semanaMPR) {
                                                                    $colors = "F.svg";
                                                                    $bg = 'bg-morado';
                                                                    $bgbtn = "btn-morado";
                                                                } else {
                                                                    $colors = "F.svg";
                                                                    $bg = 'bg-success';
                                                                    $bgbtn = "btn-success";
                                                                }
                                                                $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo);\"";
                                                                break;
                                                        }
                                                        if ($semanaMP == $i) {
                                                            $aux = true;
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
//                                                                $equipo->graficaGant .= "<td class=\"manita\">"
//                                                                        . "<div class=\"btn-group\">"
//                                                                        . "<img data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" src=\"svg/$colors\" width=\"15\">"
//                                                                        //. "<button class=\"btn $bgbtn btn-sm fs-9\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Ver</button>"
//                                                                        . "<div class=\"dropdown-menu\">"
//                                                                        . "<a class=\"dropdown-item\" href=\"#\" onclick=\"openmodaldetalleMP($idPlan);\">Ver Detalles</a>";
//                                                                if ($statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"generarOrdenTrabajo($idPlan, $idPlaneacion, '$modal');\">Generar OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" tabindex=\"-1\" aria-disabled=\"true\">Generar OT</a>";
//                                                                }
//
//                                                                if ($statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" >Ver OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"verOT($idEquipo, $idOT);\">Ver OT</a>";
//                                                                }
//
//                                                                if ($statusMP == "F" || $statusMP == "N") {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\" >Cerrar OT</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#modal-cerrar-ot\" onclick=\"cerrarOT($idOT, '$modal');\">Cerrar OT</a>";
//                                                                }
//
//                                                                if ($idPermiso == 3) {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item\" href=\"#\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\">Eliminar Programacion</a>";
//                                                                } else {
//                                                                    $equipo->graficaGant .= "<a class=\"dropdown-item disabled\" href=\"#\">Eliminar Programacion</a>";
//                                                                }
//
//                                                                $equipo->graficaGant .= "</div>"
//                                                                        . "</div>"
//                                                                        . "</td>";
                                                        } else {
                                                            //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                                        }
                                                    }
                                                    if ($aux != true) {
                                                        if ($idPermiso == 3) {
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
//                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                                        } else {
                                                            $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
//                                                                $equipo->graficaGant .= "<td class=\"manita\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                                        }
                                                    }
                                                }
                                            }
                                            $equipo->planeacionMP .= "</div>"
                                                    . "</div>";
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

//                    OBTENER HISTORIAL DE OT MP
                    $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo AND status = 'F'";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idOT = $dts['id'];
                                $folio = $dts['folio'];
                                $idPlaneacion = $dts['id_planeacion_mp'];
                                $fechaCreacion = $dts['fecha_creacion'];
                                $usuarioCreador = $dts['usuario_creador'];
                                $lstActividades = $dts['lista_actividades'];
                                $idDestinoOT = $dts['id_destino'];
                                $fechaRealizado = $dts['fecha_realizado'];
                                $realizadoPor = $dts['realizado_por'];
                                $status = $dts['status'];
                                $lstActR = $dts['lista_actividades_realizadas'];

                                //Usuario creador de ot
                                $query = "SELECT * FROM t_users WHERE id = $usuarioCreador";
                                try {
                                    $result = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $dts) {
                                            $idEmpleado = $dts['id_colaborador'];
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($result as $dts) {
                                                        $nombreEmpleado = $dts['nombre'];
                                                        $apellidoEmpleado = $dts['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $equipo = $ex;
                                                exit($ex);
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $equipo = $ex;
                                    exit($ex);
                                }

                                $equipo->historialOT .= "<div class=\"timeline-item is-danger\">"
                                        . "<div class=\"timeline-marker is-danger\">"
                                        . "</div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading\">OT# $folio Creada por: <strong>$nombreEmpleado $apellidoEmpleado</strong></p>"
                                        . "<p class=\"heading\">$fechaCreacion</p>"
                                        . "<div class=\"field has-addons\">"
                                        . "<p class=\"control\">"
                                        . "<a class=\"button is-danger is-outlined is-small\" onclick=\"imprimirOT($idEquipo, $idOT)\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-file-download\"></i>"
                                        . "</span>"
                                        . "<span>Descargar OT</span>"
                                        . "</a>"
                                        . "</p>"
                                        . "<p class=\"control\">"
                                        . "<a class=\"button is-danger is-outlined is-small\" onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo);\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-info-circle\"></i>"
                                        . "</span>"
                                        . "<span>Ver más</span>"
                                        . "</a>"
                                        . "</p>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_equipos_adjuntos WHERE id_equipo = $idEquipo";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dts) {
                                $idAdjunto = $dts['id'];
                                $urlArchivo = $dts['url_archivo'];
                                $fechaSubida = $dts['fecha_subida'];
                                if ($dts['subido_por'] != "") {
                                    $subido = $dts['subido_por'];
                                } else {
                                    $subido = 0;
                                }

                                if ($urlArchivo != "") {
                                    $info = new SplFileInfo($urlArchivo);
                                    $ext = $info->getExtension();

                                    switch ($ext) {
                                        case 'doc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
                                        case 'DOC':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
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
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'JPG':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'jpeg':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'JPEG':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'svg':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'SVG':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
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
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
                                            }
                                            break;
                                        case 'PNG':
                                            if ($pagina == 0) {
                                                $url = "img/equipos/$urlArchivo";
                                            } else {
                                                $url = "../img/equipos/$urlArchivo";
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
                                        case 'MOV':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mov':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'MP4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mp4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                    }

//                                $tarea->adjuntos .= $ext;
//                                    if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
//                                        $mpr->adjuntos .= "<div class=\"col-3 mt-1\">"
//                                                . "<a class=\"example-image-link\" href=\"planner/mp/$urlArchivo\" data-lightbox=\"mp-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
//                                                . "</div>";
//                                    } else {
//                                        $mpr->adjuntos .= "<div class=\"col-3 mt-1\">"
//                                                . "<a class=\"example-image-link\" href=\"planner/mp/$urlArchivo\" data-lightbox=\"mp-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
//                                                . "</div>";
//                                    }

                                    if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                                        $equipo->adjuntos .= "<div class=\"column\">"
                                                . "<figure class=\"image is-96x96\">"
                                                . "<a class=\"example-image-link\" href=\"img/equipos/$urlArchivo\" data-lightbox=\"adjuntos-equipos-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</figure>"
                                                . "</div>";
                                    } else {
                                        $equipo->adjuntos .= "<div class=\"column\">"
                                                . "<figure class=\"image is-96x96\">"
                                                . "<a class=\"example-image-link\" target=\"_blank\" href=\"img/equipos/$urlArchivo\" target=\"_blank\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</figure>"
                                                . "</div>";
                                    }
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }
                }
            } else {
                $equipo = "No existe el equipo";
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

    public function recargarMCEq($idEquipo, $status) {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');

        $currentWeek = date("W");

        //obtener mc
        //Obtener las tareas de correctivo del equipo
        $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND status = '$status' AND activo = 1";
        try {
            $result = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($result as $dts) {
                    $idAccion = $dts['id'];
                    $idTarea = $dts['id_tarea']; //Para las actividades del antiguo planner
                    $actividad = $dts['actividad'];
                    $statusAccion = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $fechaInicio = $dts['fecha_inicio'];
                    $fechaFin = $dts['fecha_fin'];
                    $fechaRealizacion = $dts['fecha_realizado'];
                    $realizo = $dts['realizado_por'];
                    $creado = $dts['creado_por'];
                    $idDestinoActividad = $dts['id_destino'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $semanaI = $dts['semana_inicio'];
                    $semanaF = $dts['semana_fin'];

                    if ($semanaI == "") {
                        $semanaI = date("W", strtotime($fechaCreacion));
                    }

                    if ($idTarea != 0) {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE (id_tarea = $idTarea OR id_mc = $idAccion)";
                    } else {
                        $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idAccion";
                    }

                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $tieneAdjuntos = "SI";
                        } else {
                            $tieneAdjuntos = "NO";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Obtener destino de la actividad
                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoActividad";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $des = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos de el usuario responsable
                    $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoR = $t['foto'];
                                            $nombreR = $t['nombre'];
                                            $apellidoR = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoR = "advertencia2.svg";
                            $nombreR = "";
                            $apellidoR = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT * FROM t_users WHERE id = $realizo";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoRE = $t['foto'];
                                            $nombreRE = $t['nombre'];
                                            $apellidoRE = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreRE = "";
                            $apellidoRE = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que creador
                    $query = "SELECT * FROM t_users WHERE id = $creado";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $destinoCreador = $u['id_destino'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoC = $t['foto'];
                                            $nombreC = $t['nombre'];
                                            $apellidoC = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoC = "advertencia2.svg";
                            $nombreC = "";
                            $apellidoC = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $pagina = 0;

                    $salida .= "<div class=\"columns hvr-float\">"
                            . "<div class=\"column is-8\">"
                            . "<div class=\"field text-truncate\">";
                    if ($statusAccion == "F") {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                            } else {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked disabled>";
                            }
                        } else {
                            $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                        }
                    } else {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                            } else {
                                $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                            }
                        } else {
                            $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                        }
                    }
                    $salida .= "<label for=\"chkb_$idAccion\"></label>";
                    if ($destinoCreador == 10) {
                        $salida .= "<span class=\"manita\" onclick=\"showDetallesTareaMC('show'); obtDetalleTareaMC($idAccion);\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> ($des) $actividad</span>";
                    } else {
                        $salida .= "<span class=\"manita\" onclick=\"showDetallesTareaMC('show'); obtDetalleTareaMC($idAccion);\">($des) $actividad</span>";
                    }


                    $salida .= "</div>"
                            . "</div>"
                            . "<div class=\"column is-4\">"
                            . "<div class=\"control\">"
                            . "<div class=\"tags has-addons\">";
                    if ($fotoR == "advertencia2.svg") {
                        $salida .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">Sin responsable</span>";
                    } else {
                        $salida .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                    }
                    if ($tieneAdjuntos == "SI") {
                        $salida .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
                    }

                    //Seccion de planeacion de MC

                    if ($fechaInicio != null && $fechaFin != null) {
                        $salida .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
                    } else {
                        $salida .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
                    }
                    $salida .= "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $salida;
    }

    public function obtDetallePlan($idPlan) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        $query = "SELECT * FROM t_planes_actividades WHERE id_mantto = $idPlan";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $actividad = $dts['actividad'];
                    $salida .= "<li class=\"manita\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $actividad</li>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function obtDetalleOT($idPlaneacion, $idEquipo) {
        $conn = new Conexion();
        $conn->conectar();
        $ot = new OrdenTrabajo();

        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion AND id_equipo = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $ot->id = $dts['id'];
                    $ot->folio = $dts['folio'];
                    $ot->fechaCreacion = $dts['fecha_creacion'];
                    $ot->creadoPor = $dts['usuario_creador'];
                    $listActividades = $dts['lista_actividades'];
                    $ot->idDestino = $dts['id_destino'];
                    $ot->fechaRealizado = $dts['fecha_realizado'];
                    $idRealizadoPor = $dts['realizado_por'];
                    $lstActRealizadas = $dts['lista_actividades_realizadas'];

                    if ($idRealizadoPor != "") {
                        $query = "SELECT * FROM t_colaboradores WHERE id = $idRealizadoPor";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $nombreRealizado = $dts['nombre'];
                                    $apellidoRealizado = $dts['apellido'];
                                }
                            } else {
                                $nombreRealizado = "";
                                $apellidoRealizado = "";
                            }
                        } catch (Exception $ex) {
                            $ot = $ex;
                            exit($ex);
                        }
                    } else {
                        $nombreRealizado = "";
                        $apellidoRealizado = "";
                    }

                    $ot->realizadoPor = $nombreRealizado . " " . $apellidoRealizado;
                    //obtener datos del usuario que creo la tarea
                    $query = "SELECT * FROM t_users WHERE id = $ot->creadoPor";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idEmpleado = $dts['id_colaborador'];
                                //Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombreCreador = $dts['nombre'];
                                            $apellidoCreador = $dts['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $ot = $ex;
                        exit($ex);
                    }

                    //Obtner la lista de actividades
                    $query = "SELECT * FROM t_mp_planeacion WHERE id = $idPlaneacion";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $d) {
                                $idPlanMP = $d['id_plan'];
                                $semana = $d['semana'];
                                $status = $d['status'];
                                $creadoPor = $d['creado_por'];

                                $ot->idPlan = $idPlanMP;

                                switch ($status) {
                                    case 'N':
                                        $ot->status = "Planificado";
                                        break;
                                    case 'P':
                                        $ot->status = "En proceso";
                                        break;
                                    case 'F':
                                        $ot->status = "Finalizado";
                                        break;
                                }


                                $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlanMP";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombrePlan = $dts['nombre'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                }

                                $ot->listActividades .= "<div class=\"columns hvr-float\">"
                                        . "<div class=\"column is-12\">"
                                        . "<div class=\"field has-text-left\">"
                                        . "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" name=\"listchkbPMOT_$idPlanMP\" id=\"chkbPMOT_$idPlanMP\" onchange=\"selectAll(this, $idPlanMP)\">"
                                        . "<label for=\"chkbPMOT_$idPlanMP\"><span></span>$nombrePlan</label>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";

                                $query = "SELECT * FROM t_planes_actividades WHERE id_mantto = $idPlanMP";
                                try {
                                    $actividades = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($actividades as $act) {
                                            $idActividad = $act['id'];
                                            $nombreAct = $act['actividad'];
                                            $pos = strpos($lstActRealizadas, $idActividad);

                                            if ($pos === false) {
                                                $ot->listActividades .= "<div class=\"columns hvr-float ml-4\">"
                                                        . "<div class=\"column is-12\">"
                                                        . "<div class=\"field has-text-left\">"
                                                        . "<input type=\"checkbox\" class=\"is-checkradio is-success is-circle is-small\" name=\"listchkbOT_$idPlanMP\" id=\"chkbActOT_$idActividad\">"
                                                        . "<label for=\"chkbActOT_$idActividad\">$nombreAct</label>"
                                                        . "</div>"
                                                        . "</div>"
                                                        . "</div>";
                                            } else {
                                                $ot->listActividades .= "<div class=\"columns hvr-float ml-4\">"
                                                        . "<div class=\"column is-12\">"
                                                        . "<div class=\"field has-text-left\">"
                                                        . "<input type=\"checkbox\" class=\"is-checkradio is-success is-circle is-small\" name=\"listchkbOT_$idPlanMP\" id=\"chkbActOT_$idActividad\" checked>"
                                                        . "<label for=\"chkbActOT_$idActividad\">$nombreAct</label>"
                                                        . "</div>"
                                                        . "</div>"
                                                        . "</div>";
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                }

                                if ($status == "F") {
                                    $ot->listActividades .= "<div class=\"columns is-centered\">"
                                            . "<div class=\"column\">"
                                            . "<p class=\"control has-text-centered\">"
                                            . "<a class=\"button is-success\" disabled>"
                                            . "<span class=\"icon is-small\">"
                                            . "<i class=\"fas fa-check\"></i>"
                                            . "</span>"
                                            . "<span>Finalizar OT</span>"
                                            . "</a>"
                                            . "</p>"
                                            . "</div>"
                                            . "</div>";
                                } else {
                                    $ot->listActividades .= "<div class=\"columns is-centered\">"
                                            . "<div class=\"column\">"
                                            . "<p class=\"control has-text-centered\">"
                                            . "<a class=\"button is-success\" onclick=\"cerrarOT('modalFinalizarOT');\">"
                                            . "<span class=\"icon is-small\">"
                                            . "<i class=\"fas fa-check\"></i>"
                                            . "</span>"
                                            . "<span>Finalizar OT</span>"
                                            . "</a>"
                                            . "</p>"
                                            . "</div>"
                                            . "</div>";
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $ot = $ex;
                        exit($ex);
                    }

                    //Obtener el timeline de la OT
                    $ot->timeLine .= "<header class=\"timeline-header\">"
                            . "<span class=\"tag is-small is-info\">Inicio</span>"
                            . "</header>"
                            . "<div class=\"timeline-item is-danger\">"
                            . "<div class=\"timeline-marker is-danger is-icon\">"
                            . "<i class=\"fa fa-plus\"></i>"
                            . "</div>"
                            . "<div class=\"timeline-content\">"
                            . "<p class=\"heading\">OT Creada por: <strong>$nombreCreador $apellidoCreador</strong></p>"
                            . "<p class=\"heading\">$ot->fechaCreacion</p>"
                            . "</div>"
                            . "</div>";
                    $query = "SELECT * FROM t_mp_comentarios WHERE id_ot = $ot->id";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $comentario = $dts['comentarios'];
                                $usuario = $dts['id_usuario'];
                                $fechaComentario = $dts['fecha'];

                                $query = "SELECT * FROM t_users WHERE id = $usuario";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idEmpleado = $dts['id_colaborador'];
                                            //Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $nombre = $dts['nombre'];
                                                        $apellido = $dts['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $ot = $ex;
                                                exit($ex);
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                }

                                $ot->timeLine .= "<div class=\"timeline-item is-info\">"
                                        . "<div class=\"timeline-marker is-info\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fechaComentario</p>"
                                        . "<p>$comentario</p>"
                                        . "</div>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $ot = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_mp_adjuntos WHERE id_ot = $ot->id";
                    $pagina = 0;
                    try {
                        $adjuntos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($adjuntos as $dts) {
                                $urlArchivo = $dts['url_adjunto'];
                                $fecha = $dts['fecha'];
                                if ($dts['subido_por'] != "") {
                                    $subido = $dts['subido_por'];
                                } else {
                                    $subido = 0;
                                }
                                $query = "SELECT * FROM t_users WHERE id = $subido";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                                $ot = $ex;
                                                exit($ex);
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                }

                                if ($urlArchivo != "") {
                                    $info = new SplFileInfo($urlArchivo);
                                    $ext = $info->getExtension();

                                    switch ($ext) {
                                        case 'doc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
                                        case 'DOC':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
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
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'JPG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'jpeg':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'JPEG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'svg':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'SVG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
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
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/tareas/adjuntos/$urlArchivo";
                                            }
                                            break;
                                        case 'PNG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
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
                                        case 'MOV':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mov':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'MP4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mp4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                    }

//                                $tarea->adjuntos .= $ext;

                                    if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                                        $ot->timeLine .= "<div class=\"timeline-item is-danger\">"
                                                . "<div class=\"timeline-marker is-danger is-icon\">"
                                                . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                                . "</div>"
                                                . "<div class=\"timeline-content\">"
                                                . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                                . "<a class=\"example-image-link\" href=\"planner/mp/$urlArchivo\" data-lightbox=\"adjuntos-mp-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</div>"
                                                . "</div>";
                                    } else {
                                        $ot->timeLine .= "<div class=\"timeline-item is-danger\">"
                                                . "<div class=\"timeline-marker is-danger is-icon\">"
                                                . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                                . "</div>"
                                                . "<div class=\"timeline-content\">"
                                                . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                                . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/mp/$urlArchivo\" ><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</div>"
                                                . "</div>";
                                    }

//                                    $ot->timeLine .= "<div class=\"timeline-item is-danger\">"
//                                            . "<div class=\"timeline-marker is-danger is-icon\">"
//                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
//                                            . "</div>"
//                                            . "<div class=\"timeline-content\">"
//                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
//                                            . "<img src=\"$url\" width=\"40px\" alt=\"\">"
//                                            . "</div>"
//                                            . "</div>";
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $ot = $ex;
                        exit($ex);
                        exit($ex);
                    }
                }
            } else {
                $ot = "Sin resultados";
            }
        } catch (Exception $ex) {
            $ot = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $ot;
    }

    public function insertarComentarioOT($idOT, $comentario) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");
        $idUsuario = $_SESSION['usuario'];
        $query = "INSERT INTO t_mp_comentarios (id_ot, comentarios, id_usuario, fecha) "
                . "VALUES($idOT, '$comentario', $idUsuario, '$fecha')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function obtenerTimeLineOT($idOT) {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_ordenes_trabajo WHERE id = $idOT";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['id'];
                    $folio = $dts['folio'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $creadoPor = $dts['usuario_creador'];
                    $listActividades = $dts['lista_actividades'];
                    $idDestino = $dts['id_destino'];

                    //obtener datos del usuario que creo la tarea
                    $query = "SELECT * FROM t_users WHERE id = $creadoPor";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idEmpleado = $dts['id_colaborador'];
                                //Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $nombreCreador = $dts['nombre'];
                                            $apellidoCreador = $dts['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                    break;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $ot = $ex;
                        exit($ex);
                        break;
                    }

//                    //Obtner la lista de actividades
//                    $query = "SELECT * FROM t_mp_planeacion WHERE id = $idPlaneacion";
//                    try {
//                        $result = $conn->obtDatos($query);
//                        if ($conn->filasConsultadas > 0) {
//                            foreach ($result as $d) {
//                                $idPlanMP = $d['id_plan'];
//                                $semana = $d['semana'];
//                                $status = $d['status'];
//                                $creadoPor = $d['creado_por'];
//                                switch ($status) {
//                                    case 'N':
//                                        $status = "Planificado";
//                                        break;
//                                    case 'P':
//                                        $status = "En proceso";
//                                        break;
//                                    case 'F':
//                                        $status = "Finalizado";
//                                        break;
//                                }
//
//
//                                $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlanMP";
//                                try {
//                                    $resp = $conn->obtDatos($query);
//                                    if ($conn->filasConsultadas > 0) {
//                                        foreach ($resp as $dts) {
//                                            $nombrePlan = $dts['nombre'];
//                                        }
//                                    }
//                                } catch (Exception $ex) {
//                                    $ot = $ex; exit($ex);
//                                    break;
//                                }
//
//                                $listActividades .= "<div class=\"columns hvr-float\">"
//                                        . "<div class=\"column\">"
//                                        . "<div class=\"field text-truncate has-text-left\">"
//                                        . "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" name=\"listchkbPMOT_$idPlanMP\" id=\"chkbPMOT_$idPlanMP\" onchange=\"selectAll(this, $idPlanMP)\">"
//                                        . "<label for=\"chkbPMOT_$idPlanMP\"><span></span>$nombrePlan</label>"
//                                        . "</div>"
//                                        . "</div>"
//                                        . "</div>";
//
//                                $query = "SELECT * FROM t_planes_actividades WHERE id_mantto = $idPlanMP";
//                                try {
//                                    $actividades = $conn->obtDatos($query);
//                                    if ($conn->filasConsultadas > 0) {
//                                        foreach ($actividades as $act) {
//                                            $idActividad = $act['id'];
//                                            $nombreAct = $act['actividad'];
//                                            $listActividades .= "<div class=\"columns hvr-float ml-4\">"
//                                                    . "<div class=\"column\">"
//                                                    . "<div class=\"field text-truncate has-text-left\">"
//                                                    . "<input type=\"checkbox\" class=\"is-checkradio is-success is-circle is-small\" name=\"listchkbOT_$idPlanMP\" id=\"chkbActOT_$idActividad\" >"
//                                                    . "<label for=\"chkbActOT_$idActividad\">$nombreAct</label>"
//                                                    . "</div>"
//                                                    . "</div>"
//                                                    . "</div>";
//                                        }
//                                    }
//                                } catch (Exception $ex) {
//                                    $ot = $ex; exit($ex);
//                                }
//
//                                $listActividades .= "<div class=\"columns is-centered\">"
//                                        . "<div class=\"column\">"
//                                        . "<p class=\"control has-text-centered\">"
//                                        . "<a class=\"button is-success\">"
//                                        . "<span class=\"icon is-small\">"
//                                        . "<i class=\"fas fa-check\"></i>"
//                                        . "</span>"
//                                        . "<span>Finalizar OT</span>"
//                                        . "</a>"
//                                        . "</p>"
//                                        . "</div>"
//                                        . "</div>";
//                            }
//                        }
//                    } catch (Exception $ex) {
//                        $ot = $ex; exit($ex);
//                        break;
//                    }
                    //Obtener el timeline de la OT
                    $salida .= "<header class=\"timeline-header\">"
                            . "<span class=\"tag is-small is-info\">Inicio</span>"
                            . "</header>"
                            . "<div class=\"timeline-item is-danger\">"
                            . "<div class=\"timeline-marker is-danger is-icon\">"
                            . "<i class=\"fa fa-plus\"></i>"
                            . "</div>"
                            . "<div class=\"timeline-content\">"
                            . "<p class=\"heading\">OT Creada por: <strong>$nombreCreador $apellidoCreador</strong></p>"
                            . "<p class=\"heading\">$fechaCreacion</p>"
                            . "</div>"
                            . "</div>";
                    $query = "SELECT * FROM t_mp_comentarios WHERE id_ot = $id";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $comentario = $dts['comentarios'];
                                $usuario = $dts['id_usuario'];
                                $fechaComentario = $dts['fecha'];

                                $query = "SELECT * FROM t_users WHERE id = $usuario";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idEmpleado = $dts['id_colaborador'];
                                            //Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $nombre = $dts['nombre'];
                                                        $apellido = $dts['apellido'];
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                $ot = $ex;
                                                exit($ex);
                                                break;
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ot = $ex;
                                    exit($ex);
                                    break;
                                }

                                $salida .= "<div class=\"timeline-item is-info\">"
                                        . "<div class=\"timeline-marker is-info\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fechaComentario</p>"
                                        . "<p>$comentario</p>"
                                        . "</div>"
                                        . "</div>";
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                        break;
                    }

                    $query = "SELECT * FROM t_mp_adjuntos WHERE id_ot = $id";
                    $pagina = 0;
                    try {
                        $adjuntos = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($adjuntos as $dts) {
                                $urlArchivo = $dts['url_adjunto'];
                                $fecha = $dts['fecha'];
                                if ($dts['subido_por'] != "") {
                                    $subido = $dts['subido_por'];
                                } else {
                                    $subido = 0;
                                }
                                $query = "SELECT * FROM t_users WHERE id = $subido";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                                exit($ex);
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }

                                if ($urlArchivo != "") {
                                    $info = new SplFileInfo($urlArchivo);
                                    $ext = $info->getExtension();

                                    switch ($ext) {
                                        case 'doc':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
                                        case 'DOC':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/doc.svg";
                                            } else {
                                                $url = "../svg/formatos/doc.svg";
                                            }
                                            break;
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
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'JPG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'jpeg':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'JPEG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'svg':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
                                            }
                                            break;
                                        case 'SVG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
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
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/tareas/adjuntos/$urlArchivo";
                                            }
                                            break;
                                        case 'PNG':
                                            if ($pagina == 0) {
                                                $url = "planner/mp/$urlArchivo";
                                            } else {
                                                $url = "../planner/mp/$urlArchivo";
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
                                        case 'MOV':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mov':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'MP4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                        case 'mp4':
                                            if ($pagina == 0) {
                                                $url = "svg/formatos/mp4.svg";
                                            } else {
                                                $url = "../svg/formatos/mp4.svg";
                                            }
                                            break;
                                    }

//                                $tarea->adjuntos .= $ext;

                                    if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                                        $salida .= "<div class=\"timeline-item is-danger\">"
                                                . "<div class=\"timeline-marker is-danger is-icon\">"
                                                . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                                . "</div>"
                                                . "<div class=\"timeline-content\">"
                                                . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                                . "<a class=\"example-image-link\" href=\"planner/mp/$urlArchivo\" data-lightbox=\"adjuntos-mp-gallery\" data-title=\"\"><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</div>"
                                                . "</div>";
                                    } else {
                                        $salida .= "<div class=\"timeline-item is-danger\">"
                                                . "<div class=\"timeline-marker is-danger is-icon\">"
                                                . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                                . "</div>"
                                                . "<div class=\"timeline-content\">"
                                                . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                                . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/mp/$urlArchivo\" ><img width=\"80\" height=\"80\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                                . "</div>"
                                                . "</div>";
                                    }

//                                    $salida .= "<div class=\"timeline-item is-danger\">"
//                                            . "<div class=\"timeline-marker is-danger is-icon\">"
//                                            . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
//                                            . "</div>"
//                                            . "<div class=\"timeline-content\">"
//                                            . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
//                                            . "<img src=\"$url\" width=\"40px\" alt=\"\">"
//                                            . "</div>"
//                                            . "</div>";
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                        break;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function cerrarOT($idOT, $realizadoPor, $fechaRealizado, $lstActividades) {
        $conn = new Conexion();
        $conn->conectar();

        $fechaRealizado = date("Y-m-d", strtotime($fechaRealizado));

        $query = "UPDATE t_ordenes_trabajo SET fecha_realizado = '$fechaRealizado', realizado_por = $realizadoPor, status = 'F', lista_actividades_realizadas = '$lstActividades' 
            WHERE id = $idOT";

        try {
            $resp = $conn->consulta($query);
            $query = "SELECT * FROM t_ordenes_trabajo WHERE id = $idOT";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idPlaneacion = $dts['id_planeacion_mp'];
                    }
                    $query = "UPDATE t_mp_planeacion SET status = 'F' WHERE id = $idPlaneacion";
                    try {
                        $resp = $conn->consulta($query);
                    } catch (Exception $ex) {
                        $resp = $ex;
                        exit($ex);
                    }
                }
            } catch (Exception $ex) {
                $resp = $ex;
                exit($ex);
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }


        $conn->cerrar();
        return $resp;
    }

//    **********************************************************************
//    ***************        SECCION PROYECTOS        **********************
//    **********************************************************************

    public function agregarProyecto($idDestino, $idSeccion, $idSubseccion, $tituloProyecto, $justificacion, $tipoProyecto, $coste, $año, $fileName) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");
        if ($coste == "") {
            $coste = 0;
        }
        $query = "INSERT INTO t_proyectos (id_destino, id_seccion, id_subseccion, titulo, justificacion, fecha_creacion, creado_por, status, tipo, coste, año, activo) "
                . "VALUES($idDestino, $idSeccion, $idSubseccion, '$tituloProyecto', '$justificacion', '$fecha', " . $_SESSION['usuario'] . ", 'N', '$tipoProyecto', $coste, '$año', 1)";
        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {

                $query = "SELECT LAST_INSERT_ID(id) AS LAST FROM t_proyectos ORDER BY id DESC LIMIT 0,1";
                try {
                    $ultimoRegistro = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($ultimoRegistro as $dts) {
                            $idProyecto = $dts['LAST'];
                        }

                        if ($fileName != "") {
                            $query = "INSERT INTO t_proyectos_adjuntos (id_proyecto, url_adjunto) "
                                    . "VALUES($idProyecto, '$fileName')";
                            try {
                                $resp = $conn->consulta($query);
                            } catch (Exception $ex) {
                                $resp = $ex;
                                exit($ex);
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($ex);
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function obtenerDetalleProyecto($idProyecto) {
        $conn = new Conexion();
        $conn->conectar();

        $proyecto = new Proyecto();

        $query = "SELECT * FROM t_proyectos WHERE id = $idProyecto";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDestinoProyecto = $dts['id_destino'];
                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoProyecto";
                    try {
                        $r = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($r as $d) {
                                $proyecto->destinoProyecto = $d['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }
                    $proyecto->titulo = $dts['titulo'];
                    $proyecto->justificacion = $dts['justificacion'];
                    $proyecto->tipo = $dts['tipo'];
                    $proyecto->año = $dts['año'];
                    $proyecto->coste = money_format("%.2n", $dts['coste']);
                    $proyecto->status = $dts['status'];
                    $proyecto->idDestino = $idDestinoProyecto;
                    $proyecto->idSeccion = $dts['id_seccion'];
                    $proyecto->idSubseccion = $dts['id_subseccion'];
                }
            }
        } catch (Exception $ex) {
            $proyecto = $ex;
            exit($ex);
        }

        //obtener mc
        $query = "SELECT * FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND status = 'N' AND activo = 1";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idAccion = $dts['id'];
                    $actividad = $dts['actividad'];
                    $statusAccion = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $fechaRealizacion = $dts['fecha_realizado'];
                    $realizo = $dts['realizado_por'];
                    $creadoPor = $dts['creado_por'];

                    $query = "SELECT * FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idAccion";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $tieneAdjuntos = "SI";
                        } else {
                            $tieneAdjuntos = "NO";
                        }
                    } catch (Exception $ex) {
                        $equipo->planMC = $ex;
                        exit($ex);
                    }

                    //Datos de el usuario responsable
                    $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoR = $t['foto'];
                                            $nombreR = $t['nombre'];
                                            $apellidoR = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $proyecto = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoR = "advertencia2.svg";
                            $nombreR = "";
                            $apellidoR = "";
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT * FROM t_users WHERE id = $realizo";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoRE = $t['foto'];
                                            $nombreRE = $t['nombre'];
                                            $apellidoRE = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $proyecto = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreRE = "";
                            $apellidoRE = "";
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que creo la tarea
                    $query = "SELECT * FROM t_users WHERE id = $creadoPor";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajadorC = $u['id_colaborador'];
                                $destinoCreador = $u['id_destino'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajadorC";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoC = $t['foto'];
                                            $nombreC = $t['nombre'];
                                            $apellidoC = $t['apellido'];
                                            $cargoCreador = $t['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $proyecto = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoC = "advertencia2.svg";
                            $nombreC = "";
                            $apellidoC = "";
                            $cargoCreador = 0;
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }

                    $pagina = 0;


                    $proyecto->planAccion .= "<div class=\"columns hvr-float\">"
                            . "<div class=\"column is-7\">"
                            . "<div class=\"field\">";
                    if ($statusAccion == "F") {

                        $proyecto->planAccion .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTareaProyecto($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                    } else {

                        $proyecto->planAccion .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTareaProyecto($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                    }
                    $proyecto->planAccion .= "<label for=\"chkb_$idAccion\"></label>";
                    if ($destinoCreador == 10) {
                        $proyecto->planAccion .= "<span id=\"txtActividad$idAccion\" class=\"manita is-size-7 titulo-actividad\" onclick=\"verComentariosActividad($idAccion, this)\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> $actividad</span>";
                    } else {
                        $proyecto->planAccion .= "<span id=\"txtActividad$idAccion\" class=\"manita is-size-7 titulo-actividad\" onclick=\"verComentariosActividad($idAccion, this)\">$actividad</span>";
                    }


                    $proyecto->planAccion .= "</div>"
                            . "</div>"
                            . "<div class=\"column is-5\">"
                            . "<div class=\"control\">"
                            . "<div class=\"tags has-addons\">";
                    if ($fotoR == "advertencia2.svg") {
                        $proyecto->planAccion .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsableProyecto'); setIdActividad($idAccion);\">Sin responsable</span>";
                    } else {
                        $proyecto->planAccion .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsableProyecto'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                    }

                    $proyecto->planAccion .= "<span class=\"tag is-danger\" onclick=\"quitarTareaProyecto($idAccion);\">Eliminar</span>";
//                    if ($tieneAdjuntos == "SI") {
//                        $proyecto->planAccion .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
//                    }
                    //Seccion de planeacion de MC
//                    if ($fechaInicio != null && $fechaFin != null) {
//                        $proyecto->planAccion .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
//                    } else {
//                        $proyecto->planAccion .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
//                    }
                    $proyecto->planAccion .= "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $proyecto = $ex;
            exit($ex);
        }

        $proyecto->adjuntos .= "<header class=\"timeline-header\">"
                . "<span class=\"tag is-small is-info\">Cot. y Fact.</span>"
                . "</header>";
        //Obetner adjuntos, cotizaciones, facturas, imagenes
        $query = "SELECT * FROM t_proyectos_adjuntos WHERE id_proyecto = $idProyecto";
        try {

            $adjuntos = $conn->obtDatos($query);
            $pagina = 0;
            if ($conn->filasConsultadas > 0) {
                foreach ($adjuntos as $dts) {
                    $idAdjunto = $dts['id'];
                    $documento = $dts['url_adjunto'];
                    $fecha = $dts['fecha'];

                    if ($dts['subido_por'] != "") {
                        $subido = $dts['subido_por'];
                    } else {
                        $subido = 0;
                    }


                    $query = "SELECT * FROM t_users WHERE id = $subido";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                    $proyecto = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $nombre = "";
                            $apellido = "";
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }

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
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'JPG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'jpeg':
                                if ($pagina == 0) {
                                    $url = "planner/proyectoss/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'JPEG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'svg':
                                if ($pagina == 0) {
                                    $url = "planner/proyectoss/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'SVG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
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
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'PNG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
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
                            case 'doc':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'DOC':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'MOV':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mov':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'MP4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mp4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                        }

//                                $tarea->adjuntos .= $ext;

                        if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                            $proyecto->adjuntos .= "<div class=\"timeline-item is-danger\">"
                                    . "<div class=\"timeline-marker is-danger is-icon\">"
                                    . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                    . "</div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                    . "<a class=\"example-image-link\" href=\"planner/proyectos/$documento\" data-lightbox=\"adjuntos-proy-gallery\" data-title=\"\"><img width=\"50\" height=\"50\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                    . "<button class=\"button is-danger is-very-small is-rounded\" onclick=\"quitarAdjuntoProyecto($idAdjunto, 'adjunto');\">"
                                    . "<span class=\"icon is-small\">"
                                    . "<i class=\"fas fa-times\"></i>"
                                    . "</span>"
                                    . "</button>"
                                    . "</div>"
                                    . "</div>";
                        } else {
                            $proyecto->adjuntos .= "<div class=\"timeline-item is-danger\">"
                                    . "<div class=\"timeline-marker is-danger is-icon\">"
                                    . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                    . "</div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                    . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/proyectos/$documento\" target=\"_blank\"><img width=\"50\" height=\"50\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                    . "<button class=\"button is-danger is-very-small is-rounded\" onclick=\"quitarAdjuntoProyecto($idAdjunto, 'adjunto');\">"
                                    . "<span class=\"icon is-small\">"
                                    . "<i class=\"fas fa-times\"></i>"
                                    . "</span>"
                                    . "</button>"
                                    . "</div>"
                                    . "</div>";
                        }

//                        $proyecto->adjuntos .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
//                                . "<a href=\"planner/proyectos/$documento\" target=\"_blank\" class=\"justify-content-center\">"
//                                . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
//                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$documento\">$documento</p>"
//                                . "</a>"
//                                . "</div>";
                    }
                }
            }
        } catch (Exception $ex) {
            $proyecto = $ex;
            exit($ex);
        }

        $proyecto->justificaciones .= "<header class=\"timeline-header\">"
                . "<span class=\"tag is-small is-info\">Justificaciones</span>"
                . "</header>";
        //Obetner justificaciones del proyecto en su mayoria documentos
        $query = "SELECT * FROM t_proyectos_justificaciones WHERE id_proyecto = $idProyecto";
        try {

            $adjuntos = $conn->obtDatos($query);
            $pagina = 0;
            if ($conn->filasConsultadas > 0) {
                foreach ($adjuntos as $dts) {
                    $idAdjunto = $dts['id'];
                    $documento = $dts['url_adjunto'];
                    $fecha = $dts['fecha'];
                    if ($dts['subido_por'] != "") {
                        $subido = $dts['subido_por'];
                    } else {
                        $subido = 0;
                    }
                    $query = "SELECT * FROM t_users WHERE id = $subido";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idTrabajador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
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
                                    $proyecto = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $nombre = "";
                            $apellido = "";
                        }
                    } catch (Exception $ex) {
                        $proyecto = $ex;
                        exit($ex);
                    }

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
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'JPG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'jpeg':
                                if ($pagina == 0) {
                                    $url = "planner/proyectoss/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'JPEG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'svg':
                                if ($pagina == 0) {
                                    $url = "planner/proyectoss/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'SVG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
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
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
                                }
                                break;
                            case 'PNG':
                                if ($pagina == 0) {
                                    $url = "planner/proyectos/$documento";
                                } else {
                                    $url = "../planner/proyectos/$documento";
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
                            case 'doc':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'DOC':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/doc.svg";
                                } else {
                                    $url = "../svg/formatos/doc.svg";
                                }
                                break;
                            case 'MOV':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mov':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'MP4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                            case 'mp4':
                                if ($pagina == 0) {
                                    $url = "svg/formatos/mp4.svg";
                                } else {
                                    $url = "../svg/formatos/mp4.svg";
                                }
                                break;
                        }

                        if ($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "svg" || $ext == "SVG") {
                            $proyecto->justificaciones .= "<div class=\"timeline-item is-danger\">"
                                    . "<div class=\"timeline-marker is-danger is-icon\">"
                                    . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                    . "</div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                    . "<a class=\"example-image-link\" href=\"planner/proyectos/$documento\" data-lightbox=\"adjuntos-proy-gallery\" data-title=\"\"><img width=\"50\" height=\"50\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                    . "<button class=\"button is-danger is-very-small is-rounded\" onclick=\"quitarAdjuntoProyecto($idAdjunto, 'justificaciones');\">"
                                    . "<span class=\"icon is-small\">"
                                    . "<i class=\"fas fa-times\"></i>"
                                    . "</span>"
                                    . "</button>"
                                    . "</div>"
                                    . "</div>";
                        } else {
                            $proyecto->justificaciones .= "<div class=\"timeline-item is-danger\">"
                                    . "<div class=\"timeline-marker is-danger is-icon\">"
                                    . "<h4 class=\"title is-4\"><span><i class=\"fas fa-paperclip\"></i></span></h4>"
                                    . "</div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading\"><strong>$nombre $apellido <span class=\"has-text-danger\">Andjuntó</span></strong>  $fecha</p>"
                                    . "<a class=\"example-image-link\" target=\"_blank\" href=\"planner/proyectos/$documento\" target=\"_blank\"><img width=\"50\" height=\"50\" class=\"example-image img-fluid\" src=\"$url\" alt=\"\"/></a>"
                                    . "<button class=\"button is-danger is-very-small is-rounded\" onclick=\"quitarAdjuntoProyecto($idAdjunto, 'justificaciones');\">"
                                    . "<span class=\"icon is-small\">"
                                    . "<i class=\"fas fa-times\"></i>"
                                    . "</span>"
                                    . "</button>"
                                    . "</div>"
                                    . "</div>";
                        }

//                        $proyecto->justificaciones .= "<div class=\"col-12 col-md-12 col-lg-12 rounded\">"
//                                . "<a href=\"planner/proyectos/$documento\" target=\"_blank\" class=\"justify-content-center\">"
//                                . "<img src=\"$url\" width=\"40\" class=\"mt-2\" alt=\"Documento\">"
//                                . "<p style=\"font-size:10px; width:50px; text-overflow: ellipsis; white-space:nowrap; overflow:hidden;\" data-toggle=\"tooltip\" title=\"$documento\">$documento</p>"
//                                . "</a>"
//                                . "</div>";
                    }
                }
            }
        } catch (Exception $ex) {
            $proyecto = $ex;
            exit($ex);
        }

        //Obtener comentarios del proyecto
        $proyecto->comentarios .= "<header class=\"timeline-header\">"
                . "<span class=\"tag is-small is-info\">Inicio</span>"
                . "</header>";

        $query = "SELECT * FROM t_proyectos_comentarios WHERE id_proyecto = $idProyecto";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['usuario'];
                    $fecha = $dts['fecha'];
                    $comentario = $dts['comentario'];

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
                                            $idCargo = $dts['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $proyecto->comentarios = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $proyecto->comentarios = $ex;
                        exit($ex);
                    }

                    $proyecto->comentarios .= "<div class=\"timeline-item is-info\">"
                            . "<div class=\"timeline-marker is-info\"></div>"
                            . "<div class=\"timeline-content\">"
                            . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fecha</p>"
                            . "<p class=\"is-size-7\">$comentario</p>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $proyecto = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $proyecto;
    }

    public function agregarActividadProyecto($idProyecto, $actividad, $usuario) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");

        $query = "INSERT INTO t_proyectos_planaccion (id_proyecto, actividad, status, creado_por, fecha_creacion, activo) "
                . "VALUES($idProyecto, '$actividad', 'N', $usuario, '$fecha', 1)";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function agregarComentariosProy($idActividad, $idUsuario, $comentario) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Mexico_City');
        $fecha = date("Y-m-d H:i:s");
        $query = "INSERT INTO t_proyectos_planaccion_comentarios (id_actividad, comentario, usuario, fecha) "
                . "VALUES($idActividad, '$comentario', $idUsuario, '$fecha')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function cambiarTipoProyecto($idProyecto, $tipo) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_proyectos SET tipo = '$tipo' WHERE id = $idProyecto";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function actualizarDatosProyecto($idProyecto, $titulo, $justificacion, $año, $coste) {
        $conn = new Conexion();
        $conn->conectar();

        if ($coste == "") {
            $coste = 0;
        }
        $ppto = explode("$", $coste);
        if (count($ppto) > 1) {
            $ppto = str_replace(',', '', $ppto[1]);
        } else {
            $ppto = str_replace(',', '', $ppto[0]);
        }
        $coste = number_format($ppto, 2, '.', '');

        $query = "UPDATE t_proyectos SET titulo = '$titulo', justificacion = '$justificacion', coste = $coste, año = '$año' WHERE id = $idProyecto";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function agregarResponsableActividadProyecto($idUsuario, $idActividad) {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_proyectos_planaccion SET responsable = $idUsuario WHERE id = $idActividad";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function recargarPAProyecto($idProyecto, $status) {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');

        $currentWeek = date("W");

        //obtener mc
        //Obtener las tareas de correctivo del equipo
        $query = "SELECT * FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND status = '$status' AND activo = 1";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idAccion = $dts['id'];
                    $actividad = $dts['actividad'];
                    $statusAccion = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $fechaRealizacion = $dts['fecha_realizado'];
                    $realizo = $dts['realizado_por'];
                    $creadoPor = $dts['creado_por'];

                    $query = "SELECT * FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idAccion";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $tieneAdjuntos = "SI";
                        } else {
                            $tieneAdjuntos = "NO";
                        }
                    } catch (Exception $ex) {
                        $equipo->planMC = $ex;
                        exit($ex);
                    }

                    //Datos de el usuario responsable
                    $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoR = $t['foto'];
                                            $nombreR = $t['nombre'];
                                            $apellidoR = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoR = "advertencia2.svg";
                            $nombreR = "";
                            $apellidoR = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que realizo
                    $query = "SELECT * FROM t_users WHERE id = $realizo";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajador = $u['id_colaborador'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoRE = $t['foto'];
                                            $nombreRE = $t['nombre'];
                                            $apellidoRE = $t['apellido'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $foto = "advertencia2.svg";
                            $nombreRE = "";
                            $apellidoRE = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    //Datos del usuario que creo la tarea
                    $query = "SELECT * FROM t_users WHERE id = $creadoPor";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                $idTrabajadorC = $u['id_colaborador'];
                                $destinoCreador = $u['id_destino'];
                                $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajadorC";
                                try {
                                    $trabajador = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($trabajador as $t) {
                                            $fotoC = $t['foto'];
                                            $nombreC = $t['nombre'];
                                            $apellidoC = $t['apellido'];
                                            $cargoCreador = $t['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        } else {
                            $fotoC = "advertencia2.svg";
                            $nombreC = "";
                            $apellidoC = "";
                            $cargoCreador = 0;
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $pagina = 0;


                    $salida .= "<div class=\"columns hvr-float\">"
                            . "<div class=\"column is-7\">"
                            . "<div class=\"field\">";
                    if ($statusAccion == "F") {

                        $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTareaProyecto($idAccion, this, " . $_SESSION["usuario"] . ")\" checked>";
                    } else {

                        $salida .= "<input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" id=\"chkb_$idAccion\" onchange=\"completarTareaProyecto($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                    }
                    $salida .= "<label for=\"chkb_$idAccion\"></label>";
                    if ($destinoCreador == 10) {
                        $salida .= "<span class=\"manita is-size-7\" onclick=\"\"><span><i class=\"fas fa-bookmark has-text-danger\"></i> </span> $actividad</span>";
                    } else {
                        $salida .= "<span class=\"manita is-size-7\" onclick=\"\">$actividad</span>";
                    }


                    $salida .= "</div>"
                            . "</div>"
                            . "<div class=\"column is-5\">"
                            . "<div class=\"control\">"
                            . "<div class=\"tags has-addons\">";
                    if ($fotoR == "advertencia2.svg") {
                        $salida .= "<span class=\"tag is-danger modal-button manita\" onclick=\"showModal('modalAgregarResponsableProyecto'); setIdActividad($idAccion);\">Sin responsable</span>";
                    } else {
                        $salida .= "<span class=\"tag is-info modal-button manita\" onclick=\"showModal('modalAgregarResponsableProyecto'); setIdActividad($idAccion);\">$nombreR $apellidoR</span>";
                    }

                    $salida .= "<span class=\"tag is-danger\" onclick=\"quitarTareaProyecto($idAccion);\">Eliminar</span>";
//                    if ($tieneAdjuntos == "SI") {
//                        $salida .= "<span class=\"tag is-dark\"><i class=\"fas fa-paperclip\"></i></span>";
//                    }
                    //Seccion de planeacion de MC
//                    if ($fechaInicio != null && $fechaFin != null) {
//                        $salida .= "<span class=\"tag is-info\"><i class=\"fas fa-calendar-check\"></i></span>";
//                    } else {
//                        $salida .= "<span class=\"tag is-danger\"><i class=\"fas fa-calendar-times\"></i></span>";
//                    }
                    $salida .= "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $salida;
    }

    public function completarTareaProyecto($idActividad, $status, $idUsuario) {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Mexico_City');
        $fecF = date("Y-m-d H:i:s");

        $query = "UPDATE t_proyectos_planaccion SET status = '$status', realizado_por = $idUsuario, fecha_realizado = '$fecF' WHERE id = $idActividad";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $resp;
    }

    public function completarProyecto($idProyecto, $status) {
        $conn = new Conexion();
        $conn->conectar();

        $idUsuario = $_SESSION['usuario'];
        date_default_timezone_set('America/Mexico_City');
        $fecF = date("Y-m-d H:i:s");

        $query = "UPDATE t_proyectos SET status = '$status', finalizado_por = $idUsuario, fecha_finalizado = '$fecF' WHERE id = $idProyecto";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarActividadProyecto($idActividad) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "DELETE FROM t_proyectos_planaccion WHERE id = $idActividad";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarAdjuntoProyecto($idAdjunto, $tipo) {
        $conn = new Conexion();
        $conn->conectar();

        if ($tipo == "adjunto") {
            $query = "SELECT * FROM t_proyectos_adjuntos WHERE id = $idAdjunto";
        } else {
            $query = "SELECT * FROM t_proyectos_justificaciones WHERE id = $idAdjunto";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $urlAdjunto = $dts['url_adjunto'];
                }
                if ($tipo == "adjunto") {
                    $query = "DELETE FROM t_proyectos_adjuntos WHERE id = $idAdjunto";
                } else {
                    $query = "DELETE FROM t_proyectos_justificaciones WHERE id = $idAdjunto";
                }

                try {
                    $resp = $conn->consulta($query);
                    unlink("../planner/proyectos/$urlAdjunto");
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($ex);
                }
            } else {
                $resp = "No existe el archivo";
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerComentariosActividad($idActividad) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        //Obtener comentarios del proyecto
        $salida .= "<header class=\"timeline-header\">"
                . "<span class=\"tag is-small is-info\">Inicio</span>"
                . "</header>";

        $query = "SELECT * FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idActividad";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['usuario'];
                    $fecha = $dts['fecha'];
                    $comentario = $dts['comentario'];

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
                                            $idCargo = $dts['id_cargo'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $salida .= "<div class=\"timeline-item is-info\">"
                            . "<div class=\"timeline-marker is-info\"></div>"
                            . "<div class=\"timeline-content\">"
                            . "<p class=\"heading\"><strong>$nombre $apellido</strong> $fecha</p>"
                            . "<p class=\"is-size-7\">$comentario</p>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function buscarMC($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        date_default_timezone_set('America/Mexico_City');
        $fecI = date("Y-m-d H:i:s", strtotime($fechaI));
        $fecF = date("Y-m-d H:i:s", strtotime($fechaF . "23:59:59"));

        $idDestino = $_SESSION['idDestino'];

        if ($idDestino == 10) {
            if ($idSeccion == 0) {
                if ($idSubseccion == 0) {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                } else {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                }
            } else {
                if ($idSubseccion == 0) {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                } else {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                }
            }
        } else {
            if ($idSeccion == 0) {
                if ($idSubseccion == 0) {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                } else {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                }
            } else {
                if ($idSubseccion == 0) {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                } else {
                    if ($idEquipo == 0) {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    } else {
                        switch ($estado) {
                            case 'todos':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "ORDER BY id_destino";
                                break;
                            case 'pendientes':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'N' "
                                        . "ORDER BY id_destino";
                                break;
                            case 'solucionados':
                                $query = "SELECT * FROM t_mc "
                                        . "WHERE fecha_creacion >= '$fecI' "
                                        . "AND fecha_creacion <= '$fecF' "
                                        . "AND id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccion "
                                        . "AND id_subseccion = $idSubseccion "
                                        . "AND id_equipo = $idEquipo "
                                        . "AND activo = 1 "
                                        . "AND status = 'F' "
                                        . "ORDER BY id_destino";
                                break;
                        }
                    }
                }
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['id'];
                    $idEquipoMC = $dts['id_equipo'];
                    $actividad = $dts['actividad'];
                    $status = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $idSeccionMC = $dts['id_seccion'];
                    $idSubseccionMC = $dts['id_subseccion'];
                    $idDestinoMC = $dts['id_destino'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $semanaI = $dts['semana_inicio'];

                    if ($semanaI == "") {
                        $semanaI = date("W", strtotime($fechaCreacion));
                    }

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreDestino = $dts['destino'];
                            }
                        } else {
                            $nombreDestino = "NA";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSeccion = $dts['seccion'];
                            }
                        } else {
                            $nombreSeccion = "Todas las secciones";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSubseccion = $dts['grupo'];
                            }
                        } else {
                            $nombreSubseccion = "Todas las subsecciones";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

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
                                    exit($ex);
                                    exit($ex);
                                }
                            }
                        } else {
                            $nombre = "";
                            $apellido = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_equipos WHERE id = $idEquipoMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idEquipo = $dts['id'];
                                $equipo = $dts['equipo'];
                            }
                        } else {
                            $equipo = "GENERALES";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    if ($status == "N") {
                        $status = "PENDIENTE";
                        $bg = "bg-rojoc";
                    } else if ($status == "F") {
                        $status = "SOLUCIONADO";
                        $bg = "bg-verdec";
                    }

                    $query = "SELECT * FROM t_mc_planeacion WHERE id_mc = $idMC";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $r) {
                                $semanaP = $r['semana'];
                            }
                        } else {
                            $semanaP = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $salida .= "<tr class=\"$bg\">"
                            . "<td style=\"display:none;\">$idMC</td>"
                            . "<td>$nombreDestino</td>"
                            . "<td>$nombreSeccion</td>"
                            . "<td>$nombreSubseccion</td>"
                            . "<td>$equipo</td>"
                            . "<td>$nombre $apellido</td>"
                            . "<td>$actividad</td>"
                            . "<td>$fechaCreacion</td>"
                            . "<td>$semanaI</td>"
                            . "<td>$semanaP</td>"
                            . "<td>$status</td>"
                            . "</tr>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function buscarEquipos($idSeccion, $idSubseccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<option value=\"0\">-Todos los equipos-</option>";
        $idDestino = $_SESSION['idDestino'];

        if ($idDestino == 10) {
            if ($idSeccion == 0) {
                if ($idSubseccion == 0) {
                    $query = "SELECT * FROM t_equipos WHERE status = 'A' ORDER BY id_destino";
                } else {
                    $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idSubseccion AND status = 'A' ORDER BY id_destino";
                }
            } else {
                if ($idSubseccion == 0) {
                    $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND status = 'A' ORDER BY id_destino";
                } else {
                    $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND status = 'A' ORDER BY id_destino";
                }
            }
        } else {
            if ($idSeccion == 0) {
                if ($idSubseccion == 0) {
                    $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND status = 'A' ORDER BY id_destino";
                } else {
                    $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND status = 'A' ORDER BY id_destino";
                }
            } else {
                if ($idSubseccion == 0) {
                    $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND status = 'A' ORDER BY id_destino";
                } else {
                    $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND status = 'A' ORDER BY id_destino";
                }
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];
                    $nombreEquipo = $dts['equipo'];
                    $salida .= "<option value=\"$idEquipo\">$nombreEquipo</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

    public function buscarOTS($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $status) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "";

        date_default_timezone_set('America/Mexico_City');
        $fecI = date("Y-m-d H:i:s", strtotime($fechaI));
        $fecF = date("Y-m-d H:i:s", strtotime($fechaF . "23:59:59"));

        $idDestino = $_SESSION['idDestino'];

        if ($idDestino == 10) {
            if ($idEquipo == 0) {
                if ($idSeccion == 0) {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idSubseccion AND status = 'A'";
                    }
                } else {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND status = 'A'";
                    }
                }
            } else {
                if ($idSeccion == 0) {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND id_subseccion = $idSubseccion AND status = 'A'";
                    }
                } else {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND id_seccion = $idSeccion AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND status = 'A'";
                    }
                }
            }
        } else {
            if ($idEquipo == 0) {
                if ($idSeccion == 0) {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idSubseccion AND id_destino = $idDestino AND status = 'A'";
                    }
                } else {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND id_destino = $idDestino AND status = 'A'";
                    }
                }
            } else {
                if ($idSeccion == 0) {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id = $idEquipo AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino AND id = $idEquipo id_subseccion = $idSubseccion AND status = 'A'";
                    }
                } else {
                    if ($idSubseccion == 0) {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND id_destino = $idDestino AND id_seccion = $idSeccion AND status = 'A'";
                    } else {
                        $query = "SELECT * FROM t_equipos WHERE id = $idEquipo AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND id_destino = $idDestino AND status = 'A'";
                    }
                }
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];
                    $equipo = $dts['equipo'];
                    $idSubseccionEq = $dts['id_subseccion'];
                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionEq";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $d) {
                                $nombreSubseccion = $d['grupo'];
                            }
                        } else {
                            $nombreSubseccion = "Todas las subsecciones";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    switch ($status) {
                        case 'todos':
                            $query = "SELECT * FROM t_ordenes_trabajo "
                                    . "WHERE id_equipo = $idEquipo "
                                    . "AND (fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF')";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_ordenes_trabajo "
                                    . "WHERE id_equipo = $idEquipo "
                                    . "AND (fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF') "
                                    . "AND status = 'N'";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_ordenes_trabajo "
                                    . "WHERE id_equipo = $idEquipo "
                                    . "AND (fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF') "
                                    . "AND status = 'F'";
                            break;
                    }
                    try {
                        $ordenes = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {

                            foreach ($ordenes as $orden) {
                                $idOT = $orden['id'];
                                $folio = $orden['folio'];
                                $idPlaneacion = $orden['id_planeacion_mp'];
                                $fechaCreacion = $orden['fecha_creacion'];
                                $listaActividades = $orden['lista_actividades'];


                                $query = "SELECT * FROM t_mp_planeacion WHERE id = $idPlaneacion";


                                try {
                                    $result = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $d) {
                                            $idPlan = $d['id_plan'];
                                            $stat = $d['status'];

                                            $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlan";
                                            try {
                                                $r = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($r as $f) {
                                                        $nombrePlan = $f['nombre'];
                                                    }
                                                } else {
                                                    $nombrePlan = "";
                                                }
                                            } catch (Exception $ex) {
                                                $salida = $ex;
                                                exit($ex);
                                            }
                                        }
                                    } else {
                                        $array = explode(",", $listaActividades);
                                        for ($i = 0; $i < count($array); $i++) {
                                            if ($array[$i] != "") {
                                                $idActividad = $array[$i];
                                            }
                                        }

                                        $query = "SELECT * FROM t_planes_actividades WHERE id = $idActividad";

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $d) {
                                                    $idPlan = $d['id_mantto'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ordenes = $ex;
                                            exit($ex);
                                            exit($ex);
                                        }

                                        $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlan";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $d) {
                                                    $nombrePlan = $d['nombre'];
                                                }
                                            } else {
                                                $nombrePlan = "";
                                            }
                                        } catch (Exception $ex) {
                                            $ordenes = $ex;
                                            exit($ex);
                                            exit($ex);
                                        }
                                    }

                                    if ($stat == "F") {
                                        $stat = "FINALIZADO";
                                        $query = "SELECT * FROM t_mp_realizado WHERE id_ot = $idOT";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $d) {
                                                    $fechaRealizado = $d['fecha_realizado'];
                                                    $realizadoPor = $d['realizado_por'];

                                                    $query = "SELECT * FROM t_colaboradores WHERE id = $realizadoPor";
                                                    try {
                                                        $result = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($result as $d) {
                                                                $nombre = $d['nombre'];
                                                                $apellido = $d['apellido'];
                                                            }
                                                        } else {
                                                            $nombre = "";
                                                            $apellido = "";
                                                        }
                                                    } catch (Exception $ex) {
                                                        $salida = $ex;
                                                        exit($ex);
                                                    }
                                                }
                                            } else {
                                                $fechaRealizado = "";
                                                $nombre = "";
                                                $apellido = "";
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                            exit($ex);
                                        }
                                    } else {
                                        $stat = "PENDIENTE";
                                        $fechaRealizado = "";
                                        $nombre = "";
                                        $apellido = "";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                    exit($ex);
                                }

                                $salida .= "<tr>"
                                        . "<td>$nombreSubseccion</td>"
                                        . "<td>$nombrePlan</td>"
                                        . "<td>$equipo</td>"
                                        . "<td>$folio</td>"
                                        . "<td>$stat</td>"
                                        . "<td>$nombre $apellido</td>"
                                        . "<td>$fechaRealizado</td>"
                                        . "<td><a href=\"planner/ver-orden-trabajo.php?idEquipo=$idEquipo&idOT=$idOT\" target=\"_blank\">Ver OT</a></td>"
                                        . "</tr>";
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $conn->cerrar();
        return $salida;
    }

    public function buscarMisPendientes($idUsuario, $idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        date_default_timezone_set('America/Mexico_City');
        $fecI = date("Y-m-d H:i:s", strtotime($fechaI));
        $fecF = date("Y-m-d H:i:s", strtotime($fechaF . "23:59:59"));

        if ($idSeccion == 0) {
            if ($idSubseccion == 0) {
                if ($idEquipo == 0) {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                } else {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                }
            } else {
                if ($idEquipo == 0) {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                } else {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                }
            }
        } else {
            if ($idSubseccion == 0) {
                if ($idEquipo == 0) {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                } else {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                }
            } else {
                if ($idEquipo == 0) {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                } else {
                    switch ($estado) {
                        case 'todos':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "ORDER BY id_destino";
                            break;
                        case 'pendientes':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'N' "
                                    . "ORDER BY id_destino";
                            break;
                        case 'solucionados':
                            $query = "SELECT * FROM t_mc "
                                    . "WHERE fecha_creacion >= '$fecI' "
                                    . "AND fecha_creacion <= '$fecF' "
                                    . "AND id_seccion = $idSeccion "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND id_equipo = $idEquipo "
                                    . "AND responsable = $idUsuario "
                                    . "AND activo = 1 "
                                    . "AND status = 'F' "
                                    . "ORDER BY id_destino";
                            break;
                    }
                }
            }
        }


        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['id'];
                    $idEquipoMC = $dts['id_equipo'];
                    $actividad = $dts['actividad'];
                    $status = $dts['status'];
                    $idResponsable = $dts['responsable'];
                    $idSeccionMC = $dts['id_seccion'];
                    $idSubseccionMC = $dts['id_subseccion'];
                    $idDestinoMC = $dts['id_destino'];
                    $fechaCreacion = $dts['fecha_creacion'];
                    $semanaI = $dts['semana_inicio'];

                    if ($semanaI == "") {
                        $semanaI = date("W", strtotime($fechaCreacion));
                    }

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreDestino = $dts['destino'];
                            }
                        } else {
                            $nombreDestino = "NA";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSeccion = $dts['seccion'];
                            }
                        } else {
                            $nombreSeccion = "Todas las secciones";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSubseccion = $dts['grupo'];
                            }
                        } else {
                            $nombreSubseccion = "Todas las subsecciones";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

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
                                    exit($ex);
                                }
                            }
                        } else {
                            $nombre = "";
                            $apellido = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $query = "SELECT * FROM t_equipos WHERE id = $idEquipoMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idEquipo = $dts['id'];
                                $equipo = $dts['equipo'];
                            }
                        } else {
                            $equipo = "GENERALES";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    if ($status == "N") {
                        $status = "PENDIENTE";
                        $bg = "bg-rojoc";
                    } else if ($status == "F") {
                        $status = "SOLUCIONADO";
                        $bg = "bg-verdec";
                    }

                    $query = "SELECT * FROM t_mc_planeacion WHERE id_mc = $idMC";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $r) {
                                $semanaP = $r['semana'];
                            }
                        } else {
                            $semanaP = "";
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $salida .= "<tr class=\"$bg\">"
                            . "<td style=\"display:none;\">$idMC</td>"
                            . "<td>$nombreDestino</td>"
                            . "<td>$nombreSeccion</td>"
                            . "<td>$nombreSubseccion</td>"
                            . "<td>$equipo</td>"
                            . "<td>$nombre $apellido</td>"
                            . "<td>$actividad</td>"
                            . "<td>$fechaCreacion</td>"
                            . "<td>$semanaI</td>"
                            . "<td>$semanaP</td>"
                            . "<td>$status</td>"
                            . "</tr>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $salida;
    }

}
?>

