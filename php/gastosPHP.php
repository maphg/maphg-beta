<?php

include 'conexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 1) {
        $idPresupuesto = $_POST['idPresupuesto'];
        $idDestino = $_POST['idDestino'];
        $fase = $_POST['fase'];
        $obj = new Gastos();
        $resp = $obj->obtenerRegistroGastos($idPresupuesto, $idDestino, $fase);
        echo json_encode($resp);
    }

    if ($action == 2) {
        $obj = new Gastos();
        $tipoGasto = $_POST['tipoGasto'];
        if ($tipoGasto == 1) {
            $idDestino = $_POST['idDestino'];
            $numDoc = $_POST['numDoc'];
            $fechaSol = $_POST['fechaSol'];
            $fechaPosibleLlegada = $_POST['fechaPosibleLlegada'];
            $proveedor = $_POST['proveedor'];
            $idPresupuesto = $_POST['idPresupuesto'];
            $seccion = $_POST['seccion'];
            $ubicacion = $_POST['ubicacion'];
            $items = json_decode($_POST['items']);

            $obj = new Gastos();
            $resp = $obj->agregarGasto($idDestino, $tipoGasto, $numDoc, $fechaSol, $fechaPosibleLlegada, $proveedor, $idPresupuesto, $seccion, $ubicacion, $items);
            echo $resp;
        } else {
            $idDestino = $_POST['idDestino'];
            $numDoc = $_POST['numDoc'];
            $fechaSol = $_POST['fechaSol'];
            $fechaPosibleLlegada = $_POST['fechaPosibleLlegada'];
            $proveedor = $_POST['proveedor'];
            $idPresupuesto = $_POST['idPresupuesto'];
            $seccion = $_POST['seccion'];
            $ubicacion = $_POST['ubicacion'];
            $items = json_decode($_POST['items']);

            $obj = new Gastos();
            $resp = $obj->agregarGasto($idDestino, $tipoGasto, $numDoc, $fechaSol, $fechaPosibleLlegada, $proveedor, $idPresupuesto, $seccion, $ubicacion, $items);
            echo $resp;
        }
    }

    //Agregar presupuestos a destinos
    if ($action == 3) {
        $idDestino = $_POST['idDestino'];
        $presupuesto = $_POST['ppto'];
        $año = $_POST['año'];
        $mantto = $_POST['mantto'];
        $obj = new Gastos();
        $resp = $obj->agregarPresupuesto($idDestino, $presupuesto, $año, $mantto);
        echo $resp;
    }

    if ($action == 4) {
        $idDocumento = $_POST['idDocumento'];
        $obj = new Gastos();
        $resp = $obj->obtPedido($idDocumento);
        echo json_encode($resp);
    }

    if ($action == 5) {
        $idSeccion = $_POST['idSeccion'];
        $obj = new Gastos();
        $resp = $obj->obtAreas($idSeccion);
        echo $resp;
    }

    if ($action == 6) {
        $idItem = $_POST['idItem'];
        $fecha = $_POST['fecha'];
        $tipoGasto = $_POST['tipoGasto'];
        $campo = $_POST['campo'];
        $obj = new Gastos();
        $resp = $obj->actualizarGasto($idItem, $campo, $fecha, $tipoGasto);
        echo $resp;
    }

    if ($action == 7) {
        $idPpto = $_POST['idPpto'];
        $fase = $_POST['fase'];
        $porc = $_POST['porc'];
        $mantto = $_POST['mantto'];

        $obj = new Gastos();
        $resp = $obj->setPorc($idPpto, $fase, $porc, $mantto);
        echo $resp;
    }

    //Actualizar el monto del presupuesto total anual
    if ($action == 8) {
        $idPresupuesto = $_POST['idPresupuesto'];
        $presupuesto = $_POST['presupuesto'];
        $mantto = $_POST['mantto'];
        $obj = new Gastos();
        $resp = $obj->actualizarPresupuesto($idPresupuesto, $presupuesto, $mantto);
        echo $resp;
    }

    if ($action == 9) {
        $idPpto = $_POST['idPpto'];
        $idPptoMensual = $_POST['idPptoMes'];
        $fase = $_POST['fase'];
        $porc = $_POST['porc'];

        $obj = new Gastos();
        $resp = $obj->setPorcMensual($idPpto, $idPptoMensual, $porc, $fase);
        echo $resp;
    }

    if ($action == 10) {
        $idDestino = $_POST['idDestino'];
        $idPptoMC = $_POST['idPptoMC'];
        $idPptoMP = $_POST['idPptoMP'];
        $fase = $_POST['fase'];
        $obj = new Gastos();
        $resp = $obj->obtenerRegistroGastos2($idPptoMC, $idPptoMP, $idDestino, $fase);
        echo json_encode($resp);
    }
}

Class Pedido {

    public $idPresupuesto;
    public $numeroDocumento;
    public $fechaSolicitud;
    public $fechaPosibleLlegada;
    public $fechaOrdenCompra;
    public $proveedor;
    public $tipoGasto; //Si es material o subcontrata (Empresas)
    public $idDestino;
    public $idSeccion;
    public $idUbicacion;
    public $items;

}

Class Presupuestos {

    public $pptoAnual;
    public $pptoMensualTotal;
    public $pptoMensualServicios;
    public $pptoMensualMateriales;
    public $tablaGastos;
    public $tablaGastosServicios;
    public $tablaGastosMateriales;
    public $arrayMeses;
    public $arrayPptoMC;
    public $arrayPptoMP;
    public $arrayGastoMC;
    public $arrayGastoMP;
    public $arrayMesesServ;
    public $arrayPptoMCServ;
    public $arrayPptoMPServ;
    public $arrayGastoMCServ;
    public $arrayGastoMPServ;
    public $arrayMesesMat;
    public $arrayPptoMCMat;
    public $arrayPptoMPMat;
    public $arrayGastoMCMat;
    public $arrayGastoMPMat;

}

