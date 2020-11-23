<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');

    if ($action == "obtenerServicios") {
        $array = array();
        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT* FROM t_subcontratas_america_materiales WHERE activo = 1 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $fecha = $x['fecha_contabilizacion'];
                $importe = $x['importe_us'];
                $cc = $x['centro_coste'];
                $asignacion = $x['asignacion'];
                $texto = $x['texto'];
                $nombreProveedorAF = $x['nombre_proveedor_af'];
                $nombre_1 = $x['nombre_1'];
                $textoCeco = $x['texto_ceco'];

                $arrayTemp = array(
                    "fecha" => $fecha,
                    "importe" => $importe,
                    "cc" => $cc,
                    "asignacion" => $asignacion,
                    "texto" => $texto,
                    "nombreProveedorAF" => $nombreProveedorAF,
                    "nombre_1" => $nombre_1,
                    "textoCeco" => $textoCeco
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }

    if ($action == "obtenerMateriales") {
        $array = array();
        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT* FROM t_compras_america_materiales WHERE activo = 1 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $fecha = $x['fecha_contabilizacion'];
                $importe = $x['importe_us'];
                $cc = $x['centro_coste'];
                $asignacion = $x['asignacion'];
                $texto = $x['texto'];
                $nombreProveedorAF = $x['nombre_proveedor_af'];
                $nombre_1 = $x['nombre_1'];
                $documentoCompras = $x['documento_compras'];
                $textoCeco = $x['texto_ceco'];

                $arrayTemp = array(
                    "fecha" => $fecha,
                    "importe" => $importe,
                    "cc" => $cc,
                    "asignacion" => $asignacion,
                    "texto" => $texto,
                    "nombreProveedorAF" => $nombreProveedorAF,
                    "nombre_1" => $nombre_1,
                    "documentoCompras" => $documentoCompras,
                    "textoCeco" => $textoCeco
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }
}