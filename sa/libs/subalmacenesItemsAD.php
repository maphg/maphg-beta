<?php

date_default_timezone_set('America/Mexico_City');
include 'conexion.php';
include 'subalmacenesItemsINFO.php';

Class subalmacenesItemsAD {

    public function obtenerListaSubalmacenes($idDestino, $fase) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if ($idDestino == 10) {
            $query = "SELECT * FROM t_subalmacenes "
                    . "WHERE fase = '$fase' "
                    . "ORDER BY nombre";
        } else {
            $query = "SELECT * FROM t_subalmacenes "
                    . "WHERE fase = '$fase' "
                    . "AND id_destino = $idDestino "
                    . "ORDER BY nombre";
        }

        if ($fase == "GP") {
            $bgButton = "is-gp";
        } else if ($fase == "TRS") {
            $bgButton = "is-trs";
        } else {
            $bgButton = "is-zi";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSubalmacen = $dts['id'];
                    $nombreSA = $dts['nombre'];
                    $salida .= "<div class=\"columns\">"
                            . "<div class = \"column has-text-centered\">"
                            . "<a class = \"button is-large $bgButton is-fullwidth\" href = \"menu.php?idSubalmacen=$idSubalmacen\"><span class = \"icon is-medium\"><i class = \"fas fa-sign-in-alt\"></i></span><span>$nombreSA</span></a>"
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

    public function obtenerListaItesm($idSubalmacen) {
        $listaItems = array();

        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $item = new SubalmacenesItemsINFO();
                    $item->id = $dts['id'];
                    $item->idSubalmacen = $dts['id_subalmacen'];
                    $item->cod2bend = $dts['cod2bend'];
                    $item->descripcion = $dts['descripcion'];
                    $item->marca = $dts['marca'];
                    $item->modelo = $dts['modelo'];
                    $item->caracteristicas = $dts['caracteristicas'];
                    $item->tipoMaterial = $dts['tipo_material'];
                    $item->cantidad = $dts['cantidad'];
                    $item->unidad = $dts['unidad'];
                    $item->precio = $dts['precio'];
                    $item->categoria = $dts['categoria'];

                    $listaItems[] = $item;
                }
            }
        } catch (Exception $ex) {
            exit($ex);
        }


        $conn->cerrar();
        return $listaItems;
    }

    public function agregarItem($item) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "INSERT INTO t_subalmacenes_items (id_subalmacen, cod2bend, descripcion, marca, caracteristicas, cantidad, id_usuario, categoria) "
                . "VALUES(" . $item->idSubalmacen . ", '" . $item->cod2bend . "', '" . $item->descripcion . "', '" . $item->marca . "', '" . $item->caracteristicas . "', $item->cantidad, 1, '" . $item->categoria . "')";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerItem($idItem) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_subalmacenes_items WHERE id = $idItem";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $item = new SubalmacenesItemsINFO();
                    $item->id = $dts['id'];
                    $item->idSubalmacen = $dts['id_subalmacen'];
                    $item->cod2bend = $dts['cod2bend'];
                    $item->descripcion = $dts['descripcion'];
                    $item->marca = $dts['marca'];
                    $item->modelo = $dts['modelo'];
                    $item->caracteristicas = $dts['caracteristicas'];
                    $item->tipoMaterial = $dts['tipo_material'];
                    $item->cantidad = $dts['cantidad'];
                    $item->unidad = $dts['unidad'];
                    $item->precio = $dts['precio'];
                    $item->categoria = $dts['categoria'];
                }
            }
        } catch (Exception $ex) {
            exit($ex);
        }


        $conn->cerrar();
        return $item;
    }

    public function actualizarItem($item) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_subalmacenes_items "
                . "SET cod2bend = '" . $item->cod2bend . "', descripcion = '" . $item->descripcion . "', "
                . "marca = '" . $item->marca . "', caracteristicas = '" . $item->caracteristicas . "', "
                . "categoria = '" . $item->categoria . "' "
                . "WHERE id = $item->id";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function buscarItem($palabra, $idSubalmacen) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        if ($palabra != "") {
            $query = "SELECT * FROM t_subalmacenes_items WHERE (descripcion LIKE '%$palabra%' OR caracteristicas LIKE '%$palabra%' OR categoria LIKE '%$palabra%') AND id_subalmacen = $idSubalmacen";
        } else {
            $query = "SELECT * FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $item = new SubalmacenesItemsINFO();
                    $item->id = $dts['id'];
                    $item->idSubalmacen = $dts['id_subalmacen'];
                    $item->cod2bend = $dts['cod2bend'];
                    $item->descripcion = $dts['descripcion'];
                    $item->marca = $dts['marca'];
                    $item->modelo = $dts['modelo'];
                    $item->caracteristicas = $dts['caracteristicas'];
                    $item->tipoMaterial = $dts['tipo_material'];
                    $item->cantidad = $dts['cantidad'];
                    $item->unidad = $dts['unidad'];
                    $item->precio = $dts['precio'];
                    $item->categoria = $dts['categoria'];

                    $salida .= "<div class=\"columns border rounded\">"
                            . "<div class=\"column is-9\">"
                            . "<h6 class=\"title is-6 manita text-truncate\">"
                            . "" . strtoupper($item->descripcion) . " - "
                            . "" . $item->caracteristicas . " "
                            . "</h6>"
                            . "</div>"
                            . "<div class=\"column is-1\">";
                    if ($item->cantidad == 0) {
                        $salida .= "<h6 class=\"mt-2 mr-2 tag is-danger\">" . $item->cantidad . "</h6>";
                    } else {
                        $salida .= "<h6 class=\"mt-2 mr-2 tag is-success\">" . $item->cantidad . "</h6>";
                    }


                    $salida .= "</div>"
                            . "<div class=\"column is-1\">"
                            . "<input id=\"txtCantidadMaterial_$item->id " . "_$item->cantidad\" type=\"number\" class=\"input is-small\">"
                            . "</div>"
//                                . "<div class=\"column is-1\">"
//                                . "<button class=\"button is-info is-small\" onclick=\"addCartSalida(" . $item->id . ", " . $item->cantidad . ");\">Añadir</button>"
//                                . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            exit($ex);
        }


        $conn->cerrar();
        return $salida;
    }

    public function buscarItemSalida($palabra, $idSubalmacen) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        if ($palabra != "") {
            $query = "SELECT * FROM t_subalmacenes_items WHERE (descripcion LIKE '%$palabra%' OR caracteristicas LIKE '%$palabra%' OR categoria LIKE '%$palabra%') AND id_subalmacen = $idSubalmacen";
        } else {
            $query = "SELECT * FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $item = new SubalmacenesItemsINFO();
                    $item->id = $dts['id'];
                    $item->idSubalmacen = $dts['id_subalmacen'];
                    $item->cod2bend = $dts['cod2bend'];
                    $item->descripcion = $dts['descripcion'];
                    $item->marca = $dts['marca'];
                    $item->modelo = $dts['modelo'];
                    $item->caracteristicas = $dts['caracteristicas'];
                    $item->tipoMaterial = $dts['tipo_material'];
                    $item->cantidad = $dts['cantidad'];
                    $item->unidad = $dts['unidad'];
                    $item->precio = $dts['precio'];
                    $item->categoria = $dts['categoria'];

                    $salida .= "<div class=\"columns border rounded\">"
                            . "<div class=\"column is-9\">"
                            . "<h6 class=\"title is-6 manita text-truncate\">"
                            . "" . strtoupper($item->descripcion) . " - "
                            . "" . $item->caracteristicas . " "
                            . "</h6>"
                            . "</div>"
                            . "<div class=\"column is-1\">";
                    if ($item->cantidad == 0) {
                        $salida .= "<h6 class=\"mt-2 mr-2 tag is-danger\">" . $item->cantidad . "</h6>";
                    } else {
                        $salida .= "<h6 class=\"mt-2 mr-2 tag is-success\">" . $item->cantidad . "</h6>";
                    }


                    $salida .= "</div>"
                            . "<div class=\"column is-1\">"
                            . "<input id=\"txtCantidadMaterial$item->id\" type=\"number\" class=\"input is-small\">"
                            . "</div>"
                            . "<div class=\"column is-1\">"
                            . "<button class=\"button is-info is-small\" onclick=\"addCartSalida(" . $item->id . ");\">Añadir</button>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            exit($ex);
        }


        $conn->cerrar();
        return $salida;
    }

    public function actualizarStock($idUsuario) {
        $conn = new Conexion();
        $conn->conectar();
        session_start();
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $query = "SELECT * FROM t_subalmacenes_items WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $cantidad = $dts['cantidad'];
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
                $cantidadActual = $cantidad + $item['cantidad'];
                $resp = "";
                $query = "UPDATE t_subalmacenes_items "
                        . "SET cantidad = $cantidadActual "
                        . "WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        $resp = "";
                        $today = date("Y-m-d H:i:s");
                        $query = "INSERT INTO t_subalmacenes_entradas (id_usuario, id_material, cantidad, fecha) "
                                . "VALUES('$idUsuario', " . $item['idMaterial'] . ", " . $item['cantidad'] . ", '$today')";
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                            exit($resp);
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
            }

            if ($resp == 1) {
                unset($_SESSION["cart"]);
            }
        }

        $conn->cerrar();
        return $resp;
    }

    public function registrarSalidaMaterial($idUsuario, $idSubalmacen, $idGift) {
        $conn = new Conexion();
        $conn->conectar();
        session_start();
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $query = "SELECT * FROM t_subalmacenes_items WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $cantidad = $dts['cantidad'];
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
                $cantidadActual = $cantidad - $item['cantidad'];
                $resp = "";
                $query = "UPDATE t_subalmacenes_items "
                        . "SET cantidad = $cantidadActual "
                        . "WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        $resp = "";
                        $today = date("Y-m-d H:i:s");
                        $query = "INSERT INTO t_subalmacenes_salidas (id_usuario, id_material, id_gift, cantidad, fecha, id_subalmacen) "
                                . "VALUES('$idUsuario', " . $item['idMaterial'] . ", $idGift, " . $item['cantidad'] . ", '$today', $idSubalmacen)";
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                            exit($resp);
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
            }

            if ($resp == 1) {
                unset($_SESSION["cart"]);
            }
        }

        $conn->cerrar();
        return $resp;
    }
    
    public function registrarSalidaMaterialZI($idUsuario, $idSubalmacen, $tipo, $motivo) {
        $conn = new Conexion();
        $conn->conectar();
        session_start();
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $query = "SELECT * FROM t_subalmacenes_items WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $cantidad = $dts['cantidad'];
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
                $cantidadActual = $cantidad - $item['cantidad'];
                $resp = "";
                $query = "UPDATE t_subalmacenes_items "
                        . "SET cantidad = $cantidadActual "
                        . "WHERE id = " . $item['idMaterial'] . "";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        $resp = "";
                        $today = date("Y-m-d H:i:s");
                        switch ($tipo){
                            case 'mc':
                                $query = "INSERT INTO t_subalmacenes_salidas (id_usuario, id_material, cantidad, fecha, id_subalmacen, tipo, motivo) "
                                . "VALUES('$idUsuario', " . $item['idMaterial'] . ", " . $item['cantidad'] . ", '$today', $idSubalmacen, '$tipo', 'TAREA: $motivo')";
                                break;
                            case 'mp':
                                $query = "INSERT INTO t_subalmacenes_salidas (id_usuario, id_material, cantidad, fecha, id_subalmacen, tipo, motivo) "
                                . "VALUES('$idUsuario', " . $item['idMaterial'] . ", " . $item['cantidad'] . ", '$today', $idSubalmacen, '$tipo', 'OT: $motivo')";
                                break;
                            case 'otro':
                                $query = "INSERT INTO t_subalmacenes_salidas (id_usuario, id_material, cantidad, fecha, id_subalmacen, tipo, motivo) "
                                . "VALUES('$idUsuario', " . $item['idMaterial'] . ", " . $item['cantidad'] . ", '$today', $idSubalmacen, '$tipo', '$motivo')";
                                break;
                        }
                        
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                            exit($resp);
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($resp);
                }
            }

            if ($resp == 1) {
                unset($_SESSION["cart"]);
            }
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerEquipos($idSubseccion, $idDestino) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<option value=\"0\">Equipos</option>";

        $query = "SELECT id, equipo FROM t_equipos "
                . "WHERE id_destino = $idDestino "
                . "AND id_subseccion = $idSubseccion "
                . "ORDER BY equipo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];
                    $equipo = $dts['equipo'];

                    $salida .= "<option value=\"$idEquipo\">$equipo</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function obtenerMotivos($idEquipo, $tipo) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<option value=\"0\">Motivo</option>";

        if ($tipo == "mp") {
            $query = "SELECT * FROM t_mp_planeacion "
                    . "WHERE id_equipo = $idEquipo "
                    . "AND status = 'P'";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idPlaneacion = $dts['id'];
                        $año = $dts['año'];
                        $q = "SELECT * FROM t_ordenes_trabajo WHERE id_planeacion_mp = $idPlaneacion";
                        try {
                            $result = $conn->obtDatos($q);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($result as $d) {
                                    $idOT = $d['id'];
                                    $folioOT = $d['folio'];
                                    $salida .= "<option value=\"$idOT\">Folio: $folioOT Año: $año</option>";
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
        } else {
            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N'";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $idMC = $dts['id'];
                        $actividad = $dts['actividad'];

                        $salida .= "<option value=\"$idMC\">$actividad</option>";
                    }
                }
            } catch (Exception $ex) {
                $salida = $ex;
            }
        }


        $conn->cerrar();
        return $salida;
    }

}
?>