Class Gastos {

    public function obtenerRegistroGastos($idPresupueto, $idDestino, $tarjeta) {
        $conn = new Conexion();
        $conn->conectar();
        $ppto = new Presupuestos();
        setlocale(LC_MONETARY, "en_US");
        $year = date('Y');
        $month = date("F");
        if($month == "January"){
            $month == "December";
            $year = $year - 1;
        }
        switch ($month) {
            case 'January':
                $mesActual = "ENERO";
                break;
            case 'February':
                $mesActual = "FEBRERO";
                break;
            case 'March':
                $mesActual = "MARZO";
                break;
            case 'April':
                $mesActual = "ABRIL";
                break;
            case 'May':
                $mesActual = "MAYO";
                break;
            case 'June':
                $mesActual = "JUNIO";
                break;
            case 'July':
                $mesActual = "JULIO";
                break;
            case 'August':
                $mesActual = "AGOSTO";
                break;
            case 'September':
                $mesActual = "SEPTIEMBRE";
                break;
            case 'October':
                $mesActual = "OCTUBRE";
                break;
            case 'November':
                $mesActual = "NOVIEMBRE";
                break;
            case 'December':
                $mesActual = "DICIEMBRE";
                break;
        }

        switch ($tarjeta) {
            case 'cardTRS':
                $gastoTotalAnualMCTRS = 0;
                $gastoTotalAnualMPTRS = 0;
                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MCTRS' OR ceco = 'MPTRS') "
                        . "AND id_destino = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $ceco = $dts['ceco'];
                            $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idDocumento";
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dts) {
                                        $cod2bend = "";
                                        $tipo = "002 (Externo)";
                                        $idDocumento = $dts['id_documento'];
                                        $descripcion = $dts['descripcion'];
                                        $fechaSol = $dts['fecha_solicitud'];
                                        $fechaOrCompra = $dts['fecha_orden_compra'];
                                        $idSeccion = $dts['id_seccion'];
                                        $idUbicacion = $dts['id_ubicacion'];
                                        $fechaAprobacion = $dts['fecha_aprobacion'];
                                        $fechaPosibleInicio = $dts['fecha_posible_inicio'];
                                        $fechaRealInicio = $dts['fecha_real_inicio'];
                                        $fechaFin = $dts['fecha_fin'];
                                        $fechaPago = $dts['fecha_pago'];
                                        $pagoParcial = $dts['pago_parcial'];
                                        $totalPago = $dts['total_pago'];

                                        setlocale(LC_TIME, 'es_ES.UTF-8');
                                        $mes = strftime("%B", strtotime($fechaAprobacion));

                                        $query = "SELECT * FROM t_gastos WHERE id = $idDocumento";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPresupesto = $dts['id_presupuesto'];
                                                    $numDoc = $dts['num_documento'];
                                                    $ceco = $dts['ceco'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreSeccion = $dts['seccion'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        //$query = "SELECT * FROM c_ubicaciones WHERE id = $idUbicacion";
                                        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
                                            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idUbicacion";
                                        } else {
                                            $query = "SELECT * FROM c_grupos WHERE id = $idUbicacion";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreUbicacion = $dts['grupo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }
                                        $ppto->tablaGastos .= "<tr data-toggle=\"modal\" data-target=\"#modal-editar-gasto\" onclick=\"obtRegistro($idDocumento);\">"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td class=\"fs-10\">$ceco</td>"
                                                . "<td class=\"fs-10\">$numDoc</td>"
                                                . "<td class=\"fs-10\">$cod2bend</td>"
                                                . "<td class=\"fs-10\">$descripcion</td>"
                                                . "<td class=\"fs-10\">$tipo</td>"
                                                . "<td class=\"fs-10\">" . strtoupper($mes) . "</td>"
                                                . "<td class=\"fs-10\"></td>"
                                                . "<td class=\"fs-10\">$fechaAprobacion</td>"
                                                . "<td class=\"fs-10\">$fechaRealInicio</td>"
                                                . "<td class=\"fs-10\">$fechaFin</td>"
                                                . "<td class=\"fs-10\">" . money_format("%.2n", $totalPago) . "</td>"
                                                . "<td class=\"fs-10\">$nombreSeccion</td>"
                                                . "<td class=\"fs-10\">$nombreUbicacion</td>"
                                                . "</tr>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $ppto = $ex;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Se obtiene los detalles del presupuesto mensual
                $query = "SELECT * FROM t_presupuesto_mensual WHERE id_presupuesto = $idPresupueto";
                try {
                    $resultado = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resultado as $dts) {
                            $gastoMPTRS = 0;
                            $gastoMCTRS = 0;
                            $mes = $dts['mes'];
                            $mpTRS = $dts['mp_trs'];
                            $mcTRS = $dts['mc_trs'];

                            if ($mes == $mesActual) {
                                $query = "SELECT * FROM t_gastos "
                                        . "WHERE (ceco = 'MPTRS' OR ceco = 'MCTRS') "
                                        . "AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));
                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCTRS") {
                                                                $gastoMCTRS += $gastado;
                                                                $gastoTotalAnualMCTRS += $gastoMCTRS;
                                                            } elseif ($ceco == "MPTRS") {
                                                                $gastoMPTRS += $gastado;
                                                                $gastoTotalAnualMPTRS += $gastoMPTRS;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    } else {
                                        $gastoMPTRS = 0;
                                        $gastoMCTRS = 0;
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }

                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 bg-current-month py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:Segoe Pro Display Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:Segoe Pro Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:Segoe Pro Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpTRS) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPTRS) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%2n", $mcTRS) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCTRS) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
                                break;
                            } else {
                                $query = "SELECT * FROM t_gastos "
                                        . "WHERE (ceco = 'MPTRS' OR ceco = 'MCTRS') "
                                        . "AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));
                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCTRS") {
                                                                $gastoMCTRS += $gastado;
                                                                $gastoTotalAnualMCTRS += $gastoMCTRS;
                                                            } elseif ($ceco == "MPTRS") {
                                                                $gastoMPTRS += $gastado;
                                                                $gastoTotalAnualMPTRS += $gastoMPTRS;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    } else {
                                        $gastoMPTRS = 0;
                                        $gastoMCTRS = 0;
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }
                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:Segoe Pro Display Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:Segoe Pro Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:Segoe Pro Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpTRS) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPTRS) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%.2n", $mcTRS) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCTRS) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Se obtiene los datos del presupuesto anual
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPresupesto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idPpto = $dts['id'];
                            $pptoAnualMantto = $dts['presupuesto'];
                            $pptoAnualTRS = $dts['ppto_trs'];
                            $mcTRSAnual = $dts['mc_trs'];
                            $mpTRSAnual = $dts['mp_trs'];
                        }

                        //Calcular porcentaje de gastos anuales
                        $porcGastoAnualMCTRS = ($gastoTotalAnualMCTRS * 100) / $mcTRSAnual;
                        $porcGastoAnualMPTRS = ($gastoTotalAnualMPTRS * 100) / $mpTRSAnual;

                        $ppto->pptoAnual = "<div class=\"row\">"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-bolder fs-27\">" . money_format("%.2n", $pptoAnualTRS) . "</h1>"
                                . "</div>"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-lighter fs-16 display-1\">PRESUPUESTO ANUAL</h1>"
                                . "</div>"
                                . "</div>"
                                . "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                                . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:12.88px;}</style>"
                                . "<title>wigget</title>"
                                . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                                . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6
	l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                                . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4
	c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                                . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mpTRSAnual) . "</text>"
                                . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMPTRS) . "</text>"
                                . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                                . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mcTRSAnual) . "</text>"
                                . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMCTRS) . "</text>"
                                . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4
	c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54
	L118.8,54z\"/>"
                                . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3
	c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7
	c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                                . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                                . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcGastoAnualMPTRS, 2) . "%</text>"
                                . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                                . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcGastoAnualMCTRS, 2) . "%</text>"
                                . "</svg>";
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                break;
            case 'cardGP':
                $gastoTotalAnualMCGP = 0;
                $gastoTotalAnualMPGP = 0;
                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MCGP' OR ceco = 'MPGP') AND id_destino = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $ceco = $dts['ceco'];
                            $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idDocumento";
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dts) {
                                        $cod2bend = "";
                                        $tipo = "002 (Externo)";
                                        $idDocumento = $dts['id_documento'];
                                        $descripcion = $dts['descripcion'];
                                        $fechaSol = $dts['fecha_solicitud'];
                                        $fechaOrCompra = $dts['fecha_orden_compra'];
                                        $idSeccion = $dts['id_seccion'];
                                        $idUbicacion = $dts['id_ubicacion'];
                                        $fechaAprobacion = $dts['fecha_aprobacion'];
                                        $fechaPosibleInicio = $dts['fecha_posible_inicio'];
                                        $fechaRealInicio = $dts['fecha_real_inicio'];
                                        $fechaFin = $dts['fecha_fin'];
                                        $fechaPago = $dts['fecha_pago'];
                                        $pagoParcial = $dts['pago_parcial'];
                                        $totalPago = $dts['total_pago'];

                                        setlocale(LC_TIME, 'es_ES.UTF-8');
                                        $mes = strftime("%B", strtotime($fechaAprobacion));

                                        $query = "SELECT * FROM t_gastos WHERE id = $idDocumento";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPresupesto = $dts['id_presupuesto'];
                                                    $numDoc = $dts['num_documento'];
                                                    $ceco = $dts['ceco'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreSeccion = $dts['seccion'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        //$query = "SELECT * FROM c_ubicaciones WHERE id = $idUbicacion";
                                        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
                                            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idUbicacion";
                                        } else {
                                            $query = "SELECT * FROM c_grupos WHERE id = $idUbicacion";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreUbicacion = $dts['grupo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }
                                        $ppto->tablaGastos .= "<tr data-toggle=\"modal\" data-target=\"#modal-editar-gasto\" onclick=\"obtRegistro($idDocumento);\">"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td class=\"fs-10\">$ceco</td>"
                                                . "<td class=\"fs-10\">$numDoc</td>"
                                                . "<td class=\"fs-10\">$cod2bend</td>"
                                                . "<td class=\"fs-10\">$descripcion</td>"
                                                . "<td class=\"fs-10\">$tipo</td>"
                                                . "<td class=\"fs-10\">" . strtoupper($mes) . "</td>"
                                                . "<td class=\"fs-10\"></td>"
                                                . "<td class=\"fs-10\">$fechaAprobacion</td>"
                                                . "<td class=\"fs-10\">$fechaRealInicio</td>"
                                                . "<td class=\"fs-10\">$fechaFin</td>"
                                                . "<td class=\"fs-10\">" . money_format("%.2n", $totalPago) . "</td>"
                                                . "<td class=\"fs-10\">$nombreSeccion</td>"
                                                . "<td class=\"fs-10\">$nombreUbicacion</td>"
                                                . "</tr>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $ppto = $ex;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                $query = "SELECT * FROM t_presupuesto_mensual WHERE id_presupuesto = $idPresupueto";
                try {
                    $resultado = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resultado as $dts) {
                            $gastoMPGP = 0;
                            $gastoMCGP = 0;
                            $mes = $dts['mes'];
                            $mpGP = $dts['mp_gp'];
                            $mcGP = $dts['mc_gp'];

                            if ($mes == $mesActual) {
                                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MPGP' OR ceco = 'MCGP') AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));

                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCGP") {
                                                                $gastoMCGP += $gastado;
                                                                $gastoTotalAnualMCGP += $gastoMCGP;
                                                            } elseif ($ceco == "MPGP") {
                                                                $gastoMPGP += $gastado;
                                                                $gastoTotalAnualMPGP += $gastoMPGP;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }

                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 bg-current-month py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:Segoe ProDisplay Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:Segoe Pro Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:Segoe Pro Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpGP) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPGP) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%2n", $mcGP) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCGP) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
//                                
                                break;
                            } else {
                                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MPGP' OR ceco = 'MCGP') AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));

                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCGP") {
                                                                $gastoMCGP += $gastado;
                                                                $gastoTotalAnualMCGP += $gastoMCGP;
                                                            } elseif ($ceco == "MPGP") {
                                                                $gastoMPGP += $gastado;
                                                                $gastoTotalAnualMPGP += $gastoMPGP;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }

                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:SegoeProDisplay-Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:SegoePro-Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:SegoePro-Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpGP) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPGP) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%2n", $mcGP) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCGP) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Se obtiene los datos del presupuesto anual
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPresupesto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idPpto = $dts['id'];
                            $pptoAnualMantto = $dts['presupuesto'];
                            $pptoAnualGP = $dts['ppto_gp'];
                            $mcGPAnual = $dts['mc_gp'];
                            $mpGPAnual = $dts['mp_gp'];
                        }

                        //Calcular porcentaje de gastos anuales
                        $porcGastoAnualMCGP = ($gastoTotalAnualMCGP * 100) / $mcGPAnual;
                        $porcGastoAnualMPGP = ($gastoTotalAnualMPGP * 100) / $mpGPAnual;

                        $ppto->pptoAnual = "<div class=\"row\">"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-bolder fs-27\">" . money_format("%.2n", $pptoAnualGP) . "</h1>"
                                . "</div>"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-lighter fs-16 display-1\">PRESUPUESTO ANUAL</h1>"
                                . "</div>"
                                . "</div>"
                                . "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                                . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:12.88px;}</style>"
                                . "<title>wigget</title>"
                                . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                                . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6
	l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                                . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4
	c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                                . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mpGPAnual) . "</text>"
                                . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMPGP) . "</text>"
                                . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                                . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mcGPAnual) . "</text>"
                                . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMCGP) . "</text>"
                                . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4
	c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54
	L118.8,54z\"/>"
                                . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3
	c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7
	c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                                . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                                . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcGastoAnualMPGP, 2) . "%</text>"
                                . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                                . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcGastoAnualMCGP, 2) . "%</text>"
                                . "</svg>";
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }
                break;
            case 'cardZI':
                $gastoTotalAnualMCZI = 0;
                $gastoTotalAnualMPZI = 0;
                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MCZI' OR ceco = 'MPZI') AND id_destino = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $ceco = $dts['ceco'];
                            $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idDocumento";
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dts) {
                                        $cod2bend = "";
                                        $tipo = "002 (Externo)";
                                        $idDocumento = $dts['id_documento'];
                                        $descripcion = $dts['descripcion'];
                                        $fechaSol = $dts['fecha_solicitud'];
                                        $fechaOrCompra = $dts['fecha_orden_compra'];
                                        $idSeccion = $dts['id_seccion'];
                                        $idUbicacion = $dts['id_ubicacion'];
                                        $fechaAprobacion = $dts['fecha_aprobacion'];
                                        $fechaPosibleInicio = $dts['fecha_posible_inicio'];
                                        $fechaRealInicio = $dts['fecha_real_inicio'];
                                        $fechaFin = $dts['fecha_fin'];
                                        $fechaPago = $dts['fecha_pago'];
                                        $pagoParcial = $dts['pago_parcial'];
                                        $totalPago = $dts['total_pago'];

                                        setlocale(LC_TIME, 'es_ES.UTF-8');
                                        $mes = strftime("%B", strtotime($fechaAprobacion));

                                        $query = "SELECT * FROM t_gastos WHERE id = $idDocumento";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPresupesto = $dts['id_presupuesto'];
                                                    $numDoc = $dts['num_documento'];
                                                    $ceco = $dts['ceco'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreSeccion = $dts['seccion'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        //$query = "SELECT * FROM c_ubicaciones WHERE id = $idUbicacion";
                                        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
                                            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idUbicacion";
                                        } else {
                                            $query = "SELECT * FROM c_grupos WHERE id = $idUbicacion";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreUbicacion = $dts['grupo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }
                                        $ppto->tablaGastos .= "<tr data-toggle=\"modal\" data-target=\"#modal-editar-gasto\" onclick=\"obtRegistro($idDocumento);\">"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td class=\"fs-10\">$ceco</td>"
                                                . "<td class=\"fs-10\">$numDoc</td>"
                                                . "<td class=\"fs-10\">$cod2bend</td>"
                                                . "<td class=\"fs-10\">$descripcion</td>"
                                                . "<td class=\"fs-10\">$tipo</td>"
                                                . "<td class=\"fs-10\">" . strtoupper($mes) . "</td>"
                                                . "<td class=\"fs-10\"></td>"
                                                . "<td class=\"fs-10\">$fechaAprobacion</td>"
                                                . "<td class=\"fs-10\">$fechaRealInicio</td>"
                                                . "<td class=\"fs-10\">$fechaFin</td>"
                                                . "<td class=\"fs-10\">" . money_format("%.2n", $totalPago) . "</td>"
                                                . "<td class=\"fs-10\">$nombreSeccion</td>"
                                                . "<td class=\"fs-10\">$nombreUbicacion</td>"
                                                . "</tr>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $ppto = $ex;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                $query = "SELECT * FROM t_presupuesto_mensual WHERE id_presupuesto = $idPresupueto";
                try {
                    $resultado = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resultado as $dts) {
                            $gastoMPZI = 0;
                            $gastoMCZI = 0;
                            $mes = $dts['mes'];
                            $mpZI = $dts['mp_zi'];
                            $mcZI = $dts['mc_zi'];

                            if ($mes == $mesActual) {

                                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MPZI' OR ceco = 'MCZI') AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));
                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCZI") {
                                                                $gastoMCZI += $gastado;
                                                                $gastoTotalAnualMCZI += $gastoMCZI;
                                                            } elseif ($ceco == "MPZI") {
                                                                $gastoMPZI += $gastado;
                                                                $gastoTotalAnualMPZI += $gastoMPZI;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }

                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 bg-current-month py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:SegoeProDisplay-Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:SegoePro-Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:SegoePro-Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpZI) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPZI) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%2n", $mcZI) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCZI) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
                                break;
                            } else {
                                $query = "SELECT * FROM t_gastos WHERE (ceco = 'MPZI' OR ceco = 'MCZI') AND id_destino = $idDestino";
                                try {
                                    $gastos = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($gastos as $gasto) {
                                            $idGasto = $gasto['id'];
                                            $ceco = $gasto['ceco'];
                                            $fecha = $gasto['fecha_solicitud'];
                                            setlocale(LC_TIME, 'es_ES.UTF-8');
                                            $mesGasto = strftime("%B", strtotime($fecha));
                                            if (strtoupper($mesGasto) == $mes) {
                                                $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idGasto";
                                                try {
                                                    $items = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($items as $item) {
                                                            $gastado = $item['total_pago'];
                                                            if ($ceco == "MCZI") {
                                                                $gastoMCZI += $gastado;
                                                                $gastoTotalAnualMCZI += $gastoMCZI;
                                                            } elseif ($ceco == "MPZI") {
                                                                $gastoMPZI += $gastado;
                                                                $gastoTotalAnualMPZI += $gastoMPZI;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {
                                                    $ppto = $ex;
                                                }
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    $ppto = $ex;
                                }

                                $ppto->pptoMensual .= "<div class=\"col-12 col-md-2 col-lg-2 mt-2 py-2\">"
                                        . "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 63 64.71\">"
                                        . "<defs>"
                                        . "<style>.cls-1{fill:#ebe7ff;}.cls-2{fill:#d7d0fb;}.cls-3{fill:#7866d3;}.cls-4,.cls-5,.cls-9{isolation:isolate;}.cls-4,.cls-5{font-size:8.52px;}.cls-4{font-family:SegoeProDisplay-Semibold, Segoe Pro Display;}.cls-4,.cls-9{font-weight:600;}.cls-5{font-family:SegoePro-Light, Segoe Pro;font-weight:300;}.cls-6{fill:#bee7ff;}.cls-7{fill:#1997e3;}.cls-8{fill:#e5f5ff;}.cls-9{font-size:9.37px;font-family:SegoePro-Semibold, Segoe Pro;}.cls-10{letter-spacing:-0.01em;}</style>"
                                        . "</defs>"
                                        . "<title>ficha</title>"
                                        . "<g id=\"Capa_2\" data-name=\"Capa 2\">"
                                        . "<g id=\"Capa_1-2\" data-name=\"Capa 1\">"
                                        . "<path class=\"cls-1\" d=\"M9,11.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<rect class=\"cls-2\" y=\"11.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-3\" d=\"M7.5,23.71v1H3.6a4.87,4.87,0,0,1-1.2-.1h0a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.8c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a1.45,1.45,0,0,1,.7-.2h0l-.7-.3-3.9-1.6v-1.3H7.5Z\"/>"
                                        . "<path class=\"cls-3\" d=\"M5.3,21.21H7.5v1h-6v-1.8a2.77,2.77,0,0,1,.5-1.6,1.61,1.61,0,0,1,1.3-.6,1.82,1.82,0,0,1,1.4.6,2.27,2.27,0,0,1,.6,1.6Zm-3,0H4.5v-.6a1.69,1.69,0,0,0-.3-1,1.14,1.14,0,0,0-.8-.3c-.7,0-1.1.4-1.1,1.2Z\"/>"
                                        . "<text id=\"MPP\" class=\"cls-4\" transform=\"translate(11.47 21.82)\">" . money_format("%.2n", $mpZI) . "</text>"
                                        . "<text id=\"MPG\" class=\"cls-5\" transform=\"translate(12.76 31.82)\">" . money_format("%.2n", $gastoMPZI) . "</text>"
                                        . "<rect class=\"cls-6\" y=\"39.71\" width=\"9\" height=\"25\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.5,51.81v1h-5a1.42,1.42,0,0,1,.6.2l4.5,1.8v.7l-4.4,1.7c-.2.1-.4.1-.6.2h5v.9h-6v-1.4l4-1.6a2.54,2.54,0,0,1,.7-.2h0a4.88,4.88,0,0,1-.7-.3l-3.9-1.6v-1.4Z\"/>"
                                        . "<path class=\"cls-7\" d=\"M7.2,46.21a3.29,3.29,0,0,1,.4,1.7A3.23,3.23,0,0,1,6.8,50a3.44,3.44,0,0,1-2.1.8,3.17,3.17,0,0,1-2.3-.9,3.1,3.1,0,0,1-.9-2.2,5.9,5.9,0,0,1,.2-1.4h1a3.26,3.26,0,0,0-.4,1.3,2.27,2.27,0,0,0,.6,1.6,2.27,2.27,0,0,0,1.6.6,2.45,2.45,0,0,0,1.6-.6,2,2,0,0,0,.6-1.5,2.82,2.82,0,0,0-.4-1.5Z\"/>"
                                        . "<path class=\"cls-8\" d=\"M9,39.71H60.6a2.43,2.43,0,0,1,2.4,2.4h0v20.2a2.43,2.43,0,0,1-2.4,2.4H9Z\"/>"
                                        . "<text id=\"MCP\" class=\"cls-4\" transform=\"translate(11.47 49.82)\">" . money_format("%2n", $mcZI) . "</text>"
                                        . "<text id=\"MCG\" class=\"cls-5\" transform=\"translate(12.76 59.82)\">" . money_format("%.2n", $gastoMCZI) . "</text>"
                                        . "<text class=\"cls-9\" transform=\"translate(16.69 7.96)\">$mes</text>"
                                        . "</g>"
                                        . "</g>"
                                        . "</svg>"
                                        . "</div>";
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Se obtiene los datos del presupuesto anual
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPresupesto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idPpto = $dts['id'];
                            $pptoAnualMantto = $dts['presupuesto'];
                            $pptoAnualZI = $dts['ppto_zi'];
                            $mcZIAnual = $dts['mc_zi'];
                            $mpZIAnual = $dts['mp_zi'];
                        }

                        //Calcular porcentaje de gastos anuales
                        $porcGastoAnualMCZI = ($gastoTotalAnualMCZI * 100) / $mcZIAnual;
                        $porcGastoAnualMPZI = ($gastoTotalAnualMPZI * 100) / $mpZIAnual;

                        $ppto->pptoAnual = "<div class=\"row\">"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-bolder fs-27\">" . money_format("%.2n", $pptoAnualZI) . "</h1>"
                                . "</div>"
                                . "<div class=\"col-12 text-center\">"
                                . "<h1 class=\"font-weight-lighter fs-16 display-1\">PRESUPUESTO ANUAL</h1>"
                                . "</div>"
                                . "</div>"
                                . "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                                . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:12.88px;}</style>"
                                . "<title>wigget</title>"
                                . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                                . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6
	l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                                . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4
	c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                                . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mpZIAnual) . "</text>"
                                . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMPZI) . "</text>"
                                . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                                . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                                . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.2n", $mcZIAnual) . "</text>"
                                . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.2n", $gastoTotalAnualMCZI) . "</text>"
                                . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4
	c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54
	L118.8,54z\"/>"
                                . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3
	c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7
	c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                                . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                                . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcGastoAnualMPZI, 2) . "%</text>"
                                . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9
	c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                                . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcGastoAnualMCZI, 2) . "%</text>"
                                . "</svg>";
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                break;
            case 'btnDetalles':
                $query = "SELECT * FROM t_gastos WHERE id_destino = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $ceco = $dts['ceco'];
                            $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idDocumento";
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dts) {
                                        $cod2bend = "";
                                        $tipo = "002 (Externo)";
                                        $idDocumento = $dts['id_documento'];
                                        $descripcion = $dts['descripcion'];
                                        $fechaSol = $dts['fecha_solicitud'];
                                        $fechaOrCompra = $dts['fecha_orden_compra'];
                                        $idSeccion = $dts['id_seccion'];
                                        $idUbicacion = $dts['id_ubicacion'];
                                        $fechaAprobacion = $dts['fecha_aprobacion'];
                                        $fechaPosibleInicio = $dts['fecha_posible_inicio'];
                                        $fechaRealInicio = $dts['fecha_real_inicio'];
                                        $fechaFin = $dts['fecha_fin'];
                                        $fechaPago = $dts['fecha_pago'];
                                        $pagoParcial = $dts['pago_parcial'];
                                        $totalPago = $dts['total_pago'];

                                        setlocale(LC_TIME, 'es_ES.UTF-8');
                                        $mes = strftime("%B", strtotime($fechaAprobacion));

                                        $query = "SELECT * FROM t_gastos WHERE id = $idDocumento";
                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPresupesto = $dts['id_presupuesto'];
                                                    $numDoc = $dts['num_documento'];
                                                    $ceco = $dts['ceco'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreSeccion = $dts['seccion'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }

                                        //$query = "SELECT * FROM c_ubicaciones WHERE id = $idUbicacion";
                                        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
                                            $query = "SELECT * FROM c_subcategorias_zh WHERE id = $idUbicacion";
                                        } else {
                                            $query = "SELECT * FROM c_grupos WHERE id = $idUbicacion";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $nombreUbicacion = $dts['grupo'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $ppto = $ex;
                                        }
                                        $ppto->tablaGastos .= "<tr data-toggle=\"modal\" data-target=\"#modal-editar-gasto\" onclick=\"obtRegistro($idDocumento);\">"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td class=\"fs-10\">$ceco</td>"
                                                . "<td class=\"fs-10\">$numDoc</td>"
                                                . "<td class=\"fs-10\">$cod2bend</td>"
                                                . "<td class=\"fs-10\">$descripcion</td>"
                                                . "<td class=\"fs-10\">$tipo</td>"
                                                . "<td class=\"fs-10\">" . strtoupper($mes) . "</td>"
                                                . "<td class=\"fs-10\"></td>"
                                                . "<td class=\"fs-10\">$fechaAprobacion</td>"
                                                . "<td class=\"fs-10\">$fechaRealInicio</td>"
                                                . "<td class=\"fs-10\">$fechaFin</td>"
                                                . "<td class=\"fs-10\">" . money_format("%.2n", $totalPago) . "</td>"
                                                . "<td class=\"fs-10\">$nombreSeccion</td>"
                                                . "<td class=\"fs-10\">$nombreUbicacion</td>"
                                                . "</tr>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $ppto = $ex;
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }
                break;
        }

        $conn->cerrar();
        return $ppto;
    }

    public function obtenerRegistroGastos2($idPptoMC, $idPptoMP, $idDestino, $tarjeta) {
        $conn = new Conexion();
        $conn->conectar();
        $ppto = new Presupuestos();
        setlocale(LC_MONETARY, "en_US");

        $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $destino = $dts['destino'];
                    $bandera = $dts['bandera'];
                    $gp = $dts['gp'];
                    $trs = $dts['trs'];
                    $division = $dts['division'];
                }
            }
        } catch (Exception $ex) {
            $ppto = $ex;
        }
        $year = date('Y');
        $currentMonth = date("n");

        $month = date("F");
        
        if($month == "January"){
            $month = "December";
            $currentMonth = 12;
            $year = $year - 1;
        }
        
        switch ($month) {
            case 'January':
                $mesActual = "ENERO";
                break;
            case 'February':
                $mesActual = "FEBRERO";
                break;
            case 'March':
                $mesActual = "MARZO";
                break;
            case 'April':
                $mesActual = "ABRIL";
                break;
            case 'May':
                $mesActual = "MAYO";
                break;
            case 'June':
                $mesActual = "JUNIO";
                break;
            case 'July':
                $mesActual = "JULIO";
                break;
            case 'August':
                $mesActual = "AGOSTO";
                break;
            case 'September':
                $mesActual = "SEPTIEMBRE";
                break;
            case 'October':
                $mesActual = "OCTUBRE";
                break;
            case 'November':
                $mesActual = "NOVIEMBRE";
                break;
            case 'December':
                $mesActual = "DICIEMBRE";
                break;
        }

        $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPptoMC";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $pptoAnualTRSMC = $dts['ppto_trs'];
                    $pptoAnualMatTRSMC = $dts['materiales_trs'];
                    $pptoAnualSerTRSMC = $dts['servicios_trs'];
                    $pptoAnualGPMC = $dts['ppto_gp'];
                    $pptoAnualMatGPMC = $dts['materiales_gp'];
                    $pptoAnualSerGPMC = $dts['servicios_gp'];
                    $pptoAnualZIMC = $dts['ppto_zi'];
                    $pptoAnualMatZIMC = $dts['materiales_zi'];
                    $pptoAnualSerZIMC = $dts['servicios_zi'];
                }
            } else {
                $pptoAnualTRSMC = 0;
                $pptoAnualMatTRSMC = 0;
                $pptoAnualSerTRSMC = 0;
                $pptoAnualGPMC = 0;
                $pptoAnualMatGPMC = 0;
                $pptoAnualSerGPMC = 0;
                $pptoAnualZIMC = 0;
                $pptoAnualMatZIMC = 0;
                $pptoAnualSerZIMC = 0;
            }
        } catch (Exception $ex) {
            $ppto = $ex;
        }

        $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPptoMP";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $pptoAnualTRSMP = $dts['ppto_trs'];
                    $pptoAnualMatTRSMP = $dts['materiales_trs'];
                    $pptoAnualSerTRSMP = $dts['servicios_trs'];
                    $pptoAnualGPMP = $dts['ppto_gp'];
                    $pptoAnualMatGPMP = $dts['materiales_gp'];
                    $pptoAnualSerGPMP = $dts['servicios_gp'];
                    $pptoAnualZIMP = $dts['ppto_zi'];
                    $pptoAnualMatZIMP = $dts['materiales_zi'];
                    $pptoAnualSerZIMP = $dts['servicios_zi'];
                }
            } else {
                $pptoAnualTRSMP = 0;
                $pptoAnualMatTRSMP = 0;
                $pptoAnualSerTRSMP = 0;
                $pptoAnualGPMP = 0;
                $pptoAnualMatGPMP = 0;
                $pptoAnualSerGPMP = 0;
                $pptoAnualZIMP = 0;
                $pptoAnualMatZIMP = 0;
                $pptoAnualSerZIMP = 0;
            }
        } catch (Exception $ex) {
            $ppto = $ex;
        }

        switch ($tarjeta) {
            case 'cardTRS':
                //Servicios
                //TRS
                $gastoMensualServiciosTRSMC = 0;
                $gastoMensualServiciosTRSMP = 0;
                $gastoAnualServiciosTRSMC = 0;
                $gastoAnualServiciosTRSMP = 0;
                $porcAnualServiciosTRSMC = 0;
                $porcAnualServiciosTRSMP = 0;

                $gastoEneroServiciosMC = 0;
                $gastoEneroServiciosMP = 0;
                $gastoFebreroServiciosMC = 0;
                $gastoFebreroServiciosMP = 0;
                $gastoMarzoServiciosMC = 0;
                $gastoMarzoServiciosMP = 0;
                $gastoAbrilServiciosMC = 0;
                $gastoAbrilServiciosMP = 0;
                $gastoMayoServiciosMC = 0;
                $gastoMayoServiciosMP = 0;
                $gastoJunioServiciosMC = 0;
                $gastoJunioServiciosMP = 0;
                $gastoJulioServiciosMC = 0;
                $gastoJulioServiciosMP = 0;
                $gastoAgostoServiciosMC = 0;
                $gastoAgostoServiciosMP = 0;
                $gastoSeptiembreServiciosMC = 0;
                $gastoSeptiembreServiciosMP = 0;
                $gastoOctubreServiciosMC = 0;
                $gastoOctubreServiciosMP = 0;
                $gastoNoviembreServiciosMC = 0;
                $gastoNoviembreServiciosMP = 0;
                $gastoDiciembreServiciosMC = 0;
                $gastoDiciembreServiciosMP = 0;


                $query = "SELECT * FROM t_gastos_servicios WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosTRSMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosTRSMC += $importe;
                                    }
                                } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosTRSMP += $importe;
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMP += $importe;
                                            break;
                                    }
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosTRSMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "TRS") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosServicios .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosServicios .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fechaDocumento</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Materiales
//TRS
                $gastoMensualMaterialesTRSMC = 0;
                $gastoMensualMaterialesTRSMP = 0;
                $gastoAnualMaterialesTRSMC = 0;
                $gastoAnualMaterialesTRSMP = 0;
                $porcAnualMaterialesTRSMC = 0;
                $porcAnualMaterialesTRSMP = 0;

                $gastoEneroMaterialesMC = 0;
                $gastoEneroMaterialesMP = 0;
                $gastoFebreroMaterialesMC = 0;
                $gastoFebreroMaterialesMP = 0;
                $gastoMarzoMaterialesMC = 0;
                $gastoMarzoMaterialesMP = 0;
                $gastoAbrilMaterialesMC = 0;
                $gastoAbrilMaterialesMP = 0;
                $gastoMayoMaterialesMC = 0;
                $gastoMayoMaterialesMP = 0;
                $gastoJunioMaterialesMC = 0;
                $gastoJunioMaterialesMP = 0;
                $gastoJulioMaterialesMC = 0;
                $gastoJulioMaterialesMP = 0;
                $gastoAgostoMaterialesMC = 0;
                $gastoAgostoMaterialesMP = 0;
                $gastoSeptiembreMaterialesMC = 0;
                $gastoSeptiembreMaterialesMP = 0;
                $gastoOctubreMaterialesMC = 0;
                $gastoOctubreMaterialesMP = 0;
                $gastoNoviembreMaterialesMC = 0;
                $gastoNoviembreMaterialesMP = 0;
                $gastoDiciembreMaterialesMC = 0;
                $gastoDiciembreMaterialesMP = 0;

                $query = "SELECT * FROM t_gastos_materiales WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesTRSMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesTRSMC += $importe;
                                    }
                                } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesTRSMP += $importe;

                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMP += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesTRSMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "TRS") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosMateriales .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosMateriales .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fechaDocumento</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                $totalGastoAnualTRSMC = $gastoAnualServiciosTRSMC + $gastoAnualMaterialesTRSMC;
                $totalGastoAnualTRSMP = $gastoAnualServiciosTRSMP + $gastoAnualMaterialesTRSMP;

                $porcAnualGastoTRSMC = ($totalGastoAnualTRSMC * 100) / $pptoAnualTRSMC;
                $porcAnualGastoTRSMP = ($totalGastoAnualTRSMP * 100) / $pptoAnualTRSMP;

                $pptoMensualMatTRSMC = $pptoAnualMatTRSMC / 12;
                $pptoMensualSerTRSMC = $pptoAnualSerTRSMC / 12;
                $pptoMensualMatTRSMP = $pptoAnualMatTRSMP / 12;
                $pptoMensualSerTRSMP = $pptoAnualSerTRSMP / 12;

                $pptoMensualTotalTRSMC = $pptoMensualMatTRSMC + $pptoMensualSerTRSMC;
                $pptoMensualTotalTRSMP = $pptoMensualMatTRSMP + $pptoMensualSerTRSMP;


                $ppto->pptoAnual = "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                        . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:10px;}</style>"
                        . "<title>wigget</title>"
                        . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                        . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                        . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                        . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualTRSMP) . "</text>"
                        . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualTRSMP) . "</text>"
                        . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                        . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualTRSMC) . "</text>"
                        . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualTRSMC) . "</text>"
                        . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54L118.8,54z\"/>"
                        . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                        . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                        . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcAnualGastoTRSMP) . "%</text>"
                        . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                        . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcAnualGastoTRSMC) . "%</text>"
                        . "</svg>";

                $arrayMeses = array();
                $arrayPresupuestoMensualMP = array();
                $arrayPresupuestoMensualMC = array();
                $arrayGastoMensualMP = array();
                $arrayGastoMensualMC = array();

                $arrayPresupuestoServMensualMP = array();
                $arrayPresupuestoServMensualMC = array();
                $arrayGastoServMensualMP = array();
                $arrayGastoServMensualMC = array();

                $arrayPresupuestoMatMensualMP = array();
                $arrayPresupuestoMatMensualMC = array();
                $arrayGastoMatMensualMP = array();
                $arrayGastoMatMensualMC = array();


                for ($i = 1; $i <= 12; $i++) {
                    switch ($i) {
                        case 1:
                            $mesPpto = "ENERO";
                            $gastoMensualServMC = $gastoEneroServiciosMC;
                            $gastoMensualSerMP = $gastoEneroServiciosMP;
                            $gastoMensualMatMC = $gastoEneroMaterialesMC;
                            $gastoMensualMatMP = $gastoEneroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 2:
                            $mesPpto = "FEBRERO";
                            $gastoMensualServMC = $gastoFebreroServiciosMC;
                            $gastoMensualSerMP = $gastoFebreroServiciosMP;
                            $gastoMensualMatMC = $gastoFebreroMaterialesMC;
                            $gastoMensualMatMP = $gastoFebreroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 3:
                            $mesPpto = "MARZO";
                            $gastoMensualServMC = $gastoMarzoServiciosMC;
                            $gastoMensualSerMP = $gastoMarzoServiciosMP;
                            $gastoMensualMatMC = $gastoMarzoMaterialesMC;
                            $gastoMensualMatMP = $gastoMarzoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 4:
                            $mesPpto = "ABRIL";
                            $gastoMensualServMC = $gastoAbrilServiciosMC;
                            $gastoMensualSerMP = $gastoAbrilServiciosMP;
                            $gastoMensualMatMC = $gastoAbrilMaterialesMC;
                            $gastoMensualMatMP = $gastoAbrilMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 5:
                            $mesPpto = "MAYO";
                            $gastoMensualServMC = $gastoMayoServiciosMC;
                            $gastoMensualSerMP = $gastoMayoServiciosMP;
                            $gastoMensualMatMC = $gastoMayoMaterialesMC;
                            $gastoMensualMatMP = $gastoMayoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 6:
                            $mesPpto = "JUNIO";
                            $gastoMensualServMC = $gastoJunioServiciosMC;
                            $gastoMensualSerMP = $gastoJunioServiciosMP;
                            $gastoMensualMatMC = $gastoJunioMaterialesMC;
                            $gastoMensualMatMP = $gastoJunioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 7:
                            $mesPpto = "JULIO";
                            $gastoMensualServMC = $gastoJulioServiciosMC;
                            $gastoMensualSerMP = $gastoJulioServiciosMP;
                            $gastoMensualMatMC = $gastoJulioMaterialesMC;
                            $gastoMensualMatMP = $gastoJulioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 8:
                            $mesPpto = "AGOSTO";
                            $gastoMensualServMC = $gastoAgostoServiciosMC;
                            $gastoMensualSerMP = $gastoAgostoServiciosMP;
                            $gastoMensualMatMC = $gastoAgostoMaterialesMC;
                            $gastoMensualMatMP = $gastoAgostoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 9:
                            $mesPpto = "SEPTIEMBRE";
                            $gastoMensualServMC = $gastoSeptiembreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoSeptiembreMaterialesMC;
                            $gastoMensualMatMP = $gastoSeptiembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 10:
                            $mesPpto = "OCTUBRE";
                            $gastoMensualServMC = $gastoOctubreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoOctubreMaterialesMC;
                            $gastoMensualMatMP = $gastoOctubreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 11:
                            $mesPpto = "NOVIEMBRE";
                            $gastoMensualServMC = $gastoNoviembreServiciosMC;
                            $gastoMensualSerMP = $gastoNoviembreServiciosMP;
                            $gastoMensualMatMC = $gastoNoviembreMaterialesMC;
                            $gastoMensualMatMP = $gastoNoviembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 12:
                            $mesPpto = "DICIEMBRE";
                            $gastoMensualServMC = $gastoDiciembreServiciosMC;
                            $gastoMensualSerMP = $gastoDiciembreServiciosMP;
                            $gastoMensualMatMC = $gastoDiciembreMaterialesMC;
                            $gastoMensualMatMP = $gastoDiciembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                    }



                    if ($currentMonth == $i) {
                        //Widget total serv + mat
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalTRSMP) . "</h6>";
                        if ($pptoMensualTotalTRSMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalTRSMC) . "</h6>";
                        if ($pptoMensualTotalTRSMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerTRSMP) . "</h6>";
                        if ($pptoMensualSerTRSMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerTRSMC) . "</h6>";
                        if ($pptoMensualSerTRSMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";


                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatTRSMP) . "</h6>";
                        if ($pptoMensualMatTRSMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatTRSMC) . "</h6>";
                        if ($pptoMensualMatTRSMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";

                        break;
                    } else {
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalTRSMP) . "</h6>";
                        if ($pptoMensualTotalTRSMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalTRSMC) . "</h6>";
                        if ($pptoMensualTotalTRSMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerTRSMP) . "</h6>";
                        if ($pptoMensualSerTRSMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerTRSMC) . "</h6>";
                        if ($pptoMensualSerTRSMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatTRSMP) . "</h6>";
                        if ($pptoMensualMatTRSMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatTRSMC) . "</h6>";
                        if ($pptoMensualMatTRSMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";
                    }
                    $arrayMeses[] = "$mesPpto";
                    $arrayPresupuestoMensualMC[] = round($pptoMensualTotalTRSMC);
                    $arrayPresupuestoMensualMP[] = round($pptoMensualTotalTRSMP);
                    $arrayGastoMensualMC[] = round($gastoMensualMC);
                    $arrayGastoMensualMP[] = round($gastoMensualMP);

                    $arrayPresupuestoServMensualMC[] = round($pptoMensualSerTRSMC);
                    $arrayPresupuestoServMensualMP[] = round($pptoMensualSerTRSMP);
                    $arrayGastoServMensualMC[] = round($gastoMensualServMC);
                    $arrayGastoServMensualMP[] = round($gastoMensualSerMP);

                    $arrayPresupuestoMatMensualMC[] = round($pptoMensualMatTRSMC);
                    $arrayPresupuestoMatMensualMP[] = round($pptoMensualMatTRSMP);
                    $arrayGastoMatMensualMC[] = round($gastoMensualMatMC);
                    $arrayGastoMatMensualMP[] = round($gastoMensualMatMP);
                }

                $ppto->arrayMeses = $arrayMeses;
                $ppto->arrayPptoMC = $arrayPresupuestoMensualMC;
                $ppto->arrayPptoMP = $arrayPresupuestoMensualMP;
                $ppto->arrayGastoMC = $arrayGastoMensualMC;
                $ppto->arrayGastoMP = $arrayGastoMensualMP;

                $ppto->arrayPptoMCServ = $arrayPresupuestoServMensualMC;
                $ppto->arrayPptoMPServ = $arrayPresupuestoServMensualMP;
                $ppto->arrayGastoMCServ = $arrayGastoServMensualMC;
                $ppto->arrayGastoMPServ = $arrayGastoServMensualMP;

                $ppto->arrayPptoMCMat = $arrayPresupuestoMatMensualMC;
                $ppto->arrayPptoMPMat = $arrayPresupuestoMatMensualMP;
                $ppto->arrayGastoMCMat = $arrayGastoMatMensualMC;
                $ppto->arrayGastoMPMat = $arrayGastoMatMensualMP;

                break;
            case 'cardGP':
