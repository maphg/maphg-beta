<?php
// Se elimino la clase tg, donde crea desborde de fila de titulos
setlocale(LC_MONETARY, 'en_US');
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "actualizarTarea") {
        $idTarea = $_POST['idTarea'];
        $titulo = $_POST['titulo'];
        $obj = new Planner();
        $resp = $obj->actualizarTarea($idTarea, $titulo);
        echo $resp;
    }

    if ($action == "eliminarTarea") {
        $idTarea = $_POST['idTarea'];
        $obj = new Planner();
        $resp = $obj->eliminarTarea($idTarea);
        echo $resp;
    }

    if ($action == "buscarPorPalabra") {
        $idGrupo = $_POST['idGrupo'];
        $idDestino = $_POST['idDestino'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $idRelCatSubcat = $_POST['idRelCatSubcat'];
        $pagina = $_POST['pagina'];
        $palabra = $_POST['palabra'];
        $obj = new Planner();
        $resp = $obj->obtenerEquiposxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $pagina, $palabra);
        echo json_encode($resp);
    }

    if ($action == "obtenerComentarios") {
        $idDestino = $_SESSION['idDestino'];
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtenerComentarios($idEquipo, $idDestino);
        echo json_encode($resp);
    }

    if ($action == "insertarComentarioEquipo") {
        $idEquipo = $_POST['idEquipo'];
        $comentario = $_POST['comentario'];
        $obj = new Planner();
        $resp = $obj->insertarComentarioEquipo($idEquipo, $comentario);
        echo $resp;
    }

    if ($action == "obtenerFotos") {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtenerFotos($idEquipo);
        echo json_encode($resp);
    }

    if ($action == "obtenerCotizaciones") {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtenerCotizacionesEquipo($idEquipo);
        echo json_encode($resp);
    }

    if ($action == "obtenerInfo") {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtenerInformacionEquipo($idEquipo);
        echo json_encode($resp);
    }

    if ($action == "actualizarInfoEq") {
        $idEquipo = $_POST['idEquipo'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $estatus = $_POST['estado'];
        $obj = new Planner();
        $resp = $obj->actualizarInfoEquipo($idEquipo, $marca, $modelo, $serie, $estatus);
        echo $resp;
    }

    if ($action == "obtMC") {
        $idEquipo = $_POST['idEquipo'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->obtCorrectivos($idEquipo, $status);
        echo json_encode($resp);
    }

    if ($action == "obtenerComentariosMC") {
        $idMC = $_POST['idMC'];
        $obj = new Planner();
        $resp = $obj->obtenerComentariosMC($idMC);
        echo json_encode($resp);
    }

    if ($action == "insertarComentarioMC") {
        $idMC = $_POST['idMC'];
        $comentario = $_POST['comentario'];
        $obj = new Planner();
        $resp = $obj->insertarComentarioMC($idMC, $comentario);
        echo $resp;
    }

    if ($action == 'borrarComentario') {
        $idComentario = $_POST['idComentario'];
        $obj = new Planner();
        $resp = $obj->borrarComentario($idComentario);
        echo $resp;
    }

    if ($action == "obtenerFotosMC") {
        $idMC = $_POST['idMC'];
        $obj = new Planner();
        $resp = $obj->obtenerFotosMC($idMC);
        echo json_encode($resp);
    }

    if ($action == "borrarFotoMC") {
        $idAdjunto = $_POST['idAdjunto'];
        $obj = new Planner();
        $resp = $obj->borrarFotoMC($idAdjunto);
        echo $resp;
    }

    if ($action == "obtFechasMC") {
        $idMC = $_POST['idMC'];
        $obj = new Planner();
        $resp = $obj->obtenerFechaMC($idMC);
        echo json_encode($resp);
    }

    if ($action == "obtMCG") {
        $idSubseccion = $_POST['idSubseccion'];
        $idDestino = $_POST['idDestino'];
        $idCategoria = $_POST['idCategoria'];
        $idSubcategoria = $_POST['idSubcategoria'];
        $idRelSubcategoria = $_POST['idRelSubcategoria'];
        $status = $_POST['status'];
        $obj = new Planner();
        $resp = $obj->obtCorrectivosG($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria, $status);
        echo json_encode($resp);
    }

    if ($action == "obtMP") {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtPreventivos($idEquipo);
        echo json_encode($resp);
    }

    if ($action == "obtTEST") {
        $idEquipo = $_POST['idEquipo'];
        $obj = new Planner();
        $resp = $obj->obtTest($idEquipo);
        echo json_encode($resp);
    }

    //***************************************************************

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
        $pagina = $_POST['pagina'];
        $obj = new Planner();
        $resp = $obj->obtenerEquipos($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $pagina);
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

class Equipo
{

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

class Proyecto
{

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

class DetalleEquipo
{

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

class TareaMC
{

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

class OrdenTrabajo
{

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

class DetalleMPRealizado
{

    public $listActividades;
    public $comentarios;
    public $adjuntos;
}

class ListaEquipo
{

    public $idSeccion;
    public $nombreSeccion;
    public $idSubseccion;
    public $nombreSubseccion;
    public $listaEquipos;
}

class ComentariosEquipo
{

    public $header;
    public $comentariosGenerales;
    public $comentariosMCMPM;
}

class FotosEquipo
{

    public $header;
    public $fotosGenerales;
    public $fotosMCMPM;
}

class CotizacionesEquipo
{

    public $header;
    public $cotizaciones;
}

class InfoEquipo
{

    public $header;
    public $informacion;
    public $editarInfo;
}

class MCMPEquipo
{

    public $correctivos;
    public $preventivos;
    public $historicoMP;
}

class FechasMC
{

    public $header;
    public $fechaInicio;
    public $fechaFin;
}

class Planner
{

    public function crearTableros($idDestino)
    {
        $_SESSION['idDestino'] = $idDestino;
        $salida = 1;
        return $salida;
    }

    public function setTipoProyecto($tipoProyecto)
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $_SESSION['tipoProyecto'] = $tipoProyecto;

        $conn->cerrar();
        return $salida;
    }

    public function setSeccion($idSeccion)
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $_SESSION['idSeccion'] = $idSeccion;

        $conn->cerrar();
        return $salida;
    }

    public function showHideCols($idSecciones, $idUsuario)
    {
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

    public function recargarCols($idPermiso, $idUsuario, $tipo)
    {
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

    public function mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion)
    {
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
            $totalRegistros = $conn->filasConsultadas;
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

        if ($totalRegistros > 0) {
            $porcAvance = ($numeroTotalSolucionadas * 100) / $totalRegistros;
        } else {
            $porcAvance = 100;
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

        $salida .= "<div class=\"column is-3 is-mobile\">
                    <div class=\"columns is-gapless my-1\">
                        <div class=\"column is-2 has-text-centered\"><p class=\"seccion-logo " . strtolower($nombreSeccion) . "-background\">$nombreSeccion</p></div>
                        <div class=\"column is-1\"></div>
                        <div class=\"column is-6 has-text-centered t-grafica\"><progress class=\"progress is-chico " . strtolower($nombreSeccion) . "-barra\" value=\"" . round($porcAvance) . "\" max=\"100\"></progress></div>
                        <div class=\"column is-1\"></div>
                        <div class=\"column is-2 has-text-centered \"><p class=\"t-normal2\">" . round($porcAvance) . "%</p></div>
                    </div>";

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

                            //obtener total de tareas pendientes por subseccion
                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                            } else {
                                $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                            }

                            try {
                                $resp = $conn->obtDatos($query);
                                $penSubseccion = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                echo $ex;
                            }

                            //obtener total de tareas solucionadas por subseccion
                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 AND status = 'F'";
                            } else {
                                $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                            }

                            try {
                                $resp = $conn->obtDatos($query);
                                $solSubseccion = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                echo $ex;
                            }

                            //********SECCION PROYECTOS************
                            if ($nombreSubseccion == "PROYECTOS") { //Si la subseccion son los proyectos
                                if ($idDestino == 10) {
                                    $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                                } else {
                                    $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                                }
                                try {
                                    $proyectos = $conn->obtDatos($query);
                                    $totalProys = $conn->filasConsultadas;
                                    //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                if ($idDestino == 10) {
                                    $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                                } else {
                                    $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                                }
                                try {
                                    $proyectos = $conn->obtDatos($query);
                                    $totalProysF = $conn->filasConsultadas;
                                    //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }

                                $salida .= "<a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">$nombreSubseccion</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>";
                                //                                $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                //                                        //Titulo de la subseccion
                                //                                        . "<div class=\"column has-text-left is-8 pad-03 manita\">"
                                //                                        . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                //                                        . "</div>"
                                //                                        //Contador de tareas
                                //                                        . "<div class=\"column is-1 pad-03\">"
                                //                                        . "<div class=\"tags has-addons\">";
                                //                                if ($totalProysF > 0) {
                                //                                    $salida .= "<span class=\"tag is-success fs-10\">";
                                //                                    $numeroDigitos = strlen($totalProysF);
                                //                                    if ($numeroDigitos > 1) {
                                //                                        $salida .= $totalProysF;
                                //                                    } else {
                                //                                        $salida .= "0$totalProysF";
                                //                                    }
                                //                                    $salida .= "</span>";
                                //                                }
                                //
                                //                                $salida .= "</div>"
                                //                                        . "</div>"
                                //                                        . "<div class=\"column is-1 pad-03\">"
                                //                                        . "<div class=\"tags has-addons\">";
                                //                                if ($totalProys > 0) {
                                //                                    $salida .= "<span class=\"tag is-danger fs-10\">";
                                //                                    $numeroDigitos = strlen($totalProys);
                                //                                    if ($numeroDigitos > 1) {
                                //                                        $salida .= $totalProys;
                                //                                    } else {
                                //                                        $salida .= "0$totalProys";
                                //                                    }
                                //                                    $salida .= "</span>";
                                //                                }
                                //
                                //                                $salida .= "</div>"
                                //                                        . "</div>"//Fin del contador de tareas
                                //                                        . "</div>";
                                //                                //Seccion del collapse
                                //                                //*******LISTADO DE LOS PROYECTOS*********
                                //                                $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                //                                        . "<div class=\"columns is-mobile mb-2\">"
                                //                                        . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                //                                        . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
                                //                                        . "</div>"
                                //                                        . "</div>";
                                //                                if ($idDestino == 10) {
                                //                                    $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
                                //                                } else {
                                //                                    $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
                                //                                }
                                //
                                //                                try {
                                //                                    $proyectos = $conn->obtDatos($query);
                                //                                    if ($conn->filasConsultadas > 0) {
                                //                                        foreach ($proyectos as $pr) {
                                //                                            $idProyecto = $pr['id'];
                                //                                            $tituloProyecto = $pr['titulo'];
                                //                                            $tipoProyecto = $pr['tipo'];
                                //                                            $idDestinoProyecto = $pr['id_destino'];
                                //
                                //                                            $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
                                //                                            try {
                                //                                                $out = $conn->obtDatos($query);
                                //                                                if ($conn->filasConsultadas > 0) {
                                //                                                    foreach ($out as $s) {
                                //                                                        $destinoProy = $s['destino'];
                                //                                                    }
                                //                                                }
                                //                                            } catch (Exception $ex) {
                                //                                                $salida = $ex;
                                //                                            }
                                //                                            if ($tipoProyecto == "CAPEX") {
                                //                                                $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
                                //                                            } else if ($tipoProyecto == "CAPIN") {
                                //                                                $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
                                //                                            } else {
                                //                                                $imgTipo = "";
                                //                                            }
                                //
                                //                                            $query = "SELECT id FROM t_proyectos_planaccion "
                                //                                                    . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
                                //                                            try {
                                //                                                $resp = $conn->obtDatos($query);
                                //                                                $totalPA = $conn->filasConsultadas;
                                //                                            } catch (Exception $ex) {
                                //                                                $salida = $ex;
                                //                                            }
                                //                                            $query = "SELECT id FROM t_proyectos_planaccion "
                                //                                                    . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'F'";
                                //                                            try {
                                //                                                $resp = $conn->obtDatos($query);
                                //                                                $totalPAF = $conn->filasConsultadas;
                                //                                            } catch (Exception $ex) {
                                //                                                $salida = $ex;
                                //                                            }
                                //
                                //                                            $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
                                //                                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                //                                                    . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
                                //                                                    . "</div>"
                                //                                                    . "<div class=\"column is-1 pad-03\">"
                                //                                                    . "<div class=\"tags has-addons\">";
                                //                                            if ($totalPAF > 0) {
                                //                                                $salida .= "<span class=\"tag is-success fs-10\">";
                                //                                                $numeroDigitos = strlen($totalPAF);
                                //                                                if ($numeroDigitos > 1) {
                                //                                                    $salida .= $totalPAF;
                                //                                                } else {
                                //                                                    $salida .= "0$totalPAF";
                                //                                                }
                                //                                                $salida .= "</span>";
                                //                                            }
                                //                                            $salida .= "</div>"
                                //                                                    . "</div>"
                                //                                                    . "<div class=\"column is-1 pad-03\">"
                                //                                                    . "<div class=\"tags has-addons\">";
                                //                                            if ($totalPA > 0) {
                                //                                                $salida .= "<span class=\"tag is-danger fs-10\">";
                                //                                                $numeroDigitos = strlen($totalPA);
                                //                                                if ($numeroDigitos > 1) {
                                //                                                    $salida .= $totalPA;
                                //                                                } else {
                                //                                                    $salida .= "0$totalPA";
                                //                                                }
                                //                                                $salida .= "</span>";
                                //                                            }
                                //                                            $salida .= "</div>"
                                //                                                    . "</div>"
                                //                                                    . "</div>";
                                //                                        }
                                //                                    }
                                //                                } catch (Exception $ex) {
                                //                                    $salida = $ex;
                                //                                }
                                //                                $salida .= "</div>";
                            }
                            //******** RESTO DE LAS SECCIONES **********
                            else { //Las demas subsecciones
                                if ($idSubseccion == 12 || $idSubseccion == 342 || $idSubseccion == 343 || $idSubseccion == 344) {
                                    $salida .= "<a href=\"#\" onclick=\"showHide('hoteles', $idDestino, $idSubseccion, 1);\">"
                                        . "<div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\">"
                                        . "<p class=\"t-normal has-text-left px-4\">$nombreSubseccion</p>"
                                        . "</div>"
                                        . "<div class=\"column\">"
                                        . "<p class=\"t-pendiente\">$penSubseccion</p>"
                                        . "</div>"
                                        . "</div>"
                                        . "</a>";
                                } else {
                                    $salida .= "<a href=\"#\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, 1, 0, 0, 1, '$destino', '$nombreSeccion', '$nombreSubseccion');\">"
                                        . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                        . "<div class=\"column is-10\">"
                                        . "<p class=\"t-normal has-text-left px-4\">$nombreSubseccion</p>"
                                        . "</div>"
                                        . "<div class=\"column\">"
                                        . "<p class=\"t-pendiente\">$penSubseccion</p>"
                                        . "</div>"
                                        . "</div>"
                                        . "</a>";
                                }

                                //                                $salida .= "<div class=\"columns is-mobile mb-2 \">";
                                //                                if ($idSubseccion == 12 || $idSubseccion == 342 || $idSubseccion == 343 || $idSubseccion == 344) {
                                //                                    $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('hoteles', $idDestino, $idSubseccion, 1);\">";
                                //                                } else {
                                //                                    $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, 1, 0, 0, 1, '$destino', '$nombreSeccion', '$nombreSubseccion');\">";
                                //                                }
                                //
                                //                                $salida .= "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                //                                        . "</div>"
                                //                                        . "<div class=\"column is-1 pad-03\">"
                                //                                        . "<div class=\"tags has-addons\">";
                                //                                if ($solSubseccion > 0) {
                                //                                    $salida .= "<span class=\"tag is-success fs-10\">";
                                //                                    $numeroDigitos = strlen($solSubseccion);
                                //                                    if ($numeroDigitos > 1) {
                                //                                        $salida .= $solSubseccion;
                                //                                    } else {
                                //                                        $salida .= "0$solSubseccion";
                                //                                    }
                                //                                    $salida .= "</span>";
                                //                                }
                                //                                $salida .= "</div>"
                                //                                        . "</div>"
                                //                                        . "<div class=\"column is-1 pad-03\">"
                                //                                        . "<div class=\"tags has-addons\">";
                                //                                if ($penSubseccion > 0) {
                                //                                    $salida .= "<span class=\"tag is-danger fs-10\">";
                                //                                    $numeroDigitos = strlen($penSubseccion);
                                //                                    if ($numeroDigitos > 1) {
                                //                                        $salida .= $penSubseccion;
                                //                                    } else {
                                //                                        $salida .= "0$penSubseccion";
                                //                                    }
                                //                                    $salida .= "</span>";
                                //                                }
                                //                                $salida .= "</div>"
                                //                                        . "</div>"
                                //                                        . "</div>";
                            }
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        //        $salida .= "<a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                    <a href=\"#\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">Zona Lorem ipsum dolor sit amet, consectetd</p></div><div class=\"column\"><p class=\"t-pendiente\">34</p></div></div></a>
        //                </div>";

        $salida .= "</div>";

        $conn->cerrar();
        return $salida;
    }

    //Obtener la lista de los equipos - Carga Principal
    public function obtenerEquipos($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $pagina)
    {
        $listaEquipo = new ListaEquipo();
        date_default_timezone_set('America/Cancun');
        $currentYear = date('Y');
        $currentWeek = date("W");
        $conn = new Conexion();
        $conn->conectar();
        $lstEquipo = [];

        $listaEquipo->idSubseccion = $idGrupo;

        //obtener nombre de la subseccion
        $query = "SELECT id_seccion, grupo "
            . "FROM c_subsecciones "
            . "WHERE id = $idGrupo";
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

        //Obtener el numero de pendientes de la categoria
        if ($idDestino == 10) {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'N'";
        } else {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_destino = $idDestino "
                . "AND id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'N'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $penCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        //obtener el numero de solucionados de la categoria
        if ($idDestino == 10) {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'F'";
        } else {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_destino = $idDestino "
                . "AND id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'F'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $solCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        //Fila de las tareas generales del area
        $listaEquipo->listaEquipos = "<div class=\"columns is-gapless my-1 is-mobile\">"
            . "<div class=\"column is-two-fifths\">"
            . "<div class=\"columns\">"
            . "<div class=\"column\">"
            . "<div class=\"message is-white has-text-centered\">"
            . "<p class=\"message-body\"><strong>Equipos</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column is-white\">"
            . "<div class=\"columns is-gapless\">"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Correctivo: Pendientes\">MC-P</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Correctivo: Finalizados\">MC-S</p></div>"
            // . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: En Proceso\">MP-E</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: Planificado\">MP-P</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: NO Planificado\">MP-NP</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: Finalizados\">MP-S</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Ultimo Preventivo realizado\">U.MP</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Test: Realizados\">TEST</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Ultimo Test realizado\">U.TEST</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Informacion\">INFO</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Cotizaciones\">COT</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Imagenes y Fotografias\">PICS</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Comentarios\">COMENTS</p></div>"
            // . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Comentarios\">Status 1</p></div>"
            . "</div>"
            . "</div>"
            . "</div>";

        //Fila donde de las tareas generales del area - Carga Princiapal
        $listaEquipo->listaEquipos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita\">"
            . "<div class=\"column is-two-fifths\">"
            . "<div class=\"columns\">"
            . "<div class=\"column\">"
            . "<div class=\"message is-small is-white\">"
            . "<p class=\"message-body\">"
            . "<strong>TAREAS GENERALES DEL AREA</strong>"
            . "</p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column\">"
            . "<div class=\"columns is-gapless\">";

        if ($penCategoria > 0) {
            $listaEquipo->listaEquipos .=  "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'N');\">$penCategoria</p></div>";
        } else {
            $listaEquipo->listaEquipos .=  "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'N');\">$penCategoria</p></div>";
        }

        if ($solCategoria > 0) {
            $listaEquipo->listaEquipos .=  "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'F');\">$solCategoria</p></div>";
        } else {
            $listaEquipo->listaEquipos .=  "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'F');\">$solCategoria</p></div>";
        }

        $listaEquipo->listaEquipos .= "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "</div>"
            . "</div>"
            . "</div>";


        //Obtener numero de registros y paginas
        //Se obtienen los datos de los equipos
        if ($idDestino == 10) { //Buscar equipos de la seccion de todos los destinos
            if ($idCategoria == 1) { //Equipos MC/MP
                if ($idGrupo == 12 || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) {
                    //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria "
                        . "FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
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
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "ORDER BY id_destino";
                } else {
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND status = 'A' "
                        . "ORDER BY id_destino";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "ORDER BY id_destino";
            }
        } else { //Buscar equipos de un destino en especifico
            if ($idCategoria == 1) {
                if ($idGrupo == "12-quitar" || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
                    $query = "SELECT id FROM c_hoteles "
                        . "WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "ORDER BY equipo";
                } else {
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND status = 'A' "
                        . "ORDER BY equipo";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND id_destino = $idDestino "
                    . "AND categoria = $idCategoria "
                    . "AND status = 'A' "
                    . "AND pap = $idSubcategoria ORDER BY equipo";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 25;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        //Se obtienen los datos de los equipos
        if ($idDestino == 10) { //Buscar equipos de la seccion de todos los destinos
            if ($idCategoria == 1) { //Equipos MC/MP
                if ($idGrupo == 12 || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria "
                        . "FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
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
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "ORDER BY id_destino "
                        . "LIMIT $desde, $porPagina";
                } else {
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND status = 'A' "
                        . "ORDER BY id_destino "
                        . "LIMIT $desde, $porPagina";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "ORDER BY id_destino "
                    . "LIMIT $desde, $porPagina";
            }
        } else { //Buscar equipos de un destino en especifico
            if ($idCategoria == 1) {
                if ($idGrupo == "12-quitar" || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
                    $query = "SELECT id FROM c_hoteles "
                        . "WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "ORDER BY equipo "
                        . "LIMIT $desde, $porPagina";
                } else {
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND status = 'A' "
                        . "ORDER BY equipo "
                        . "LIMIT $desde, $porPagina";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND id_destino = $idDestino "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "ORDER BY equipo "
                    . "LIMIT $desde, $porPagina";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];

                    //Se obtiene el numero de pendientes del equipo
                    $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroPendientes = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //Se agrega a un array para ser ordenado de mayor a menor
                    $equipo = ["idEquipo" => $idEquipo, "cantPendientes" => $numeroPendientes];
                    $lstEquipo[] = $equipo;
                }
            }
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }
        $conn->cerrar();
        arsort($lstEquipo);

        //Se ordenan los equipos de mayor a menor en numero de pendientes
        foreach ($lstEquipo as $key => $row) {
            $aux[$key] = $row['cantPendientes'];
        }
        if (count($lstEquipo) > 0 && count($aux) > 0) {
            //Se ordenan los equipos de mayor a menor en numero de pendientes
            array_multisort($aux, SORT_DESC, $lstEquipo);
            $año = date('Y');

            //Se recorre el arreglo para obtner detalles del equipo MC y MP
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
                            //Se obtiene numeor de pendientes del equipo
                            $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalPenEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            //Se obtiene numero de solucionados del equipo
                            $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status = 'F' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalSolEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            //Obtener fecha de ultimo MP realizado y numero de MP programados, proceso y finalizados

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'MP' "
                                . "ORDER BY id DESC LIMIT 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $d) {
                                        $idPlaneacion = $d['id'];
                                        $query = "SELECT * FROM t_ordenes_trabajo "
                                            . "WHERE id_planeacion_mp = $idPlaneacion AND status = 'F'";
                                        try {
                                            $r = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($r as $d) {
                                                    $fechaMPR = $d['fecha_realizado'];
                                                }
                                            } else {
                                                $fechaMPR = "NA";
                                            }
                                        } catch (Exception $ex) {
                                            $listaEquipo = $ex;
                                        }
                                    }
                                } else {
                                    $fechaMPR = "NA";
                                }
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'N' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpPlanificado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_np "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F'"
                                . "AND activo = 1 
                                ";

                            try {
                                $resp = $conn->obtDatos($query);
                                $mpnPlanificado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'P' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpProceso = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpRealizado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            //Numero de comentarios al equipo
                            $query = "SELECT * FROM t_comentarios_equipo WHERE id_equipo = $idEquipo";
                            try {
                                $resp = $conn->obtDatos($query);
                                $comentariosEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
                            $comentariosMP = 0;
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dt) {
                                        $idOT = $dt['id'];

                                        $query = "SELECT *"
                                            . "FROM t_mp_comentarios "
                                            . "WHERE id_ot = $idOT ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $comentariosMP += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $comentariosMP = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //Comentarios en MC
                            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
                            $comentariosMC = 0;
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idMC = $dts['id'];

                                        $query = "SELECT * "
                                            . "FROM t_mc_comentarios "
                                            . "WHERE id_mc = $idMC ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $comentariosMC += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $comentariosMC = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $numeroComentarios = $comentariosEquipo + $comentariosMC + $comentariosMP;

                            //Numero de fotografias
                            //Numero de comentarios al equipo
                            $query = "SELECT * FROM t_equipos_adjuntos WHERE id_equipo = $idEquipo";
                            try {
                                $resp = $conn->obtDatos($query);
                                $fotosEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
                            $fotosMP = 0;
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dt) {
                                        $idOT = $dt['id'];

                                        $query = "SELECT *"
                                            . "FROM t_mp_adjuntos "
                                            . "WHERE id_ot = $idOT ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $fotosMP += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $fotosMP = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //Comentarios en MC
                            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
                            $fotosMC = 0;
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idMC = $dts['id'];

                                        $query = "SELECT * "
                                            . "FROM t_mc_adjuntos "
                                            . "WHERE id_mc = $idMC ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $fotosMC += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $fotosMC = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $numeroFotos = $fotosEquipo + $fotosMC + $fotosMP;

                            //numero de cotizaciones
                            $query = "SELECT * FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo";
                            try {
                                $coti = $conn->obtDatos($query);
                                $numeroCotizaciones = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //TEST ultima fecha y numero de test realizados
                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'TEST' "
                                . "ORDER BY id DESC LIMIT 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $d) {
                                        $idPlaneacion = $d['id'];
                                        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion";
                                        try {
                                            $r = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($r as $d) {
                                                    $fechaTestR = $d['fecha_realizado'];
                                                }
                                            } else {
                                                $fechaTestR = "NA";
                                            }
                                        } catch (Exception $ex) {
                                            $listaEquipo = $ex;
                                        }
                                    }
                                } else {
                                    $fechaTestR = "NA";
                                }
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'TEST'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $numeroTest = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $listaEquipo->listaEquipos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita\">"
                                . "<div class=\"column is-two-fifths\">"
                                . "<div class=\"columns\">"
                                . "<div class=\"column\">";

                            if ($totalPenEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"message is-small is-warning\">";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"message is-small is-success\">";
                            }

                            $listaEquipo->listaEquipos .= "<p class=\"message-body\">"
                                . "<strong>" . strtoupper($equipo) . "</strong>"
                                . "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "<div class=\"column\">"
                                . "<div class=\"columns is-gapless\">";

                            if ($totalPenEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'N')\">$totalPenEquipo</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'N')\">$totalPenEquipo</p></div>";
                            }

                            if ($totalSolEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'F')\">$totalSolEquipo</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'F')\">$totalSolEquipo</p></div>";
                            }

                            // if ($mpProceso > 0) {
                            //     $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-proceso\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpProceso</p></div>";
                            // } else {
                            //     $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpProceso</p></div>";
                            // }

                            if ($mpPlanificado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpPlanificado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpPlanificado</p></div>";
                            }

                            // Inicio semento para la nueva columna MP-NP
                            if ($mpnPlanificado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-test\" onclick=\"showModal('modal-MPNP'); obtMPNP($idEquipo,'$equipo');\">$mpnPlanificado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-MPNP'); obtMPNP($idEquipo, '$equipo');\">$mpnPlanificado</p></div>";
                            }
                            // Fin Segmento. 

                            if ($mpRealizado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpRealizado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpRealizado</p></div>";
                            }

                            if ($fechaMPR != "NA" and $fechaMPR != "") {
                                $fechaMPR = new DateTime($fechaMPR);
                                $fechaMPR = $fechaMPR->format("d-m-Y");
                            }

                            if ($fechaMPR != "") {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">$fechaMPR</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">-</p></div>";
                            }

                            if ($numeroTest > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-test\" onclick=\"showModal('modal-mp'); obtTest($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$numeroTest</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtTest($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$numeroTest</p></div>";
                            }

                            if ($fechaTestR != "") {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">$fechaTestR</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">-</p></div>";
                            }
                            $listaEquipo->listaEquipos .= "<div class=\"column\">"
                                . "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-info'); obtenerInfoEquipo($idEquipo); obtenerFotosEquipo($idEquipo);\">"
                                . "<span><i class=\"fas fa-info-circle\"></i></span>"
                                . "</p>"
                                . "</div>";

                            if ($numeroCotizaciones > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-test\" onclick=\"showModal('modal-equipo-cotizaciones'); obtenerCotizacionesEquipo($idEquipo);\">$numeroCotizaciones</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-cotizaciones'); obtenerCotizacionesEquipo($idEquipo);\">$numeroCotizaciones</p></div>";
                            }

                            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosEquipo($idEquipo);\">$numeroFotos</p></div>";

                            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-comentarios'); obtenerComentariosEquipo($idEquipo);\">$numeroComentarios</p></div>";


                            $listaEquipo->listaEquipos .= "</div>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                } catch (Exception $ex) {
                    $listaEquipo = $ex;
                    exit($ex);
                }
            }
        }

        //Paginador
        $listaEquipo->listaEquipos .= "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8\">"
            . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, 1 );\" href=\"#\">Inicio</a>";
            //$pagina = $pagina - 1;
            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>"
                . "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {
            //$pagina = $pagina + 1;
            $listaEquipo->listaEquipos .= "<a class=\"pagination-next\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>"
                . "<a class=\"pagination-next\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $totalPaginas );\" href=\"#\">Fin</a>";
        } else {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>"
                . "<a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $listaEquipo->listaEquipos .= "<ul class=\"pagination-list\">";

        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . " );\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, 1 );\" href=\"#\">1</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . " );\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                    } else {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($i + 1) . " );\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPagina($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $totalPaginas );\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }
        $listaEquipo->listaEquipos .= "</ul>"
            . "</nav>"
            . "</div>"
            . "</div>";

        $conn->cerrar();
        return $listaEquipo;
    }

    //Obtener equipos por palabra busqueda
    public function obtenerEquiposxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $pagina, $palabra)
    {
        $listaEquipo = new ListaEquipo();
        date_default_timezone_set('America/Cancun');
        $currentYear = date('Y');
        $currentWeek = date("W");
        $conn = new Conexion();
        $conn->conectar();
        $lstEquipo = [];

        $listaEquipo->idSubseccion = $idGrupo;

        //obtener nombre de la subseccion
        $query = "SELECT id_seccion, grupo "
            . "FROM c_subsecciones "
            . "WHERE id = $idGrupo";
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

        //Obtener el numero de pendientes de la categoria
        if ($idDestino == 10) {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'N'";
        } else {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_destino = $idDestino "
                . "AND id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'N'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $penCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        //obtener el numero de solucionados de la categoria
        if ($idDestino == 10) {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'F'";
        } else {
            $query = "SELECT id FROM t_mc "
                . "WHERE id_destino = $idDestino "
                . "AND id_subseccion = $idGrupo "
                . "AND id_categoria = 6 "
                . "AND activo = 1 "
                . "AND status = 'F'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $solCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }

        //Fila de las tareas generales del area
        $listaEquipo->listaEquipos = "<div class=\"columns is-gapless my-1 is-mobile\">"
            . "<div class=\"column is-two-fifths\">"
            . "<div class=\"columns\">"
            . "<div class=\"column\">"
            . "<div class=\"message is-white has-text-centered\">"
            . "<p class=\"message-body\"><strong>Equipos</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column is-white\">"
            . "<div class=\"columns is-gapless\">"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Correctivo: Pendientes\">MC-P</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Correctivo: Finalizados\">MC-S</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: Planificado\">MP-P</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: NO Planificado\">MP-NP</p></div>"
            // . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: En Proceso\">MP-E</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Mantto. Preventivo: Realizado\">MP-R</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Ultimo Preventivo realizado\">U.MP</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Test: Realizados\">TEST</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Ultimo Test realizado\">U.TEST</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Informacion\">INFO</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Cotizaciones\">COT</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Imagenes y Fotografias\">PICS</p></div>"
            . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Comentarios\">COMENTS</p></div>"
            // . "<div class=\"column\"><p class=\"t-titulos\" data-tooltip=\"Comentarios\">Satus 2</p></div>"
            . "</div>"
            . "</div>"
            . "</div>";

        //Fila donde de las tareas generales del area
        $listaEquipo->listaEquipos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita\">"
            . "<div class=\"column is-two-fifths\">"
            . "<div class=\"columns\">"
            . "<div class=\"column\">"
            . "<div class=\"message is-small is-white\">"
            . "<p class=\"message-body\">"
            . "<strong>TAREAS GENERALES DEL AREA</strong>"
            . "</p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column\">"
            . "<div class=\"columns is-gapless\">";
        if ($penCategoria > 0) {
            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'N');\">$penCategoria</p></div>";
        } else {
            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'N');\">$penCategoria</p></div>";
        }

        if ($solCategoria > 0) {
            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'F');\">$solCategoria</p></div>";
        } else {
            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivosG($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat, 'F');\">$solCategoria</p></div>";
        }

        // Bloque de codigo para acompletar las columnas de tareas generales.
        $listaEquipo->listaEquipos .= "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "<div class=\"column\"></div>"
            . "</div>"
            . "</div>"
            . "</div>";


        //Obtener numero de registros y paginas
        //Se obtienen los datos de los equipos
        if ($idDestino == 10) { //Buscar equipos de la seccion de todos los destinos
            if ($idCategoria == 1) { //Equipos MC/MP
                if ($idGrupo == 12 || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria "
                        . "FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
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
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY id_destino";
                } else {
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY id_destino";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "AND equipo LIKE '%$palabra%' "
                    . "ORDER BY id_destino";
            }
        } else { //Buscar equipos de un destino en especifico
            if ($idCategoria == 1) {
                if ($idGrupo == "12-quitar" || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
                    $query = "SELECT id FROM c_hoteles "
                        . "WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY equipo";
                } else {
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY equipo";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND id_destino = $idDestino "
                    . "AND categoria = $idCategoria "
                    . "AND status = 'A' "
                    . "AND equipo LIKE '%$palabra%' "
                    . "AND pap = $idSubcategoria ORDER BY equipo";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 25;
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }



        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        //Se obtienen los datos de los equipos
        if ($idDestino == 10) { //Buscar equipos de la seccion de todos los destinos
            if ($idCategoria == 1) { //Equipos MC/MP
                if ($idGrupo == 12 || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria "
                        . "FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
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
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY id_destino "
                        . "LIMIT $desde, $porPagina";
                } else {
                    /* Consulta para obtener equipos de todos los destinos
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY id_destino "
                        . "LIMIT $desde, $porPagina";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "AND equipo LIKE '%$palabra%' "
                    . "ORDER BY id_destino "
                    . "LIMIT $desde, $porPagina";
            }
        } else { //Buscar equipos de un destino en especifico
            if ($idCategoria == 1) {
                if ($idGrupo == "12-quitar" || $idGrupo == 342 || $idGrupo == 343 || $idGrupo == 344) { //Subseccion Fan&Coils, Villas GP, TRS o Familiy
                    //Se obtiene el nombre de la subcategoria que seria el nombre del hotel
                    $query = "SELECT subcategoria FROM c_subcategorias_planner "
                        . "WHERE id = $idSubcategoria";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $nombreSubcategoria = $dts['subcategoria'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //En base al nombre del hotel se busca su id
                    $query = "SELECT id FROM c_hoteles "
                        . "WHERE hotel LIKE '%$nombreSubcategoria%'";
                    try {
                        $r = $conn->obtDatos($query);
                        foreach ($r as $dts) {
                            $idHotel = $dts['id'];
                        }
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion especifica fancoils y villas y por hotel
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND id_hotel = $idHotel "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY equipo "
                        . "LIMIT $desde, $porPagina";
                } else {
                    /* Consulta para obtener equipos de un destino
                     * Filtrando por subseccion
                     */
                    $query = "SELECT id FROM t_equipos "
                        . "WHERE id_subseccion = $idGrupo "
                        . "AND id_destino = $idDestino "
                        . "AND status = 'A' "
                        . "AND equipo LIKE '%$palabra%' "
                        . "ORDER BY equipo "
                        . "LIMIT $desde, $porPagina";
                }
            } else {
                $query = "SELECT id FROM t_equipos "
                    . "WHERE id_subseccion = $idGrupo "
                    . "AND id_destino = $idDestino "
                    . "AND categoria = $idCategoria "
                    . "AND pap = $idSubcategoria "
                    . "AND status = 'A' "
                    . "AND equipo LIKE '%$palabra%' "
                    . "ORDER BY equipo "
                    . "LIMIT $desde, $porPagina";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];

                    //Se obtiene el numero de pendientes del equipo
                    $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroPendientes = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $listaEquipo = $ex;
                        exit($ex);
                    }

                    //Se agrega a un array para ser ordenado de mayor a menor
                    $equipo = ["idEquipo" => $idEquipo, "cantPendientes" => $numeroPendientes];
                    $lstEquipo[] = $equipo;
                }
            }
        } catch (Exception $ex) {
            $listaEquipo = $ex;
            exit($ex);
        }
        $conn->cerrar();
        arsort($lstEquipo); //t

        //Se ordenan los equipos de mayor a menor en numero de pendientes
        foreach ($lstEquipo as $key => $row) {
            $aux[$key] = $row['cantPendientes'];
        }
        if (count($lstEquipo) > 0 && count($aux) > 0) {
            //Se ordenan los equipos de mayor a menor en numero de pendientes
            array_multisort($aux, SORT_DESC, $lstEquipo);
            $año = date('Y');

            //Se recorre el arreglo para obtner detalles del equipo MC y MP
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
                            //Se obtiene numeor de pendientes del equipo
                            $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalPenEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            //Se obtiene numero de solucionados del equipo
                            $query = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status = 'F' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalSolEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                                exit($ex);
                            }

                            //Se obtiene numero de MP planeados, en proceso y finalizados
                            $query = "SELECT id, status FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND año = '$año' AND activo = 1";
                            $mpPlanificado = 0;
                            $mpnPlanificado = 0;
                            $mpProceso = 0;
                            $mpRealizado = 0;
                            //                            try {
                            //                                $resp = $conn->obtDatos($query);
                            //                                if ($conn->filasConsultadas > 0) {
                            //                                    foreach ($resp as $dts) {
                            //                                        $id = $dts['id'];
                            //                                        $status = $dts['status'];
                            //                                        if ($status == 'F') {
                            //                                            $mpRealizado += 1;
                            //                                        } else if ($status == 'P') {
                            //                                            $mpProceso += 1;
                            //                                        } else {
                            //
                            //                                            $mpPlanificado += 1;
                            //                                        }
                            //                                    }
                            //                                }
                            //                            } catch (Exception $ex) {
                            //                                $salida = $ex;
                            //                                exit($ex);
                            //                            }
                            //Se obtiene la fecha del ultimo MP que se realizo al equipo
                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'MP' "
                                . "ORDER BY id DESC LIMIT 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $d) {
                                        $idPlaneacion = $d['id'];
                                        $query = "SELECT * FROM t_ordenes_trabajo "
                                            . "WHERE id_planeacion_mp = $idPlaneacion AND status = 'F'";
                                        try {
                                            $r = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($r as $d) {
                                                    $fechaMPR = $d['fecha_realizado'];
                                                }
                                            } else {
                                                $fechaMPR = "NA";
                                            }
                                        } catch (Exception $ex) {
                                            $listaEquipo = $ex;
                                        }
                                    }
                                } else {
                                    $fechaMPR = "NA";
                                }
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'N' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpPlanificado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            // Nuevo segmento
                            $query = "SELECT * FROM t_mp_np "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F'"
                                . "AND activo = 1 
                                ";

                            try {
                                $resp = $conn->obtDatos($query);
                                $mpnPlanificado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }


                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'P' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpProceso = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'MP' "
                                . "AND activo = 1 AND año = '$currentYear'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $mpRealizado = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            //Numero de comentarios al equipo
                            $query = "SELECT * FROM t_comentarios_equipo WHERE id_equipo = $idEquipo";
                            try {
                                $resp = $conn->obtDatos($query);
                                $comentariosEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
                            $comentariosMP = 0;
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dt) {
                                        $idOT = $dt['id'];

                                        $query = "SELECT *"
                                            . "FROM t_mp_comentarios "
                                            . "WHERE id_ot = $idOT ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $comentariosMP += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $comentariosMP = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //Comentarios en MC
                            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
                            $comentariosMC = 0;
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idMC = $dts['id'];

                                        $query = "SELECT * "
                                            . "FROM t_mc_comentarios "
                                            . "WHERE id_mc = $idMC ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $comentariosMC += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $comentariosMC = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $numeroComentarios = $comentariosEquipo + $comentariosMC + $comentariosMP;

                            //Numero de fotografias
                            //Numero de comentarios al equipo
                            $query = "SELECT * FROM t_equipos_adjuntos WHERE id_equipo = $idEquipo";
                            try {
                                $resp = $conn->obtDatos($query);
                                $fotosEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
                            $fotosMP = 0;
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dt) {
                                        $idOT = $dt['id'];

                                        $query = "SELECT *"
                                            . "FROM t_mp_adjuntos "
                                            . "WHERE id_ot = $idOT ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $fotosMP += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $fotosMP = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //Comentarios en MC
                            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
                            $fotosMC = 0;
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idMC = $dts['id'];

                                        $query = "SELECT * "
                                            . "FROM t_mc_adjuntos "
                                            . "WHERE id_mc = $idMC ORDER BY fecha";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            $fotosMC += $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $equipo = $ex;
                                            exit($ex);
                                        }
                                    }
                                } else {
                                    $fotosMC = 0;
                                }
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            $numeroFotos = $fotosEquipo + $fotosMC + $fotosMP;

                            //numero de cotizaciones
                            $query = "SELECT * FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo";
                            try {
                                $coti = $conn->obtDatos($query);
                                $numeroCotizaciones = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $equipo = $ex;
                                exit($ex);
                            }

                            //TEST ultima fecha y numero de test realizados
                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'TEST' "
                                . "ORDER BY id DESC LIMIT 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $d) {
                                        $idPlaneacion = $d['id'];
                                        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion";
                                        try {
                                            $r = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($r as $d) {
                                                    $fechaTestR = $d['fecha_realizado'];
                                                }
                                            } else {
                                                $fechaTestR = "NA";
                                            }
                                        } catch (Exception $ex) {
                                            $listaEquipo = $ex;
                                        }
                                    }
                                } else {
                                    $fechaTestR = "NA";
                                }
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $query = "SELECT * FROM t_mp_planeacion "
                                . "WHERE id_equipo = $idEquipo "
                                . "AND status = 'F' AND tipoplan = 'TEST'";
                            try {
                                $resp = $conn->obtDatos($query);
                                $numeroTest = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $listaEquipo = $ex;
                            }

                            $listaEquipo->listaEquipos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita\">"
                                . "<div class=\"column is-two-fifths\">"
                                . "<div class=\"columns\">"
                                . "<div class=\"column\">";

                            if ($totalPenEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"message is-small is-warning\">";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"message is-small is-success\">";
                            }

                            $listaEquipo->listaEquipos .= "<p class=\"message-body\">"
                                . "<strong>" . strtoupper($equipo) . "</strong>"
                                . "</p>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "</div>"
                                . "<div class=\"column\">"
                                . "<div class=\"columns is-gapless\">";

                            if ($totalPenEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'N')\">$totalPenEquipo</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'N')\">$totalPenEquipo</p></div>";
                            }

                            if ($totalSolEquipo > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'F')\">$totalSolEquipo</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mc'); obtCorrectivos($idEquipo, 'F')\">$totalSolEquipo</p></div>";
                            }

                            if ($mpPlanificado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-pendientes\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpPlanificado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpPlanificado</p></div>";
                            }
                            // Segmento para agregar la nueva columna MP-NP
                            if ($mpnPlanificado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-test\" onclick=\"showModal('modal-MPNP'); obtMPNP($idEquipo, '$equipo');\">$mpnPlanificado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-MPNP'); obtMPNP($idEquipo, '$equipo');\">$mpnPlanificado</p></div>";
                            }
                            // Fin de Segmento.

                            // if ($mpProceso > 0) {
                            //     $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-proceso\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpProceso</p></div>";
                            // } else {
                            //     $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpProceso</p></div>";
                            // }

                            if ($mpRealizado > 0) {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-solucionado\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpRealizado</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtPreventivos($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$mpRealizado</p></div>";
                            }

                            if ($fechaMPR != "NA" and $fechaMPR != "") {
                                $fechaMPR = new DateTime($fechaMPR);
                                $fechaMPR = $fechaMPR->format("d-m-Y");
                            }

                            if ($fechaMPR != "") {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">$fechaMPR</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">-</p></div>";
                            }

                            if ($numeroTest != "") {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-test\" onclick=\"showModal('modal-mp'); obtTest($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$numeroTest</p></div>";
                            } else {
                                $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-mp'); obtTest($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\">$numeroTest</p></div>";
                            }


                            $listaEquipo->listaEquipos .= "<div class=\"column\"><p class=\"t-normal\">$fechaTestR</p></div>"
                                . "<div class=\"column\">"
                                . "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-info'); obtenerInfoEquipo($idEquipo); obtenerFotosEquipo($idEquipo);\">"
                                . "<span><i class=\"fas fa-info-circle\"></i></span>"
                                . "</p>"
                                . "</div>"
                                . "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-cotizaciones'); obtenerCotizacionesEquipo($idEquipo);\">$numeroCotizaciones</p></div>"
                                . "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosEquipo($idEquipo);\">$numeroFotos</p></div>"
                                . "<div class=\"column\"><p class=\"t-normal\" onclick=\"showModal('modal-equipo-comentarios'); obtenerComentariosEquipo($idEquipo);\">$numeroComentarios</p></div>"
                                . "</div>"
                                . "</div>"
                                . "</div>";
                        }
                    }
                } catch (Exception $ex) {
                    $listaEquipo = $ex;
                    exit($ex);
                }
            }
        }

        //Paginador
        $listaEquipo->listaEquipos .= "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8\">"
            . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, 1 );\" href=\"#\">Inicio</a>";
            //$pagina = $pagina - 1;
            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>"
                . "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {
            //$pagina = $pagina + 1;
            $listaEquipo->listaEquipos .= "<a class=\"pagination-next\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>"
                . "<a class=\"pagination-next\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $totalPaginas );\" href=\"#\">Fin</a>";
        } else {

            $listaEquipo->listaEquipos .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>"
                . "<a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $listaEquipo->listaEquipos .= "<ul class=\"pagination-list\">";

        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . " );\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, 1 );\" href=\"#\">1</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($pagina - 1) . " );\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                    } else {
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, " . intval($i + 1) . " );\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $listaEquipo->listaEquipos .= "<li><a class=\"pagination-link\" onclick=\"obtenerEquiposxPaginaxPalabra($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat, $totalPaginas );\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }
        $listaEquipo->listaEquipos .= "</ul>"
            . "</nav>"
            . "</div>"
            . "</div>";

        $conn->cerrar();
        return $listaEquipo;
    }

    public function buscarEquipo($equipo, $idDestino, $idGrupo, $idCategoria, $idSubcategoria)
    {
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

    public function obtenerInfoEquipo($idEquipo)
    {
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

    public function obtenerComentarios($idEquipo, $idDestino)
    {
        //if($idDestino != 10){
        // $destino = "AND t_equipos.id_destino = $idDestino";
        // }else{
        $destino = "";
        // }

        $conn = new Conexion();
        $conn->conectar();
        $equipo = new ComentariosEquipo();



        //Datos del equipo
        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo $destino";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong class=\"ml-1\"> COMENTARIOS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-comentarios');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";

        $equipo->comentariosGenerales = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Comentarios generales</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8\">"
            . "<div class=\"field has-addons has-addons-centered\">"
            . "<div class=\"control\">"
            . "<input id=\"txtComentarioEquipo\" class=\"input\" type=\"text\" placeholder=\"Añadir comentario\">"
            . "</div>"
            . "<div class=\"control\">"
            . "<button class=\"button is-info\" onclick=\"agregarComentarioEquipo($idEquipo);\">Enviar</button>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";
        $query = "SELECT * FROM t_comentarios_equipo WHERE id_equipo = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['id_usuario'];

                    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $d) {
                                $idColaborador = $d['id_colaborador'];

                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $d) {
                                            $nombre = $d['nombre'];
                                            $apellido = $d['apellido'];
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

                    $comentario = $dts['comentarios'];
                    $fecha = $dts['fecha'];
                    $equipo->comentariosGenerales .= "<div class=\"timeline-item\">"
                        . "<div class=\"timeline-marker\"></div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\"><strong>$nombre $apellido</strong></p>"
                        . "<p class=\"heading\">$fecha</p>"
                        . "<p class=\"has-text-justified\">$comentario</p>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }
        $equipo->comentariosGenerales .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        //comentarios de MP y MC
        $equipo->comentariosMCMPM = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Comentarios Relacionados (MP/MC)</h4>";

        //Comentarios en MP

        if (isset($_SESSION['idDestino'])) {
            $idDestinoCMPMC = $_SESSION['idDestino'];
            if ($idDestinoCMPMC != 10) {
                $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo AND id_destino=$idDestinoCMPMC";
            } else {
                $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
            }
        }
        try {
            $result = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($result as $dt) {
                    $idOT = $dt['id'];

                    if (isset($_SESSION['idDestino'])) {
                        $idDestinoCMPMC = $_SESSION['idDestino'];
                        if ($idDestinoCMPMC != 10) {
                            $query = "SELECT t_mp_comentarios.comentarios 'COMENTARIOS', "
                                . "t_mp_comentarios.id_usuario 'IDUSUARIO', "
                                . "t_mp_comentarios.fecha 'FECHA', "
                                . "t_mp_comentarios.id_ot 'IDOT', "
                                . "t_users.id_colaborador 'IDEMPLEADO', "
                                . "t_colaboradores.nombre 'NOMBREEMP', "
                                . "t_colaboradores.apellido 'APELLIDOEMP', "
                                . "t_ordenes_trabajo.folio 'FOLIO' "
                                . "FROM t_mp_comentarios "
                                . "INNER JOIN t_users ON t_users.id = t_mp_comentarios.id_usuario "
                                . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                                . "INNER JOIN t_ordenes_trabajo ON t_ordenes_trabajo.id = t_mp_comentarios.id_ot "
                                . "WHERE t_mp_comentarios.id_ot = $idOT AND t_users.id=$idDestinoCMPMC
                                    ORDER BY t_mp_comentarios.fecha";
                        } else {
                            $query = "SELECT t_mp_comentarios.comentarios 'COMENTARIOS', "
                                . "t_mp_comentarios.id_usuario 'IDUSUARIO', "
                                . "t_mp_comentarios.fecha 'FECHA', "
                                . "t_mp_comentarios.id_ot 'IDOT', "
                                . "t_users.id_colaborador 'IDEMPLEADO', "
                                . "t_colaboradores.nombre 'NOMBREEMP', "
                                . "t_colaboradores.apellido 'APELLIDOEMP', "
                                . "t_ordenes_trabajo.folio 'FOLIO' "
                                . "FROM t_mp_comentarios "
                                . "INNER JOIN t_users ON t_users.id = t_mp_comentarios.id_usuario "
                                . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                                . "INNER JOIN t_ordenes_trabajo ON t_ordenes_trabajo.id = t_mp_comentarios.id_ot "
                                . "WHERE t_mp_comentarios.id_ot = $idOT ORDER BY t_mp_comentarios.fecha";
                        }
                    }

                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dt) {
                                $comentariosMP = $dt['COMENTARIOS'];
                                $fechaMP = $dt['FECHA'];
                                $nombreEmp = $dt['NOMBREEMP'];
                                $apellidoEmp = $dt['APELLIDOEMP'];
                                $folioOT = $dt['FOLIO'];

                                $equipo->comentariosMCMPM .= "<div class=\"timeline-item\">"
                                    . "<div class=\"timeline-marker\"></div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                    . "<p class=\"heading \">$fechaMP</p>"
                                    . "<div class=\"control\">"
                                    . "<div class=\"tags has-addons\">"
                                    . "<span class=\"tag is-dark\">MP</span>"
                                    . "<span class=\"tag is-info\">OT $folioOT</span>"
                                    . "</div>"
                                    . "</div>"
                                    . "<p class=\"has-text-justified\">$comentariosMP</p>"
                                    . "</div>"
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

        //Comentarios en MC
        if (isset($_SESSION['idDestino'])) {
            $idDestinoCMPMC = $_SESSION['idDestino'];
            if ($idDestinoCMPMC != 10) {
                $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND id_destino=$idDestinoCMPMC";
            } else {
                $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
            }
        }
        // $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['id'];
                    $idDestinoMC = $dts['id_destino'];
                    if ($idDestinoMC != 10) {
                        $query = "SELECT t_mc_comentarios.comentario 'COMENTARIO', "
                            . "t_mc_comentarios.fecha 'FECHA', "
                            . "t_mc_comentarios.id_usuario 'IDUSUARIO', "
                            . "t_mc_comentarios.id_mc 'IDMC', "
                            . "t_users.id_colaborador 'IDEMPLEADO', "
                            . "t_colaboradores.nombre 'NOMBREEMP', "
                            . "t_colaboradores.apellido 'APELLIDOEMP', "
                            . "t_mc.actividad 'ACTIVIDAD' "
                            . "FROM t_mc_comentarios "
                            . "INNER JOIN t_users ON t_users.id = t_mc_comentarios.id_usuario "
                            . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                            . "INNER JOIN t_mc ON t_mc.id = t_mc_comentarios.id_mc "
                            . "WHERE t_mc_comentarios.id_mc = $idMC AND t_mc.id_destino=$idDestinoMC ORDER BY t_mc_comentarios.fecha";
                    } else {
                        $query = "SELECT t_mc_comentarios.comentario 'COMENTARIO', "
                            . "t_mc_comentarios.fecha 'FECHA', "
                            . "t_mc_comentarios.id_usuario 'IDUSUARIO', "
                            . "t_mc_comentarios.id_mc 'IDMC', "
                            . "t_users.id_colaborador 'IDEMPLEADO', "
                            . "t_colaboradores.nombre 'NOMBREEMP', "
                            . "t_colaboradores.apellido 'APELLIDOEMP', "
                            . "t_mc.actividad 'ACTIVIDAD' "
                            . "FROM t_mc_comentarios "
                            . "INNER JOIN t_users ON t_users.id = t_mc_comentarios.id_usuario "
                            . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                            . "INNER JOIN t_mc ON t_mc.id = t_mc_comentarios.id_mc "
                            . "WHERE t_mc_comentarios.id_mc = $idMC ORDER BY t_mc_comentarios.fecha";
                    }



                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dt) {
                                $comentariosMC = $dt['COMENTARIO'];
                                $fechaMC = $dt['FECHA'];
                                $nombreEmp = $dt['NOMBREEMP'];
                                $apellidoEmp = $dt['APELLIDOEMP'];
                                $actividadMC = $dt['ACTIVIDAD'];

                                $equipo->comentariosMCMPM .= "<div class=\"timeline-item\">"
                                    . "<div class=\"timeline-marker\"></div>"
                                    . "<div class=\"timeline-content\">"
                                    . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                    . "<p class=\"heading \">$fechaMC</p>"
                                    . "<div class=\"control\">"
                                    . "<div class=\"tags has-addons\">"
                                    . "<span class=\"tag is-dark\">MC</span>"
                                    . "<span class=\"tag is-warning\">$actividadMC</span>"
                                    . "</div>"
                                    . "</div>"
                                    . "<p class=\"has-text-justified\">$comentariosMC</p>"
                                    . "</div>"
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

        $equipo->comentariosMCMPM .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        $conn->cerrar();
        return $equipo;
    }

    public function insertarComentarioEquipo($idEquipo, $comentario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
        $fecha = date('Y-m-d H:i:s');
        $idUsuario = $_SESSION['usuario'];

        $query = "INSERT INTO t_comentarios_equipo (fecha, comentarios, id_equipo, id_usuario, status) "
            . "VALUES('$fecha', '$comentario', $idEquipo, $idUsuario, 'A')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerFotos($idEquipo)
    {
        $conn = new Conexion();
        $conn->conectar();
        $equipo = new FotosEquipo();

        //Datos del equipo
        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong class=\"ml-1\"> IMAGENES Y FOTOGRAFIAS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-pictures');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";

        $equipo->fotosGenerales = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Fotografias generales</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<a class=\"button is-warning\">"
            . "<input class=\"file-input\" type=\"file\" name=\"resume\" id=\"txtFotoEquipo\" multiple onchange=\"cargarFotosEquipo($idEquipo);\">"
            . "<span class=\"icon\">"
            . "<i class=\"fad fa-camera-alt\"></i>"
            . "</span>"
            . "<span>Añadir fotografias</span>"
            . "</a>"
            . "</div>"
            . "</div>";

        $equipo->fotosGenerales1 = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Fotografias generales</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<a class=\"button is-warning\">"
            . "<input class=\"file-input\" type=\"file\" name=\"resume\" id=\"txtFotoEquipo1\" multiple onchange=\"cargarFotosEquipo1($idEquipo);\">"
            . "<span class=\"icon\">"
            . "<i class=\"fad fa-camera-alt\"></i>"
            . "</span>"
            . "<span>Añadir fotografias</span>"
            . "</a>"
            . "</div>"
            . "</div>";

        $equipo->fotosGeneralesArchivos = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Adjuntos</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<a class=\"button is-warning\">"
            . "<input class=\"file-input\" type=\"file\" name=\"resume\" id=\"txtFotoEquipoAdjuntos\" multiple onchange=\"cargarEquipoAdjuntos($idEquipo);\">"
            . "<span class=\"icon\">"
            . "<i class=\"fad fa-file-alt\"></i>"
            . "</span>"
            . "<span>Añadir Adjuntos</span>"
            . "</a>"
            . "</div>"
            . "</div>";

        $query = "SELECT * FROM t_equipos_adjuntos WHERE id_equipo = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['subido_por'];

                    if ($idUsuario != "") {
                        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $d) {
                                    $idColaborador = $d['id_colaborador'];

                                    $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $d) {
                                                $nombre = $d['nombre'];
                                                $apellido = $d['apellido'];
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
                    } else {
                        $nombre = "";
                        $apellido = "";
                    }


                    $urlFoto = $dts['url_archivo'];
                    $fecha = $dts['fecha_subida'];
                    $tipoFile = substr(strrchr($urlFoto, "."), 1);

                    $urlFotoAux = "../img/equipos/$urlFoto";


                    if (file_exists($urlFotoAux)) {
                        $urlFotoAux = "img/equipos/$urlFoto";
                    } else {
                        $urlFotoAux = "../img/equipos/$urlFoto";
                    }




                    if ($tipoFile == "jpg" || $tipoFile == "png" || $tipoFile == "jpeg") {
                        $equipo->fotosGenerales .=
                            "<div class=\"timeline-item\">"
                            . "<div class=\"timeline-marker\"></div>"
                            . "<div class=\"timeline-content\">"
                            . "<a href=\"img/equipos/$urlFoto\" target=\"_BLANCK\">"
                            . "<p class=\"heading\"><strong>$nombre $apellido</strong></p>"
                            . "<p class=\"heading\">$fecha</p>"
                            . "<img class=\"ximg\" src=\"$urlFotoAux\" alt=\"\">"
                            . "</a>"
                            . "</div>"
                            . "</div>";

                        $equipo->fotosGenerales1 .=
                            "<div class=\"timeline-item\">"
                            . "<div class=\"timeline-marker\"></div>"
                            . "<div class=\"timeline-content\">"
                            . "<a href=\"img/equipos/$urlFoto\" target=\"_BLANCK\">"
                            . "<p class=\"heading\"><strong>$nombre $apellido</strong></p>"
                            . "<p class=\"heading\">$fecha</p>"
                            . "<img class=\"ximg\" src=\"img/equipos/$urlFoto\" alt=\"\">"
                            . "</a>"
                            . "</div>"
                            . "</div>";
                    } else {
                        $equipo->fotosGeneralesArchivos .=
                            "<div class=\"timeline-item\">"
                            . "<div class=\"timeline-marker\"></div>"
                            . "<div class=\"timeline-content\">"
                            . "<a href=\"img/equipos/$urlFoto\" target=\"_BLANCK\">"
                            . "<p class=\"heading\"><strong>$nombre $apellido</strong></p>"
                            . "<p class=\"heading\">$fecha</p>"
                            . "<img class=\"ximg\" src=\"svg/formatos/$tipoFile.svg\" alt=\"\">"
                            . "</a>"
                            . "</div>"
                            . "</div>";
                    }
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }
        $equipo->fotosGenerales .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        $equipo->fotosGenerales1 .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        //comentarios de MP y MC
        $equipo->fotosMCMPM = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Comentarios Relacionados (MP/MC)</h4>";

        //Comentarios en MP
        $idDestino = $_SESSION['idDestino'];

        if ($idDestino != 10) {
            $destino = "AND t_users.id_destino = $idDestino";
        } else {
            $destino = "";
        }
        $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo";
        try {
            $result = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($result as $dt) {
                    $idOT = $dt['id'];

                    $query = "SELECT t_mp_adjuntos.url_adjunto 'ADJUNTO', "
                        . "t_mp_adjuntos.subido_por 'IDUSUARIO', "
                        . "t_mp_adjuntos.fecha 'FECHA', "
                        . "t_mp_adjuntos.id_ot 'IDOT', "
                        . "t_users.id_colaborador 'IDEMPLEADO', "
                        . "t_colaboradores.nombre 'NOMBREEMP', "
                        . "t_colaboradores.apellido 'APELLIDOEMP', "
                        . "t_ordenes_trabajo.folio 'FOLIO' "
                        . "FROM t_mp_adjuntos "
                        . "INNER JOIN t_users ON t_users.id = t_mp_adjuntos.subido_por "
                        . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                        . "INNER JOIN t_ordenes_trabajo ON t_ordenes_trabajo.id = t_mp_adjuntos.id_ot "

                        //Se agrego el filtro para filtrar por Destino.
                        . "WHERE t_mp_adjuntos.id_ot = $idOT $destino  ORDER BY t_mp_adjuntos.fecha";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dt) {
                                $fotosMP = $dt['ADJUNTO'];
                                $fechaMP = $dt['FECHA'];
                                $nombreEmp = $dt['NOMBREEMP'];
                                $apellidoEmp = $dt['APELLIDOEMP'];
                                $folioOT = $dt['FOLIO'];

                                $fotosMPAux = "planner/mp/$fotosMP";

                                if (file_exists($fotosMPAux)) {
                                    $urlFotoMP = "planner/mp/$fotosMP";
                                } else {
                                    $urlFotoMP = "../planner/mp/$fotosMP";
                                }

                                $tipoMP = substr(strrchr($fotosMP, "."), 1);

                                if ($tipoMP == "jpg" || $tipoMP == "jpeg" || $tipoMP == "png") {
                                    $equipo->fotosMCMPM .= "<div class=\"timeline-item\">"
                                        . "<div class=\"timeline-marker\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                        . "<p class=\"heading \">$fechaMP</p>"
                                        . "<div class=\"control\">"
                                        . "<div class=\"tags has-addons\">"
                                        . "<span class=\"tag is-dark\">MP</span>"
                                        . "<span class=\"tag is-info\">OT $folioOT</span>"
                                        . "</div>"
                                        . "</div>"
                                        . "<a href=\"$urlFotoMP\" target=\"_BLANCK\"><img class=\"ximg\" src=\"$urlFotoMP\" alt=\"\"></a>"
                                        . "</div>"
                                        . "</div>";
                                } else {
                                    $equipo->fotosMCMPM .= "<div class=\"timeline-item\">"
                                        . "<div class=\"timeline-marker\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                        . "<p class=\"heading \">$fechaMP</p>"
                                        . "<div class=\"control\">"
                                        . "<div class=\"tags has-addons\">"
                                        . "<span class=\"tag is-dark\">MP</span>"
                                        . "<span class=\"tag is-info\">OT $folioOT</span>"
                                        . "</div>"
                                        . "</div>"
                                        . "<a href=\"planner/mp/$fotosMP\" target=\"_BLANCK\"><img class=\"ximg\" src=\"svg/formatos/$tipoMP.svg\" alt=\"\"></a>"
                                        . "</div>"
                                        . "</div>";
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

        //Comentarios en MC
        $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['id'];

                    $query = "SELECT t_mc_adjuntos.url_adjunto 'ADJUNTO', "
                        . "t_mc_adjuntos.fecha 'FECHA', "
                        . "t_mc_adjuntos.subido_por 'IDUSUARIO', "
                        . "t_mc_adjuntos.id_mc 'IDMC', "
                        . "t_users.id_colaborador 'IDEMPLEADO', "
                        . "t_colaboradores.nombre 'NOMBREEMP', "
                        . "t_colaboradores.apellido 'APELLIDOEMP', "
                        . "t_mc.actividad 'ACTIVIDAD' "
                        . "FROM t_mc_adjuntos "
                        . "INNER JOIN t_users ON t_users.id = t_mc_adjuntos.subido_por "
                        . "INNER JOIN t_colaboradores ON t_colaboradores.id = t_users.id_colaborador "
                        . "INNER JOIN t_mc ON t_mc.id = t_mc_adjuntos.id_mc "
                        . "WHERE t_mc_adjuntos.id_mc = $idMC $destino ORDER BY t_mc_adjuntos.fecha";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $dt) {
                                $fotosMC = $dt['ADJUNTO'];
                                $fechaMC = $dt['FECHA'];
                                $nombreEmp = $dt['NOMBREEMP'];
                                $apellidoEmp = $dt['APELLIDOEMP'];
                                $actividadMC = $dt['ACTIVIDAD'];

                                $fotosMCAux = "../planner/tareas/adjuntos/$fotosMC";
                                if (file_exists($fotosMCAux)) {
                                    $urlFotoMC = "planner/tareas/adjuntos/$fotosMC";
                                } else {
                                    $urlFotoMC = "../planner/tareas/adjuntos/$fotosMC";
                                }

                                $tipoMC = substr(strrchr($fotosMC, "."), 1);

                                if ($tipoMC == "jpg" || $tipoMC == "jpeg" || $tipoMC == "png") {

                                    $equipo->fotosMCMPM .= "<div class=\"timeline-item\">"
                                        . "<div class=\"timeline-marker\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                        . "<p class=\"heading \">$fechaMC</p>"
                                        . "<div class=\"control\">"
                                        . "<div class=\"tags has-addons\">"
                                        . "<span class=\"tag is-dark\">MC</span>"
                                        . "<span class=\"tag is-warning\">$actividadMC</span>"
                                        . "</div>"
                                        . "</div>"
                                        . "<a href=\"$urlFotoMC\" target=\"_BLANCK\"><img class=\"ximg\" src=\"$urlFotoMC\" alt=\"\"></a>"
                                        . "</div>"
                                        . "</div>";
                                } else {


                                    $equipo->fotosMCMPM .= "<div class=\"timeline-item\">"
                                        . "<div class=\"timeline-marker\"></div>"
                                        . "<div class=\"timeline-content\">"
                                        . "<p class=\"heading \"><strong>$nombreEmp $apellidoEmp</strong></p>"
                                        . "<p class=\"heading \">$fechaMC</p>"
                                        . "<div class=\"control\">"
                                        . "<div class=\"tags has-addons\">"
                                        . "<span class=\"tag is-dark\">MC</span>"
                                        . "<span class=\"tag is-warning\">$actividadMC</span>"
                                        . "</div>"
                                        . "</div>"
                                        . "<a href=\"$urlFotoMC\" target=\"_BLANCK\"><img class=\"ximg\" src=\"svg/formatos/$tipoMC.svg\" alt=\"\"></a>"
                                        . "</div>"
                                        . "</div>";
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

        $equipo->fotosMCMPM .= "</div>";

        $conn->cerrar();
        return $equipo;
    }

    public function obtenerCotizacionesEquipo($idEquipo)
    {
        $conn = new Conexion();
        $conn->conectar();
        $equipo = new CotizacionesEquipo();

        //Datos del equipo
        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong class=\"ml-1\"> COTIZACIONES</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            //                . "<div class=\"navbar-item\">";
            //        if ($status == "F") {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
            //        } else {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
            //        }
            //        $equipo->correctivos .= "</button>"
            //                . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-cotizaciones');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";

        $equipo->cotizaciones = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Cotizaciones</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<a class=\"button is-warning\">"
            . "<input class=\"file-input\" type=\"file\" name=\"resume\" id=\"txtCotEquipo\" multiple onchange=\"cargarCotizacionesEquipo($idEquipo)\">"
            . "<span class=\"icon\">"
            . "<i class=\"fas fa-plus\"></i>"
            . "</span>"
            . "<span>Añadir cotizaciones</span>"
            . "</a>"
            . "</div>"
            . "</div>";
        $query = "SELECT * FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo AND activo = 1";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['subido_por'];
                    $idCot = $dts['id'];

                    if ($idUsuario != "") {
                        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $d) {
                                    $idColaborador = $d['id_colaborador'];

                                    $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $d) {
                                                $nombre = $d['nombre'];
                                                $apellido = $d['apellido'];
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
                    } else {
                        $nombre = "";
                        $apellido = "";
                    }

                    $archivo = $dts['url_archivo'];
                    $fecha = $dts['fecha'];

                    $equipo->cotizaciones .= "<div class=\"timeline-item\">"
                        . "<div class=\"timeline-marker\"></div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\"><strong>$nombre $apellido </strong>"
                        . "<a class=\"delete\" onclick=\"eliminarCotEquipo($idEquipo, $idCot, '$archivo');\"></a>"
                        . "</p>"
                        . "<p class=\"heading\">$fecha</p>"
                        . "<a href=\"img/equipos/cotizaciones/$archivo\" target=\"_blank\">"
                        . "<img class=\"ximg\" src=\"svg/cot.svg\" alt=\"\">"
                        . "</a>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }
        $equipo->cotizaciones .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        $conn->cerrar();
        return $equipo;
    }

    public function obtenerInformacionEquipo($idEquipo)
    {
        $conn = new Conexion();
        $conn->conectar();
        $equipo = new InfoEquipo();

        //Datos del equipo
        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong class=\"ml-1\"> INFORMACION</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            //                . "<div class=\"navbar-item\">";
            //        if ($status == "F") {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
            //        } else {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
            //        }
            //        $equipo->correctivos .= "</button>"
            //                . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-info'); obtenerInfoEquipo($idEquipo); obtenerFotosEquipo($idEquipo)\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";

        $equipo->informacion = "<h4 class=\"subtitle is-4 has-text-centered\">Informacion del equipo</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<button class=\"button is-warning\" onclick=\"editarInfoEquipo();\">"
            . "<span class=\"icon is-small\">"
            . "<i class=\"fad fa-edit\"></i>"
            . "</span>"
            . "<span>Editar información</span>"
            . "</button>"
            . "</div>"
            . "</div>";

        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_destino 'IDDESTINO', "
            . "t_equipos.id_tipo 'IDTIPO', "
            . "t_equipos.matricula 'MATRICULA', "
            . "t_equipos.id_ccoste 'IDCECO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_marca 'IDMARCA', "
            . "t_equipos.modelo 'MODELO', "
            . "t_equipos.serie 'SERIE', "
            . "t_equipos.status_equipo 'STATUS', "
            . "t_equipos.jerarquia 'JERARQUIA', "
            . "c_destinos.destino 'DESTINO', "
            . "c_tipos.tipo 'TIPO', "
            . "c_secciones.seccion 'SECCION', "
            . "c_marcas.marca 'MARCA' "
            . "FROM t_equipos "
            . "INNER JOIN c_destinos ON c_destinos.id = t_equipos.id_destino "
            . "INNER JOIN c_tipos ON c_tipos.id = t_equipos.id_tipo "
            . "INNER JOIN c_marcas ON c_marcas.id = t_equipos.id_marca "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreEquipo = $dts['EQUIPO'];
                    $destino = $dts['DESTINO'];
                    $idMarcaEq = $dts['IDMARCA'];
                    $tipo = $dts['TIPO'];
                    $matricula = $dts['MATRICULA'];
                    $seccion = $dts['SECCION'];
                    $marca = $dts['MARCA'];
                    $modelo = $dts['MODELO'];
                    $serie = $dts['SERIE'];
                    $status = $dts['STATUS'];
                    $idCeco = $dts['IDCECO'];
                    $jerarquia = $dts['JERARQUIA'];

                    $equipo->editarInfo = "<h4 class=\"subtitle is-4 has-text-centered\">Editar Información</h4>"
                        . "<div class=\"columns\">"
                        . "<div class=\"column has-text-left\">"
                        . "<div class=\"field is-horizontal\">"
                        . "<div class=\"field-label is-normal\">"
                        . "<label class=\"label\">Marca</label>"
                        . "</div>"
                        . "<div class=\"field-body\">"
                        . "<div class=\"select is-fullwidth\">"
                        . "<select id=\"cbEditMarca\">"
                        . "<option>Marca</option>";
                    $q = "SELECT * FROM c_marcas ORDER BY marca";
                    try {
                        $r = $conn->obtDatos($q);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($r as $d) {
                                $idMarca = $d['id'];
                                $nombreMarca = $d['marca'];
                                if ($idMarca == $idMarcaEq) {
                                    $equipo->editarInfo .= "<option value=\"$idMarca\" selected>$nombreMarca</option>";
                                } else {
                                    $equipo->editarInfo .= "<option value=\"$idMarca\">$nombreMarca</option>";
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }
                    $equipo->editarInfo .= "</select>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"columns\">"
                        . "<div class=\"column has-text-left\">"
                        . "<div class=\"field is-horizontal\">"
                        . "<div class=\"field-label is-normal\">"
                        . "<label class=\"label\">Modelo</label>"
                        . "</div>"
                        . "<div class=\"field-body\">"
                        . "<div class=\"field\">"
                        . "<p class=\"control\">"
                        . "<input id=\"txtEditModelo\" class=\"input\" type=\"text\" placeholder=\"Modelo\" value=\"$modelo\">"
                        . "</p>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"columns\">"
                        . "<div class=\"column has-text-left\">"
                        . "<div class=\"field is-horizontal\">"
                        . "<div class=\"field-label is-normal\">"
                        . "<label class=\"label\">Serie</label>"
                        . "</div>"
                        . "<div class=\"field-body\">"
                        . "<div class=\"field\">"
                        . "<p class=\"control\">"
                        . "<input id=\"txtEditSerie\" class=\"input\" type=\"text\" placeholder=\"Serie\" value=\"$serie\">"
                        . "</p>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"columns\">"
                        . "<div class=\"column has-text-left\">"
                        . "<div class=\"field is-horizontal\">"
                        . "<div class=\"field-label is-normal\">"
                        . "<label class=\"label\">Estado</label>"
                        . "</div>"
                        . "<div class=\"field-body\">"
                        . "<div class=\"select is-fullwidth\">"
                        . "<select id=\"cbEditStatus\">"
                        . "<option>Estado</option>";
                    switch ($status) {
                        case 'U':
                            $equipo->editarInfo .= "<option value=\"U\" selected>Operativo</option>"
                                . "<option value=\"T\">En Taller</option>"
                                . "<option value=\"B\">Baja</option>";
                            break;
                        case 'T':
                            $equipo->editarInfo .= "<option value=\"U\">Operativo</option>"
                                . "<option value=\"T\" selected>En Taller</option>"
                                . "<option value=\"B\">Baja</option>";
                            break;
                        case 'B':
                            $equipo->editarInfo .= "<option value=\"U\">Operativo</option>"
                                . "<option value=\"T\">En Taller</option>"
                                . "<option value=\"B\" selected>Baja</option>";
                            break;
                    }

                    $equipo->editarInfo .= "</select>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"columns is-centered\">"
                        . "<div class=\"column is-8 has-text-centered\">"
                        . "<button class=\"button is-warning\" onclick=\"actualizarInfoEquipo($idEquipo);\">"
                        . "<span class=\"icon is-small\">"
                        . "<i class=\"fad fa-save\"></i>"
                        . "</span>"
                        . "<span>Guardar Cambios</span>"
                        . "</button>"
                        . "</div>"
                        . "</div>";

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

                                $ceco = "$depto $fase $destinoCC";
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    if ($matricula == "") {
                        $matricula = "NA";
                    }

                    switch ($status) {
                        case 'U':
                            $status = "Operativo";
                            break;
                        case 'T':
                            $status = "Taller";
                            break;
                        case 'B':
                            $status = "Baja";
                            break;
                    }

                    switch ($jerarquia) {
                        case 1:
                            $jerarquia = "Nivel 1 (Equipo Principal)";

                            break;
                        case 2:
                            $jerarquia = "Nivel 2 (Despiece)";


                            break;
                        case 3:
                            $jerarquia = "Nivel 3 (Componente)";

                            break;
                    }


                    $equipo->informacion .= " <div class=\"columns is-mobile is-gapless\">"
                        . "<div class=\"column is-5 has-text-right\">"
                        . "<h4 class=\"subtitle is-6 mr-2\">Nombre: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Destino: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Tipo: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Matricula: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Ceco: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Seccion: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Marca: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Modelo: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Serie: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Estado: </h4>"
                        . "<h4 class=\"subtitle is-6 mr-2\">Jerarquia: </h4>"
                        . "</div>"
                        . "<div class=\"column has-text-left\">"
                        . "<h4 class=\"subtitle is-6 \">$nombreEquipo</h4>"
                        . "<h4 class=\"subtitle is-6 \">$destino</h4>"
                        . "<h4 class=\"subtitle is-6 \">$tipo</h4>"
                        . "<h4 class=\"subtitle is-6 \">$matricula</h4>"
                        . "<h4 class=\"subtitle is-6 \">$ceco</h4>"
                        . "<h4 class=\"subtitle is-6 \">$seccion</h4>"
                        . "<h4 class=\"subtitle is-6 \">$marca</h4>"
                        . "<h4 class=\"subtitle is-6 \">$modelo</h4>"
                        . "<h4 class=\"subtitle is-6 \">$serie</h4>"
                        . "<h4 class=\"subtitle is-6 \">$status</h4>"
                        . "<h4 class=\"subtitle is-6 \">$jerarquia</h4>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

    public function actualizarInfoEquipo($idEquipo, $marca, $modelo, $serie, $estado)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_equipos "
            . "SET id_marca = $marca, modelo = '$modelo', status_equipo = '$estado' "
            . "WHERE id = $idEquipo";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    //    **********************************************************************
    //    ***************SECCION TAREAS GENERALES DE AREA***********************
    //    **********************************************************************

    public function obtDetalleSubcategoria($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria)
    {
        $equipo = new Equipo();
        $equipo->planMC = "";
        //        $equipo->historicoMP = "";
        $conn = new Conexion();
        $conn->conectar();
        //$pagina = 0;

        date_default_timezone_set('America/Cancun');
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
                . "t_mc.creado_por 'IDCREADOR', "
                . "t_mc.id_destino 'IDDESTINO', "
                . "t_mc.fecha_creacion 'FECHACR', "
                . "t_mc.semana_inicio 'SEMANAI', "
                . "t_mc.semana_fin 'SEMANAF', "
                . "c_destinos.destino 'DESTINO' "
                . "FROM t_mc "
                . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
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
                    . "t_mc.creado_por 'IDCREADOR', "
                    . "t_mc.id_destino 'IDDESTINO', "
                    . "t_mc.fecha_creacion 'FECHACR', "
                    . "t_mc.semana_inicio 'SEMANAI', "
                    . "t_mc.semana_fin 'SEMANAF', "
                    . "c_destinos.destino 'DESTINO' "
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
                        . "t_colaboradores.foto 'FOTO', "
                        . "c_destinos.destino 'DESTINO' "
                        . "FROM t_users "
                        . "INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id "
                        . "INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id "
                        . "WHERE t_users.id = $creado";
                    try {
                        $usuario = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($usuario as $u) {
                                //                                $idTrabajador = $u['id_colaborador'];
                                $destinoCreador = $u['IDDESTINO'];
                                $des = $u['DESTINO'];
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

    // Se obtienen todas los correctivos generales.
    public function obtCorrectivosG($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria, $status)
    {
        $conn = new Conexion();
        $conn->conectar();
        $equipo = new MCMPEquipo();

        //Datos de la subcategoria
        $query = "SELECT c_subsecciones.id_seccion 'IDSECCION', "
            . "c_subsecciones.grupo 'SUBSECCION',"
            . "c_secciones.seccion 'SECCION' "
            . "FROM c_subsecciones "
            . "INNER JOIN c_secciones ON c_secciones.id = c_subsecciones.id_seccion "
            . "WHERE c_subsecciones.id = $idSubseccion";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }



        $equipo->correctivos .= "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<span class=\"navbar-item\">"
            . "<button class=\"button is-warning\" onclick=\"closeModal('modal-mc');\"><i class=\"fas fa-arrow-left\"></i></button>"
            . "</span>"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / TAREAS GENERALES / <strong> CORRECTIVOS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            . "<div class=\"navbar-item\">";
        if ($status == "F") {
            $equipo->correctivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivosG($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria, 'N');\">"
                . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
        } else {
            $equipo->correctivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivosG($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria, 'F');\">"
                . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
        }
        $equipo->correctivos .= "</button>"
            . "</div>"
            . "<div class=\"navbar-item\">"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>"
            . "<section class=\"mt-4\">"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-3\">"
            . "<div class=\"field has-addons\">"
            . "<div class=\"control is-expanded\">"
            . "<input id=\"txtTituloTareaMC\" class=\"input\" type=\"text\" placeholder=\"Agregar Nuevo correctivo.\">"
            . "</div>"
            . "<div class=\"control\">"
            . "<a class=\"button is-warning\" onclick=\"agregarTarea(0);\">"
            . "<i class=\"fad fa-plus-circle\"></i>"
            . "</a>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</section>"
            . "<section class=\"mt-4\">"
            . "<div class=\"columns is-gapless my-1 is-mobile mx-2\">"
            . "<div class=\"column is-half\">"
            . "<div class=\"columns is-mobile\">"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Descripcion\"><strong>Descripcion de los correctivos</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column is-white\">"
            . "<div class=\"columns is-gapless is-mobile\">"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Responsable\"><strong>Responsable</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Fecha estimada de solucion\"><strong>Fecha</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Documentos e imagenes adjuntoas\"><strong>Adjuntos</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Comentarios\"><strong>Comentarios</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . " <p class=\"t-titulos\" data-tooltip=\"Status seleccionado\"><strong>Status Tarea</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . " <p class=\"t-titulos\" data-tooltip=\"Fase Seleccionada\"><strong>Opción</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";


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
                . "t_mc.creado_por 'IDCREADOR', "
                . "t_mc.id_destino 'IDDESTINO', "
                . "t_mc.fecha_creacion 'FECHACR', "
                . "t_mc.semana_inicio 'SEMANAI', "
                . "t_mc.semana_fin 'SEMANAF', "
                . "t_mc.status_default 'STATUS_DEFAULT', "
                . "t_mc.status_material 'STATUS_MATERIAL', "
                . "t_mc.status_urgente 'STATUS_URGENTE', "
                . "t_mc.status_trabajare 'STATUS_TRABAJARE', "
                . "t_mc.departamento_calidad 'DEPARTAMENTO_CALIDAD', "
                . "t_mc.departamento_finanzas 'DEPARTAMENTO_FINANZAS', "
                . "t_mc.departamento_rrhh 'DEPARTAMENTO_RRHH', "
                . "t_mc.departamento_compras 'DEPARTAMENTO_COMPRAS', "
                . "t_mc.departamento_direccion 'DEPARTAMENTO_DIRECCION', "
                . "t_mc.energetico_agua 'ENERGETICO_AGUA', "
                . "t_mc.energetico_gas 'ENERGETICO_GAS', "
                . "t_mc.energetico_electricidad 'ENERGETICO_ELECTRICIDAD', "
                . "t_mc.energetico_diesel 'ENERGETICO_DIESEL', "
                . "t_mc.zona 'FASE', "
                . "c_destinos.destino 'DESTINO' "
                . "FROM t_mc "
                . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
                . "WHERE t_mc.id_subseccion = $idSubseccion "
                . "AND t_mc.id_categoria = $idCategoria "
                . "AND t_mc.id_subcategoria = $idSubcategoria "
                . "AND t_mc.status = '$status' "
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
                    . "t_mc.creado_por 'IDCREADOR', "
                    . "t_mc.id_destino 'IDDESTINO', "
                    . "t_mc.fecha_creacion 'FECHACR', "
                    . "t_mc.semana_inicio 'SEMANAI', "
                    . "t_mc.semana_fin 'SEMANAF', "
                    . "t_mc.status_default 'STATUS_DEFAULT', "
                    . "t_mc.status_material 'STATUS_MATERIAL', "
                    . "t_mc.status_urgente 'STATUS_URGENTE', "
                    . "t_mc.status_trabajare 'STATUS_TRABAJARE', "
                    . "t_mc.departamento_calidad 'DEPARTAMENTO_CALIDAD', "
                    . "t_mc.departamento_finanzas 'DEPARTAMENTO_FINANZAS', "
                    . "t_mc.departamento_rrhh 'DEPARTAMENTO_RRHH', "
                    . "t_mc.departamento_compras 'DEPARTAMENTO_COMPRAS', "
                    . "t_mc.departamento_direccion 'DEPARTAMENTO_DIRECCION', "
                    . "t_mc.energetico_agua 'ENERGETICO_AGUA', "
                    . "t_mc.energetico_gas 'ENERGETICO_GAS', "
                    . "t_mc.energetico_electricidad 'ENERGETICO_ELECTRICIDAD', "
                    . "t_mc.energetico_diesel 'ENERGETICO_DIESEL', "
                    . "t_mc.zona 'ZONA', "
                    . "c_destinos.destino 'DESTINO' "
                    . "FROM t_mc "
                    . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
                    . "WHERE (t_mc.id_destino = $idDestino) "
                    . "AND t_mc.id_subseccion = $idSubseccion "
                    . "AND t_mc.id_categoria = $idCategoria "
                    . "AND t_mc.id_subcategoria = $idSubcategoria "
                    . "AND t_mc.status = '$status' "
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
                    . "t_mc.status_default 'STATUS_DEFAULT', "
                    . "t_mc.status_material 'STATUS_MATERIAL', "
                    . "t_mc.status_urgente 'STATUS_URGENTE', "
                    . "t_mc.status_trabajare 'STATUS_TRABAJARE', "
                    . "t_mc.departamento_calidad 'DEPARTAMENTO_CALIDAD', "
                    . "t_mc.departamento_finanzas 'DEPARTAMENTO_FINANZAS', "
                    . "t_mc.departamento_rrhh 'DEPARTAMENTO_RRHH', "
                    . "t_mc.departamento_compras 'DEPARTAMENTO_COMPRAS', "
                    . "t_mc.departamento_direccion 'DEPARTAMENTO_DIRECCION', "
                    . "t_mc.energetico_agua 'ENERGETICO_AGUA', "
                    . "t_mc.energetico_gas 'ENERGETICO_GAS', "
                    . "t_mc.energetico_electricidad 'ENERGETICO_ELECTRICIDAD', "
                    . "t_mc.energetico_diesel 'ENERGETICO_DIESEL', "
                    . "t_mc.zona 'ZONA', "
                    . "c_destinos.destino 'DESTINO' "
                    . "FROM t_mc "
                    . "INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id "
                    . "WHERE (t_mc.id_destino = $idDestino OR t_mc.id_destino = 10) "
                    . "AND t_mc.id_subseccion = $idSubseccion "
                    . "AND t_mc.id_categoria = $idCategoria "
                    . "AND t_mc.id_subcategoria = $idSubcategoria "
                    . "AND t_mc.status = '$status' "
                    . "AND t_mc.activo = 1";
            }
        }
        try {
            // Agrega la fila unicamente para DEP, donde muestra los regstros marcados como departamentos.
            if ($idSubseccion == 62 || $idSubseccion == 211 || $idSubseccion == 212 || $idSubseccion == 213 || $idSubseccion == 214) {
                $arrayDEPNombre = array(62 => "RRHH", 211 => "Finanzas", 212 => "Dirección", 213 => "Compras Almacén", 214 => "Calidad");

                $equipo->correctivos .= "
                <div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\"  onclick=\" show_hide_modal('modal-mc','hide'); reporteStatusDEP($idSubseccion, $idDestino, 23, 0, 0, 0, 'destinoTNombre', 'seccionNombre','$arrayDEPNombre[$idSubseccion]'); \">
                <div class=\"column\">
                <div class=\"columns\">
                <div class=\"column\">
                <div class=\"message is-small is-danger\">
                <p class=\"message-body\"><strong></strong>
                <span>Departamento $arrayDEPNombre[$idSubseccion]</span>
                </p>
                </div>
                </div>
                </div>
                </div>
                </div>
                ";
            }
            // Fin

            // Bloque de Código para Mostrar la opción de Fase, siempre y cuando se este clasificado.
            $search = 0;
            $checkedGP = "";
            $checkedTRS = "";
            $checkedZI = "";
            if ($idDestino == 1) {
                $arraySubseccion = array(308, 14, 300, 293, 320, 313, 297, 200, 38, 13, 35, 14, 15, 200, 1001, 301, 37, 200, 39, 340, 288, 314, 291, 332, 302, 34, 331, 296, 298, 306, 339, 337, 336, 341, 335, 340, 334, 338);
                $search = array_search($idSubseccion, $arraySubseccion, false);
            } elseif ($idDestino == 2) {
                $arraySubseccion = array(0, 200, 344, 313, 301, 200, 297, 296, 300, 293, 311, 35, 38, 310, 200, 34, 15, 37, 354, 306, 14, 39, 308, 13, 320, 341, 340, 200);
                $search = array_search($idSubseccion, $arraySubseccion, false);
            } elseif ($idDestino == 7) {
                $arraySubseccion = array(0, 214, 213, 212, 211, 200, 62, 200, 344, 293, 291, 314, 301, 25, 298, 292, 305, 297, 200, 296, 299, 300, 354, 39, 320, 15, 37, 35, 34, 306, 308, 200, 14, 311, 13, 38);
                $search = array_search($idSubseccion, $arraySubseccion, false);
            }

            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['ID'];
                    $idTarea = $dts['IDTAREA']; //Para las actividades del antiguo planner
                    $actividad = $dts['ACTIVIDAD'];
                    $statusAccion = $dts['STATUS'];
                    $responsable = $dts['IDRESPONSABLE'];
                    $fechaI = $dts['FECHAI'];
                    $fechaFin = $dts['FECHAF'];
                    $fechaRealizacion = $dts['FECHAR'];
                    $realizo = $dts['IDREALIZADO'];
                    $creadoPor = $dts['IDCREADOR'];
                    $idDestinoActividad = $dts['IDDESTINO'];
                    $fechaCreacion = $dts['FECHACR'];
                    $semanaI = $dts['SEMANAI'];
                    $semanaF = $dts['SEMANAF'];
                    $status_default = $dts['STATUS_DEFAULT'];
                    $status_material = $dts['STATUS_MATERIAL'];
                    $status_urgente = $dts['STATUS_URGENTE'];
                    $status_trabajare = $dts['STATUS_TRABAJARE'];
                    $departamento_calidad = $dts['DEPARTAMENTO_CALIDAD'];
                    $departamento_finanzas = $dts['DEPARTAMENTO_FINANZAS'];
                    $departamento_rrhh = $dts['DEPARTAMENTO_RRHH'];
                    $departamento_compras = $dts['DEPARTAMENTO_COMPRAS'];
                    $departamento_direccion = $dts['DEPARTAMENTO_DIRECCION'];
                    $energetico_agua = $dts['ENERGETICO_AGUA'];
                    $energetico_gas = $dts['ENERGETICO_GAS'];
                    $energetico_electricidad = $dts['ENERGETICO_ELECTRICIDAD'];
                    $energetico_diesel = $dts['ENERGETICO_DIESEL'];
                    $des = $dts['DESTINO'];
                    $zona = $dts['ZONA'];

                    //Obtener el nombre del responsable
                    $query = "SELECT t_users.id_colaborador 'IDCOL', "
                        . "t_colaboradores.nombre 'NOMBRE', "
                        . "t_colaboradores.apellido 'APELLIDO' "
                        . "FROM t_users "
                        . "INNER JOIN t_colaboradores "
                        . "ON t_colaboradores.id = t_users.id_colaborador "
                        . "WHERE t_users.id = $responsable";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreR = $dts['NOMBRE'];
                                $apellidoR = $dts['APELLIDO'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    //obtener nombre del creador
                    $query = "SELECT t_users.id_colaborador 'IDCOL', "
                        . "t_colaboradores.nombre 'NOMBRE', "
                        . "t_colaboradores.apellido 'APELLIDO' "
                        . "FROM t_users "
                        . "INNER JOIN t_colaboradores "
                        . "ON t_colaboradores.id = t_users.id_colaborador "
                        . "WHERE t_users.id = $creadoPor";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreC = $dts['NOMBRE'];
                                $apellidoC = $dts['APELLIDO'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroComentarios = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroAdjuntos = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $equipo->correctivos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">"
                        . "<div class=\"column is-half\">"
                        . "<div class=\"columns\">"
                        . "<div class=\"column\">";
                    if ($status == "F") {
                        $equipo->correctivos .= "<div class=\"message is-small is-success\">";
                    } else {
                        $equipo->correctivos .= "<div class=\"message is-small is-danger\">";
                    }
                    if ($status == "N") {
                        $equipo->correctivos .= "<p class=\"message-body\">$status_urgente<strong>" . strtoupper($actividad) . "</strong>";
                    } else {
                        $equipo->correctivos .= "<p class=\"message-body\"><strong>" . strtoupper($actividad) . "</strong>";
                    }
                    if ($creadoPor == 4) {
                        $equipo->correctivos .= "<span><i class=\"fas fa-star-of-life fa-pulse mx-2 has-text-warning fa-lg\"></i>$nombreC $apellidoC</span>";
                    } else {
                        $equipo->correctivos .= "<span><i class=\"fad fa-user-circle mx-2 fa-lg\"></i>$nombreC $apellidoC</span>";
                    }

                    $equipo->correctivos .= "</p>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"column\">"
                        . "<div class=\"columns is-gapless\">"
                        . "<div class=\"column\">";
                    if ($responsable != 0) { //Validar si tiene responsable
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idMC);\">$nombreR $apellidoR</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idMC);\"><i class=\"fad fa-user-slash\"></i></p>";
                    }
                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";

                    setlocale(LC_TIME, "es_ES");
                    if ($fechaI == "") { //Validar si tiene una fecha de inicio
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-mc-fecha'); obtenerFechasMC($idMC);\"><i class=\"fad fa-calendar-times\"></i></p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-mc-fecha'); obtenerFechasMC($idMC);\">" . strftime("%d %b %G", strtotime($fechaI)) . "</p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";

                    if ($numeroAdjuntos > 0) { //Validar si tiene adjuntos
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosMC($idMC)\">$numeroAdjuntos</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosMC($idMC)\"><i class=\"fad fa-file-minus\"></i></p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";
                    if ($numeroComentarios > 0) { //Validar si tiene comentarios
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-comentarios'); obtComentariosMC($idMC);\">$numeroComentarios</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-equipo-comentarios'); obtComentariosMC($idMC);\"><i class=\"fad fa-comment-alt-times\"></i></p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";
                    if ($status == "N") {

                        if ($departamento_calidad != "" || $departamento_finanzas != "" || $departamento_rrhh != "" || $departamento_compras != "" || $departamento_direccion != "") {
                            $departamento = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-primary\">D</strong></span>";
                        } else {
                            $departamento = "";
                        }

                        if ($energetico_agua != "" || $energetico_gas != "" || $energetico_electricidad != "" || $energetico_diesel != "") {
                            $energetico = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-warning\">E</strong></span>";
                        } else {
                            $energetico = "";
                        }

                        if ($status_material != "" || $status_trabajare != "" || $departamento != "" || $energetico != "") {

                            $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"modalStatusMC($idMC, " . $_SESSION["usuario"] . ", 'MCG')\"> $status_material $status_trabajare $departamento $energetico</p>";
                        } else {
                            $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"modalStatusMC($idMC, " . $_SESSION["usuario"] . ", 'MCG')\"><i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i></p>";
                        }
                    } else {
                        $equipo->correctivos .= "<p class=\"t-solucionado\" onclick=\"restaurarMC($idMC, " . $_SESSION["usuario"] . ", 'MCG')\">Restaurar</p>";
                    }
                    $equipo->correctivos .= "</div>";



                    if ($arraySubseccion[$search] == $idSubseccion) { //Opción para Seleccionar la ZONA.

                        if ($zona == "GP") {
                            $checkedGP = "checked";
                        } elseif ($zona == "TRS") {
                            $checkedTRS = "checked";
                        } elseif ($zona == "ZI") {
                            $checkedZI = "checked";
                        } else {
                            $checkedGP = "";
                            $checkedTRS = "";
                            $checkedZI = "";
                        }

                        $equipo->correctivos .= "<div class=\"column\"><p class=\"t-normal m-0 p-0\">
                        <label class=\"radio is-size-7 p-2\">
                        <input type=\"radio\" $checkedGP name=\"$idMC\" onclick=\"zonaMC($idMC, 'GP', 0, 'F', 0);\">
                        GP
                        </label>
                        <label class=\"radio is-size-7\">
                        <input type=\"radio\" $checkedTRS name=\"$idMC\"  onclick=\"zonaMC($idMC, 'TRS', 0, 'F', 0);\">
                        TRS
                        </label>
                        <label class=\"radio is-size-7\">
                        <input type=\"radio\" $checkedZI name=\"$idMC\" onclick=\"zonaMC($idMC, 'ZI', 0, 'F', 0);\">
                        ZI
                        </label>
                        </p></div>";
                        $checkedGP = "";
                        $checkedTRS = "";
                        $checkedZI = "";
                    } else {
                        $equipo->correctivos .= "<div class=\"column\"><p class=\"t-normal\">NA</p></div>";
                    }

                    // Cierre de maquetación de la fila.
                    $equipo->correctivos .= "</div>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->correctivos .= "</section>";

        $conn->cerrar();
        return $equipo;
    }

    public function recargarMCPAPF($idDestino, $idSubseccion, $idCategoria, $idSubcategoria, $status)
    {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');

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

    public function obtDetalleTarea($idTarea)
    {
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

    public function actualizarTarea($idTarea, $titulo)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_mc SET actividad = '$titulo' WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarTarea($idTarea)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_mc SET activo = 0 WHERE id = $idTarea";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function insertarComentario($idTarea, $comentario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function obtenerTimeLine($idTarea)
    {
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

    public function actualizarRangoFechas($idTareas, $fechas)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function buscarUsuarios($idDestino, $palabra, $proyecto)
    {
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

    public function agregarResponsableActividad($idUsuario, $idActividad)
    {
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

    public function completarTarea($idActividad, $status, $idUsuario)
    {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
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

    public function agregarTarea($idEquipo, $actividad, $usuario, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function obtDetalleEquipo($idEquipo)
    {
        $idUsuario = $_SESSION['usuario'];
        $conn = new Conexion();
        $equipo = new DetalleEquipo();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
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
                    $equipo->planeacionMP .= "<div class=\"columns mx-2 my-3 manita is-centered mb-0 pb-0\">"
                        . "<div class=\"column is-2\">"
                        . "</div>"
                        . "<div class=\"columns mt-4\">";
                    for ($i = 1; $i <= 52; $i++) {
                        $equipo->planeacionMP .= "<img class=\"mr-1\" src=\"svg/semanas/s-$i.svg\" width=\"15px\" alt=\"\">";
                    }
                    $equipo->planeacionMP .= "</div>"
                        . "</div>";

                    $query = "SELECT * FROM t_planes_mantto "
                        . "WHERE id_destino = $idDestino "
                        . "AND id_tipo_equipo = $idTipo";
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

                                $equipo->planeacionMP .= "<div class=\"columns mx-2 my-3 manita is-centered\">"
                                    . "<div class=\"column is-2\">"
                                    . "<h6 class=\"title is-6 has-text-right \">$planMantto</h6>"
                                    . "</div>"
                                    . "<div class=\"columns\">";
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

                    //                    OBTENER HISTORIAL DE OT MP
                    $query = "SELECT * FROM t_ordenes_trabajo "
                        . "WHERE id_equipo = $idEquipo AND status = 'F'";
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
                    $pagina = 0;
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

    public function obtCorrectivos($idEquipo, $status)
    {
        $conn = new Conexion();
        $conn->conectar();
        $equipo = new MCMPEquipo();

        //Datos del equipo
        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }


        $equipo->correctivos = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong> CORRECTIVOS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            . "<div class=\"navbar-item\">";
        if ($status == "F") {
            $equipo->correctivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
                . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
        } else {
            $equipo->correctivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
                . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
        }
        $equipo->correctivos .= "</button>"
            . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-mc');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>"
            . "<section class=\"mt-4\">"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-3\">"
            . "<div class=\"field has-addons\">"
            . "<div class=\"control is-expanded\">"
            . "<input id=\"txtTituloTareaMC\" class=\"input\" type=\"text\" placeholder=\"Agregar Nuevo correctivo.\">"
            . "</div>"
            . "<div class=\"control\">"
            . "<a class=\"button is-warning\" onclick=\"agregarTarea($idEquipo);\">"
            . "<i class=\"fad fa-plus-circle\"></i>"
            . "</a>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</section>"
            . "<section class=\"mt-4\">"
            . "<div class=\"columns is-gapless my-1 is-mobile mx-2\">"
            . "<div class=\"column is-half\">"
            . "<div class=\"columns is-mobile\">"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Descripcion\"><strong>Descripcion de los correctivos</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "<div class=\"column is-white\">"
            . "<div class=\"columns is-gapless is-mobile\">"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Responsable\"><strong>Responsable</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Fecha estimada de solucion\"><strong>Fecha</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Documentos e imagenes adjuntoas\"><strong>Adjuntos</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Comentarios\"><strong>Comentarios</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Status\"><strong>Status Correctivo</strong></p>"
            . "</div>"
            . "<div class=\"column\">"
            . "<p class=\"t-titulos\" data-tooltip=\"Status\"><strong>Opción</strong></p>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";

        $query = "SELECT * FROM t_mc "
            . "WHERE id_equipo = $idEquipo "
            . "AND status = '$status' "
            . "AND activo = 1";
        try {

            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idMC = $dts['id'];
                    $idSubseccion = $dts['id_subseccion'];
                    $idDestino = $dts['id_destino'];
                    $actividad = $dts['actividad'];
                    $creadoPor = $dts['creado_por'];
                    $responsable = $dts['responsable'];
                    $fechaI = $dts['fecha_inicio'];
                    $fechaRealizado = $dts['fecha_realizado'];
                    $status_default = $dts['status_default'];
                    $status_material = $dts['status_material'];
                    $status_trabajare = $dts['status_trabajare'];
                    $status_urgente = $dts['status_urgente'];
                    $departamento_calidad = $dts['departamento_calidad'];
                    $departamento_finanzas = $dts['departamento_finanzas'];
                    $departamento_rrhh = $dts['departamento_rrhh'];
                    $departamento_compras = $dts['departamento_compras'];
                    $departamento_direccion = $dts['departamento_direccion'];
                    $energetico_agua = $dts['energetico_agua'];
                    $energetico_gas = $dts['energetico_gas'];
                    $energetico_electricidad = $dts['energetico_electricidad'];
                    $energetico_diesel = $dts['energetico_diesel'];
                    $zona = $dts['zona'];

                    $search = 0;
                    $checkedGP = "";
                    $checkedTRS = "";
                    $checkedZI = "";
                    if ($idDestino == 1) {
                        $araySubseccion = array(308, 14, 300, 293, 320, 313, 297, 200, 38, 13, 35, 14, 15, 200, 1001, 301, 37, 200, 39, 340, 288, 314, 291, 332, 302, 34, 331, 296, 298, 306, 339, 337, 336, 341, 335, 340, 334, 338);
                        // var_export($araySubseccionRM);
                        $search = array_search($idSubseccion, $araySubseccion, false);
                    } elseif ($idDestino == 2) {
                        $araySubseccion = array(0, 200, 344, 313, 301, 200, 297, 296, 300, 293, 311, 35, 38, 310, 200, 34, 15, 37, 354, 306, 14, 39, 308, 13, 320, 341, 340, 200);
                        // var_export($araySubseccionPUJ);
                        $search = array_search($idSubseccion, $araySubseccion, false);
                    } elseif ($idDestino == 7) {
                        $araySubseccion = array(0, 214, 213, 212, 211, 200, 62, 200, 344, 293, 291, 314, 301, 25, 298, 292, 305, 297, 200, 296, 299, 300, 354, 39, 320, 15, 37, 35, 34, 306, 308, 200, 14, 311, 13, 38);
                        // var_export($araySubseccionCMU);
                        $search = array_search($idSubseccion, $araySubseccion, false);
                    }


                    //Obtener el nombre del responsable
                    $query = "SELECT t_users.id_colaborador 'IDCOL', "
                        . "t_colaboradores.nombre 'NOMBRE', "
                        . "t_colaboradores.apellido 'APELLIDO' "
                        . "FROM t_users "
                        . "INNER JOIN t_colaboradores "
                        . "ON t_colaboradores.id = t_users.id_colaborador "
                        . "WHERE t_users.id = $responsable";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreR = $dts['NOMBRE'];
                                $apellidoR = $dts['APELLIDO'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    //obtener nombre del creador
                    $query = "SELECT t_users.id_colaborador 'IDCOL', "
                        . "t_colaboradores.nombre 'NOMBRE', "
                        . "t_colaboradores.apellido 'APELLIDO' "
                        . "FROM t_users "
                        . "INNER JOIN t_colaboradores "
                        . "ON t_colaboradores.id = t_users.id_colaborador "
                        . "WHERE t_users.id = $creadoPor";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreC = $dts['NOMBRE'];
                                $apellidoC = $dts['APELLIDO'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroComentarios = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idMC";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroAdjuntos = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }

                    $equipo->correctivos .= "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">"
                        . "<div class=\"column is-half\">"
                        . "<div class=\"columns\">"
                        . "<div class=\"column\">";
                    if ($status == "F") {
                        $equipo->correctivos .= "<div class=\"message is-small is-success\">";
                    } else {
                        $equipo->correctivos .= "<div class=\"message is-small is-danger\">";
                    }

                    $equipo->correctivos .= "<p class=\"message-body\">$status_urgente<strong>" . strtoupper($actividad) . "</strong>";
                    if ($creadoPor == 4) {
                        $equipo->correctivos .= "<span><i class=\"fas fa-star-of-life fa-pulse mx-2 has-text-warning fa-lg\"></i>$nombreC $apellidoC</span>";
                    } else {
                        $equipo->correctivos .= "<span><i class=\"fad fa-user-circle mx-2 fa-lg\"></i>$nombreC $apellidoC</span>";
                    }

                    $equipo->correctivos .= "</p>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"column\">"
                        . "<div class=\"columns is-gapless\">"
                        . "<div class=\"column\">";
                    if ($responsable != 0) { //Validar si tiene responsable
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idMC);\">$nombreR $apellidoR</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modalAgregarResponsable'); setIdActividad($idMC);\"><i class=\"fad fa-user-slash\"></i></p>";
                    }
                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";

                    setlocale(LC_TIME, "es_ES");
                    if ($fechaI == "") { //Validar si tiene una fecha de inicio
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-mc-fecha'); obtenerFechasMC($idMC);\"><i class=\"fad fa-calendar-times\"></i></p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-mc-fecha'); obtenerFechasMC($idMC);\">" . strftime("%d %b %G", strtotime($fechaI)) . "</p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";

                    if ($numeroAdjuntos > 0) { //Validar si tiene adjuntos
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosMC($idMC)\">$numeroAdjuntos</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-equipo-pictures'); obtenerFotosMC($idMC)\"><i class=\"fad fa-file-minus\"></i></p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";
                    if ($numeroComentarios > 0) { //Validar si tiene comentarios
                        $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"showModal('modal-equipo-comentarios'); obtComentariosMC($idMC);\">$numeroComentarios</p>";
                    } else {
                        $equipo->correctivos .= "<p class=\"t-icono-rojo\" onclick=\"showModal('modal-equipo-comentarios'); obtComentariosMC($idMC);\"><i class=\"fad fa-comment-alt-times\"></i></p>";
                    }

                    $equipo->correctivos .= "</div>"
                        . "<div class=\"column\">";
                    if ($status == "N") {

                        if ($departamento_calidad != "" || $departamento_finanzas != "" || $departamento_rrhh != "" || $departamento_compras != "" || $departamento_direccion != "") {
                            $departamento = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-primary\">D</strong></span>";
                        } else {
                            $departamento = "";
                        }

                        if ($energetico_agua != "" || $energetico_gas != "" || $energetico_electricidad != "" || $energetico_diesel != "") {
                            $energetico = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-warning\">E</strong></span>";
                        } else {
                            $energetico = "";
                        }

                        if ($status_material != "" || $status_trabajare != "" || $departamento != "" || $energetico != "") {
                            $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"modalStatusMC($idMC, " . $_SESSION["usuario"] . ", 'MC')\">$status_material $status_trabajare $departamento $energetico</p>";
                        } else {
                            $equipo->correctivos .= "<p class=\"t-normal\" onclick=\"modalStatusMC($idMC, " . $_SESSION["usuario"] . ", 'MC')\"><i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i></p>";
                        }
                    } else {
                        $equipo->correctivos .= "<p class=\"t-solucionado\" onclick=\"restaurarMC($idMC, " . $_SESSION["usuario"] . ", 'MC')\">Restaurar</p>";
                    }

                    $equipo->correctivos .= "</div>";;

                    if ($araySubseccion[$search] == $idSubseccion) { //Opción para Seleccionar la ZONA.

                        if ($zona == "GP") {
                            $checkedGP = "checked";
                        } elseif ($zona == "TRS") {
                            $checkedTRS = "checked";
                        } elseif ($zona == "ZI") {
                            $checkedZI = "checked";
                        } else {
                            $checkedGP = "";
                            $checkedTRS = "";
                            $checkedZI = "";
                        }

                        $equipo->correctivos .=
                            "
                            <div class=\"column t-normal\">
                            <label class=\"radio is-size-7 p-2\">
                            <input type=\"radio\" $checkedGP name=\"$idMC\" onclick=\"zonaMC($idMC, 'GP', $idEquipo, 'F', $idSubseccion);\">
                            GP
                            </label>
                            <label class=\"radio is-size-7\">
                            <input type=\"radio\" $checkedTRS name=\"$idMC\" onclick=\"zonaMC($idMC, 'TRS', $idEquipo, 'F', $idSubseccion);\">
                            TRS
                            </label>
                            <label class=\"radio is-size-7\">
                            <input type=\"radio\" $checkedZI name=\"$idMC\" onclick=\"zonaMC($idMC, 'ZI', $idEquipo, 'F', $idSubseccion);\">
                            ZI
                            </label>
                            ";
                        $checkedGP = "";
                        $checkedTRS = "";
                        $checkedZI = "";
                    } else {
                        $equipo->correctivos .= "<div class=\"column\"><p class=\"t-normal\">NA</p>";
                    }

                    $equipo->correctivos .= "</div>"

                        . "</div>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->correctivos .= "</section>";

        $conn->cerrar();
        return $equipo;
    }

    public function obtenerComentariosMC($idMC)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT t_mc.actividad 'ACTIVIDAD', "
            . "t_mc.id_seccion 'IDSECCION', "
            . "t_mc.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION'"
            . "FROM t_mc "
            . "INNER JOIN c_secciones ON c_secciones.id = t_mc.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_mc.id_subseccion "
            . "WHERE t_mc.id = $idMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $d) {
                    $actividad = $d['ACTIVIDAD'];
                    $seccion = $d['SECCION'];
                    $subseccion = $d['SUBSECCION'];
                }
            } else {
                $actividad = "";
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }
        $equipo = new ComentariosEquipo();

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($actividad) . " / <strong class=\"ml-1\"> COMENTARIOS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-comentarios');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";
        $equipo->comentariosGenerales = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Comentarios generales</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column\">"
            . "<div class=\"field has-addons has-addons-centered is-fullwidth\">"
            . "<div class=\"control\">"
            . "<div class=\"control has-icons-left has-icons-right\">"
            . "<input id=\"txtComentariosMC\" class=\"input\" type=\"text\" placeholder=\"Añadir comentario\"><span class=\"icon is-small is-left\"><i class=\"fas fa-comment-alt-medical\"></i></span>"
            . "</div>"
            . "</div>"
            . "<div class=\"control\">"
            . "<button type=\"button\" class=\"button is-info\" onclick=\"agregarComentarioMC($idMC);\">Enviar</button>"
            . "</div>"
            . "</div>"
            . "</div>"
            . "</div>";


        $query = "SELECT * FROM t_mc_comentarios WHERE id_mc = $idMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['id_usuario'];

                    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $d) {
                                $idColaborador = $d['id_colaborador'];

                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $d) {
                                            $nombre = $d['nombre'];
                                            $apellido = $d['apellido'];
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
                    $idComentario = $dts['id'];
                    $comentario = $dts['comentario'];
                    $fecha = $dts['fecha'];
                    $equipo->comentariosGenerales .= "<div class=\"timeline-item\">"
                        . "<div class=\"timeline-marker\"></div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\"><strong>$nombre $apellido</strong><button class=\"is-delete is-size-7 manita\" onclick=\"borrarComentariosMC($idComentario, $idMC);\">Borrar</button></p>"
                        . "<p class=\"heading\">$fecha</p>"
                        . "<p class=\"has-text-justified\">$comentario</p>"
                        . "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }


        $equipo->comentariosGenerales .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";

        $conn->cerrar();
        return $equipo;
    }

    public function insertarComentarioMC($idMC, $comentario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
        $fecha = date('Y-m-d H:i:s');
        $idUsuario = $_SESSION['usuario'];

        $query = "INSERT INTO t_mc_comentarios (id_mc, comentario, id_usuario, fecha) "
            . "VALUES($idMC, '$comentario', $idUsuario, '$fecha')";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function borrarComentario($idComentario)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "DELETE FROM t_mc_comentarios WHERE id = $idComentario";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerFotosMC($idMC)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT t_mc.actividad 'ACTIVIDAD', "
            . "t_mc.id_seccion 'IDSECCION', "
            . "t_mc.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION'"
            . "FROM t_mc "
            . "INNER JOIN c_secciones ON c_secciones.id = t_mc.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_mc.id_subseccion "
            . "WHERE t_mc.id = $idMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $d) {
                    $actividad = $d['ACTIVIDAD'];
                    $seccion = $d['SECCION'];
                    $subseccion = $d['SUBSECCION'];
                }
            } else {
                $actividad = "";
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $equipo = new FotosEquipo();

        $equipo->header = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($actividad) . " / <strong class=\"ml-1\"> IMAGENES Y FOTOGRAFIAS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            //                . "<div class=\"navbar-item\">";
            //        if ($status == "F") {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
            //        } else {
            //            $equipo->correctivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
            //        }
            //        $equipo->correctivos .= "</button>"
            //                . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-equipo-pictures');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";

        $equipo->fotosGenerales = "<div class=\"timeline is-left\">"
            . "<h4 class=\"subtitle is-4 has-text-centered\">Fotografias generales</h4>"
            . "<div class=\"columns is-centered\">"
            . "<div class=\"column is-8 has-text-centered\">"
            . "<a class=\"button is-warning\">"
            . "<input class=\"file-input\" type=\"file\" name=\"resume\" id=\"txtFotoMC\" multiple onchange=\"cargarFotosMC($idMC);\">"
            . "<span class=\"icon\">"
            . "<i class=\"fad fa-camera-alt\"></i>"
            . "</span>"
            . "<span>Añadir fotografias</span>"
            . "</a>"
            //                . "<button class=\"button is-warning\">"
            //                . "<span class=\"icon is-small\">"
            //                . "<i class=\"fad fa-camera-alt\"></i>"
            //                . "</span>"
            //                . "<span>Añadir fotografias</span>"
            //                . "</button>"
            . "</div>"
            . "</div>";
        $query = "SELECT * FROM t_mc_adjuntos WHERE id_mc = $idMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['subido_por'];

                    if ($idUsuario != "") {
                        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $d) {
                                    $idColaborador = $d['id_colaborador'];

                                    $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $d) {
                                                $nombre = $d['nombre'];
                                                $apellido = $d['apellido'];
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
                    } else {
                        $nombre = "";
                        $apellido = "";
                    }
                    $idAdjunto = $dts['id'];
                    $urlFoto = $dts['url_adjunto'];
                    $fecha = $dts['fecha'];
                    $equipo->fotosGenerales .= "<div class=\"timeline-item\">"
                        . "<div class=\"timeline-marker\"></div>"
                        . "<div class=\"timeline-content\">"
                        . "<p class=\"heading\"><strong>$nombre $apellido</strong><button class=\"is-delete is-size-7 manita\" onclick=\"borrarFotosMC($idAdjunto, $idMC);\"><a class=\"delete is-medium\"></a></button></p>"
                        . "<p class=\"heading\">$fecha</p>";

                    $file_2 = "../../planner/tareas/adjuntos/$urlFoto";
                    $file_1 = "../planner/tareas/adjuntos/$urlFoto";
                    $tipo = substr(strrchr($urlFoto, "."), 1);

                    if ($tipo == "jpg" || $tipo == "jpeg") {

                        if (file_exists("$file_1")) {
                            $equipo->fotosGenerales .=  "<a href=\"planner/tareas/adjuntos/$urlFoto\" target=\"_BLANCK\"><img class=\"ximg\" src=\"planner/tareas/adjuntos/$urlFoto\" alt=\"\"></a>";
                        } else {
                            $equipo->fotosGenerales .=  "<a href=\"../planner/tareas/adjuntos/$urlFoto\" target=\"_BLANCK\"><img class=\"ximg\" src=\"../planner/tareas/adjuntos/$urlFoto\" alt=\"\"></a>";
                        }
                    } else {
                        if (file_exists("$file_1")) {
                            $equipo->fotosGenerales .=  "<a href=\"planner/tareas/adjuntos/$urlFoto\" target=\"_BLANCK\"><img class=\"ximg\" src=\"svg/formatos/$tipo.svg\" alt=\"\"></a>";
                        } else {
                            $equipo->fotosGenerales .=  "<a href=\"../planner/tareas/adjuntos/$urlFoto\" target=\"_BLANCK\"><img class=\"ximg\" src=\"svg/formatos/$tipo.svg\" alt=\"\"></a>";
                        }
                    }

                    $equipo->fotosGenerales .=
                        "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }
        $equipo->fotosGenerales .= "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker\"></div>"
            . "</div>"
            . "<div class=\"timeline-item\">"
            . "<div class=\"timeline-marker is-icon\">"
            . "<i class=\"fad fa-genderless\"></i>"
            . "</div>"
            . "</div>"
            . "</div>";



        $conn->cerrar();
        return $equipo;
    }

    public function borrarFotoMC($idAdjunto)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_mc_adjuntos WHERE id = $idAdjunto";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $urlAdjunto = $dts['url_adjunto'];
                }
                $query = "DELETE FROM t_mc_adjuntos WHERE id = $idAdjunto";
                try {
                    $resp = $conn->consulta($query);
                    unlink("../planner/tareas/adjuntos/$urlAdjunto");
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            } else {
                $resp = "No existe el archivo";
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }


        $conn->cerrar();
        return $resp;
    }

    public function obtenerFechaMC($idMC)
    {
        $conn = new Conexion();
        $conn->conectar();
        $tarea = new FechasMC();
        $query = "SELECT * FROM t_mc WHERE id = $idMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    if ($dts['fecha_inicio'] != "" && $dts['fecha_fin'] != "") {
                        if ($dts['fecha_inicio'] != "0000-00-00" && $dts['fecha_fin'] != "0000-00-00") {
                            $tarea->fechaInicio = date_format(date_create($dts['fecha_inicio']), "m/d/Y");
                            $tarea->fechaFin = date_format(date_create($dts['fecha_fin']), "m/d/Y");
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $tarea = $ex;
        }
        $conn->cerrar();
        return $tarea;
    }

    public function obtPreventivos($idEquipo)
    {
        $equipo = new MCMPEquipo();
        $idUsuario = $_SESSION['usuario'];
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
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

        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_destino 'IDDESTINO', "
            . "t_equipos.id_tipo 'IDTIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $idDestino = $dts['IDDESTINO'];
                    $idTipo = $dts['IDTIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->preventivos = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong> PREVENTIVOS</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            //                . "<div class=\"navbar-item\">";
            //        if ($status == "F") {
            //            $equipo->preventivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
            //        } else {
            //            $equipo->preventivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
            //        }
            //        $equipo->preventivos .= "</button>"
            //                . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-mp');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";
        //Obtener grafica de planeacion mp
        $equipo->preventivos .= "<div class=\"columns mx-2 my-3 manita is-centered mb-0 pb-0\">"
            . "<div class=\"column is-2\">"
            . "</div>"
            . "<div class=\"columns mt-4\">";
        for ($i = 1; $i <= 52; $i++) {
            $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/semanas/s-$i.svg\" width=\"15px\" alt=\"\">";
        }
        $equipo->preventivos .= "</div>"
            . "</div>";

        $query = "SELECT * FROM t_planes_mantto "
            . "WHERE id_destino = $idDestino "
            . "AND id_tipo_equipo = $idTipo "
            . "AND tipoplan = 'MP'";
        try {
            $planes = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($planes as $p) {
                    $idPlan = $p['id'];
                    $planMantto = $p['nombre'];

                    $query = "SELECT * FROM t_mp_planeacion "
                        . "WHERE id_equipo = $idEquipo "
                        . "AND id_plan = $idPlan "
                        . "AND año = '$año' "
                        . "AND activo = 1";
                    try {
                        $planeacion = $conn->obtDatos($query);
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $equipo->preventivos .= "<div class=\"columns mx-2 my-3 manita is-centered\">"
                        . "<div class=\"column is-2\">"
                        . "<h6 class=\"title is-6 has-text-right \">$planMantto</h6>"
                        . "</div>"
                        . "<div class=\"columns\">";
                    //                                            for ($i = 1; $i <= 52; $i++) {
                    //                                                $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
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
                                        $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion, 'MP');\"";
                                        break;
                                    case 'P':
                                        $colors = "PR.svg";
                                        $bg = 'bg-warning';
                                        $bgbtn = "btn-warning";
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'MP');\"";
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
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'MP');\"";

                                        break;
                                }

                                if ($semanaMP == $i) {
                                    $aux = true;
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
                                } else {
                                    //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                }
                            }
                            if ($aux != true) {
                                if ($idPermiso == 3) {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                } else {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
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
                                        $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion, 'MP');\"";
                                        break;
                                    case 'P':
                                        $colors = "PR.svg";
                                        $bg = 'bg-warning';
                                        $bgbtn = "btn-warning";
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'MP');\"";
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
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'MP');\"";
                                        break;
                                }
                                if ($semanaMP == $i) {
                                    $aux = true;
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
                                } else {
                                    //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                }
                            }
                            if ($aux != true) {
                                if ($idPermiso == 3) {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                } else {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                }
                            }
                        }
                    }
                    $equipo->preventivos .= "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        //Obtener Historico de MP
        $query = "SELECT * FROM t_ordenes_trabajo "
            . "WHERE id_equipo = $idEquipo AND status = 'F'";
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

                    $query = "SELECT tipoplan FROM t_mp_planeacion WHERE id = $idPlaneacion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $d) {
                                $tipoplan = $d['tipoplan'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }
                    if ($tipoplan == "MP") {
                        $equipo->historicoMP .= "<div class=\"timeline-item is-danger\">"
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
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

    public function obtTest($idEquipo)
    {
        $equipo = new MCMPEquipo();
        $idUsuario = $_SESSION['usuario'];
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
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

        $query = "SELECT t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_destino 'IDDESTINO', "
            . "t_equipos.id_tipo 'IDTIPO', "
            . "t_equipos.id_seccion 'IDSECCION', "
            . "t_equipos.id_subseccion 'IDSUBSECCION', "
            . "c_secciones.seccion 'SECCION', "
            . "c_subsecciones.grupo 'SUBSECCION' "
            . "FROM t_equipos "
            . "INNER JOIN c_secciones ON c_secciones.id = t_equipos.id_seccion "
            . "INNER JOIN c_subsecciones ON c_subsecciones.id = t_equipos.id_subseccion "
            . "WHERE t_equipos.id = $idEquipo";

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $equipoNombre = $dts['EQUIPO'];
                    $idDestino = $dts['IDDESTINO'];
                    $idTipo = $dts['IDTIPO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
        }

        $equipo->preventivos = "<section class=\"hero is-light is-small\">"
            . "<div class=\"hero-head\">"
            . "<nav class=\"navbar\">"
            . "<div class=\"navbar-start has-text-centered\">"
            . "<div class=\"navbar-item " . strtolower($seccion) . "-background\">"
            . "<p class=\"seccion-logo\">$seccion</p>"
            . "</div>"
            . "<a class=\"navbar-item\">" . strtoupper($subseccion) . " / " . strtoupper($equipoNombre) . " / <strong> TEST</strong></a>"
            . "</div>"
            . "<div class=\"navbar-end has-text-centered\">"
            //                . "<div class=\"navbar-item\">";
            //        if ($status == "F") {
            //            $equipo->preventivos .= "<button type=\"button\" class=\"button is-danger\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'N');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver pendientes";
            //        } else {
            //            $equipo->preventivos .= "<button type=\"button\" class=\"button is-success\" name=\"button\" onclick=\"obtCorrectivos($idEquipo, 'F');\">"
            //                    . "<i class=\"fad fa-check-double mr-2\"></i></i> Ver solucionado";
            //        }
            //        $equipo->preventivos .= "</button>"
            //                . "</div>"
            . "<div class=\"navbar-item\">"
            . "<button type=\"button\" class=\"button is-warning\" name=\"button\" onclick=\"closeModal('modal-mp');\">"
            . "<i class=\"fas fa-times\"></i>"
            . "</button>"
            . "</div>"
            . "</div>"
            . "</nav>"
            . "</div>"
            . "</section>";
        //Obtener grafica de planeacion mp
        $equipo->preventivos .= "<div class=\"columns mx-2 my-3 manita is-centered mb-0 pb-0\">"
            . "<div class=\"column is-2\">"
            . "</div>"
            . "<div class=\"columns mt-4\">";
        for ($i = 1; $i <= 52; $i++) {
            $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/semanas/s-$i.svg\" width=\"15px\" alt=\"\">";
        }
        $equipo->preventivos .= "</div>"
            . "</div>";

        $query = "SELECT * FROM t_planes_mantto "
            . "WHERE id_destino = $idDestino "
            . "AND id_tipo_equipo = $idTipo "
            . "AND tipoplan = 'TEST'";
        try {
            $planes = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($planes as $p) {
                    $idPlan = $p['id'];
                    $planMantto = $p['nombre'];

                    $query = "SELECT * FROM t_mp_planeacion "
                        . "WHERE id_equipo = $idEquipo "
                        . "AND id_plan = $idPlan "
                        . "AND año = '$año' "
                        . "AND activo = 1";
                    try {
                        $planeacion = $conn->obtDatos($query);
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }

                    $equipo->preventivos .= "<div class=\"columns mx-2 my-3 manita is-centered\">"
                        . "<div class=\"column is-2\">"
                        . "<h6 class=\"title is-6 has-text-right \">$planMantto</h6>"
                        . "</div>"
                        . "<div class=\"columns\">";
                    //                                            for ($i = 1; $i <= 52; $i++) {
                    //                                                $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
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
                                        $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion, 'TEST');\"";
                                        break;
                                    case 'P':
                                        $colors = "PR.svg";
                                        $bg = 'bg-warning';
                                        $bgbtn = "btn-warning";
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'TEST');\"";
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
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'TEST');\"";

                                        break;
                                }

                                if ($semanaMP == $i) {
                                    $aux = true;
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
                                } else {
                                    //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                }
                            }
                            if ($aux != true) {
                                if ($idPermiso == 3) {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                } else {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
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
                                        $action = "onclick=\"mostrarInicioMP(); verDetalleMP($idPlan, $i, '$planMantto', $idPlaneacion, 'TEST');\"";
                                        break;
                                    case 'P':
                                        $colors = "PR.svg";
                                        $bg = 'bg-warning';
                                        $bgbtn = "btn-warning";
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'TEST');\"";
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
                                        $action = "onclick=\"mostrarDetalleOT($idPlaneacion, $idEquipo, 'TEST');\"";
                                        break;
                                }
                                if ($semanaMP == $i) {
                                    $aux = true;
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/$colors\" width=\"15px\" alt=\"\" $action>";
                                } else {
                                    //$salida .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestino, $idSubseccion);\"></td>";
                                }
                            }
                            if ($aux != true) {
                                if ($idPermiso == 3) {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\" onclick=\"agregarMP($idEquipo, $idPlan, $i, $idDestinoEquipo, $idSubseccionEq);\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                } else {
                                    $equipo->preventivos .= "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" alt=\"\">";
                                    //                                                                $equipo->graficaGant .= "<td class=\"manita\"><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                }
                            }
                        }
                    }
                    $equipo->preventivos .= "</div>"
                        . "</div>";
                }
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        //Obtener Historico de MP
        $query = "SELECT * FROM t_ordenes_trabajo "
            . "WHERE id_equipo = $idEquipo AND status = 'F'";
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

                    $query = "SELECT tipoplan FROM t_mp_planeacion WHERE id = $idPlaneacion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $d) {
                                $tipoplan = $d['tipoplan'];
                            }
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                        exit($ex);
                    }
                    if ($tipoplan == "TEST") {
                        $equipo->historicoMP .= "<div class=\"timeline-item is-danger\">"
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
            }
        } catch (Exception $ex) {
            $equipo = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $equipo;
    }

    public function recargarMCEq($idEquipo, $status)
    {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');

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

    public function obtDetallePlan($idPlan)
    {
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

    public function obtDetalleOT($idPlaneacion, $idEquipo)
    {
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

    public function insertarComentarioOT($idOT, $comentario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function obtenerTimeLineOT($idOT)
    {
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

    public function cerrarOT($idOT, $realizadoPor, $fechaRealizado, $lstActividades)
    {
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

    public function agregarProyecto($idDestino, $idSeccion, $idSubseccion, $tituloProyecto, $justificacion, $tipoProyecto, $coste, $año, $fileName)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function obtenerDetalleProyecto($idProyecto)
    {
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
                        // $equipo->planMC = $ex; Error
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

    public function agregarActividadProyecto($idProyecto, $actividad, $usuario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function agregarComentariosProy($idActividad, $idUsuario, $comentario)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
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

    public function cambiarTipoProyecto($idProyecto, $tipo)
    {
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

    public function actualizarDatosProyecto($idProyecto, $titulo, $justificacion, $año, $coste)
    {
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

    public function agregarResponsableActividadProyecto($idUsuario, $idActividad)
    {
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

    public function recargarPAProyecto($idProyecto, $status)
    {
        $salida = "";
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');

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
                        // $equipo->planMC = $ex;
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

    public function completarTareaProyecto($idActividad, $status, $idUsuario)
    {
        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
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

    public function completarProyecto($idProyecto, $status)
    {
        $conn = new Conexion();
        $conn->conectar();

        $idUsuario = $_SESSION['usuario'];
        date_default_timezone_set('America/Cancun');
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

    public function eliminarActividadProyecto($idActividad)
    {
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

    public function eliminarAdjuntoProyecto($idAdjunto, $tipo)
    {
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

    public function obtenerComentariosActividad($idActividad)
    {
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

    public function buscarMC($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado)
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        date_default_timezone_set('America/Cancun');
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

    public function buscarEquipos($idSeccion, $idSubseccion)
    {
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

    public function buscarOTS($idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $status)
    {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "";

        date_default_timezone_set('America/Cancun');
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

    public function buscarMisPendientes($idUsuario, $idSeccion, $idSubseccion, $idEquipo, $fechaI, $fechaF, $estado)
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        date_default_timezone_set('America/Cancun');
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

//    public function mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion) {
//        $salida = "";
//        $lstSecciones = [];
//        if (isset($_SESSION['idDestino'])) {
//            $idDestino = $_SESSION['idDestino'];
//        } else {
//            $idDestino = 10;
//        }
//
//        $conn = new Conexion();
//        $conn->conectar();
//
//        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
//        try {
//            $out = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($out as $s) {
//                    $destino = $s['destino'];
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $query = "SELECT seccion, titulo_seccion, url_image, url_video FROM c_secciones WHERE id = $idSeccionTarea";
//        try {
//            $resp = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($resp as $dts) {
//                    $nombreSeccion = $dts['seccion'];
//                    $tituloSeccion = $dts['titulo_seccion'];
//                    $urlImage = $dts['url_image'];
//                    $urlVideo = $dts['url_video'];
//                }
//            } else {
//                $tituloSeccion = "";
//                $urlImage = "";
//                $urlVideo = "";
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $numeroTotalPendientes = 0;
//        $numeroTotalSolucionadas = 0;
//        $numeroTotalNuevos = 0;
//        $numeroFinalizadas = 0;
//        $fecHoy = date("Y-m-d");
//        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));
//
//        //obtener el numero total de tareas pendientes y solucionadas
//        if ($idDestino == 10) {
//            $query = "SELECT status FROM t_mc WHERE id_seccion = $idSeccionTarea AND activo = 1";
//        } else {
//            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
//        }
//
//        try {
//            $tasks = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($tasks as $t) {
//                    $statusTask = $t['status'];
//                    if ($statusTask == "N") {
//                        $numeroTotalPendientes += 1;
//                    } else if ($statusTask == "F") {
//                        $numeroTotalSolucionadas += 1;
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        if ($idDestino == 10) {
//            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_seccion = $idSeccionTarea AND activo = 1";
//        } else {
//            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
//        }
//
//        try {
//            $tasks = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($tasks as $t) {
//                    $statusTask = $t['status'];
//                    if ($statusTask == "N") {
//                        $numeroTotalNuevos += 1;
//                    } else if ($statusTask == "F") {
//                        $numeroFinalizadas += 1;
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $salida .= "<div class=\"column is-3 has-text-centered mr-5\">"
//                . "<img src=\"svg/secciones/$urlImage\" class=\"mb-4\" width=\"40px\" alt=\"\">"
//                . "<div class=\"columnaTarea\">";
//
//        //Se buscan las subsecciones que esten asociadas a la seccion segun el destino
//        if ($idDestino == 10) {
//            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_seccion = $idSeccionTarea";
//        } else {
//            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea";
//        }
//
//        try {
//            $resp = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($resp as $dts) {
//                    $idRelDestSecc = $dts['id'];
//                }
//                $query = "SELECT id, id_subseccion FROM c_rel_seccion_subseccion WHERE id_rel_seccion = $idRelDestSecc";
//                try {
//                    $rels = $conn->obtDatos($query);
//                    if ($conn->filasConsultadas > 0) {
//                        foreach ($rels as $d) {
//                            $idRelSubseccionCat = $d['id'];
//                            $idSubseccion = $d['id_subseccion'];
//                            $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
//                            try {
//                                $resp = $conn->obtDatos($query);
//                                if ($conn->filasConsultadas > 0) {
//                                    foreach ($resp as $dts) {
//                                        $nombreSubsecion = $dts['grupo'];
//                                    }
//                                }
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//                            //Agregar las subsecciones a un arreglo para ordenarlos por orden alfabetico
//                            $subSeccion = ["idSubseccion" => $idSubseccion, "nombreSubseccion" => $nombreSubsecion, "idRelSubseccionCat" => $idRelSubseccionCat];
//                            $lstSecciones[] = $subSeccion;
//                        }
//                    }
//                } catch (Exception $ex) {
//                    $salida = $ex;
//                }
//
//                foreach ($lstSecciones as $key => $row) {
//                    $aux[$key] = $row['nombreSubseccion'];
//                }
//                if (count($lstSecciones) > 0 && count($aux) > 0) {
//                    array_multisort($aux, SORT_ASC, $lstSecciones);
//                    foreach ($lstSecciones as $subseccion) {
//                        $idRelSubseccionCat = $subseccion['idRelSubseccionCat'];
//                        $query = "SELECT id, grupo FROM c_subsecciones WHERE id = " . $subseccion['idSubseccion'] . "";
//                        try {
//                            $resultsSS = $conn->obtDatos($query);
//                            if ($conn->filasConsultadas > 0) {
//                                foreach ($resultsSS as $ss) {
//                                    $idSubseccion = $ss['id'];
//                                    $nombreSubseccion = $ss['grupo'];
//                                }
//                            }
//                        } catch (Exception $ex) {
//                            $salida = $ex;
//                        }
//
//                        //obtener total de tareas pendientes por subseccion
//                        if ($idDestino == 10) {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 "
//                                    . "AND status = 'N'";
//                        } else {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_destino = $idDestino "
//                                    . "AND id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 "
//                                    . "AND status = 'N'";
//                        }
//
//                        try {
//                            $resp = $conn->obtDatos($query);
//                            $penSubseccion = $conn->filasConsultadas;
//                        } catch (Exception $ex) {
//                            echo $ex;
//                        }
//
//                        //obtener total de tareas solucionadas por subseccion
//                        if ($idDestino == 10) {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 AND status = 'F'";
//                        } else {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_destino = $idDestino "
//                                    . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                        }
//
//                        try {
//                            $resp = $conn->obtDatos($query);
//                            $solSubseccion = $conn->filasConsultadas;
//                        } catch (Exception $ex) {
//                            echo $ex;
//                        }
//
//                        //********SECCION PROYECTOS************
//                        if ($nombreSubseccion == "PROYECTOS") {//Si la subseccion son los proyectos
//                            if ($idDestino == 10) {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
//                            } else {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_destino = $idDestino "
//                                        . "AND id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
//                            }
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                $totalProys = $conn->filasConsultadas;
//                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//
//                            if ($idDestino == 10) {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                            } else {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_destino = $idDestino "
//                                        . "AND id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                            }
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                $totalProysF = $conn->filasConsultadas;
//                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//
//                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
//                                    //Titulo de la subseccion
//                                    . "<div class=\"column has-text-left is-8 pad-03 manita\">"
//                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
//                                    . "</div>"
//                                    //Contador de tareas
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($totalProysF > 0) {
//                                $salida .= "<span class=\"tag is-success fs-10\">";
//                                $numeroDigitos = strlen($totalProysF);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $totalProysF;
//                                } else {
//                                    $salida .= "0$totalProysF";
//                                }
//                                $salida .= "</span>";
//                            }
//
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($totalProys > 0) {
//                                $salida .= "<span class=\"tag is-danger fs-10\">";
//                                $numeroDigitos = strlen($totalProys);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $totalProys;
//                                } else {
//                                    $salida .= "0$totalProys";
//                                }
//                                $salida .= "</span>";
//                            }
//
//                            $salida .= "</div>"
//                                    . "</div>"//Fin del contador de tareas
//                                    . "</div>";
//                            //Seccion del collapse
//                            //*******LISTADO DE LOS PROYECTOS*********
//                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
//                                    . "<div class=\"columns is-mobile mb-2\">"
//                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
//                                    . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
//                                    . "</div>"
//                                    . "</div>";
//                            if ($idDestino == 10) {
//                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
//                            } else {
//                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
//                            }
//
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                if ($conn->filasConsultadas > 0) {
//                                    foreach ($proyectos as $pr) {
//                                        $idProyecto = $pr['id'];
//                                        $tituloProyecto = $pr['titulo'];
//                                        $tipoProyecto = $pr['tipo'];
//                                        $idDestinoProyecto = $pr['id_destino'];
//
//                                        $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
//                                        try {
//                                            $out = $conn->obtDatos($query);
//                                            if ($conn->filasConsultadas > 0) {
//                                                foreach ($out as $s) {
//                                                    $destinoProy = $s['destino'];
//                                                }
//                                            }
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//                                        if ($tipoProyecto == "CAPEX") {
//                                            $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
//                                        } else if ($tipoProyecto == "CAPIN") {
//                                            $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
//                                        } else {
//                                            $imgTipo = "";
//                                        }
//
//                                        $query = "SELECT id FROM t_proyectos_planaccion "
//                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
//                                        try {
//                                            $resp = $conn->obtDatos($query);
//                                            $totalPA = $conn->filasConsultadas;
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//                                        $query = "SELECT id FROM t_proyectos_planaccion "
//                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'F'";
//                                        try {
//                                            $resp = $conn->obtDatos($query);
//                                            $totalPAF = $conn->filasConsultadas;
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//
//                                        $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
//                                                . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
//                                                . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
//                                                . "</div>"
//                                                . "<div class=\"column is-1 pad-03\">"
//                                                . "<div class=\"tags has-addons\">";
//                                        if ($totalPAF > 0) {
//                                            $salida .= "<span class=\"tag is-success fs-10\">";
//                                            $numeroDigitos = strlen($totalPAF);
//                                            if ($numeroDigitos > 1) {
//                                                $salida .= $totalPAF;
//                                            } else {
//                                                $salida .= "0$totalPAF";
//                                            }
//                                            $salida .= "</span>";
//                                        }
//                                        $salida .= "</div>"
//                                                . "</div>"
//                                                . "<div class=\"column is-1 pad-03\">"
//                                                . "<div class=\"tags has-addons\">";
//                                        if ($totalPA > 0) {
//                                            $salida .= "<span class=\"tag is-danger fs-10\">";
//                                            $numeroDigitos = strlen($totalPA);
//                                            if ($numeroDigitos > 1) {
//                                                $salida .= $totalPA;
//                                            } else {
//                                                $salida .= "0$totalPA";
//                                            }
//                                            $salida .= "</span>";
//                                        }
//                                        $salida .= "</div>"
//                                                . "</div>"
//                                                . "</div>";
//                                    }
//                                }
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//                            $salida .= "</div>";
//                        }
//                        //******** RESTO DE LAS SECCIONES **********
//                        else {//Las demas subsecciones
//                            $salida .= "<div class=\"columns is-mobile mb-2 \">";
//                            if ($idSubseccion == 12 || $idSubseccion == 342 || $idSubseccion == 343 || $idSubseccion == 344) {
//                                $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('hoteles', $idDestino, $idSubseccion, 1);\">";
//                            } else {
//                                $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, 1, 0, 0, 1);\">";
//                            }
//
//                            $salida .= "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($solSubseccion > 0) {
//                                $salida .= "<span class=\"tag is-success fs-10\">";
//                                $numeroDigitos = strlen($solSubseccion);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $solSubseccion;
//                                } else {
//                                    $salida .= "0$solSubseccion";
//                                }
//                                $salida .= "</span>";
//                            }
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($penSubseccion > 0) {
//                                $salida .= "<span class=\"tag is-danger fs-10\">";
//                                $numeroDigitos = strlen($penSubseccion);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $penSubseccion;
//                                } else {
//                                    $salida .= "0$penSubseccion";
//                                }
//                                $salida .= "</span>";
//                            }
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "</div>";
//                        }
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $salida .= "</div>"
//                . "</div>";
//
//        $conn->cerrar();
//        return $salida;
//    }
//
//    public function mostrarCols2($idUsuario, $idSeccionTarea, $fotoSeccion) {
//        $salida = "";
//        $lstSecciones = [];
//        if (isset($_SESSION['idDestino'])) {
//            $idDestino = $_SESSION['idDestino'];
//        } else {
//            $idDestino = 10;
//        }
//
//        $conn = new Conexion();
//        $conn->conectar();
//
//        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
//        try {
//            $out = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($out as $s) {
//                    $destino = $s['destino'];
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $query = "SELECT seccion, titulo_seccion, url_image, url_video FROM c_secciones WHERE id = $idSeccionTarea";
//        try {
//            $resp = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($resp as $dts) {
//                    $nombreSeccion = $dts['seccion'];
//                    $tituloSeccion = $dts['titulo_seccion'];
//                    $urlImage = $dts['url_image'];
//                    $urlVideo = $dts['url_video'];
//                }
//            } else {
//                $tituloSeccion = "";
//                $urlImage = "";
//                $urlVideo = "";
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $numeroTotalPendientes = 0;
//        $numeroTotalSolucionadas = 0;
//        $numeroTotalNuevos = 0;
//        $numeroFinalizadas = 0;
//        $fecHoy = date("Y-m-d");
//        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));
//
//        //obtener el numero total de tareas pendientes y solucionadas
//        if ($idDestino == 10) {
//            $query = "SELECT status FROM t_mc WHERE id_seccion = $idSeccionTarea AND activo = 1";
//        } else {
//            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
//        }
//
//        try {
//            $tasks = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($tasks as $t) {
//                    $statusTask = $t['status'];
//                    if ($statusTask == "N") {
//                        $numeroTotalPendientes += 1;
//                    } else if ($statusTask == "F") {
//                        $numeroTotalSolucionadas += 1;
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        if ($idDestino == 10) {
//            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_seccion = $idSeccionTarea AND activo = 1";
//        } else {
//            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
//        }
//
//        try {
//            $tasks = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($tasks as $t) {
//                    $statusTask = $t['status'];
//                    if ($statusTask == "N") {
//                        $numeroTotalNuevos += 1;
//                    } else if ($statusTask == "F") {
//                        $numeroFinalizadas += 1;
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $salida .= "<div class=\"column is-3 has-text-centered mr-5\">"
//                . "<img src=\"svg/secciones/$urlImage\" class=\"mb-4\" width=\"40px\" alt=\"\">"
//                . "<div class=\"columnaTarea\">";
//
//        //Se buscan las subsecciones que esten asociadas a la seccion segun el destino
//        if ($idDestino == 10) {
//            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_seccion = $idSeccionTarea";
//        } else {
//            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea";
//        }
//
//        try {
//            $resp = $conn->obtDatos($query);
//            if ($conn->filasConsultadas > 0) {
//                foreach ($resp as $dts) {
//                    $idRelDestSecc = $dts['id'];
//                }
//                $query = "SELECT id, id_subseccion FROM c_rel_seccion_subseccion WHERE id_rel_seccion = $idRelDestSecc";
//                try {
//                    $rels = $conn->obtDatos($query);
//                    if ($conn->filasConsultadas > 0) {
//                        foreach ($rels as $d) {
//                            $idRelSubseccionCat = $d['id'];
//                            $idSubseccion = $d['id_subseccion'];
//                            $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
//                            try {
//                                $resp = $conn->obtDatos($query);
//                                if ($conn->filasConsultadas > 0) {
//                                    foreach ($resp as $dts) {
//                                        $nombreSubsecion = $dts['grupo'];
//                                    }
//                                }
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//                            //Agregar las subsecciones a un arreglo para ordenarlos por orden alfabetico
//                            $subSeccion = ["idSubseccion" => $idSubseccion, "nombreSubseccion" => $nombreSubsecion, "idRelSubseccionCat" => $idRelSubseccionCat];
//                            $lstSecciones[] = $subSeccion;
//                        }
//                    }
//                } catch (Exception $ex) {
//                    $salida = $ex;
//                }
//
//                foreach ($lstSecciones as $key => $row) {
//                    $aux[$key] = $row['nombreSubseccion'];
//                }
//                if (count($lstSecciones) > 0 && count($aux) > 0) {
//                    array_multisort($aux, SORT_ASC, $lstSecciones);
//                    foreach ($lstSecciones as $subseccion) {
//                        $idRelSubseccionCat = $subseccion['idRelSubseccionCat'];
//                        $query = "SELECT id, grupo FROM c_subsecciones WHERE id = " . $subseccion['idSubseccion'] . "";
//                        try {
//                            $resultsSS = $conn->obtDatos($query);
//                            if ($conn->filasConsultadas > 0) {
//                                foreach ($resultsSS as $ss) {
//                                    $idSubseccion = $ss['id'];
//                                    $nombreSubseccion = $ss['grupo'];
//                                }
//                            }
//                        } catch (Exception $ex) {
//                            $salida = $ex;
//                        }
//
//                        //obtener total de tareas pendientes por subseccion
//                        if ($idDestino == 10) {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 "
//                                    . "AND status = 'N'";
//                        } else {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_destino = $idDestino "
//                                    . "AND id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 "
//                                    . "AND status = 'N'";
//                        }
//
//                        try {
//                            $resp = $conn->obtDatos($query);
//                            $penSubseccion = $conn->filasConsultadas;
//                        } catch (Exception $ex) {
//                            echo $ex;
//                        }
//
//                        //obtener total de tareas solucionadas por subseccion
//                        if ($idDestino == 10) {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_subseccion = $idSubseccion "
//                                    . "AND activo = 1 AND status = 'F'";
//                        } else {
//                            $query = "SELECT id FROM t_mc "
//                                    . "WHERE id_destino = $idDestino "
//                                    . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                        }
//
//                        try {
//                            $resp = $conn->obtDatos($query);
//                            $solSubseccion = $conn->filasConsultadas;
//                        } catch (Exception $ex) {
//                            echo $ex;
//                        }
//
//                        //********SECCION PROYECTOS************
//                        if ($nombreSubseccion == "PROYECTOS") {//Si la subseccion son los proyectos
//                            if ($idDestino == 10) {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
//                            } else {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_destino = $idDestino "
//                                        . "AND id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
//                            }
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                $totalProys = $conn->filasConsultadas;
//                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//
//                            if ($idDestino == 10) {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                            } else {
//                                $query = "SELECT id FROM t_proyectos "
//                                        . "WHERE id_destino = $idDestino "
//                                        . "AND id_seccion = $idSeccionTarea "
//                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
//                            }
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                $totalProysF = $conn->filasConsultadas;
//                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//
//                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
//                                    //Titulo de la subseccion
//                                    . "<div class=\"column has-text-left is-8 pad-03 manita\">"
//                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
//                                    . "</div>"
//                                    //Contador de tareas
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($totalProysF > 0) {
//                                $salida .= "<span class=\"tag is-success fs-10\">";
//                                $numeroDigitos = strlen($totalProysF);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $totalProysF;
//                                } else {
//                                    $salida .= "0$totalProysF";
//                                }
//                                $salida .= "</span>";
//                            }
//
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($totalProys > 0) {
//                                $salida .= "<span class=\"tag is-danger fs-10\">";
//                                $numeroDigitos = strlen($totalProys);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $totalProys;
//                                } else {
//                                    $salida .= "0$totalProys";
//                                }
//                                $salida .= "</span>";
//                            }
//
//                            $salida .= "</div>"
//                                    . "</div>"//Fin del contador de tareas
//                                    . "</div>";
//                            //Seccion del collapse
//                            //*******LISTADO DE LOS PROYECTOS*********
//                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
//                                    . "<div class=\"columns is-mobile mb-2\">"
//                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
//                                    . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
//                                    . "</div>"
//                                    . "</div>";
//                            if ($idDestino == 10) {
//                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
//                            } else {
//                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
//                            }
//
//                            try {
//                                $proyectos = $conn->obtDatos($query);
//                                if ($conn->filasConsultadas > 0) {
//                                    foreach ($proyectos as $pr) {
//                                        $idProyecto = $pr['id'];
//                                        $tituloProyecto = $pr['titulo'];
//                                        $tipoProyecto = $pr['tipo'];
//                                        $idDestinoProyecto = $pr['id_destino'];
//
//                                        $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
//                                        try {
//                                            $out = $conn->obtDatos($query);
//                                            if ($conn->filasConsultadas > 0) {
//                                                foreach ($out as $s) {
//                                                    $destinoProy = $s['destino'];
//                                                }
//                                            }
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//                                        if ($tipoProyecto == "CAPEX") {
//                                            $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
//                                        } else if ($tipoProyecto == "CAPIN") {
//                                            $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
//                                        } else {
//                                            $imgTipo = "";
//                                        }
//
//                                        $query = "SELECT id FROM t_proyectos_planaccion "
//                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
//                                        try {
//                                            $resp = $conn->obtDatos($query);
//                                            $totalPA = $conn->filasConsultadas;
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//                                        $query = "SELECT id FROM t_proyectos_planaccion "
//                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'F'";
//                                        try {
//                                            $resp = $conn->obtDatos($query);
//                                            $totalPAF = $conn->filasConsultadas;
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//
//                                        $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
//                                                . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
//                                                . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
//                                                . "</div>"
//                                                . "<div class=\"column is-1 pad-03\">"
//                                                . "<div class=\"tags has-addons\">";
//                                        if ($totalPAF > 0) {
//                                            $salida .= "<span class=\"tag is-success fs-10\">";
//                                            $numeroDigitos = strlen($totalPAF);
//                                            if ($numeroDigitos > 1) {
//                                                $salida .= $totalPAF;
//                                            } else {
//                                                $salida .= "0$totalPAF";
//                                            }
//                                            $salida .= "</span>";
//                                        }
//                                        $salida .= "</div>"
//                                                . "</div>"
//                                                . "<div class=\"column is-1 pad-03\">"
//                                                . "<div class=\"tags has-addons\">";
//                                        if ($totalPA > 0) {
//                                            $salida .= "<span class=\"tag is-danger fs-10\">";
//                                            $numeroDigitos = strlen($totalPA);
//                                            if ($numeroDigitos > 1) {
//                                                $salida .= $totalPA;
//                                            } else {
//                                                $salida .= "0$totalPA";
//                                            }
//                                            $salida .= "</span>";
//                                        }
//                                        $salida .= "</div>"
//                                                . "</div>"
//                                                . "</div>";
//                                    }
//                                }
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//                            $salida .= "</div>";
//                        }
//                        //******** RESTO DE LAS SECCIONES **********
//                        else {//Las demas subsecciones
//                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\" >"
//                                    . "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\">"
//                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($solSubseccion > 0) {
//                                $salida .= "<span class=\"tag is-success fs-10\">";
//                                $numeroDigitos = strlen($solSubseccion);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $solSubseccion;
//                                } else {
//                                    $salida .= "0$solSubseccion";
//                                }
//                                $salida .= "</span>";
//                            }
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "<div class=\"column is-1 pad-03\">"
//                                    . "<div class=\"tags has-addons\">";
//                            if ($penSubseccion > 0) {
//                                $salida .= "<span class=\"tag is-danger fs-10\">";
//                                $numeroDigitos = strlen($penSubseccion);
//                                if ($numeroDigitos > 1) {
//                                    $salida .= $penSubseccion;
//                                } else {
//                                    $salida .= "0$penSubseccion";
//                                }
//                                $salida .= "</span>";
//                            }
//                            $salida .= "</div>"
//                                    . "</div>"
//                                    . "</div>";
//
//                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">";
//                            $query = "SELECT id, id_categoria FROM c_rel_subseccion_categoria WHERE id_rel_subseccion = $idRelSubseccionCat";
//
//                            try {
//                                $relcategorias = $conn->obtDatos($query);
//                                if ($conn->filasConsultadas > 0) {
//                                    foreach ($relcategorias as $c) {
//                                        $idRelSubcategoria = $c['id'];
//                                        $idCategoria = $c['id_categoria'];
//
//                                        $query = "SELECT categoria, equipos FROM c_categorias_planner WHERE id = $idCategoria";
//                                        try {
//                                            $cats = $conn->obtDatos($query);
//                                            if ($conn->filasConsultadas > 0) {
//                                                foreach ($cats as $cc) {
//                                                    $nombreCategoria = $cc['categoria'];
//                                                    $verEquipos = $cc['equipos'];
//                                                }
//                                            }
//                                        } catch (Exception $ex) {
//                                            $salida = $ex;
//                                        }
//
//                                        //*************PREVENTIVO CORRECTIVO Y EQUIPOS****************
//                                        if ($nombreCategoria == "MP/MC - EQUIPOS") {//Equipos y tareas
//                                            //obtener total por categoria
//                                            if ($idDestino == 10) {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_subseccion = $idSubseccion "
//                                                        //. "AND id_categoria = $idCategoria "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'N'";
//                                            } else {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_destino = $idDestino "
//                                                        . "AND id_subseccion = $idSubseccion "
//                                                        //. "AND id_categoria = $idCategoria "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'N'";
//                                            }
//                                            try {
//                                                $resp = $conn->obtDatos($query);
//                                                $penCategoria = $conn->filasConsultadas;
//                                            } catch (Exception $ex) {
//                                                echo $ex;
//                                            }
//
//                                            if ($idDestino == 10) {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_subseccion = $idSubseccion "
//                                                        //. "AND id_categoria = $idCategoria "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'F'";
//                                            } else {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_destino = $idDestino "
//                                                        . "AND id_subseccion = $idSubseccion "
//                                                        //. "AND id_categoria = $idCategoria "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'F'";
//                                            }
//                                            try {
//                                                $resp = $conn->obtDatos($query);
//                                                $solCategoria = $conn->filasConsultadas;
//                                            } catch (Exception $ex) {
//                                                echo $ex;
//                                            }
//
////                                            //obtener total de tareas generales
////                                            if ($idDestino == 10) {
////                                                $query = "SELECT id FROM t_mc "
////                                                        . "WHERE id_subseccion = $idSubseccion "
////                                                        . "AND id_categoria = 6 "
////                                                        . "AND activo = 1 "
////                                                        . "AND status = 'N'";
////                                            } else {
////                                                $query = "SELECT id FROM t_mc "
////                                                        . "WHERE id_destino = $idDestino "
////                                                        . "AND id_subseccion = $idSubseccion "
////                                                        . "AND id_categoria = 6 "
////                                                        . "AND activo = 1 "
////                                                        . "AND status = 'N'";
////                                            }
////                                            try {
////                                                $resp = $conn->obtDatos($query);
////                                                $totalTareas = $conn->filasConsultadas;
////                                            } catch (Exception $ex) {
////                                                echo $ex;
////                                            }
//                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
//                                            try {
//                                                $result = $conn->obtDatos($query);
//                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
//                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
//                                                    if ($verEquipos == 1) {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    } else {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    }
//
//
//                                                    $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
//
//
//                                                    $salida .= "</div>"
//                                                            . "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($solCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-success fs-10\">";
//                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($solCategoria);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $solCategoria;
//                                                        } else {
//                                                            $salida .= "0$solCategoria";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($penCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-danger fs-10\">";
//                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($penCategoria);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $penCategoria;
//                                                        } else {
//                                                            $salida .= "0$penCategoria";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "</div>"
//                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
//                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
//                                                    try {
//                                                        $relSC = $conn->obtDatos($query);
//                                                        if ($conn->filasConsultadas > 0) {
//                                                            foreach ($relSC as $sc) {
//                                                                $idRelCatSubcat = $sc['id'];
//                                                                $idSubcategoria = $sc['id_subcategoria'];
//
//                                                                $query = "SELECT subcategoria, equipos FROM c_subcategorias_planner WHERE id = $idSubcategoria";
//                                                                try {
//                                                                    $subcategorias = $conn->obtDatos($query);
//                                                                    if ($conn->filasConsultadas > 0) {
//                                                                        foreach ($subcategorias as $scs) {
//                                                                            $nombreSubcategoria = $scs['subcategoria'];
//                                                                            $verEquipo = $scs['equipos'];
//                                                                        }
//                                                                    }
//                                                                } catch (Exception $ex) {
//                                                                    $salida = $ex;
//                                                                }
//
//                                                                //Obtener pendientes po subcategoria
//                                                                if ($idDestino == 10) {
//                                                                    $query = "SELECT id FROM t_mc "
//                                                                            . "WHERE id_subseccion = $idSubseccion "
//                                                                            . "AND id_subcategoria = $idSubcategoria "
//                                                                            . "AND activo = 1 "
//                                                                            . "AND status = 'N'";
//                                                                } else {
//                                                                    $query = "SELECT id FROM t_mc "
//                                                                            . "WHERE id_destino = $idDestino "
//                                                                            . "AND id_subseccion = $idSubseccion "
//                                                                            . "AND id_subcategoria = $idSubcategoria "
//                                                                            . "AND activo = 1 AND status = 'N'";
//                                                                }
//                                                                try {
//                                                                    $resp = $conn->obtDatos($query);
//                                                                    $penSubcategoria = $conn->filasConsultadas;
//                                                                } catch (Exception $ex) {
//                                                                    $salida = $ex;
//                                                                }
//
//                                                                if ($idDestino == 10) {
//                                                                    $query = "SELECT id FROM t_mc "
//                                                                            . "WHERE id_subseccion = $idSubseccion "
//                                                                            . "AND id_subcategoria = $idSubcategoria "
//                                                                            . "AND activo = 1 "
//                                                                            . "AND status = 'F'";
//                                                                } else {
//                                                                    $query = "SELECT id FROM t_mc "
//                                                                            . "WHERE id_destino = $idDestino "
//                                                                            . "AND id_subseccion = $idSubseccion "
//                                                                            . "AND id_subcategoria = $idSubcategoria "
//                                                                            . "AND activo = 1 "
//                                                                            . "AND status = 'F'";
//                                                                }
//                                                                try {
//                                                                    $resp = $conn->obtDatos($query);
//                                                                    $solSubcategoria = $conn->filasConsultadas;
//                                                                } catch (Exception $ex) {
//                                                                    $salida = $ex;
//                                                                }
//
//                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
//                                                                if ($verEquipos == 1) {
//                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                                } else {
//                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                                }
//
//
//                                                                $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span>" . strtoupper($nombreSubcategoria) . "</h1>";
//
//
//                                                                $salida .= "</div>"
//                                                                        . "<div class=\"column is-1 pad-03\">"
//                                                                        . "<div class=\"tags has-addons\">";
//                                                                if ($solSubcategoria > 0) {
//                                                                    $salida .= "<span class=\"tag is-success fs-10\">";
//                                                                    //$totalTareasGrales = $penSubcategoria + $totalTareas;
//                                                                    $numeroDigitos = strlen($solSubcategoria);
//                                                                    if ($numeroDigitos > 1) {
//                                                                        $salida .= $solSubcategoria;
//                                                                    } else {
//                                                                        $salida .= "0$solSubcategoria";
//                                                                    }
//                                                                    $salida .= "</span>";
//                                                                }
//                                                                $salida .= "</div>"
//                                                                        . "</div>";
//                                                                $salida .= "<div class=\"column is-1 pad-03\">"
//                                                                        . "<div class=\"tags has-addons\">";
//                                                                if ($penSubcategoria > 0) {
//                                                                    $salida .= "<span class=\"tag is-danger fs-10\">";
//                                                                    //$totalTareasGrales = $penSubcategoria + $totalTareas;
//                                                                    $numeroDigitos = strlen($penSubcategoria);
//                                                                    if ($numeroDigitos > 1) {
//                                                                        $salida .= $penSubcategoria;
//                                                                    } else {
//                                                                        $salida .= "0$penSubcategoria";
//                                                                    }
//                                                                    $salida .= "</span>";
//                                                                }
//                                                                $salida .= "</div>"
//                                                                        . "</div>";
//                                                                $salida .= "</div>";
//                                                            }
//                                                        }
//                                                    } catch (Exception $ex) {
//                                                        $salida = $ex;
//                                                    }
//                                                    $salida .= "</div>";
//                                                } else {
//                                                    $idSubcategoria = 0;
//                                                    $salida .= "<div class=\"columns is-mobile mb-2 \">";
//                                                    if ($verEquipos == 1) {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
//                                                    } else {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
//                                                    }
//                                                    $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>"
//                                                            . "</div>"
//                                                            . "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($solCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-success fs-10\">";
//                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($solCategoria);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $solCategoria;
//                                                        } else {
//                                                            $salida .= "0$solCategoria";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($penCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-danger fs-10\">";
//                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($penCategoria);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $penCategoria;
//                                                        } else {
//                                                            $salida .= "0$penCategoria";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "</div>";
//                                                }
//                                            } catch (Exception $ex) {
//                                                $salida = $ex;
//                                            }
//                                        }
//                                        //**********+BITACORAS STOCK INFORMACION*********************
//                                        elseif ($nombreCategoria == "BITACORAS" || $nombreCategoria == "STOCK - PEDIDOS" || $nombreCategoria == "INFORMACION") {
//                                            //obtener total por categoria
//                                            if ($idDestino == 10) {
//                                                $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
//                                            } else {
//                                                $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
//                                            }
//                                            try {
//                                                $resp = $conn->obtDatos($query);
//                                                $penCategoria = $conn->filasConsultadas;
//                                            } catch (Exception $ex) {
//                                                echo $ex;
//                                            }
//                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
//                                            try {
//                                                $result = $conn->obtDatos($query);
//                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
//                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
//                                                    if ($verEquipos == 1) {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    } else {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    }
//
//                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
//                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
//                                                    } else {
//                                                        $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
//                                                    }
//
//                                                    $salida .= "</div>";
//                                                    $salida .= "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($penCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-danger\">";
//                                                        $totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($totalTareasGrales);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $totalTareasGrales;
//                                                        } else {
//                                                            $salida .= "0$totalTareasGrales";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "</div>"
//                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
//                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
//                                                    try {
//                                                        $relSC = $conn->obtDatos($query);
//                                                        if ($conn->filasConsultadas > 0) {
//                                                            foreach ($relSC as $sc) {
//                                                                $idRelCatSubcat = $sc['id'];
//                                                                $idSubcategoria = $sc['id_subcategoria'];
//
//                                                                $query = "SELECT * FROM c_subcategorias_planner WHERE id = $idSubcategoria";
//                                                                try {
//                                                                    $subcategorias = $conn->obtDatos($query);
//                                                                    if ($conn->filasConsultadas > 0) {
//                                                                        foreach ($subcategorias as $scs) {
//                                                                            $nombreSubcategoria = $scs['subcategoria'];
//                                                                            $verEquipo = $scs['equipos'];
//                                                                        }
//                                                                    }
//                                                                } catch (Exception $ex) {
//                                                                    $salida = $ex;
//                                                                }
//
//                                                                //Obtener pendientes po subcategoria
//                                                                if ($idDestino == 10) {
//                                                                    $query = "SELECT * FROM t_mc WHERE id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
//                                                                } else {
//                                                                    $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
//                                                                }
//                                                                try {
//                                                                    $resp = $conn->obtDatos($query);
//                                                                    $penSubcategoria = $conn->filasConsultadas;
//                                                                } catch (Exception $ex) {
//                                                                    $salida = $ex;
//                                                                }
//
//                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
//                                                                if ($verEquipos == 1) {
//                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                                } else {
//                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                                }
//
//
//                                                                $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a href=\"file-explorer.php?p=/$destino/$nombreSubcategoria/$nombreSeccion/$nombreSubseccion\">" . strtoupper($nombreSubcategoria) . "</a></h1>";
//
//
//                                                                $salida .= "</div>";
//                                                                $salida .= "<div class=\"column is-1 pad-03\">"
//                                                                        . "<div class=\"tags has-addons\">";
//                                                                if ($penSubcategoria > 0) {
//                                                                    $salida .= "<span class=\"tag is-danger\">";
//                                                                    $totalTareasGrales = $penSubcategoria + $totalTareas;
//                                                                    $numeroDigitos = strlen($totalTareasGrales);
//                                                                    if ($numeroDigitos > 1) {
//                                                                        $salida .= $totalTareasGrales;
//                                                                    } else {
//                                                                        $salida .= "0$totalTareasGrales";
//                                                                    }
//                                                                    $salida .= "</span>";
//                                                                }
//                                                                $salida .= "</div>"
//                                                                        . "</div>";
//                                                                $salida .= "</div>";
//                                                            }
//                                                        }
//                                                    } catch (Exception $ex) {
//                                                        $salida = $ex;
//                                                    }
//                                                    $salida .= "</div>";
//                                                } else {
//                                                    $idSubcategoria = 0;
//                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
//                                                    if ($verEquipos == 1) {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    } else {
//                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
//                                                    }
//
//                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
//                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
//                                                    } else {
//                                                        $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
//                                                    }
//
//                                                    $salida .= "</div>";
//                                                    $salida .= "<div class=\"column is-1 pad-03\">"
//                                                            . "<div class=\"tags has-addons\">";
//                                                    if ($penCategoria > 0) {
//                                                        $salida .= "<span class=\"tag is-danger\">";
//                                                        $totalTareasGrales = $penCategoria + $totalTareas;
//                                                        $numeroDigitos = strlen($totalTareasGrales);
//                                                        if ($numeroDigitos > 1) {
//                                                            $salida .= $totalTareasGrales;
//                                                        } else {
//                                                            $salida .= "0$totalTareasGrales";
//                                                        }
//                                                        $salida .= "</span>";
//                                                    }
//                                                    $salida .= "</div>"
//                                                            . "</div>";
//                                                    $salida .= "</div>";
//                                                }
//                                            } catch (Exception $ex) {
//                                                $salida = $ex;
//                                            }
//                                        }
//                                    }
//                                }
//                            } catch (Exception $ex) {
//                                $salida = $ex;
//                            }
//
//                            $salida .= "</div>";
//                        }
//                    }
//                }
//            }
//        } catch (Exception $ex) {
//            $salida = $ex;
//        }
//
//        $salida .= "</div>"
//                . "</div>";
//
//        $conn->cerrar();
//        return $salida;
//    }