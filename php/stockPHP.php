<?php

setlocale(LC_MONETARY, 'en_US');
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "obtStockXPagina") {
        $idDestino = $_POST['idDestino'];
        $pagina = $_POST['pagina'];
        $idSubseccionStock = 0;
        $obj = new Stock();
        $resp = $obj->obtenerStockXPagina($idDestino, $pagina, $idSubseccionStock);
        echo $resp;
    }

    if ($action == 'filtrar') {
        $idDestino = $_POST['idDestino'];
        $pagina = $_POST['pagina'];
        $idSubseccionStock = $_POST['subseccion'];
        $idSeccion = $_POST['seccion'];
        $obj = new Stock();
        $resp = $obj->filtrar($idDestino, $pagina, $idSeccion, $idSubseccionStock);
        echo $resp;
    }

    if ($action == 'busqueda') {
        $idDestino = $_POST['idDestino'];
        $pagina = $_POST['pagina'];
        $idSubseccionStock = $_POST['subseccion'];
        $idSeccion = $_POST['seccion'];
        $busqueda = $_POST['busqueda'];
        $obj = new Stock();
        $resp = $obj->busqueda($idDestino, $pagina, $busqueda, $idSeccion, $idSubseccionStock);
        echo $resp;
    }

    if ($action == 1) {
        $idSeccion = $_POST['idFamilia'];
        $obj = new Stock();
        $resp = $obj->obtFamilias($idSeccion);
        echo $resp;
    }

    if ($action == 2) {
        $idDestino = $_POST['idDestino'];
        $fase = $_POST['fase'];
        $ubicacion = $_POST['ubicacion'];
        $cod2bend = $_POST['cod2bend'];
        $descripcion2bend = $_POST['descripcion2bend'];
        $naturaleza = $_POST['naturaleza'];
        $seccion = $_POST['seccion'];
        $familia = $_POST['familia'];
        $subfamilia = $_POST['subfamilia'];
        $descripcionNueva = $_POST['descripcionNueva'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $caracteristicasPpales = $_POST['caracteristicasPpales'];
        $existencias2bend = $_POST['existencias2bend'];
        $existenciasSubalmacen = $_POST['existenciasSubalmacen'];
        $precio = $_POST['precio'];
        $consumoAnual = $_POST['consumoAnual'];
        $stockNecesario = $_POST['stockNecesario'];
        $unidadesPedir = $_POST['unidadesPedir'];
        $fechaPedido = $_POST['fechaPedido'];
        $prioridad = $_POST['prioridad'];
        $fechaLlegada = $_POST['fechaLlegada'];

        $obj = new Stock();
        $resp = $obj->agregarRegistro($idDestino, $fase, $ubicacion, $cod2bend, $descripcion2bend, $naturaleza, $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales, $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir, $fechaPedido, $prioridad, $fechaLlegada);
        echo $resp;
    }

    if ($action == 3) {
        $idDestino = $_POST['idDestino'];
        $cod2bend = $_POST['cod2bend'];
        $descripcion2bend = $_POST['descripcion2bend'];
        $naturaleza = $_POST['naturaleza'];
        $seccion = $_POST['seccion'];
        $familia = $_POST['familia'];
        $subfamilia = $_POST['subfamilia'];
        $equipoPpal = $_POST['equipoppal'];
        $descripcionNueva = $_POST['descripcionNueva'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $caracteristicasPpales = $_POST['caracteristicasPpales'];
        $existencias2bend = $_POST['existencias2bend'];
        $existenciasSubalmacen = $_POST['existenciasSubalmacen'];
        $precio = $_POST['precio'];
        $consumoAnual = $_POST['consumoAnual'];
        $stockNecesario = $_POST['stockNecesario'];
        $unidadesPedir = $_POST['unidadesPedir'];
        $fechaPedido = $_POST['fechaPedido'];
        $prioridad = $_POST['prioridad'];
        $fechaLlegada = $_POST['fechaLlegada'];

        $obj = new Stock();
        $resp = $obj->agregarRegistroStockNecesario($idDestino, $cod2bend, $descripcion2bend, $naturaleza, $seccion, $familia, $subfamilia, $equipoPpal, $descripcionNueva, $marca, $modelo, $caracteristicasPpales, $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir, $fechaPedido, $prioridad, $fechaLlegada);
        echo $resp;
    }

    if ($action == 4) {
        $idRegistro = $_POST['idRegistro'];
        $obj = new Stock();
        $resp = $obj->obtenerRegistro($idRegistro);
        echo json_encode($resp);
    }

    if ($action == 5) {
        $idRegistro = $_POST['idRegistro'];
        $idDestino = $_POST['idDestino'];
        $fase = $_POST['fase'];
        $ubicacion = $_POST['ubicacion'];
        $cod2bend = $_POST['cod2bend'];
        $descripcion2bend = $_POST['descripcion2bend'];
        $naturaleza = $_POST['naturaleza'];
        $seccion = $_POST['seccion'];
        $familia = $_POST['familia'];
        $subfamilia = $_POST['subfamilia'];
        $descripcionNueva = $_POST['descripcionNueva'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $caracteristicasPpales = $_POST['caracteristicasPpales'];
        $existencias2bend = $_POST['existencias2bend'];
        $existenciasSubalmacen = $_POST['existenciasSubalmacen'];
        $precio = $_POST['precio'];
        $consumoAnual = $_POST['consumoAnual'];
        $stockNecesario = $_POST['stockNecesario'];
        $unidadesPedir = $_POST['unidadesPedir'];
        $fechaPedido = $_POST['fechaPedido'];
        $prioridad = $_POST['prioridad'];
        $fechaLlegada = $_POST['fechaLlegada'];

        $obj = new Stock();
        $resp = $obj->actualizarRegistro($idRegistro, $idDestino, $fase, $ubicacion, $cod2bend, $descripcion2bend, $naturaleza, $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales, $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir, $fechaPedido, $prioridad, $fechaLlegada);
        echo $resp;
    }

    if ($action == 6) {
        $idRegistro = $_POST['idRegistro'];
        $obj = new Stock();
        $resp = $obj->obtenerRegistroStockNecesario($idRegistro);
        echo json_encode($resp);
    }

    if ($action == 7) {
        $idRegistro = $_POST['idRegistro'];
        $idDestino = $_POST['idDestino'];
        $fase = $_POST['fase'];
//        $ubicacion = $_POST['ubicacion'];
        $cod2bend = $_POST['cod2bend'];
        $descripcion2bend = $_POST['descripcion2bend'];
        $naturaleza = $_POST['naturaleza'];
        $seccion = $_POST['seccion'];
        $familia = $_POST['familia'];
        $subfamilia = $_POST['subfamilia'];
        $descripcionNueva = $_POST['descripcionNueva'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $caracteristicasPpales = $_POST['caracteristicasPpales'];
        $existencias2bend = $_POST['existencias2bend'];
        $existenciasSubalmacen = $_POST['existenciasSubalmacen'];
        $precio = $_POST['precio'];
        $consumoAnual = $_POST['consumoAnual'];
        $stockNecesario = $_POST['stockNecesario'];
        $unidadesPedir = $_POST['unidadesPedir'];
        $fechaPedido = $_POST['fechaPedido'];
        $prioridad = $_POST['prioridad'];
        $fechaLlegada = $_POST['fechaLlegada'];

        $obj = new Stock();
        $resp = $obj->actualizarRegistroStockNecesario($idRegistro, $idDestino, $fase, $cod2bend, $descripcion2bend, $naturaleza, $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales, $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir, $fechaPedido, $prioridad, $fechaLlegada);
        echo $resp;
    }

    if ($action == 8) {
        $idRegistro = $_POST['idRegistro'];
        $obj = new Stock();
        $resp = $obj->eliminarRegistroStockNecesario($idRegistro);
        echo $resp;
    }

    if ($action == 9) {
        $idSeccion = $_POST['idSeccion'];
        $obj = new Stock();
        $resp = $obj->cargarFamilias($idSeccion);
        echo $resp;
    }

    if ($action == 10) {
        $word = $_POST['word'];
        $obj = new Stock();
        $resp = $obj->buscarMaterial($word);
        echo $resp;
    }
}

Class registro {

    public $idDestino;
    public $fase;
    public $ubicacion;
    public $cod2bend;
    public $descripcion2bend;
    public $naturaleza;
    public $seccion;
    public $familia;
    public $subfamilia;
    public $descripcionNueva;
    public $marca;
    public $modelo;
    public $caracteristicasPpales;
    public $existencias2bend;
    public $existenciasSubalmacen;
    public $precio;
    public $consumoAnual;
    public $stockNecesario;
    public $unidadesPedir;
    public $fechaPedido;
    public $prioridad;
    public $fechaLlegada;

}

Class Stock {

    public function obtFamilias($idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        $query = "SELECT * FROM c_subsecciones WHERE id_seccion = $idSeccion ORDER BY grupo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSubfamilia = $dts['id'];
                    $subfamilia = $dts['grupo'];

                    $salida .= "<option class=\"fs-11\" value=\"$idSubfamilia\">$subfamilia</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function agregarRegistro($idDestino, $fase, $ubicacion, $cod2bend, $descripcion2bend, $naturaleza,
            $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales,
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            $fechaPedido, $prioridad, $fechaLlegada) {

        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
        $fechaPedido = date("Y-m-d", strtotime($fechaPedido));
        $fechaLlegada = date("Y-m-d", strtotime($fechaLlegada));

        $query = "INSERT INTO t_stock(id_destino, fase, ubicacion, cod2bend, descripcion2bend, naturaleza, "
                . "id_seccion, familia, subfamilia, descripcion_nueva, marca, modelo, caracteristicas_principales, "
                . "num_existencias_2bend, num_existencias_subalmacenes, precio, consumo_anual, stock_necesario, unidades_pedir, "
                . "fecha_pedido, prioridad, fecha_entrega) "
                . "VALUES($idDestino, '$fase', '$ubicacion', '$cod2bend', '$descripcion2bend', '$naturaleza',
            $seccion, $familia, '$subfamilia', '$descripcionNueva', '$marca', '$modelo', '$caracteristicasPpales',
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            '$fechaPedido', '$prioridad', '$fechaLlegada')";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function agregarRegistroStockNecesario($idDestino, $cod2bend, $descripcion2bend, $naturaleza,
            $seccion, $familia, $subfamilia, $equipoPpal, $descripcionNueva, $marca, $modelo, $caracteristicasPpales,
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            $fechaPedido, $prioridad, $fechaLlegada) {

        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
        $fechaPedido = date("Y-m-d", strtotime($fechaPedido));
        $fechaLlegada = date("Y-m-d", strtotime($fechaLlegada));

        $query = "INSERT INTO t_stock_necesario(id_destino, cod2bend, descripcion2bend, naturaleza, "
                . "id_seccion, familia, subfamilia, descripcion_nueva, marca, modelo, caracteristicas_principales, "
                . "num_existencias_2bend, num_existencias_subalmacenes, precio, consumo_anual, stock_necesario, unidades_pedir, "
                . "fecha_pedido, prioridad, fecha_entrega, equipo_ppal) "
                . "VALUES($idDestino, '$cod2bend', '$descripcion2bend', '$naturaleza',
            $seccion, $familia, '$subfamilia', '$descripcionNueva', '$marca', '$modelo', '$caracteristicasPpales',
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            '$fechaPedido', '$prioridad', '$fechaLlegada', '$equipoPpal')";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerRegistro($idRegistro) {
        $conn = new Conexion();
        $conn->conectar();

        $registro = new registro();

        $query = "SELECT * FROM t_stock WHERE id = $idRegistro";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $registro->idDestino = $dts['id_destino'];
                    $registro->fase = $dts['fase'];
                    $registro->ubicacion = $dts['ubicacion'];
                    $registro->cod2bend = $dts['cod2bend'];
                    $registro->descripcion2bend = $dts['descripcion2bend'];
                    $registro->naturaleza = $dts['naturaleza'];
                    $registro->seccion = $dts['id_seccion'];
                    $registro->familia = $dts['familia'];
                    $registro->subfamilia = $dts['subfamilia'];
                    $registro->descripcionNueva = $dts['descripcion_nueva'];
                    $registro->marca = $dts['marca'];
                    $registro->modelo = $dts['modelo'];
                    $registro->caracteristicasPpales = $dts['caracteristicas_principales'];
                    $registro->existencias2bend = $dts['num_existencias_2bend'];
                    $registro->existenciasSubalmacen = $dts['num_existencias_2bend'];
                    $registro->precio = $dts['precio'];
                    $registro->consumoAnual = $dts['consumo_anual'];
                    $registro->stockNecesario = $dts['stock_necesario'];
                    $registro->unidadesPedir = $dts['unidades_pedir'];
                    $registro->fechaPedido = $dts['fecha_pedido'];
                    $registro->prioridad = $dts['prioridad'];
                    $registro->fechaLlegada = $dts['fecha_entrega'];
                }
            }
        } catch (Exception $ex) {
            $registro = $ex;
        }

        $conn->cerrar();
        return $registro;
    }

    public function actualizarRegistro($idRegistro, $idDestino, $fase, $ubicacion, $cod2bend, $descripcion2bend, $naturaleza,
            $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales,
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            $fechaPedido, $prioridad, $fechaLlegada) {

        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
        $fechaPedido = date("Y-m-d", strtotime($fechaPedido));
        $fechaLlegada = date("Y-m-d", strtotime($fechaLlegada));

        $query = "UPDATE t_stock SET id_destino=$idDestino,fase='$fase',ubicacion='$ubicacion', "
                . "cod2bend='$cod2bend',descripcion2bend='$descripcion2bend',naturaleza='$naturaleza',id_seccion=$seccion, "
                . "familia=$familia,subfamilia='$subfamilia',descripcion_nueva='$descripcionNueva', "
                . "marca='$marca',modelo='$modelo',caracteristicas_principales='$caracteristicasPpales', "
                . "num_existencias_2bend= $existencias2bend,num_existencias_subalmacenes=$existenciasSubalmacen, "
                . "precio=$precio,consumo_anual=$consumoAnual,stock_necesario=$stockNecesario, "
                . "unidades_pedir=$unidadesPedir,fecha_pedido='$fechaPedido',prioridad='$prioridad', "
                . "fecha_entrega='$fechaLlegada' WHERE id = $idRegistro";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtenerRegistroStockNecesario($idRegistro) {
        $conn = new Conexion();
        $conn->conectar();

        $registro = new registro();

        $query = "SELECT * FROM t_stock_necesario WHERE id = $idRegistro";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $registro->idDestino = $dts['id_destino'];
                    $registro->fase = $dts['fase'];
                    //$registro->ubicacion = $dts['ubicacion'];
                    $registro->cod2bend = $dts['cod2bend'];
                    $registro->descripcion2bend = $dts['descripcion2bend'];
                    $registro->naturaleza = $dts['naturaleza'];
                    $registro->seccion = $dts['id_seccion'];
                    $registro->familia = $dts['familia'];
                    $registro->subfamilia = $dts['subfamilia'];
                    $registro->descripcionNueva = $dts['descripcion_nueva'];
                    $registro->marca = $dts['marca'];
                    $registro->modelo = $dts['modelo'];
                    $registro->caracteristicasPpales = $dts['caracteristicas_principales'];
                    $registro->existencias2bend = $dts['num_existencias_2bend'];
                    $registro->existenciasSubalmacen = $dts['num_existencias_2bend'];
                    $registro->precio = $dts['precio'];
                    $registro->consumoAnual = $dts['consumo_anual'];
                    $registro->stockNecesario = $dts['stock_necesario'];
                    $registro->unidadesPedir = $dts['unidades_pedir'];
                    $registro->fechaPedido = $dts['fecha_pedido'];
                    $registro->prioridad = $dts['prioridad'];
                    $registro->fechaLlegada = $dts['fecha_entrega'];
                }
            }
        } catch (Exception $ex) {
            $registro = $ex;
        }

        $conn->cerrar();
        return $registro;
    }

    public function actualizarRegistroStockNecesario($idRegistro, $idDestino, $fase, $cod2bend, $descripcion2bend, $naturaleza,
            $seccion, $familia, $subfamilia, $descripcionNueva, $marca, $modelo, $caracteristicasPpales,
            $existencias2bend, $existenciasSubalmacen, $precio, $consumoAnual, $stockNecesario, $unidadesPedir,
            $fechaPedido, $prioridad, $fechaLlegada) {

        $conn = new Conexion();
        $conn->conectar();

        date_default_timezone_set('America/Cancun');
        $fechaPedido = date("Y-m-d", strtotime($fechaPedido));
        $fechaLlegada = date("Y-m-d", strtotime($fechaLlegada));

        $query = "UPDATE t_stock_necesario SET id_destino=$idDestino,fase='$fase', "
                . "cod2bend='$cod2bend',descripcion2bend='$descripcion2bend',naturaleza='$naturaleza',id_seccion=$seccion, "
                . "familia=$familia,subfamilia='$subfamilia',descripcion_nueva='$descripcionNueva', "
                . "marca='$marca',modelo='$modelo',caracteristicas_principales='$caracteristicasPpales', "
                . "num_existencias_2bend= $existencias2bend,num_existencias_subalmacenes=$existenciasSubalmacen, "
                . "precio=$precio,consumo_anual=$consumoAnual,stock_necesario=$stockNecesario, "
                . "unidades_pedir=$unidadesPedir,fecha_pedido='$fechaPedido',prioridad='$prioridad', "
                . "fecha_entrega='$fechaLlegada' WHERE id = $idRegistro";

        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarRegistroStockNecesario($idRegistro) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "DELETE FROM t_stock_necesario WHERE id = $idRegistro";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function cargarFamilias($idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $query = "SELECT * FROM c_subsecciones WHERE id_seccion = $idSeccion ORDER BY grupo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idFamilia = $dts['id'];
                    $familia = $dts['grupo'];
                    $salida .= "<option class=\"fs-11\" value=\"$idFamilia\">$familia</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function buscarMaterial($word) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";

        $query = "SELECT * FROM c_materiales_sap WHERE codigo = $word";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $material = $dts['material'];
                    $salida .= "<div class=\"columns\">"
                            . "<div class=\"column manita\">"
                            . "<h7 id=\"htexto\" onclick=\"selectItem(this);\">$material</h7>"
                            . "</div>"
                            . "</div>";
                }
            } else {
                $salida .= "<div class=\"columns\">"
                        . "<div class=\"column manita\">"
                        . "<h7 class=\"spSemibold\">Sin resultados</h7>"
                        . "</div>"
                        . "</div>";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        $conn->cerrar();
        return $salida;
    }

    public function obtenerStockXPagina($idDestino, $pagina, $idSubseccionStock) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<div class=\"columns mt-2 mx-5\">"
                . "<div class=\"column is-mobile is-centered px-4\">"
                . "<div class=\"columns is-gapless my-1 is-mobile\">"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Item</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Familia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Subfamilia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Precio compras</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Cotizacion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Precio Mantto</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Cotizacion</p></div>"
                . "</div>";


        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE familia = $idSubseccionStock ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "ORDER BY fecha_pedido";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino AND familia = $idSubseccionStock ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino ORDER BY fecha_pedido";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            echo $ex;
        }


        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.familia = $idSubseccionStock "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "AND t_stock_necesario.familia = $idSubseccionStock "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['ID'];
                    $idDestinoReg = $dts['IDDESTINO'];
                    $cod2bend = $dts['COD2BEND'];
                    $descripcion2bend = $dts['DESC2BEND'];
                    $seccion = $dts['SECCION'];
                    $familia = $dts['FAMILIA'];
                    $subfamilia = $dts['SUBFAMILIA'];
                    $descripcionNueva = $dts['DESCNUEVA'];
                    $precioCompras = $dts['PRECIOC'];
                    $proveedorCompras = $dts['PROVC'];
                    $cotizacionCompras = $dts['COTC'];
                    $precioMantto = $dts['PRECIOM'];
                    $proveedorMantto = $dts['PROVM'];
                    $cotizacionMantto = $dts['COTM'];

                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless modal-button\" data-target=\"modal\" aria-haspopup=\"true\">";
                    if ($descripcionNueva == "") {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcion2bend</p></div>";
                    } else {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcionNueva</p></div>";
                    }
                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$familia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$precioCompras</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$proveedorCompras</p></div>";
                    if ($cotizacionCompras != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$precioMantto</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$proveedorMantto</p></div>";
                    if ($cotizacionMantto != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }


        $salida .= "</div>"
                . "</div>"
                . "<div class=\"columns is-centered\">"
                . "<div class=\"column is-8\">"
                . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPagina($idDestino, 1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPagina($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPagina($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPagina($idDestino, $totalPaginas);\" href=\"#\">Fin</a>";
        } else {

            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $salida .= "<ul class=\"pagination-list\">";

        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $salida .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestino, 1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestino, $totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }


        $salida .= "</ul>"
                . "</nav>"
                . "</div>"
                . "</div>";
        $conn->cerrar();
        return $salida;
    }

    public function filtrar($idDestino, $pagina, $seccion, $idSubseccionStock) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<div class=\"columns mt-2 mx-5\">"
                . "<div class=\"column is-mobile is-centered px-4\">"
                . "<div class=\"columns is-gapless my-1 is-mobile\">"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Item</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Familia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Subfamilia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Precio compras</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Cotizacion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Precio Mantto</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Cotizacion</p></div>"
                . "</div>";


        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_seccion = $seccion AND familia = $idSubseccionStock ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "ORDER BY fecha_pedido";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino AND id_seccion = $seccion AND familia = $idSubseccionStock ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino ORDER BY fecha_pedido";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            echo $ex;
        }


        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_seccion = $seccion "
                        . "AND t_stock_necesario.familia = $idSubseccionStock "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "AND t_stock_necesario.id_seccion = $seccion "
                        . "AND t_stock_necesario.familia = $idSubseccionStock "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['ID'];
                    $idDestinoReg = $dts['IDDESTINO'];
                    $cod2bend = $dts['COD2BEND'];
                    $descripcion2bend = $dts['DESC2BEND'];
                    $seccion = $dts['SECCION'];
                    $familia = $dts['FAMILIA'];
                    $subfamilia = $dts['SUBFAMILIA'];
                    $descripcionNueva = $dts['DESCNUEVA'];
                    $precioCompras = $dts['PRECIOC'];
                    $proveedorCompras = $dts['PROVC'];
                    $cotizacionCompras = $dts['COTC'];
                    $precioMantto = $dts['PRECIOM'];
                    $proveedorMantto = $dts['PROVM'];
                    $cotizacionMantto = $dts['COTM'];

                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless modal-button\" data-target=\"modal\" aria-haspopup=\"true\">";
                    if ($descripcionNueva == "") {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcion2bend</p></div>";
                    } else {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcionNueva</p></div>";
                    }
                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$familia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$precioCompras</p></div>";
                    if ($cotizacionCompras != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$precioMantto</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$proveedorMantto</p></div>";
                    if ($cotizacionMantto != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }


        $salida .= "</div>"
                . "</div>"
                . "<div class=\"columns is-centered\">"
                . "<div class=\"column is-8\">"
                . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPaginaFiltro($idDestino, 1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPaginaFiltro($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPaginaFiltro($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPaginaFiltro($idDestino, $totalPaginas);\" href=\"#\">Fin</a>";
        } else {

            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $salida .= "<ul class=\"pagination-list\">";

        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $salida .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaFiltro($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaFiltro($idDestino, 1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaFiltro($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaFiltro($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaFiltro($idDestino, $totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }


        $salida .= "</ul>"
                . "</nav>"
                . "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

    public function busqueda($idDestino, $pagina, $busqueda, $seccion, $idSubseccionStock) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<div class=\"columns mt-2 mx-5\">"
                . "<div class=\"column is-mobile is-centered px-4\">"
                . "<div class=\"columns is-gapless my-1 is-mobile\">"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Item</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Familia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Subfamilia</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Precio compras</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-info has-text-white\">Cotizacion</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Precio Mantto</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Proveedor</p></div>"
                . "<div class=\"column\"><p class=\"t-titulos has-background-link has-text-white\">Cotizacion</p></div>"
                . "</div>";


        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_seccion = $seccion "
                        . "AND familia = $idSubseccionStock "
                        . "AND (descripcion2bend LIKE '%$busqueda%' OR descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE (descripcion2bend LIKE '%$busqueda%' OR descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino "
                        . "AND id_seccion = $seccion "
                        . "AND familia = $idSubseccionStock "
                        . "AND (descripcion2bend LIKE '%$busqueda%' OR descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido";
            } else {
                $query = "SELECT * FROM t_stock_necesario "
                        . "WHERE id_destino = $idDestino "
                        . "AND (descripcion2bend LIKE '%$busqueda%' OR descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            echo $ex;
        }


        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_seccion = $seccion "
                        . "AND t_stock_necesario.familia = $idSubseccionStock "
                        . "AND (t_stock_necesario.descripcion2bend LIKE '%$busqueda%' OR t_stock_necesario.descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE (t_stock_necesario.descripcion2bend LIKE '%$busqueda%' OR t_stock_necesario.descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        } else {
            if ($idSubseccionStock > 0) {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "AND t_stock_necesario.id_seccion = $seccion "
                        . "AND t_stock_necesario.familia = $idSubseccionStock "
                        . "AND (t_stock_necesario.descripcion2bend LIKE '%$busqueda%' OR t_stock_necesario.descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            } else {
                $query = "SELECT t_stock_necesario.id 'ID', "
                        . "t_stock_necesario.id_destino 'IDDESTINO', "
                        . "t_stock_necesario.cod2bend 'COD2BEND', "
                        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                        . "t_stock_necesario.id_seccion 'IDSECCION', "
                        . "t_stock_necesario.familia 'IDFAMILIA', "
                        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                        . "t_stock_necesario.precio_compras 'PRECIOC', "
                        . "t_stock_necesario.proveedor_compras 'PROVC', "
                        . "t_stock_necesario.cotizacion_compras 'COTC', "
                        . "t_stock_necesario.precio_mantto 'PRECIOM', "
                        . "t_stock_necesario.proveedor_mantto 'PROVM', "
                        . "t_stock_necesario.cotizacion_mantto 'COTM', "
                        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                        . "c_secciones.seccion 'SECCION', "
                        . "c_subsecciones.grupo 'FAMILIA' "
                        . "FROM t_stock_necesario "
                        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                        . "WHERE t_stock_necesario.id_destino = $idDestino "
                        . "AND (t_stock_necesario.descripcion2bend LIKE '%$busqueda%' OR t_stock_necesario.descripcion_nueva LIKE '%$busqueda%') "
                        . "ORDER BY fecha_pedido "
                        . "LIMIT $desde, $porPagina";
            }
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['ID'];
                    $idDestinoReg = $dts['IDDESTINO'];
                    $cod2bend = $dts['COD2BEND'];
                    $descripcion2bend = $dts['DESC2BEND'];
                    $seccion = $dts['SECCION'];
                    $familia = $dts['FAMILIA'];
                    $subfamilia = $dts['SUBFAMILIA'];
                    $descripcionNueva = $dts['DESCNUEVA'];
                    $precioCompras = $dts['PRECIOC'];
                    $proveedorCompras = $dts['PROVC'];
                    $cotizacionCompras = $dts['COTC'];
                    $precioMantto = $dts['PRECIOM'];
                    $proveedorMantto = $dts['PROVM'];
                    $cotizacionMantto = $dts['COTM'];

                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless modal-button\" data-target=\"modal\" aria-haspopup=\"true\">";
                    if ($descripcionNueva == "") {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcion2bend</p></div>";
                    } else {
                        $salida .= "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcionNueva</p></div>";
                    }
                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$familia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$precioCompras</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$proveedorCompras</p></div>";
                    if ($cotizacionCompras != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "<div class=\"column\"><p class=\"t-normal\">$precioMantto</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$proveedorMantto</p></div>";
                    if ($cotizacionMantto != "") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Descargar</p></div>";
                    }

                    $salida .= "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }


        $salida .= "</div>"
                . "</div>"
                . "<div class=\"columns is-centered\">"
                . "<div class=\"column is-8\">"
                . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, 1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, $totalPaginas);\" href=\"#\">Fin</a>";
        } else {

            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>";
            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $salida .= "<ul class=\"pagination-list\">";

        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $salida .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, 1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, " . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPaginaBusqueda($idDestino, $totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }


        $salida .= "</ul>"
                . "</nav>"
                . "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

}

?>