//Servicios
                //GP
                $gastoMensualServiciosGPMC = 0;
                $gastoMensualServiciosGPMP = 0;
                $gastoAnualServiciosGPMC = 0;
                $gastoAnualServiciosGPMP = 0;
                $porcAnualServiciosGPMC = 0;
                $porcAnualServiciosGPMP = 0;

                $gastoEneroServiciosMC = 0;
                $gastoEneroServiciosMP = 0;
                $gastoFebreroServiciosMC = 0;
                $gastoFebreroServiciosMP = 0;
                $gastoMarzoServiciosMC = 0;
                $gastoMarzoServiciosMP = 0;
                $gastoAbrilServiciosMC = 0;
                $gastoAbrilServiciosMP = 0;
                $gastoMayoServiciosMC = 0;
                $gastoMayoServiciosMP = 0;
                $gastoJunioServiciosMC = 0;
                $gastoJunioServiciosMP = 0;
                $gastoJulioServiciosMC = 0;
                $gastoJulioServiciosMP = 0;
                $gastoAgostoServiciosMC = 0;
                $gastoAgostoServiciosMP = 0;
                $gastoSeptiembreServiciosMC = 0;
                $gastoSeptiembreServiciosMP = 0;
                $gastoOctubreServiciosMC = 0;
                $gastoOctubreServiciosMP = 0;
                $gastoNoviembreServiciosMC = 0;
                $gastoNoviembreServiciosMP = 0;
                $gastoDiciembreServiciosMC = 0;
                $gastoDiciembreServiciosMP = 0;


                $query = "SELECT * FROM t_gastos_servicios WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosGPMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosGPMC += $importe;
                                    }
                                } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosGPMP += $importe;
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMP += $importe;
                                            break;
                                    }
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosGPMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "GP") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosServicios .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosServicios .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fechaDocumento</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Materiales
//GP
                $gastoMensualMaterialesGPMC = 0;
                $gastoMensualMaterialesGPMP = 0;
                $gastoAnualMaterialesGPMC = 0;
                $gastoAnualMaterialesGPMP = 0;
                $porcAnualMaterialesGPMC = 0;
                $porcAnualMaterialesGPMP = 0;

                $gastoEneroMaterialesMC = 0;
                $gastoEneroMaterialesMP = 0;
                $gastoFebreroMaterialesMC = 0;
                $gastoFebreroMaterialesMP = 0;
                $gastoMarzoMaterialesMC = 0;
                $gastoMarzoMaterialesMP = 0;
                $gastoAbrilMaterialesMC = 0;
                $gastoAbrilMaterialesMP = 0;
                $gastoMayoMaterialesMC = 0;
                $gastoMayoMaterialesMP = 0;
                $gastoJunioMaterialesMC = 0;
                $gastoJunioMaterialesMP = 0;
                $gastoJulioMaterialesMC = 0;
                $gastoJulioMaterialesMP = 0;
                $gastoAgostoMaterialesMC = 0;
                $gastoAgostoMaterialesMP = 0;
                $gastoSeptiembreMaterialesMC = 0;
                $gastoSeptiembreMaterialesMP = 0;
                $gastoOctubreMaterialesMC = 0;
                $gastoOctubreMaterialesMP = 0;
                $gastoNoviembreMaterialesMC = 0;
                $gastoNoviembreMaterialesMP = 0;
                $gastoDiciembreMaterialesMC = 0;
                $gastoDiciembreMaterialesMP = 0;

                $query = "SELECT * FROM t_gastos_materiales WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumento = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumento);

                                if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesGPMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesGPMC += $importe;
                                    }
                                } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesGPMP += $importe;

                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMP += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesGPMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "GP") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosMateriales .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosMateriales .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fechaDocumento</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                $totalGastoAnualGPMC = $gastoAnualServiciosGPMC + $gastoAnualMaterialesGPMC;
                $totalGastoAnualGPMP = $gastoAnualServiciosGPMP + $gastoAnualMaterialesGPMP;

                $porcAnualGastoGPMC = ($totalGastoAnualGPMC * 100) / $pptoAnualGPMC;
                $porcAnualGastoGPMP = ($totalGastoAnualGPMP * 100) / $pptoAnualGPMP;

                $pptoMensualMatGPMC = $pptoAnualMatGPMC / 12;
                $pptoMensualSerGPMC = $pptoAnualSerGPMC / 12;
                $pptoMensualMatGPMP = $pptoAnualMatGPMP / 12;
                $pptoMensualSerGPMP = $pptoAnualSerGPMP / 12;

                $pptoMensualTotalGPMC = $pptoMensualMatGPMC + $pptoMensualSerGPMC;
                $pptoMensualTotalGPMP = $pptoMensualMatGPMP + $pptoMensualSerGPMP;

                $ppto->pptoAnual = "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                        . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:10px;}</style>"
                        . "<title>wigget</title>"
                        . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                        . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                        . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                        . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualGPMP) . "</text>"
                        . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualGPMP) . "</text>"
                        . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                        . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualGPMC) . "</text>"
                        . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualGPMC) . "</text>"
                        . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54L118.8,54z\"/>"
                        . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                        . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                        . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcAnualGastoGPMP) . "%</text>"
                        . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                        . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcAnualGastoGPMC) . "%</text>"
                        . "</svg>";

                $arrayMeses = array();
                $arrayPresupuestoMensualMP = array();
                $arrayPresupuestoMensualMC = array();
                $arrayGastoMensualMP = array();
                $arrayGastoMensualMC = array();

                $arrayPresupuestoServMensualMP = array();
                $arrayPresupuestoServMensualMC = array();
                $arrayGastoServMensualMP = array();
                $arrayGastoServMensualMC = array();

                $arrayPresupuestoMatMensualMP = array();
                $arrayPresupuestoMatMensualMC = array();
                $arrayGastoMatMensualMP = array();
                $arrayGastoMatMensualMC = array();

                for ($i = 1; $i <= 12; $i++) {
                    switch ($i) {
                        case 1:
                            $mesPpto = "ENERO";
                            $gastoMensualServMC = $gastoEneroServiciosMC;
                            $gastoMensualSerMP = $gastoEneroServiciosMP;
                            $gastoMensualMatMC = $gastoEneroMaterialesMC;
                            $gastoMensualMatMP = $gastoEneroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 2:
                            $mesPpto = "FEBRERO";
                            $gastoMensualServMC = $gastoFebreroServiciosMC;
                            $gastoMensualSerMP = $gastoFebreroServiciosMP;
                            $gastoMensualMatMC = $gastoFebreroMaterialesMC;
                            $gastoMensualMatMP = $gastoFebreroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 3:
                            $mesPpto = "MARZO";
                            $gastoMensualServMC = $gastoMarzoServiciosMC;
                            $gastoMensualSerMP = $gastoMarzoServiciosMP;
                            $gastoMensualMatMC = $gastoMarzoMaterialesMC;
                            $gastoMensualMatMP = $gastoMarzoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 4:
                            $mesPpto = "ABRIL";
                            $gastoMensualServMC = $gastoAbrilServiciosMC;
                            $gastoMensualSerMP = $gastoAbrilServiciosMP;
                            $gastoMensualMatMC = $gastoAbrilMaterialesMC;
                            $gastoMensualMatMP = $gastoAbrilMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 5:
                            $mesPpto = "MAYO";
                            $gastoMensualServMC = $gastoMayoServiciosMC;
                            $gastoMensualSerMP = $gastoMayoServiciosMP;
                            $gastoMensualMatMC = $gastoMayoMaterialesMC;
                            $gastoMensualMatMP = $gastoMayoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 6:
                            $mesPpto = "JUNIO";
                            $gastoMensualServMC = $gastoJunioServiciosMC;
                            $gastoMensualSerMP = $gastoJunioServiciosMP;
                            $gastoMensualMatMC = $gastoJunioMaterialesMC;
                            $gastoMensualMatMP = $gastoJunioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 7:
                            $mesPpto = "JULIO";
                            $gastoMensualServMC = $gastoJulioServiciosMC;
                            $gastoMensualSerMP = $gastoJulioServiciosMP;
                            $gastoMensualMatMC = $gastoJulioMaterialesMC;
                            $gastoMensualMatMP = $gastoJulioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 8:
                            $mesPpto = "AGOSTO";
                            $gastoMensualServMC = $gastoAgostoServiciosMC;
                            $gastoMensualSerMP = $gastoAgostoServiciosMP;
                            $gastoMensualMatMC = $gastoAgostoMaterialesMC;
                            $gastoMensualMatMP = $gastoAgostoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 9:
                            $mesPpto = "SEPTIEMBRE";
                            $gastoMensualServMC = $gastoSeptiembreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoSeptiembreMaterialesMC;
                            $gastoMensualMatMP = $gastoSeptiembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 10:
                            $mesPpto = "OCTUBRE";
                            $gastoMensualServMC = $gastoOctubreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoOctubreMaterialesMC;
                            $gastoMensualMatMP = $gastoOctubreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 11:
                            $mesPpto = "NOVIEMBRE";
                            $gastoMensualServMC = $gastoNoviembreServiciosMC;
                            $gastoMensualSerMP = $gastoNoviembreServiciosMP;
                            $gastoMensualMatMC = $gastoNoviembreMaterialesMC;
                            $gastoMensualMatMP = $gastoNoviembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 12:
                            $mesPpto = "DICIEMBRE";
                            $gastoMensualServMC = $gastoDiciembreServiciosMC;
                            $gastoMensualSerMP = $gastoDiciembreServiciosMP;
                            $gastoMensualMatMC = $gastoDiciembreMaterialesMC;
                            $gastoMensualMatMP = $gastoDiciembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                    }

                    if ($currentMonth == $i) {
                        //Widget total serv + mat
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalGPMP) . "</h6>";
                        if ($pptoMensualTotalGPMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalGPMC) . "</h6>";
                        if ($pptoMensualTotalGPMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerGPMP) . "</h6>";
                        if ($pptoMensualSerGPMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerGPMC) . "</h6>";
                        if ($pptoMensualSerGPMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";


                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatGPMP) . "</h6>";
                        if ($pptoMensualMatGPMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatGPMC) . "</h6>";
                        if ($pptoMensualMatGPMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";

                        break;
                    } else {
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalGPMP) . "</h6>";
                        if ($pptoMensualTotalGPMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalGPMC) . "</h6>";
                        if ($pptoMensualTotalGPMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerGPMP) . "</h6>";
                        if ($pptoMensualSerGPMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerGPMC) . "</h6>";
                        if ($pptoMensualSerGPMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatGPMP) . "</h6>";
                        if ($pptoMensualMatGPMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatGPMC) . "</h6>";
                        if ($pptoMensualMatGPMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";
                    }

                    $arrayMeses[] = "$mesPpto";
                    $arrayPresupuestoMensualMC[] = round($pptoMensualTotalGPMC);
                    $arrayPresupuestoMensualMP[] = round($pptoMensualTotalGPMP);
                    $arrayGastoMensualMC[] = round($gastoMensualMC);
                    $arrayGastoMensualMP[] = round($gastoMensualMP);

                    $arrayPresupuestoServMensualMC[] = round($pptoMensualSerGPMC);
                    $arrayPresupuestoServMensualMP[] = round($pptoMensualSerGPMP);
                    $arrayGastoServMensualMC[] = round($gastoMensualServMC);
                    $arrayGastoServMensualMP[] = round($gastoMensualSerMP);

                    $arrayPresupuestoMatMensualMC[] = round($pptoMensualMatGPMC);
                    $arrayPresupuestoMatMensualMP[] = round($pptoMensualMatGPMP);
                    $arrayGastoMatMensualMC[] = round($gastoMensualMatMC);
                    $arrayGastoMatMensualMP[] = round($gastoMensualMatMP);
                }
                $ppto->arrayMeses = $arrayMeses;
                $ppto->arrayPptoMC = $arrayPresupuestoMensualMC;
                $ppto->arrayPptoMP = $arrayPresupuestoMensualMP;
                $ppto->arrayGastoMC = $arrayGastoMensualMC;
                $ppto->arrayGastoMP = $arrayGastoMensualMP;

                $ppto->arrayPptoMCServ = $arrayPresupuestoServMensualMC;
                $ppto->arrayPptoMPServ = $arrayPresupuestoServMensualMP;
                $ppto->arrayGastoMCServ = $arrayGastoServMensualMC;
                $ppto->arrayGastoMPServ = $arrayGastoServMensualMP;

                $ppto->arrayPptoMCMat = $arrayPresupuestoMatMensualMC;
                $ppto->arrayPptoMPMat = $arrayPresupuestoMatMensualMP;
                $ppto->arrayGastoMCMat = $arrayGastoMatMensualMC;
                $ppto->arrayGastoMPMat = $arrayGastoMatMensualMP;
                break;
            case 'cardZI':
//Servicios
                //ZI
                $gastoMensualServiciosZIMC = 0;
                $gastoMensualServiciosZIMP = 0;
                $gastoAnualServiciosZIMC = 0;
                $gastoAnualServiciosZIMP = 0;
                $porcAnualServiciosZIMC = 0;
                $porcAnualServiciosZIMP = 0;

                $gastoEneroServiciosMC = 0;
                $gastoEneroServiciosMP = 0;
                $gastoFebreroServiciosMC = 0;
                $gastoFebreroServiciosMP = 0;
                $gastoMarzoServiciosMC = 0;
                $gastoMarzoServiciosMP = 0;
                $gastoAbrilServiciosMC = 0;
                $gastoAbrilServiciosMP = 0;
                $gastoMayoServiciosMC = 0;
                $gastoMayoServiciosMP = 0;
                $gastoJunioServiciosMC = 0;
                $gastoJunioServiciosMP = 0;
                $gastoJulioServiciosMC = 0;
                $gastoJulioServiciosMP = 0;
                $gastoAgostoServiciosMC = 0;
                $gastoAgostoServiciosMP = 0;
                $gastoSeptiembreServiciosMC = 0;
                $gastoSeptiembreServiciosMP = 0;
                $gastoOctubreServiciosMC = 0;
                $gastoOctubreServiciosMP = 0;
                $gastoNoviembreServiciosMC = 0;
                $gastoNoviembreServiciosMP = 0;
                $gastoDiciembreServiciosMC = 0;
                $gastoDiciembreServiciosMP = 0;


                $query = "SELECT * FROM t_gastos_servicios WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosZIMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosZIMC += $importe;
                                    }
                                } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosZIMP += $importe;
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroServiciosMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroServiciosMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoServiciosMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilServiciosMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoServiciosMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioServiciosMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioServiciosMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoServiciosMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreServiciosMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreServiciosMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreServiciosMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreServiciosMP += $importe;
                                            break;
                                    }
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosZIMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "ZI") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosServicios .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosServicios .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fechaDocumento</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Materiales
//ZI
                $gastoMensualMaterialesZIMC = 0;
                $gastoMensualMaterialesZIMP = 0;
                $gastoAnualMaterialesZIMC = 0;
                $gastoAnualMaterialesZIMP = 0;
                $porcAnualMaterialesZIMC = 0;
                $porcAnualMaterialesZIMP = 0;

                $gastoEneroMaterialesMC = 0;
                $gastoEneroMaterialesMP = 0;
                $gastoFebreroMaterialesMC = 0;
                $gastoFebreroMaterialesMP = 0;
                $gastoMarzoMaterialesMC = 0;
                $gastoMarzoMaterialesMP = 0;
                $gastoAbrilMaterialesMC = 0;
                $gastoAbrilMaterialesMP = 0;
                $gastoMayoMaterialesMC = 0;
                $gastoMayoMaterialesMP = 0;
                $gastoJunioMaterialesMC = 0;
                $gastoJunioMaterialesMP = 0;
                $gastoJulioMaterialesMC = 0;
                $gastoJulioMaterialesMP = 0;
                $gastoAgostoMaterialesMC = 0;
                $gastoAgostoMaterialesMP = 0;
                $gastoSeptiembreMaterialesMC = 0;
                $gastoSeptiembreMaterialesMP = 0;
                $gastoOctubreMaterialesMC = 0;
                $gastoOctubreMaterialesMP = 0;
                $gastoNoviembreMaterialesMC = 0;
                $gastoNoviembreMaterialesMP = 0;
                $gastoDiciembreMaterialesMC = 0;
                $gastoDiciembreMaterialesMP = 0;

                $query = "SELECT * FROM t_gastos_materiales WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesZIMC += $importe;

                                    //Sumar los gastos mensuales de los meses que han trancurrido
                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMC += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMC += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMC += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMC += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMC += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMC += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMC += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMC += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMC += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMC += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMC += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMC += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesZIMC += $importe;
                                    }
                                } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesZIMP += $importe;

                                    switch ($fecha) {
                                        case 'January':
                                            $gastoEneroMaterialesMP += $importe;
                                            break;
                                        case 'February':
                                            $gastoFebreroMaterialesMP += $importe;
                                            break;
                                        case 'March':
                                            $gastoMarzoMaterialesMP += $importe;
                                            break;
                                        case 'April':
                                            $gastoAbrilMaterialesMP += $importe;
                                            break;
                                        case 'May':
                                            $gastoMayoMaterialesMP += $importe;
                                            break;
                                        case 'June':
                                            $gastoJunioMaterialesMP += $importe;
                                            break;
                                        case 'July':
                                            $gastoJulioMaterialesMP += $importe;
                                            break;
                                        case 'August':
                                            $gastoAgostoMaterialesMP += $importe;
                                            break;
                                        case 'September':
                                            $gastoSeptiembreMaterialesMP += $importe;
                                            break;
                                        case 'October':
                                            $gastoOctubreMaterialesMP += $importe;
                                            break;
                                        case 'November':
                                            $gastoNoviembreMaterialesMP += $importe;
                                            break;
                                        case 'December':
                                            $gastoDiciembreMaterialesMP += $importe;
                                            break;
                                    }

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesZIMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "ZI") {
                                    if ($idDestino == 10) {
                                        $ppto->tablaGastosMateriales .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fecha</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    } else {
                                        if ($destino == $destinoCECO) {
                                            $ppto->tablaGastosMateriales .= "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$nombreCECO</td>"
                                                    . "<td>$numDocumento</td>"
                                                    . "<td>$fecha</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$nombreDocumento</td>"
                                                    . "</tr>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                $totalGastoAnualZIMC = $gastoAnualServiciosZIMC + $gastoAnualMaterialesZIMC;
                $totalGastoAnualZIMP = $gastoAnualServiciosZIMP + $gastoAnualMaterialesZIMP;

                $porcAnualGastoZIMC = ($totalGastoAnualZIMC * 100) / $pptoAnualZIMC;
                $porcAnualGastoZIMP = ($totalGastoAnualZIMP * 100) / $pptoAnualZIMP;

                $pptoMensualMatZIMC = $pptoAnualMatZIMC / 12;
                $pptoMensualSerZIMC = $pptoAnualSerZIMC / 12;
                $pptoMensualMatZIMP = $pptoAnualMatZIMP / 12;
                $pptoMensualSerZIMP = $pptoAnualSerZIMP / 12;

                $pptoMensualTotalZIMC = $pptoMensualMatZIMC + $pptoMensualSerZIMC;
                $pptoMensualTotalZIMP = $pptoMensualMatZIMP + $pptoMensualSerZIMP;

                $ppto->pptoAnual = "<svg version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 40 158.4 102.3\" style=\"enable-background:new 0 0 158.4 102.3;\" xml:space=\"preserve\">"
                        . "<style type=\"text/css\">.st0{fill:#EBE7FF;}.st1{fill:#D7D0FB;}.st2{fill:#7866D3;}.st3{font-family:'Segoe Pro Semibold';}.st4{font-size:7px;}.st5{font-family:'Segoe Pro Light';}.st6{fill:#E5F5FF;}.st7{fill:#BEE7FF;}.st8{fill:#1997E3;}.st9{font-family:'Segoe Pro Bold';}.st10{font-size:20px;}.st11{font-size:10px;}</style>"
                        . "<title>wigget</title>"
                        . "<rect x=\"12.4\" y=\"55.5\" class=\"st0\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st1\" d=\"M66.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C65.7,46.5,66.4,47.2,66.4,48.1z\"/>"
                        . "<path class=\"st2\" d=\"M40,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L37,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.9v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0L37,52l1.6-4h1.3L40,54z\"/>"
                        . "<path class=\"st2\" d=\"M42.3,51.8V54h-1v-6h1.8c0.6,0,1.1,0.1,1.6,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.5-0.2,1-0.6,1.4c-0.4,0.4-1,0.6-1.6,0.6H42.3z M42.3,48.8V51H43c0.4,0,0.7-0.1,1-0.3c0.2-0.2,0.3-0.5,0.3-0.8c0-0.7-0.4-1.1-1.2-1.1L42.3,48.8z\"/>"
                        . "<text id=\"mptotal\" transform=\"matrix(1 0 0 1 16.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualZIMP) . "</text>"
                        . "<text id=\"mpg\" transform=\"matrix(1 0 0 1 17.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualZIMP) . "</text>"
                        . "<rect x=\"91.4\" y=\"55.5\" class=\"st6\" width=\"54\" height=\"25\"/>"
                        . "<path class=\"st7\" d=\"M145.4,48.1v7.4h-54v-7.4c0-0.9,0.7-1.6,1.6-1.6c0,0,0,0,0,0h50.7C144.7,46.5,145.4,47.2,145.4,48.1z\"/>"
                        . "<text id=\"mctotal\" transform=\"matrix(1 0 0 1 95.14 65.61)\" class=\"st3 st4\">" . money_format("%.0n", $pptoAnualZIMC) . "</text>"
                        . "<text id=\"mcg\" transform=\"matrix(1 0 0 1 96.35 75.61)\" class=\"st5 st4\">" . money_format("%.0n", $totalGastoAnualZIMC) . "</text>"
                        . "<path class=\"st8\" d=\"M118.8,54h-1v-3.9c0-0.4,0-0.8,0.1-1.2l0,0c0,0.2-0.1,0.4-0.2,0.6L116,54h-0.7l-1.8-4.4c-0.1-0.2-0.1-0.4-0.2-0.6l0,0v5h-0.8v-6h1.4l1.6,4c0.1,0.2,0.2,0.5,0.2,0.7l0,0c0.1-0.2,0.2-0.5,0.3-0.7l1.6-4h1.3L118.8,54L118.8,54z\"/>"
                        . "<path class=\"st8\" d=\"M124.4,53.7c-0.5,0.3-1.1,0.4-1.7,0.3c-0.8,0-1.5-0.3-2.1-0.8c-0.5-0.6-0.8-1.4-0.8-2.2c0-0.9,0.3-1.7,0.9-2.3c0.6-0.6,1.4-0.9,2.2-0.9c0.5,0,0.9,0.1,1.4,0.2v1c-0.4-0.2-0.8-0.4-1.3-0.4c-0.6,0-1.2,0.2-1.6,0.6c-0.4,0.5-0.6,1.1-0.6,1.7c0,0.6,0.2,1.2,0.6,1.6c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1-0.1,1.5-0.4V53.7z\"/>"
                        . "<path class=\"st1\" d=\"M56.8,85.6H43l-3.6-3.7l-3.6,3.7h-14c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C56.9,85.6,56.9,85.6,56.8,85.6z\"/>"
                        . "<text id=\"mppor\" transform=\"matrix(1 0 0 1 23.6 98.49)\" class=\"st2 st9 st11\">" . round($porcAnualGastoZIMP) . "%</text>"
                        . "<path class=\"st7\" d=\"M135.9,85.6H122l-3.6-3.7l-3.6,3.7h-13.9c-1.3,0-2.4,1.1-2.4,2.4v11.9c0,1.3,1.1,2.4,2.4,2.4h34.9c1.3,0,2.4-1.1,2.4-2.4V88c0.1-1.3-0.9-2.3-2.2-2.4C136,85.6,135.9,85.6,135.9,85.6z\"/>"
                        . "<text id=\"mcpor\" transform=\"matrix(1 0 0 1 102.6 98.49)\" class=\"st8 st9 st11\">" . round($porcAnualGastoZIMC) . "%</text>"
                        . "</svg>";

                $arrayMeses = array();
                $arrayPresupuestoMensualMP = array();
                $arrayPresupuestoMensualMC = array();
                $arrayGastoMensualMP = array();
                $arrayGastoMensualMC = array();

                $arrayPresupuestoServMensualMP = array();
                $arrayPresupuestoServMensualMC = array();
                $arrayGastoServMensualMP = array();
                $arrayGastoServMensualMC = array();

                $arrayPresupuestoMatMensualMP = array();
                $arrayPresupuestoMatMensualMC = array();
                $arrayGastoMatMensualMP = array();
                $arrayGastoMatMensualMC = array();
                for ($i = 1; $i <= 12; $i++) {
                    switch ($i) {
                        case 1:
                            $mesPpto = "ENERO";
                            $gastoMensualServMC = $gastoEneroServiciosMC;
                            $gastoMensualSerMP = $gastoEneroServiciosMP;
                            $gastoMensualMatMC = $gastoEneroMaterialesMC;
                            $gastoMensualMatMP = $gastoEneroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 2:
                            $mesPpto = "FEBRERO";
                            $gastoMensualServMC = $gastoFebreroServiciosMC;
                            $gastoMensualSerMP = $gastoFebreroServiciosMP;
                            $gastoMensualMatMC = $gastoFebreroMaterialesMC;
                            $gastoMensualMatMP = $gastoFebreroMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 3:
                            $mesPpto = "MARZO";
                            $gastoMensualServMC = $gastoMarzoServiciosMC;
                            $gastoMensualSerMP = $gastoMarzoServiciosMP;
                            $gastoMensualMatMC = $gastoMarzoMaterialesMC;
                            $gastoMensualMatMP = $gastoMarzoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 4:
                            $mesPpto = "ABRIL";
                            $gastoMensualServMC = $gastoAbrilServiciosMC;
                            $gastoMensualSerMP = $gastoAbrilServiciosMP;
                            $gastoMensualMatMC = $gastoAbrilMaterialesMC;
                            $gastoMensualMatMP = $gastoAbrilMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 5:
                            $mesPpto = "MAYO";
                            $gastoMensualServMC = $gastoMayoServiciosMC;
                            $gastoMensualSerMP = $gastoMayoServiciosMP;
                            $gastoMensualMatMC = $gastoMayoMaterialesMC;
                            $gastoMensualMatMP = $gastoMayoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 6:
                            $mesPpto = "JUNIO";
                            $gastoMensualServMC = $gastoJunioServiciosMC;
                            $gastoMensualSerMP = $gastoJunioServiciosMP;
                            $gastoMensualMatMC = $gastoJunioMaterialesMC;
                            $gastoMensualMatMP = $gastoJunioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 7:
                            $mesPpto = "JULIO";
                            $gastoMensualServMC = $gastoJulioServiciosMC;
                            $gastoMensualSerMP = $gastoJulioServiciosMP;
                            $gastoMensualMatMC = $gastoJulioMaterialesMC;
                            $gastoMensualMatMP = $gastoJulioMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 8:
                            $mesPpto = "AGOSTO";
                            $gastoMensualServMC = $gastoAgostoServiciosMC;
                            $gastoMensualSerMP = $gastoAgostoServiciosMP;
                            $gastoMensualMatMC = $gastoAgostoMaterialesMC;
                            $gastoMensualMatMP = $gastoAgostoMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 9:
                            $mesPpto = "SEPTIEMBRE";
                            $gastoMensualServMC = $gastoSeptiembreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoSeptiembreMaterialesMC;
                            $gastoMensualMatMP = $gastoSeptiembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 10:
                            $mesPpto = "OCTUBRE";
                            $gastoMensualServMC = $gastoOctubreServiciosMC;
                            $gastoMensualSerMP = $gastoSeptiembreServiciosMP;
                            $gastoMensualMatMC = $gastoOctubreMaterialesMC;
                            $gastoMensualMatMP = $gastoOctubreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 11:
                            $mesPpto = "NOVIEMBRE";
                            $gastoMensualServMC = $gastoNoviembreServiciosMC;
                            $gastoMensualSerMP = $gastoNoviembreServiciosMP;
                            $gastoMensualMatMC = $gastoNoviembreMaterialesMC;
                            $gastoMensualMatMP = $gastoNoviembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                        case 12:
                            $mesPpto = "DICIEMBRE";
                            $gastoMensualServMC = $gastoDiciembreServiciosMC;
                            $gastoMensualSerMP = $gastoDiciembreServiciosMP;
                            $gastoMensualMatMC = $gastoDiciembreMaterialesMC;
                            $gastoMensualMatMP = $gastoDiciembreMaterialesMP;

                            $gastoMensualMC = $gastoMensualServMC + $gastoMensualMatMC;
                            $gastoMensualMP = $gastoMensualSerMP + $gastoMensualMatMP;
                            break;
                    }

                    if ($currentMonth == $i) {
                        //Widget total serv + mat
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalZIMP) . "</h6>";
                        if ($pptoMensualTotalZIMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalZIMC) . "</h6>";
                        if ($pptoMensualTotalZIMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerZIMP) . "</h6>";
                        if ($pptoMensualSerZIMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerZIMC) . "</h6>";
                        if ($pptoMensualSerZIMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";


                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2 rounded shadow border-normal\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatZIMP) . "</h6>";
                        if ($pptoMensualMatZIMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatZIMC) . "</h6>";
                        if ($pptoMensualMatZIMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";

                        break;
                    } else {
                        $ppto->pptoMensualTotal .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalZIMP) . "</h6>";
                        if ($pptoMensualTotalZIMP < $gastoMensualMP) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMP) . "</h6>";
                        }

                        $ppto->pptoMensualTotal .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualTotalZIMC) . "</h6>";
                        if ($pptoMensualTotalZIMC < $gastoMensualMC) {
                            $ppto->pptoMensualTotal .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualTotal .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMC) . "</h6>";
                        }
                        $ppto->pptoMensualTotal .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget de Servicios
                        $ppto->pptoMensualServicios .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerZIMP) . "</h6>";
                        if ($pptoMensualSerZIMP < $gastoMensualSerMP) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualSerMP) . "</h6>";
                        }

                        $ppto->pptoMensualServicios .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualSerZIMC) . "</h6>";
                        if ($pptoMensualSerZIMC < $gastoMensualServMC) {
                            $ppto->pptoMensualServicios .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualServicios .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualServMC) . "</h6>";
                        }
                        $ppto->pptoMensualServicios .= "</div>"
                                . "</div>"
                                . "</div>";

                        //Widget Materiales
                        $ppto->pptoMensualMateriales .= "<div class=\"col-5 col-md-2 col-lg-2 col-xxl-1 text-center mr-2\">"
                                . "<div class=\"row\">"
                                . "<div class=\"col-12 py-0 my-0\">"
                                . "<p class=\"spdisplaysemibold\">$mesPpto</p>"
                                . "</div>"
                                . "<div class=\"col-12 bg-azulc rounded-3 mb-2 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MP</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatZIMP) . "</h6>";
                        if ($pptoMensualMatZIMP < $gastoMensualMatMP) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMP) . "</h6>";
                        }

                        $ppto->pptoMensualMateriales .= "</div>"
                                . "<div class=\"col-12 bg-rojoc rounded-3 hvr-grow-shadow\">"
                                . "<h5 class=\"spdisplaysemibold\">MC</h5>"
                                . "<h6 class=\"spdisplaysemibold\">" . money_format("%.0n", $pptoMensualMatZIMC) . "</h6>";
                        if ($pptoMensualMatZIMC < $gastoMensualMatMC) {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"text-danger\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        } else {
                            $ppto->pptoMensualMateriales .= "<h6 class=\"\">" . money_format("%.0n", $gastoMensualMatMC) . "</h6>";
                        }
                        $ppto->pptoMensualMateriales .= "</div>"
                                . "</div>"
                                . "</div>";
                    }
                    $arrayMeses[] = "$mesPpto";
                    $arrayPresupuestoMensualMC[] = round($pptoMensualTotalZIMC);
                    $arrayPresupuestoMensualMP[] = round($pptoMensualTotalZIMP);
                    $arrayGastoMensualMC[] = round($gastoMensualMC);
                    $arrayGastoMensualMP[] = round($gastoMensualMP);

                    $arrayPresupuestoServMensualMC[] = round($pptoMensualSerZIMC);
                    $arrayPresupuestoServMensualMP[] = round($pptoMensualSerZIMP);
                    $arrayGastoServMensualMC[] = round($gastoMensualServMC);
                    $arrayGastoServMensualMP[] = round($gastoMensualSerMP);

                    $arrayPresupuestoMatMensualMC[] = round($pptoMensualMatZIMC);
                    $arrayPresupuestoMatMensualMP[] = round($pptoMensualMatZIMP);
                    $arrayGastoMatMensualMC[] = round($gastoMensualMatMC);
                    $arrayGastoMatMensualMP[] = round($gastoMensualMatMP);
                }

                $ppto->arrayMeses = $arrayMeses;
                $ppto->arrayPptoMC = $arrayPresupuestoMensualMC;
                $ppto->arrayPptoMP = $arrayPresupuestoMensualMP;
                $ppto->arrayGastoMC = $arrayGastoMensualMC;
                $ppto->arrayGastoMP = $arrayGastoMensualMP;

                $ppto->arrayPptoMCServ = $arrayPresupuestoServMensualMC;
                $ppto->arrayPptoMPServ = $arrayPresupuestoServMensualMP;
                $ppto->arrayGastoMCServ = $arrayGastoServMensualMC;
                $ppto->arrayGastoMPServ = $arrayGastoServMensualMP;

                $ppto->arrayPptoMCMat = $arrayPresupuestoMatMensualMC;
                $ppto->arrayPptoMPMat = $arrayPresupuestoMatMensualMP;
                $ppto->arrayGastoMCMat = $arrayGastoMatMensualMC;
                $ppto->arrayGastoMPMat = $arrayGastoMatMensualMP;
                break;
            case 'btnDetalles':
                //Servicios
                //TRS
                $gastoMensualServiciosTRSMC = 0;
                $gastoMensualServiciosTRSMP = 0;
                $gastoAnualServiciosTRSMC = 0;
                $gastoAnualServiciosTRSMP = 0;
                $porcAnualServiciosTRSMC = 0;
                $porcAnualServiciosTRSMP = 0;

//GP
                $gastoMensualServiciosGPMC = 0;
                $gastoMensualServiciosGPMP = 0;
                $gastoAnualServiciosGPMC = 0;
                $gastoAnualServiciosGPMP = 0;
                $porcAnualServiciosGPMC = 0;
                $porcAnualServiciosGPMP = 0;

//ZI
                $gastoMensualServiciosZIMC = 0;
                $gastoMensualServiciosZIMP = 0;
                $gastoAnualServiciosZIMC = 0;
                $gastoAnualServiciosZIMP = 0;
                $porcAnualServiciosZIMC = 0;
                $porcAnualServiciosZIMP = 0;
                $query = "SELECT * FROM t_gastos_servicios WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosTRSMC += $importe;

                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosTRSMC += $importe;
                                    }
                                } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosTRSMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosTRSMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosGPMC += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosGPMC += $importe;
                                    }
                                } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosGPMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosGPMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualServiciosZIMC += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosZIMC += $importe;
                                    }
                                } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualServiciosZIMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualServiciosZIMP += $importe;
                                    }
                                }



                                if ($idDestino == 10) {
                                    $ppto->tablaGastosServicios .= "<tr>"
                                            . "<td style=\"display: none;\">$idDocumento</td>"
                                            . "<td>$destinoCECO</td>"
                                            . "<td class=\"fs-9\">$nombreCECO</td>"
                                            . "<td>$numDocumento</td>"
                                            . "<td>$fechaDocumento</td>"
                                            . "<td>" . money_format("%.0n", $importe) . "</td>"
                                            . "<td>$asignacion</td>"
                                            . "<td>$descripcion</td>"
                                            . "<td>$proveedor</td>"
                                            . "<td>$nombreDocumento</td>"
                                            . "</tr>";
                                } else {
                                    if ($destino == $destinoCECO) {
                                        $ppto->tablaGastosServicios .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }

                //Materiales
//TRS
                $gastoMensualMaterialesTRSMC = 0;
                $gastoMensualMaterialesTRSMP = 0;
                $gastoAnualMaterialesTRSMC = 0;
                $gastoAnualMaterialesTRSMP = 0;
                $porcAnualMaterialesTRSMC = 0;
                $porcAnualMaterialesTRSMP = 0;

//GP
                $gastoMensualMaterialesGPMC = 0;
                $gastoMensualMaterialesGPMP = 0;
                $gastoAnualMaterialesGPMC = 0;
                $gastoAnualMaterialesGPMP = 0;
                $porcAnualMaterialesGPMC = 0;
                $porcAnualMaterialesGPMP = 0;

//ZI
                $gastoMensualMaterialesZIMC = 0;
                $gastoMensualMaterialesZIMP = 0;
                $gastoAnualMaterialesZIMC = 0;
                $gastoAnualMaterialesZIMP = 0;
                $porcAnualMaterialesZIMC = 0;
                $porcAnualMaterialesZIMP = 0;
                $query = "SELECT * FROM t_gastos_materiales WHERE division = '$division'";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idDocumento = $dts['id'];
                            $numDocumento = $dts['num_documento'];
                            $fechaDocumento = $dts['fecha_documento'];
                            $importe = $dts['importe_ml3'];
                            $ceco = $dts['ceco'];
                            $asignacion = $dts['asignacion'];
                            $descripcion = $dts['texto'];
                            $proveedor = $dts['nombre_proveedor_af'];
                            $nombreDocumento = $dts['nombre_1'];

                            if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                
                            } else {
                                if ($importe == "") {
                                    $importe = 0;
                                }

                                $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $destinoCECO = $dts['destino'];
                                            $nombreCECO = $dts['nombre_ceco'];
                                            $marcaCECO = $dts['marca'];
                                            $tipoCECO = $dts['tipo'];
                                        }
                                    } else {
                                        $destinoCECO = "";
                                        $nombreCECO = "";
                                        $marcaCECO = "";
                                        $tipoCECO = "";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                $fechaDocumentoTime = strtotime($fechaDocumento);
                                $fecha = date("F", $fechaDocumentoTime);

                                if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesTRSMC += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesTRSMC += $importe;
                                    }
                                } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesTRSMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesTRSMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesGPMC += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesGPMC += $importe;
                                    }
                                } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesGPMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesGPMP += $importe;
                                    }
                                }

                                if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                                    //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                                    $gastoAnualMaterialesZIMC += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesZIMC += $importe;
                                    }
                                } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                                    $gastoAnualMaterialesZIMP += $importe;
                                    if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                                        $gastoMensualMaterialesZIMP += $importe;
                                    }
                                }



                                if ($idDestino == 10) {
                                    $ppto->tablaGastosMateriales .= "<tr>"
                                            . "<td style=\"display: none;\">$idDocumento</td>"
                                            . "<td>$destinoCECO</td>"
                                            . "<td class=\"fs-9\">$nombreCECO</td>"
                                            . "<td>$numDocumento</td>"
                                            . "<td>$fechaDocumento</td>"
                                            . "<td>" . money_format("%.0n", $importe) . "</td>"
                                            . "<td>$asignacion</td>"
                                            . "<td>$descripcion</td>"
                                            . "<td>$proveedor</td>"
                                            . "<td>$nombreDocumento</td>"
                                            . "</tr>";
                                } else {
                                    if ($destino == $destinoCECO) {
                                        $ppto->tablaGastosMateriales .= "<tr>"
                                                . "<td style=\"display: none;\">$idDocumento</td>"
                                                . "<td>$destinoCECO</td>"
                                                . "<td class=\"fs-9\">$nombreCECO</td>"
                                                . "<td>$numDocumento</td>"
                                                . "<td>$fechaDocumento</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$nombreDocumento</td>"
                                                . "</tr>";
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $ex) {
                    $ppto = $ex;
                }
                break;
        }

        $conn->cerrar();
        return $ppto;
    }

    public function agregarGasto($idDestino, $tipoGasto, $numDoc, $fechaSol, $fechaPosibleLlegada, $proveedor, $ceco, $seccion, $ubicacion, $items) {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
        $year = date("Y"); //Año en curso
        $fechaSol = date('Y-m-d', strtotime($fechaSol));
        $fechaPosibleLlegada = date('Y-m-d', strtotime($fechaPosibleLlegada));

        if ($ubicacion == "") {
            $ubicacion = 0;
        }

        //Obtener el total del gasto del documento
        $totalGasto = 0;
        for ($i = 0; $i < count($items); $i++) {
            if ($tipoGasto == 1) {
                $totalGasto += $items[$i][4];
            } else {
                $totalGasto += $items[$i][2];
            }
        }

        $query = "SELECT * FROM t_presupuestos_destinos WHERE id_destino = $idDestino AND año = '$year'";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idPpto = $dts['id'];
                }

                $query = "INSERT INTO t_gastos(id_presupuesto, ceco, num_documento, fecha_solicitud, fecha_posible_llegada, proveedor, tipo_gasto, id_destino, id_seccion, id_ubicacion) "
                        . "VALUES($idPpto, '$ceco', '$numDoc', '$fechaSol', '$fechaPosibleLlegada', '$proveedor', $tipoGasto, $idDestino, $seccion, $ubicacion)";
                try {
                    $resp = $conn->consulta($query);
                    $query = "SELECT LAST_INSERT_ID(id) AS last FROM t_gastos ORDER BY id DESC LIMIT 0,1";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idDocumento = $dts['last']; //ID del ultimo registro ingresado.
                            }
                        }
//                        insertar items
                        for ($i = 0; $i < count($items); $i++) {
                            if ($tipoGasto == 1) {
                                $query = "INSERT INTO t_gastos_items(id_presupuesto, tipo_gasto, id_documento, cod2bend, descripcion, tipo, fecha_solicitud, fecha_orden_compra, fecha_posible_llegada, cantidad, importe, id_destino, id_seccion, id_ubicacion) "
                                        . "VALUES($idPpto, $tipoGasto, $idDocumento, '" . $items[$i][1] . "', '" . $items[$i][2] . "', '" . $items[$i][0] . "', '$fechaSol', '$fechaSol', '$fechaPosibleLlegada', " . $items[$i][3] . ", " . $items[$i][4] . ", $idDestino, $seccion, $ubicacion)";

                                try {
                                    $resp = $conn->consulta($query);
                                    //$totalGasto += $items[$i][4];
                                } catch (Exception $ex) {
                                    $resp = $ex;
                                    break;
                                }
                            } else {
                                $query = "INSERT INTO t_gastos_items(id_presupuesto, tipo_gasto, id_documento, descripcion, cantidad, id_destino, id_seccion, id_ubicacion, fecha_aprobacion, fecha_posible_inicio, total_pago) "
                                        . "VALUES($idPpto, $tipoGasto, $idDocumento, '" . $items[$i][0] . "', " . $items[$i][1] . ", $idDestino, $seccion, $ubicacion, '$fechaSol', '$fechaPosibleLlegada', " . $items[$i][2] . ")";
                                try {
                                    $resp = $conn->consulta($query);
                                    //$totalGasto += $items[$i][2];
                                } catch (Exception $ex) {
                                    $resp = $ex;
                                    break;
                                }
                            }
                        }
                    } catch (Exception $ex) {
                        $resp = $ex;
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

    //Agregar presupuesto a los destinos
    public function agregarPresupuesto($idDestino, $presupuesto, $año, $mantto) {
        $conn = new Conexion();
        $conn->conectar();

        if ($mantto == "MC") {
            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id_destino = $idDestino";
        } else if ("MP") {
            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id_destino = $idDestino";
        }
        //SE VALIDA SI EXISTE UN PRESUPUESTO EN EL MISMO AÑO POR DESTINO

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDestinoPpto = $dts['id_destino'];
                    $añoPpto = $dts['año'];
                }
            } else {
                $idDestinoPpto = "";
                $añoPpto = "";
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        if ($idDestino == $idDestinoPpto && $año == $añoPpto) {
            $resp = "Ya existe presupuesto para este año";
        } else {
            //SE INSERTA EL PRESUPUESTO NUEVO
            if ($mantto == "MC") {
                $query = "INSERT INTO t_presupuestos_mc_destinos (id_destino, año, presupuesto) "
                        . "VALUES($idDestino, '$año', $presupuesto)";
            } else if ($mantto == "MP") {
                $query = "INSERT INTO t_presupuestos_mp_destinos (id_destino, año, presupuesto) "
                        . "VALUES($idDestino, '$año', $presupuesto)";
            }

            try {
                $resp = $conn->consulta($query);
                if ($resp == 1) {
                    //SE OBTIENE EL ID DE PRESUPUESTO INSERTADO
                    if ($mantto == "MC") {
                        $query = "SELECT LAST_INSERT_ID(id) AS last FROM t_presupuestos_mc_destinos ORDER BY id DESC LIMIT 0,1";
                    } else if ($mantto == "MP") {
                        $query = "SELECT LAST_INSERT_ID(id) AS last FROM t_presupuestos_mp_destinos ORDER BY id DESC LIMIT 0,1";
                    }
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idPptoD = $dts['last']; //ID del ultimo registro ingresado.
                            }
                        }
                    } catch (Exception $ex) {
                        $resp = $ex;
                    }

                    //Se verifica si el destino tiene GP y TRS;
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

                    //Se divide el presupuesto entre las fases del destino
                    if ($gp == "SI" && $trs == "SI") {//Si tiene tanto GP como TRS
                        $porc = 100 / 3;
                        $pptoGP = ($presupuesto * $porc) / 100;
                        $pptoTRS = ($presupuesto * $porc) / 100;
                        $pptoZI = ($presupuesto * $porc) / 100;

                        if ($mantto == "MC") {
                            $query = "UPDATE t_presupuestos_mc_destinos SET porc_gp = $porc, porc_trs = $porc, "
                                    . "porc_zi = $porc, ppto_gp = $pptoGP, ppto_trs = $pptoTRS, ppto_zi = $pptoZI WHERE id = $idPptoD";
                        } else if ($mantto == "MP") {
                            $query = "UPDATE t_presupuestos_mp_destinos SET porc_gp = $porc, porc_trs = $porc, "
                                    . "porc_zi = $porc, ppto_gp = $pptoGP, ppto_trs = $pptoTRS, ppto_zi = $pptoZI WHERE id = $idPptoD";
                        }

                        //Se ejecuta la sentencia para insertar los porcentajes y el total del presupupesto por fase
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {//Si se inserto correctamente se calculan el valor del ppto de mp y mc por fase
                                $materialesGP = ($pptoGP * 50) / 100;
                                $serviciosGP = ($pptoGP * 50) / 100;
                                $materialesTRS = ($pptoTRS * 50) / 100;
                                $serviciosTRS = ($pptoTRS * 50) / 100;
                                $materialesZI = ($pptoZI * 50) / 100;
                                $serviciosZI = ($pptoZI * 50) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_gp = 50, porc_servicios_gp = 50, "
                                            . "porc_materiales_trs = 50, porc_servicios_trs = 50, porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                            . "materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, materiales_zi = $materialesZI, "
                                            . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                } else if ($mantto == "MP") {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_gp = 50, porc_servicios_gp = 50, "
                                            . "porc_materiales_trs = 50, porc_servicios_trs = 50, porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                            . "materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, materiales_zi = $materialesZI, "
                                            . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        //Se calcula el presupuesto mensual por mp y mc
                                        $porcMensual = 100 / 12;
                                        $serviciosGPMensual = ($serviciosGP * $porcMensual) / 100;
                                        $materialesGPMensual = ($materialesGP * $porcMensual) / 100;
                                        $serviciosTRSMensual = ($serviciosTRS * $porcMensual) / 100;
                                        $materialesTRSMensual = ($materialesTRS * $porcMensual) / 100;
                                        $serviciosZIMensual = ($serviciosZI * $porcMensual) / 100;
                                        $materialesZIMensual = ($materialesZI * $porcMensual) / 100;

                                        //SE CREAN LOS 12 MESES DEL PRESUPUESTO
                                        for ($i = 0; $i < 12; $i++) {
                                            switch ($i) {
                                                case 0:
                                                    $mes = "ENERO";
                                                    break;
                                                case 1:
                                                    $mes = "FEBRERO";
                                                    break;
                                                case 2:
                                                    $mes = "MARZO";
                                                    break;
                                                case 3:
                                                    $mes = "ABRIL";
                                                    break;
                                                case 4:
                                                    $mes = "MAYO";
                                                    break;
                                                case 5:
                                                    $mes = "JUNIO";
                                                    break;
                                                case 6:
                                                    $mes = "JULIO";
                                                    break;
                                                case 7:
                                                    $mes = "AGOSTO";
                                                    break;
                                                case 8:
                                                    $mes = "SEPTIEMBRE";
                                                    break;
                                                case 9:
                                                    $mes = "OCTUBRE";
                                                    break;
                                                case 10:
                                                    $mes = "NOVIEMBRE";
                                                    break;
                                                case 11:
                                                    $mes = "DICIEMBRE";
                                                    break;
                                            }

                                            if ($mantto == "MC") {
                                                $query = "INSERT INTO t_presupuesto_mc_mensual (id_presupuesto, mes, porc_servicios_gp, "
                                                        . "porc_materiales_gp, servicios_gp, materiales_gp, porc_servicios_trs, porc_materiales_trs, servicios_trs, materiales_trs, "
                                                        . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                        . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosGPMensual, $materialesGPMensual, "
                                                        . "$porcMensual, $porcMensual, $serviciosTRSMensual, $materialesTRSMensual, $porcMensual, $porcMensual, "
                                                        . "$serviciosZIMensual, $materialesZIMensual)";
                                            } else if ($mantto == "MP") {
                                                $query = "INSERT INTO t_presupuesto_mp_mensual (id_presupuesto, mes, porc_servicios_gp, "
                                                        . "porc_materiales_gp, servicios_gp, materiales_gp, porc_servicios_trs, porc_materiales_trs, servicios_trs, materiales_trs, "
                                                        . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                        . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosGPMensual, $materialesGPMensual, "
                                                        . "$porcMensual, $porcMensual, $serviciosTRSMensual, $materialesTRSMensual, $porcMensual, $porcMensual, "
                                                        . "$serviciosZIMensual, $materialesZIMensual)";
                                            }
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
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    } else {
                        $porc = 100 / 2;
                        $pptoZI = ($presupuesto * $porc) / 100;
                        if ($gp == "SI") {//Si tiene GP
                            $pptoGP = ($presupuesto * $porc) / 100;

                            if ($mantto == "MC") {
                                $query = "UPDATE t_presupuestos_mc_destinos SET porc_gp = $porc, "
                                        . "porc_zi = $porc, ppto_gp = $pptoGP, ppto_zi = $pptoZI WHERE id = $idPptoD";
                            } else if ($mantto == "MP") {
                                $query = "UPDATE t_presupuestos_mp_destinos SET porc_gp = $porc, "
                                        . "porc_zi = $porc, ppto_gp = $pptoGP, ppto_zi = $pptoZI WHERE id = $idPptoD";
                            }

                            //Se ejecuta la sentencia para insertar los porcentajes y el total del presupupesto por fase
                            try {
                                $resp = $conn->consulta($query);
                                if ($resp == 1) {//Si se inserto correctamente se calculan el valor del ppto de mp y mc por fase
                                    $materialesGP = ($pptoGP * 50) / 100;
                                    $serviciosGP = ($pptoGP * 50) / 100;
                                    $materialesZI = ($pptoZI * 50) / 100;
                                    $serviciosZI = ($pptoZI * 50) / 100;

                                    if ($mantto == "MC") {
                                        $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_gp = 50, porc_servicios_gp = 50, "
                                                . "porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                                . "materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_zi = $materialesZI, "
                                                . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                    } else if ($mantto == "MP") {
                                        $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_gp = 50, porc_servicios_gp = 50, "
                                                . "porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                                . "materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_zi = $materialesZI, "
                                                . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                    }
                                    try {
                                        $resp = $conn->consulta($query);
                                        if ($resp == 1) {
                                            //Se calcula el presupuesto mensual por mp y mc
                                            $porcMensual = 100 / 12;
                                            $serviciosGPMensual = ($serviciosGP * $porcMensual) / 100;
                                            $materialesGPMensual = ($materialesGP * $porcMensual) / 100;
                                            $serviciosZIMensual = ($serviciosZI * $porcMensual) / 100;
                                            $materialesZIMensual = ($materialesZI * $porcMensual) / 100;

                                            //SE CREAN LOS 12 MESES DEL PRESUPUESTO
                                            for ($i = 0; $i < 12; $i++) {
                                                switch ($i) {
                                                    case 0:
                                                        $mes = "ENERO";
                                                        break;
                                                    case 1:
                                                        $mes = "FEBRERO";
                                                        break;
                                                    case 2:
                                                        $mes = "MARZO";
                                                        break;
                                                    case 3:
                                                        $mes = "ABRIL";
                                                        break;
                                                    case 4:
                                                        $mes = "MAYO";
                                                        break;
                                                    case 5:
                                                        $mes = "JUNIO";
                                                        break;
                                                    case 6:
                                                        $mes = "JULIO";
                                                        break;
                                                    case 7:
                                                        $mes = "AGOSTO";
                                                        break;
                                                    case 8:
                                                        $mes = "SEPTIEMBRE";
                                                        break;
                                                    case 9:
                                                        $mes = "OCTUBRE";
                                                        break;
                                                    case 10:
                                                        $mes = "NOVIEMBRE";
                                                        break;
                                                    case 11:
                                                        $mes = "DICIEMBRE";
                                                        break;
                                                }

                                                if ($mantto == "MC") {
                                                    $query = "INSERT INTO t_presupuesto_mc_mensual (id_presupuesto, mes, porc_servicios_gp, "
                                                            . "porc_materiales_gp, servicios_gp, materiales_gp, "
                                                            . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                            . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosGPMensual, $materialesGPMensual, "
                                                            . "$porcMensual, $porcMensual, "
                                                            . "$serviciosZIMensual, $materialesZIMensual)";
                                                } else if ($mantto == "MP") {
                                                    $query = "INSERT INTO t_presupuesto_mp_mensual (id_presupuesto, mes, porc_servicios_gp, "
                                                            . "porc_materiales_gp, servicios_gp, materiales_gp, "
                                                            . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                            . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosGPMensual, $materialesGPMensual, "
                                                            . "$porcMensual, $porcMensual, "
                                                            . "$serviciosZIMensual, $materialesZIMensual)";
                                                }
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
                                }
                            } catch (Exception $ex) {
                                $resp = $ex;
                            }
                        }
                        if ($trs == "SI") {//Si tiene TRS
                            $pptoTRS = ($presupuesto * $porc) / 100;
                            if ($mantto == "MC") {
                                $query = "UPDATE t_presupuestos_mc_destinos SET porc_trs = $porc, "
                                        . "porc_zi = $porc, ppto_trs = $pptoTRS, ppto_zi = $pptoZI WHERE id = $idPptoD";
                            } else if ($mantto == "MP") {
                                $query = "UPDATE t_presupuestos_mp_destinos SET porc_trs = $porc, "
                                        . "porc_zi = $porc, ppto_trs = $pptoTRS, ppto_zi = $pptoZI WHERE id = $idPptoD";
                            }

                            //Se ejecuta la sentencia para insertar los porcentajes y el total del presupupesto por fase
                            try {
                                $resp = $conn->consulta($query);
                                if ($resp == 1) {//Si se inserto correctamente se calculan el valor del ppto de mp y mc por fase
                                    $materialesTRS = ($pptoTRS * 50) / 100;
                                    $serviciosTRS = ($pptoTRS * 50) / 100;
                                    $materialesZI = ($pptoZI * 50) / 100;
                                    $serviciosZI = ($pptoZI * 50) / 100;

                                    if ($mantto == "MC") {
                                        $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_trs = 50, porc_servicios_trs = 50, "
                                                . "porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                                . "materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, materiales_zi = $materialesZI, "
                                                . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                    } else if ($mantto == "MP") {
                                        $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_trs = 50, porc_servicios_trs = 50, "
                                                . "porc_materiales_zi = 50, porc_servicios_zi = 50, "
                                                . "materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, materiales_zi = $materialesZI, "
                                                . "servicios_zi = $serviciosZI WHERE id = $idPptoD";
                                    }
                                    try {
                                        $resp = $conn->consulta($query);
                                        if ($resp == 1) {
                                            //Se calcula el presupuesto mensual por mp y mc
                                            $porcMensual = 100 / 12;
                                            $serviciosTRSMensual = ($serviciosTRS * $porcMensual) / 100;
                                            $materialesTRSMensual = ($materialesTRS * $porcMensual) / 100;
                                            $serviciosZIMensual = ($serviciosZI * $porcMensual) / 100;
                                            $materialesZIMensual = ($materialesZI * $porcMensual) / 100;

                                            //SE CREAN LOS 12 MESES DEL PRESUPUESTO
                                            for ($i = 0; $i < 12; $i++) {
                                                switch ($i) {
                                                    case 0:
                                                        $mes = "ENERO";
                                                        break;
                                                    case 1:
                                                        $mes = "FEBRERO";
                                                        break;
                                                    case 2:
                                                        $mes = "MARZO";
                                                        break;
                                                    case 3:
                                                        $mes = "ABRIL";
                                                        break;
                                                    case 4:
                                                        $mes = "MAYO";
                                                        break;
                                                    case 5:
                                                        $mes = "JUNIO";
                                                        break;
                                                    case 6:
                                                        $mes = "JULIO";
                                                        break;
                                                    case 7:
                                                        $mes = "AGOSTO";
                                                        break;
                                                    case 8:
                                                        $mes = "SEPTIEMBRE";
                                                        break;
                                                    case 9:
                                                        $mes = "OCTUBRE";
                                                        break;
                                                    case 10:
                                                        $mes = "NOVIEMBRE";
                                                        break;
                                                    case 11:
                                                        $mes = "DICIEMBRE";
                                                        break;
                                                }

                                                if ($mantto == "MC") {
                                                    $query = "INSERT INTO t_presupuesto_mc_mensual (id_presupuesto, mes, porc_servicios_trs, "
                                                            . "porc_materiales_trs, servicios_trs, materiales_trs, "
                                                            . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                            . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosTRSMensual, $materialesTRSMensual, "
                                                            . "$porcMensual, $porcMensual, "
                                                            . "$serviciosZIMensual, $materialesZIMensual)";
                                                } else if ($mantto == "MP") {
                                                    $query = "INSERT INTO t_presupuesto_mp_mensual (id_presupuesto, mes, porc_servicios_trs, "
                                                            . "porc_materiales_trs, servicios_trs, materiales_trs, "
                                                            . "porc_servicios_zi, porc_materiales_zi, servicios_zi, materiales_zi) "
                                                            . "VALUES($idPptoD, '$mes', $porcMensual, $porcMensual, $serviciosTRSMensual, $materialesTRSMensual, "
                                                            . "$porcMensual, $porcMensual, "
                                                            . "$serviciosZIMensual, $materialesZIMensual)";
                                                }
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
                                }
                            } catch (Exception $ex) {
                                $resp = $ex;
                            }
                        }
                    }
                }
            } catch (Exception $ex) {
                $resp = $ex;
            }
        }

        $conn->cerrar();

        return $resp;
    }

    public function actualizarPresupuesto($idPresupuesto, $presupuesto, $mantto) {
        $conn = new Conexion();
        $conn->conectar();

        /* Se trata el valor del presupuesto ingresado para poder ser insertado */
        $ppto = explode("$", $presupuesto);
        if (count($ppto) > 1) {
            $ppto = str_replace(',', '', $ppto[1]);
        } else {
            $ppto = str_replace(',', '', $ppto[0]);
        }
        $pptoFinal = number_format($ppto, 2, '.', '');

        //Se actualiza el presupuesto anual
        if ($mantto == "MC") {
            $query = "UPDATE t_presupuestos_mc_destinos SET presupuesto = $pptoFinal WHERE id = $idPresupuesto";
        } else {
            $query = "UPDATE t_presupuestos_mp_destinos SET presupuesto = $pptoFinal WHERE id = $idPresupuesto";
        }

        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {
                //Obtener los porcentajes de cada fase
                if ($mantto == "MC") {
                    $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPresupuesto";
                } else {
                    $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPresupuesto";
                }

                try {
                    $datos = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($datos as $dts) {
                            $porcGP = $dts['porc_gp'];
                            $porcTRS = $dts['porc_trs'];
                            $porcZI = $dts['porc_zi'];
                            $porcServiciosGP = $dts['porc_servicios_gp'];
                            $porcMaterialesGP = $dts['porc_materiales_gp'];
                            $porcServiciosTRS = $dts['porc_servicios_trs'];
                            $porcMaterialesTRS = $dts['porc_materiales_trs'];
                            $porcServiciosZI = $dts['porc_servicios_zi'];
                            $porcMaterialesZI = $dts['porc_materiales_zi'];
                        }

                        $pptoGP = ($pptoFinal * $porcGP) / 100;
                        $pptoTRS = ($pptoFinal * $porcTRS) / 100;
                        $pptoZI = ($pptoFinal * $porcZI) / 100;
                        $materialesGP = ($pptoGP * $porcMaterialesGP) / 100;
                        $serviciosGP = ($pptoGP * $porcServiciosGP) / 100;
                        $materialesTRS = ($pptoTRS * $porcMaterialesTRS) / 100;
                        $serviciosTRS = ($pptoTRS * $porcServiciosTRS) / 100;
                        $materialesZI = ($pptoZI * $porcMaterialesZI) / 100;
                        $serviciosZI = ($pptoZI * $porcServiciosZI) / 100;

                        if ($mantto == "MC") {
                            $query = "UPDATE t_presupuestos_mc_destinos SET ppto_gp = $pptoGP, ppto_trs = $pptoTRS, "
                                    . "ppto_zi = $pptoZI, materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, "
                                    . "materiales_zi = $materialesZI, servicios_zi = $serviciosZI WHERE id = $idPresupuesto";
                        } else {
                            $query = "UPDATE t_presupuestos_mp_destinos SET ppto_gp = $pptoGP, ppto_trs = $pptoTRS, "
                                    . "ppto_zi = $pptoZI, materiales_gp = $materialesGP, servicios_gp = $serviciosGP, materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS, "
                                    . "materiales_zi = $materialesZI, servicios_zi = $serviciosZI WHERE id = $idPresupuesto";
                        }

                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                if ($mantto == "MC") {
                                    $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPresupuesto";
                                } else {
                                    $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPresupuesto";
                                }

                                try {
                                    $result = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($result as $dts) {
                                            $idPptoMensual = $dts['id'];
                                            $porcServiciosGPMensual = $dts['porc_servicios_gp'];
                                            $porcMaterialesGPMensual = $dts['porc_materiales_gp'];
                                            $porcServiciosTRSMensual = $dts['porc_servicios_trs'];
                                            $porcMaterialesTRSMensual = $dts['porc_materiales_trs'];
                                            $porcServiciosZIMensual = $dts['porc_servicios_zi'];
                                            $porcMaterialesZIMensual = $dts['porc_materiales_zi'];

                                            if ($porcServiciosGP != "") {
                                                $serviciosGPMensual = ($serviciosGP * $porcServiciosGPMensual) / 100;
                                            } else {
                                                $serviciosGPMensual = "NULL";
                                            }

                                            if ($porcMaterialesGP != "") {
                                                $materialesGPMensual = ($materialesGP * $porcMaterialesGPMensual) / 100;
                                            } else {
                                                $materialesGPMensual = "NULL";
                                            }

                                            if ($porcServiciosTRS != "") {
                                                $serviciosTRSMensual = ($serviciosTRS * $porcServiciosTRSMensual) / 100;
                                            } else {
                                                $serviciosTRSMensual = "NULL";
                                            }

                                            if ($porcMaterialesTRS != "") {
                                                $materialesTRSMensual = ($materialesTRS * $porcMaterialesTRSMensual) / 100;
                                            } else {
                                                $materialesTRSMensual = "NULL";
                                            }

                                            $serviciosZIMensual = ($serviciosZI * $porcServiciosZIMensual) / 100;
                                            $materialesZIMensual = ($materialesZI * $porcMaterialesZIMensual) / 100;

                                            if ($mantto == "MC") {
                                                $query = "UPDATE t_presupuesto_mc_mensual SET servicios_gp = $serviciosGPMensual, materiales_gp = $materialesGPMensual, servicios_trs = $serviciosTRSMensual, "
                                                        . "materiales_trs = $materialesTRSMensual, servicios_zi = $serviciosZIMensual, materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                            } else {
                                                $query = "UPDATE t_presupuesto_mc_mensual SET servicios_gp = $serviciosGPMensual, materiales_gp = $materialesGPMensual, servicios_trs = $serviciosTRSMensual, "
                                                        . "materiales_trs = $materialesTRSMensual, servicios_zi = $serviciosZIMensual, materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                            }
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
                            }
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

    public function obtPedido($idDocumento) {
        $conn = new Conexion();
        $conn->conectar();
        $pedido = new Pedido();
        $query = "SELECT * FROM t_gastos WHERE id = $idDocumento";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $pedido->idPresupuesto = $dts['id_presupuesto'];
                    $pedido->numeroDocumento = $dts['num_documento'];
                    $pedido->fechaSolicitud = $dts['fecha_solicitud'];
                    $pedido->fechaPosibleLlegada = $dts['fecha_posible_llegada'];
                    //$pedido->fechaOrdenCompra = $dts['fecha_orden_compra'];
                    $pedido->proveedor = $dts['proveedor'];
                    $pedido->tipoGasto = $dts['tipo_gasto'];
                    $pedido->idDestino = $dts['id_destino'];
                    $pedido->idSeccion = $dts['id_seccion'];
                    $pedido->idUbicacion = $dts['id_ubicacion'];
                    $ceco = $dts['ceco'];



                    switch ($ceco) {
                        case "MCGP":
                            $fase = "MCGP";
                            break;
                        case "MPGP":
                            $fase = "MPGP";
                            break;
                        case "MCTRS":
                            $fase = "MCTRS";
                            break;
                        case "MPTRS":
                            $fase = "MPTRS";
                            break;
                        case "MCZI":
                            $fase = "MCZI";
                            break;
                        case "MPZI":
                            $fase = "MPZI";
                            break;
                    }

                    $query = "SELECT * FROM t_gastos_items WHERE id_documento = $idDocumento";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idItem = $dts['id'];
                                $tipoGasto = $dts['tipo_gasto'];
                                $cod2bend = $dts['cod2bend'];
                                $descripcion = $dts['descripcion'];
                                $tipo = $dts['tipo']; //001 - Almacen, 002 - Externo
                                $fechaSolicitud = $dts['fecha_solicitud'];
                                $fechaOC = $dts['fecha_orden_compra'];
                                $fechaPosibleLlegada = $dts['fecha_posible_llegada'];
                                $fechaRealLlegada = $dts['fecha_real_llegada'];
                                $fechaRetiroAlmacen = $dts['fecha_retiro_almacen']; //Fecha entrega
                                $cantidad = $dts['cantidad'];
                                $importe = $dts['importe'];
                                $idDestino = $dts['id_destino'];
                                $idSeccion = $dts['id_seccion'];
                                $idUbicacion = $dts['id_ubicacion'];
                                //Subcontratas
                                $fechaAprobacion = $dts['fecha_aprobacion'];
                                $fechaPosibleInicio = $dts['fecha_posible_inicio'];
                                $fechaRealInicio = $dts['fecha_real_inicio'];
                                $fechaFin = $dts['fecha_fin'];
                                $fechaPago = $dts['fecha_pago'];
                                $pagoParcial = $dts['pago_parcial'];
                                $totalPago = $dts['total_pago'];

                                if ($tipoGasto == 1) {//Materiales
                                    $pedido->items .= "<tr>"
                                            . "<td>$fase</td>"
                                            . "<td>$cod2bend</td>"
                                            . "<td>$descripcion</td>"
                                            . "<td>$fechaSolicitud</td>"
                                            . "<td>$fechaOC</td>"
                                            . "<td><input type=\"text\" class=\"dtpick form-control form-control-sm input-texto datetimepicker-input\" id=\"fechaEntrega_$idItem\" data-toggle=\"datetimepicker\" data-target=\"#fechaEntrega_$idItem\" value=\"$fechaRealLlegada\" onclick=\"createDatepicker(this);\" onchange=\"actualizarGasto($idItem, this);\"/></td>"
                                            . "<td><input type=\"text\" class=\"dtpick form-control form-control-sm input-texto datetimepicker-input\" id=\"fechaRetiroAlmacen_$idItem\" data-toggle=\"datetimepicker\" data-target=\"#fechaRetiroAlmacen_$idItem\" value=\"$fechaRetiroAlmacen\" onclick=\"createDatepicker(this);\" onchange=\"actualizarGasto($idItem, this);\"/></td>"
                                            . "</tr>";
                                } else {//Servicios y subcontratas
                                    $pedido->items .= "<tr>"
                                            . "<td>$fase</td>"
                                            . "<td>$cod2bend</td>"
                                            . "<td>$descripcion</td>"
                                            . "<td></td>"
                                            . "<td>$fechaAprobacion</td>"
                                            . "<td><input type=\"text\" class=\"dtpick form-control form-control-sm input-texto datetimepicker-input\" id=\"fechaInicio_$idItem\" data-toggle=\"datetimepicker\" data-target=\"#fechaInicio_$idItem\" value=\"$fechaRealInicio\" onclick=\"createDatepicker(this);\" onchange=\"actualizarGasto($idItem, this);\"/></td>"
                                            . "<td><input type=\"text\" class=\"dtpick form-control form-control-sm input-texto datetimepicker-input\" id=\"fechaFin_$idItem\" data-toggle=\"datetimepicker\" data-target=\"#fechaFin_$idItem\" value=\"$fechaFin\" onclick=\"createDatepicker(this);\" onchange=\"actualizarGasto($idItem, this);\"/></td>"
                                            . "</tr>";
                                }
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

        $conn->cerrar();
        return $pedido;
    }

    public function obtAreas($idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idSeccion == 5 || $idSeccion == 6 || $idSeccion == 12) {
            $query = "SELECT * FROM c_subcategorias_zh WHERE id_seccion = $idSeccion";
        } else {
            $query = "SELECT * FROM c_grupos WHERE id_seccion = $idSeccion";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idGrupo = $dts['id'];
                    $grupo = $dts['grupo'];

                    $salida .= "<option value=\"$idGrupo\">$grupo</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function actualizarGasto($idItem, $campo, $fecha, $tipoGasto) {
        $conn = new Conexion();
        $conn->conectar();
        $list = explode("_", $campo);
        date_default_timezone_set('America/Cancun');
        $fecha = date('Y-m-d', strtotime($fecha));

        switch ($list[0]) {
            case 'fechaEntrega':
                $query = "UPDATE t_gastos_items SET fecha_real_llegada = '$fecha' WHERE id = $idItem";
                break;
            case 'fechaRetiroAlmacen':
                $query = "UPDATE t_gastos_items SET fecha_retiro_almacen = '$fecha' WHERE id = $idItem";
                break;
            case 'fechaInicio':
                $query = "UPDATE t_gastos_items SET fecha_real_inicio = '$fecha' WHERE id = $idItem";
                break;
            case 'fechaFin':
                $query = "UPDATE t_gastos_items SET fecha_fin = '$fecha' WHERE id = $idItem";
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

    //Actualizar el porcentaje que corresponde a cada fase o tipo de mantenimiento 
    public function setPorc($idPpto, $fase, $porc, $mantto) {
        $conn = new Conexion();
        $conn->conectar();

        switch ($fase) {
            case 'GP':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_gp = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_gp = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['presupuesto'];
                                }

                                $pptoGP = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET ppto_gp = $pptoGP WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET ppto_gp = $pptoGP WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $porcMaterialesGP = $dts['porc_materiales_gp'];
                                                    $porcServiciosGP = $dts['porc_servicios_gp'];
                                                    $presupuestoGP = $dts['ppto_gp'];
                                                }

                                                $materialesGP = ($presupuestoGP * $porcMaterialesGP) / 100;
                                                $serviciosGP = ($presupuestoGP * $porcServiciosGP) / 100;

                                                if ($mantto == "MC") {
                                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_gp = $materialesGP, servicios_gp = $serviciosGP WHERE id = $idPpto";
                                                } else {
                                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_gp = $materialesGP, servicios_gp = $serviciosGP WHERE id = $idPpto";
                                                }

                                                try {
                                                    $resp = $conn->consulta($query);
                                                    if ($resp == 1) {
                                                        if ($mantto == "MC") {
                                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                                        } else {
                                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                                        }

                                                        try {
                                                            $result = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($result as $dts) {
                                                                    $idPptoMensual = $dts['id'];
                                                                    $porcServiciosGPMensual = $dts['porc_servicios_gp'];
                                                                    $porcMaterialesGPMensual = $dts['porc_materiales_gp'];
//                                                                $porcMPTRSMensual = $dts['porc_mp_trs'];
//                                                                $porcMCTRSMensual = $dts['porc_mc_trs'];
//                                                                $porcMPZIMensual = $dts['porc_mp_zi'];
//                                                                $porcMCZIMensual = $dts['porc_mc_zi'];

                                                                    if ($porcServiciosGP != "") {
                                                                        $serviciosGPMensual = ($serviciosGP * $porcServiciosGPMensual) / 100;
                                                                    } else {
                                                                        $serviciosGPMensual = "NULL";
                                                                    }

                                                                    if ($porcMaterialesGP != "") {
                                                                        $materialesGPMensual = ($materialesGP * $porcMaterialesGPMensual) / 100;
                                                                    } else {
                                                                        $materialesGPMensual = "NULL";
                                                                    }

//                                                                if ($porcMPTRS != "") {
//                                                                    $mpTRSMensual = ($mpTRS * $porcMPTRSMensual) / 100;
//                                                                } else {
//                                                                    $mpTRSMensual = "NULL";
//                                                                }
//
//                                                                if ($porcMCTRS != "") {
//                                                                    $mcTRSMensual = ($mcTRS * $porcMCTRSMensual) / 100;
//                                                                } else {
//                                                                    $mcTRSMensual = "NULL";
//                                                                }
//
//                                                                $mpZIMensual = ($mpZI * $porcMPZIMensual) / 100;
//                                                                $mcZIMensual = ($mcZI * $porcMCZIMensual) / 100;

                                                                    if ($mantto == "MC") {
                                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_gp = $serviciosGPMensual, materiales_gp = $materialesGPMensual WHERE id = $idPptoMensual";
                                                                    } else {
                                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_gp = $serviciosGPMensual, materiales_gp = $materialesGPMensual WHERE id = $idPptoMensual";
                                                                    }

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
                                                    }
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
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
                break;
            case 'TRS':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_trs = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_trs = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['presupuesto'];
                                }

                                $pptoTRS = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET ppto_trs = $pptoTRS WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET ppto_trs = $pptoTRS WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $porcMaterialesTRS = $dts['porc_materiales_trs'];
                                                    $porcServiciosTRS = $dts['porc_servicios_trs'];
                                                    $presupuestoTRS = $dts['ppto_trs'];
                                                }

                                                $materialesTRS = ($presupuestoTRS * $porcMaterialesTRS) / 100;
                                                $serviciosTRS = ($presupuestoTRS * $porcServiciosTRS) / 100;

                                                if ($mantto == "MC") {
                                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS WHERE id = $idPpto";
                                                } else {
                                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_trs = $materialesTRS, servicios_trs = $serviciosTRS WHERE id = $idPpto";
                                                }

                                                try {
                                                    $resp = $conn->consulta($query);
                                                    if ($resp == 1) {
                                                        if ($mantto == "MC") {
                                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                                        } else {
                                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                                        }

                                                        try {
                                                            $result = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($result as $dts) {
                                                                    $idPptoMensual = $dts['id'];
                                                                    $porcServiciosTRSMensual = $dts['porc_servicios_trs'];
                                                                    $porcMaterialesTRSMensual = $dts['porc_materiales_trs'];
//                                                                $porcMPTRSMensual = $dts['porc_mp_trs'];
//                                                                $porcMCTRSMensual = $dts['porc_mc_trs'];
//                                                                $porcMPZIMensual = $dts['porc_mp_zi'];
//                                                                $porcMCZIMensual = $dts['porc_mc_zi'];

                                                                    if ($porcServiciosTRS != "") {
                                                                        $serviciosTRSMensual = ($serviciosTRS * $porcServiciosTRSMensual) / 100;
                                                                    } else {
                                                                        $serviciosTRSMensual = "NULL";
                                                                    }

                                                                    if ($porcMaterialesTRS != "") {
                                                                        $materialesTRSMensual = ($materialesTRS * $porcMaterialesTRSMensual) / 100;
                                                                    } else {
                                                                        $materialesTRSMensual = "NULL";
                                                                    }

//                                                                if ($porcMPTRS != "") {
//                                                                    $mpTRSMensual = ($mpTRS * $porcMPTRSMensual) / 100;
//                                                                } else {
//                                                                    $mpTRSMensual = "NULL";
//                                                                }
//
//                                                                if ($porcMCTRS != "") {
//                                                                    $mcTRSMensual = ($mcTRS * $porcMCTRSMensual) / 100;
//                                                                } else {
//                                                                    $mcTRSMensual = "NULL";
//                                                                }
//
//                                                                $mpZIMensual = ($mpZI * $porcMPZIMensual) / 100;
//                                                                $mcZIMensual = ($mcZI * $porcMCZIMensual) / 100;

                                                                    if ($mantto == "MC") {
                                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_trs = $serviciosTRSMensual, materiales_trs = $materialesTRSMensual WHERE id = $idPptoMensual";
                                                                    } else {
                                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_trs = $serviciosTRSMensual, materiales_trs = $materialesTRSMensual WHERE id = $idPptoMensual";
                                                                    }

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
                                                    }
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
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
                break;
            case 'ZI':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_zi = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_zi = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['presupuesto'];
                                }

                                $pptoZI = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET ppto_zi = $pptoZI WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET ppto_zi = $pptoZI WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $porcMaterialesZI = $dts['porc_materiales_zi'];
                                                    $porcServiciosZI = $dts['porc_servicios_zi'];
                                                    $presupuestoZI = $dts['ppto_zi'];
                                                }

                                                $materialesZI = ($presupuestoZI * $porcMaterialesZI) / 100;
                                                $serviciosZI = ($presupuestoZI * $porcServiciosZI) / 100;

                                                if ($mantto == "MC") {
                                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_zi = $materialesZI, servicios_zi = $serviciosZI WHERE id = $idPpto";
                                                } else {
                                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_zi = $materialesZI, servicios_zi = $serviciosZI WHERE id = $idPpto";
                                                }

                                                try {
                                                    $resp = $conn->consulta($query);
                                                    if ($resp == 1) {
                                                        if ($mantto == "MC") {
                                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                                        } else {
                                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                                        }

                                                        try {
                                                            $result = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($result as $dts) {
                                                                    $idPptoMensual = $dts['id'];
                                                                    $porcServiciosZIMensual = $dts['porc_servicios_zi'];
                                                                    $porcMaterialesZIMensual = $dts['porc_materiales_zi'];
//                                                                $porcMPTRSMensual = $dts['porc_mp_trs'];
//                                                                $porcMCTRSMensual = $dts['porc_mc_trs'];
//                                                                $porcMPZIMensual = $dts['porc_mp_zi'];
//                                                                $porcMCZIMensual = $dts['porc_mc_zi'];

                                                                    if ($porcServiciosZI != "") {
                                                                        $serviciosZIMensual = ($serviciosZI * $porcServiciosZIMensual) / 100;
                                                                    } else {
                                                                        $serviciosZIMensual = "NULL";
                                                                    }

                                                                    if ($porcMaterialesZI != "") {
                                                                        $materialesZIMensual = ($materialesZI * $porcMaterialesZIMensual) / 100;
                                                                    } else {
                                                                        $materialesZIMensual = "NULL";
                                                                    }

//                                                                if ($porcMPTRS != "") {
//                                                                    $mpTRSMensual = ($mpTRS * $porcMPTRSMensual) / 100;
//                                                                } else {
//                                                                    $mpTRSMensual = "NULL";
//                                                                }
//
//                                                                if ($porcMCTRS != "") {
//                                                                    $mcTRSMensual = ($mcTRS * $porcMCTRSMensual) / 100;
//                                                                } else {
//                                                                    $mcTRSMensual = "NULL";
//                                                                }
//
//                                                                $mpZIMensual = ($mpZI * $porcMPZIMensual) / 100;
//                                                                $mcZIMensual = ($mcZI * $porcMCZIMensual) / 100;

                                                                    if ($mantto == "MC") {
                                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_zi = $serviciosZIMensual, materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                                                    } else {
                                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_zi = $serviciosZIMensual, materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                                                    }

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
                                                    }
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
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
                break;
            case 'MGP':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_gp = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_gp = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_gp'];
                                }

                                $materialesGP = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_gp = $materialesGP WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_gp = $materialesGP WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_materiales_gp'];
                                                    if ($porc != "") {
                                                        $materialesGPMensual = ($materialesGP * $porc) / 100;
                                                    } else {
                                                        $materialesGPMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET materiales_gp = $materialesGPMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET materiales_gp = $materialesGPMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
            case 'SGP':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_servicios_gp = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_servicios_gp = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_gp'];
                                }

                                $serviciosGP = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET servicios_gp = $serviciosGP WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET servicios_gp = $serviciosGP WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_servicios_gp'];
                                                    if ($porc != "") {
                                                        $serviciosGPMensual = ($serviciosGP * $porc) / 100;
                                                    } else {
                                                        $serviciosGPMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_gp = $serviciosGPMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_gp = $serviciosGPMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
            case 'MTRS':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_trs = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_trs = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_trs'];
                                }

                                $materialesTRS = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_trs = $materialesTRS WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_trs = $materialesTRS WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_materiales_trs'];
                                                    if ($porc != "") {
                                                        $materialesTRSMensual = ($materialesTRS * $porc) / 100;
                                                    } else {
                                                        $materialesTRSMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET materiales_trs = $materialesTRSMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET materiales_trs = $materialesTRSMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
            case 'STRS':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_servicios_trs = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_servicios_trs = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_trs'];
                                }

                                $serviciosTRS = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET servicios_trs = $serviciosTRS WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET servicios_trs = $serviciosTRS WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_servicios_trs'];
                                                    if ($porc != "") {
                                                        $serviciosTRSMensual = ($serviciosTRS * $porc) / 100;
                                                    } else {
                                                        $serviciosTRSMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_trs = $serviciosTRSMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_trs = $serviciosTRSMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
            case 'MZI':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_materiales_zi = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_materiales_zi = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_zi'];
                                }

                                $materialesZI = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET materiales_zi = $materialesZI WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET materiales_zi = $materialesZI WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_materiales_zi'];
                                                    if ($porc != "") {
                                                        $materialesZIMensual = ($materialesZI * $porc) / 100;
                                                    } else {
                                                        $materialesZIMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET materiales_zi = $materialesZIMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
            case 'SZI':
                if ($mantto == "MC") {
                    $query = "UPDATE t_presupuestos_mc_destinos SET porc_servicios_zi = $porc WHERE id = $idPpto";
                } else {
                    $query = "UPDATE t_presupuestos_mp_destinos SET porc_servicios_zi = $porc WHERE id = $idPpto";
                }

                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        if ($mantto == "MC") {
                            $query = "SELECT * FROM t_presupuestos_mc_destinos WHERE id = $idPpto";
                        } else {
                            $query = "SELECT * FROM t_presupuestos_mp_destinos WHERE id = $idPpto";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $presupuesto = $dts['ppto_zi'];
                                }

                                $serviciosZI = ($presupuesto * $porc) / 100;

                                if ($mantto == "MC") {
                                    $query = "UPDATE t_presupuestos_mc_destinos SET servicios_zi = $serviciosZI WHERE id = $idPpto";
                                } else {
                                    $query = "UPDATE t_presupuestos_mp_destinos SET servicios_zi = $serviciosZI WHERE id = $idPpto";
                                }
                                try {
                                    $resp = $conn->consulta($query);
                                    if ($resp == 1) {
                                        if ($mantto == "MC") {
                                            $query = "SELECT * FROM t_presupuesto_mc_mensual WHERE id_presupuesto = $idPpto";
                                        } else {
                                            $query = "SELECT * FROM t_presupuesto_mp_mensual WHERE id_presupuesto = $idPpto";
                                        }

                                        try {
                                            $result = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($result as $dts) {
                                                    $idPptoMensual = $dts['id'];

                                                    $porc = $dts['porc_servicios_zi'];
                                                    if ($porc != "") {
                                                        $serviciosZIMensual = ($serviciosZI * $porc) / 100;
                                                    } else {
                                                        $serviciosZIMensual = "NULL";
                                                    }

                                                    if ($mantto == "MC") {
                                                        $query = "UPDATE t_presupuesto_mc_mensual SET servicios_zi = $serviciosZIMensual WHERE id = $idPptoMensual";
                                                    } else {
                                                        $query = "UPDATE t_presupuesto_mp_mensual SET servicios_zi = $serviciosZIMensual WHERE id = $idPptoMensual";
                                                    }

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
                                    }
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
                break;
        }

        $conn->cerrar();
        return $resp;
    }

    public function setPorcMensual($idPpto, $idMes, $porc, $fase) {
        $conn = new Conexion();
        $conn->conectar();

        switch ($fase) {
            case 'MCGP':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MCGP = $dts['mc_gp'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mc_gp = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mcGPMensual = ($MCGP * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mc_gp = $mcGPMensual WHERE id = $idMes";
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

                break;
            case 'MPGP':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MPGP = $dts['mp_gp'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mp_gp = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mpGPMensual = ($MPGP * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mp_gp = $mpGPMensual WHERE id = $idMes";
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
                break;
            case 'MCTRS':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MCTRS = $dts['mc_trs'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mc_trs = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mcTRSMensual = ($MCTRS * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mc_trs = $mcTRSMensual WHERE id = $idMes";
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
                break;
            case 'MPTRS':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MPTRS = $dts['mp_trs'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mp_trs = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mpTRSMensual = ($MPTRS * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mp_trs = $mpTRSMensual WHERE id = $idMes";
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
                break;
            case 'MCZI':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MCZI = $dts['mc_zi'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mc_zi = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mcZIMensual = ($MCZI * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mc_zi = $mcZIMensual WHERE id = $idMes";
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
                break;
            case 'MPZI':
                $query = "SELECT * FROM t_presupuestos_destinos WHERE id = $idPpto";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $MPZI = $dts['mp_zi'];
                        }
                        $query = "UPDATE t_presupuesto_mensual SET porc_mp_zi = $porc WHERE id = $idMes";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                $mpZIMensual = ($MPZI * $porc) / 100;

                                $query = "UPDATE t_presupuesto_mensual SET mp_zi = $mpZIMensual WHERE id = $idMes";
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
                break;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtPptoRestante($idDestino) {

        $conn = new Conexion();
        $conn->conectar();

        //Empresas y servicios
//TRS
        $gastoMensualServiciosTRSMC = 0;
        $gastoMensualServiciosTRSMP = 0;
        $gastoAnualServiciosTRSMC = 0;
        $gastoAnualServiciosTRSMP = 0;
        $porcAnualServiciosTRSMC = 0;
        $porcAnualServiciosTRSMP = 0;

//GP
        $gastoMensualServiciosGPMC = 0;
        $gastoMensualServiciosGPMP = 0;
        $gastoAnualServiciosGPMC = 0;
        $gastoAnualServiciosGPMP = 0;
        $porcAnualServiciosGPMC = 0;
        $porcAnualServiciosGPMP = 0;

//ZI
        $gastoMensualServiciosZIMC = 0;
        $gastoMensualServiciosZIMP = 0;
        $gastoAnualServiciosZIMC = 0;
        $gastoAnualServiciosZIMP = 0;
        $porcAnualServiciosZIMC = 0;
        $porcAnualServiciosZIMP = 0;

        $query = "SELECT * FROM t_gastos_servicios";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDocumento = $dts['id'];
                    $numDocumento = $dts['num_documento'];
                    $fechaDocumento = $dts['fecha_documento'];
                    $importe = $dts['importe_ml3'];
                    $ceco = $dts['ceco'];
                    $asignacion = $dts['asignacion'];
                    $descripcion = $dts['texto'];
                    $proveedor = $dts['nombre_proveedor_af'];
                    $nombreDocumento = $dts['nombre_1'];

                    if ($importe == "") {
                        $importe = 0;
                    }

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
                        $ppto = $ex;
                    }

                    $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $destinoCECO = $dts['destino'];
                                $nombreCECO = $dts['nombre_ceco'];
                                $marcaCECO = $dts['marca'];
                                $tipoCECO = $dts['tipo'];
                            }
                        } else {
                            $destinoCECO = "";
                            $nombreCECO = "";
                            $marcaCECO = "";
                            $tipoCECO = "";
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $fechaDocumento = strtotime($fechaDocumento);
                    $fecha = date("F", $fechaDocumento);

                    if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualServiciosTRSMC += $importe;

                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosTRSMC += $importe;
                        }
                    } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualServiciosTRSMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosTRSMP += $importe;
                        }
                    }

                    if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualServiciosGPMC += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosGPMC += $importe;
                        }
                    } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualServiciosGPMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosGPMP += $importe;
                        }
                    }

                    if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualServiciosZIMC += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosZIMC += $importe;
                        }
                    } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualServiciosZIMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualServiciosZIMP += $importe;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }


//Materiales
//TRS
        $gastoMensualMaterialesTRSMC = 0;
        $gastoMensualMaterialesTRSMP = 0;
        $gastoAnualMaterialesTRSMC = 0;
        $gastoAnualMaterialesTRSMP = 0;
        $porcAnualMaterialesTRSMC = 0;
        $porcAnualMaterialesTRSMP = 0;

//GP
        $gastoMensualMaterialesGPMC = 0;
        $gastoMensualMaterialesGPMP = 0;
        $gastoAnualMaterialesGPMC = 0;
        $gastoAnualMaterialesGPMP = 0;
        $porcAnualMaterialesGPMC = 0;
        $porcAnualMaterialesGPMP = 0;

//ZI
        $gastoMensualMaterialesZIMC = 0;
        $gastoMensualMaterialesZIMP = 0;
        $gastoAnualMaterialesZIMC = 0;
        $gastoAnualMaterialesZIMP = 0;
        $porcAnualMaterialesZIMC = 0;
        $porcAnualMaterialesZIMP = 0;
//Materiales 
        $query = "SELECT * FROM t_gastos_materiales";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDocumento = $dts['id'];
                    $numDocumento = $dts['num_documento'];
                    $fechaDocumento = $dts['fecha_documento'];
                    $importe = $dts['importe_ml3'];
                    $ceco = $dts['ceco'];
                    $asignacion = $dts['asignacion'];
                    $descripcion = $dts['texto'];
                    $proveedor = $dts['nombre_proveedor_af'];
                    $nombreDocumento = $dts['nombre_1'];

                    if ($importe == "") {
                        $importe = 0;
                    }

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
                        $ppto = $ex;
                    }

                    $query = "SELECT * FROM c_cecos WHERE ceco = '$ceco'";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $destinoCECO = $dts['destino'];
                                $nombreCECO = $dts['nombre_ceco'];
                                $marcaCECO = $dts['marca'];
                                $tipoCECO = $dts['tipo'];
                            }
                        } else {
                            $destinoCECO = "";
                            $nombreCECO = "";
                            $marcaCECO = "";
                            $tipoCECO = "";
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $fechaDocumento = strtotime($fechaDocumento);
                    $fecha = date("F", $fechaDocumento);

                    if ($marcaCECO == "TRS" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualMaterialesTRSMC += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesTRSMC += $importe;
                        }
                    } elseif ($marcaCECO == "TRS" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualMaterialesTRSMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesTRSMP += $importe;
                        }
                    }

                    if ($marcaCECO == "GP" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualMaterialesGPMC += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesGPMC += $importe;
                        }
                    } elseif ($marcaCECO == "GP" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualMaterialesGPMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesGPMP += $importe;
                        }
                    }

                    if ($marcaCECO == "ZI" && $tipoCECO == "CORRECTIVO" && $destino == $destinoCECO) {
                        //echo "$ceco - $destinoCECO - $nombreCECO - $tipoCECO: $importe <br>";
                        $gastoAnualMaterialesZIMC += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesZIMC += $importe;
                        }
                    } elseif ($marcaCECO == "ZI" && $tipoCECO == "PREVENTIVO" && $destino == $destinoCECO) {
                        $gastoAnualMaterialesZIMP += $importe;
                        if ($fecha == $month) {//Sumar todos los gastos del mes en curso
                            $gastoMensualMaterialesZIMP += $importe;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }

        $totalGastoAnualTRSMC = $gastoAnualServiciosTRSMC + $gastoAnualMaterialesTRSMC;
        $totalGastoAnualTRSMP = $gastoAnualServiciosTRSMP + $gastoAnualMaterialesTRSMP;
        $totalGastoAnualGPMC = $gastoAnualServiciosGPMC + $gastoAnualMaterialesGPMC;
        $totalGastoAnualGPMP = $gastoAnualServiciosGPMP + $gastoAnualMaterialesGPMP;
        $totalGastoAnualZIMC = $gastoAnualServiciosZIMC + $gastoAnualMaterialesZIMC;
        $totalGastoAnualZIMP = $gastoAnualServiciosZIMP + $gastoAnualMaterialesZIMP;
    }

}

?>
