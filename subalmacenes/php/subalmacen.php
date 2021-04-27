<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
include "../../php/conexion.php";

if (isset($_GET['action'])) {

    $idDestino = $_GET['idDestino'];
    $idUsuario = $_GET['idUsuario'];
    $fechaActual = date('Y-m-d H:m:s');
    $action = $_GET['action'];
    $array = array();

    // OBTIENE EL SUBALMACEN SELECCIONADO
    if ($action == "subalmacenSeleccionado") {
        $idSubalmacen = $_GET['idSubalmacen'];

        $query = "SELECT nombre, fase, tipo FROM t_subalmacenes WHERE id = $idSubalmacen";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $subalmacen = $x['nombre'];
                $fase = $x['fase'];
                $tipo = $x['tipo'];

                $array['subalmacen'] = $subalmacen;
                $array['fase'] = $fase;
                $array['tipo'] = $tipo;
            }
        }
        echo json_encode($array);
    }

    // OBTIENE TODOS LOS STOCK POR DESTINO
    if ($action == "consultaTodosItems") {
        $palabraBuscar = $_GET['palabraBuscar'];

        if ($palabraBuscar == "") {
            $filtroPalabraBuscar = "";
        } else {
            $filtroPalabraBuscar = "and (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.descripcion_cod2bend LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
        }

        $query = "SELECT t_subalmacenes_items_stock.id, t_subalmacenes_items_stock.id_subalmacen, t_subalmacenes_items_stock.stock_actual, t_subalmacenes_items_stock.stock_teorico, t_subalmacenes_items_stock.id_item_global,
        t_subalmacenes_items_globales.cod2bend, 
        t_subalmacenes_items_globales.descripcion_cod2bend,
        t_subalmacenes_items_globales.descripcion_servicio_tecnico,
        t_subalmacenes_items_globales.id_seccion,
        t_subalmacenes_items_globales.area,
        t_subalmacenes_items_globales.categoria,
        t_subalmacenes_items_globales.marca,
        t_subalmacenes_items_globales.modelo,
        t_subalmacenes_items_globales.caracteristicas,
        t_subalmacenes_items_globales.subfamilia
        FROM t_subalmacenes_items_stock
        INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_globales.id 
        WHERE t_subalmacenes_items_stock.id_destino = $idDestino and t_subalmacenes_items_stock.activo = 1 $filtroPalabraBuscar";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSubalmacen = $x['id_subalmacen'];
                $idItemStock = $x['id'];
                $idItemGlobal = $x['id_item_global'];
                $stockTeorico = $x['stock_teorico'];
                $cod2bend = $x['cod2bend'];
                $descripcionCod2bend = $x['descripcion_cod2bend'];
                $servicioTecnico = $x['descripcion_servicio_tecnico'];
                $idSeccion = $x['id_seccion'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];
                $subfamilia = $x['subfamilia'];
                $stockActual = $x['stock_actual'];
                $stockTeorico = $x['stock_teorico'];

                #SECCION
                $seccion = "ND";
                $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $seccion = $x['seccion'];
                    }
                }


                #SUBALMACEN
                $subalmacen = "NA";
                $query = "SELECT nombre FROM t_subalmacenes WHERE id = $idSubalmacen";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $subalmacen = $x['nombre'];
                    }
                }

                $array[] = array(
                    "cod2bend" => $cod2bend,
                    "descripcionCod2bend" => $descripcionCod2bend,
                    "servicioTecnico" => $servicioTecnico,
                    "seccion" => $seccion,
                    "area" => $area,
                    "categoria" => $categoria,
                    "stockTeorico" => $stockTeorico,
                    "stockActual" => $stockActual,
                    "marca" => $marca,
                    "modelo" => $modelo,
                    "caracteristicas" => $caracteristicas,
                    "subfamilia" => $subfamilia,
                    "subalmacen" => $subalmacen
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE OPCIONES PARA AGREGAR UN ITEM GLOBAL POR DESTINO
    if ($action == "consultarOpcionesItem") {
        $array = array();

        $query = "SELECT id, seccion FROM c_secciones WHERE status = 'A' and mp = 'SI'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array['secciones'][] = array(
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );
            }
        }
        echo json_encode($array);
    }


    // AGREGAR ITEMS
    if ($action == "agregarItems") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $marca = $_GET['marca'];
        $gremio = $_GET['gremio'];
        $unidad = $_GET['unidad'];
        $descripcion = $_GET['descripcion'];
        $caracteristicas = $_GET['caracteristicas'];
        $cod2bend = $_GET['cod2bend'];
        $categoria = $_GET['categoria'];
        $stockTeorico = $_GET['stockTeorico'];
        $stockActual = $_GET['stockActual'];
        $fechaActual = date('Y-m-d H:m:s');
        $resp = 0;
        $idItem = 0;

        $query = "SELECT max(id) 'id' FROM t_subalmacenes_items_globales";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = intval($x['id']) + 1;
            }
        }

        if ($idItem > 0) {
            $query = "INSERT INTO t_subalmacenes_items_globales(id_destino, id_gremio, cod2bend, descripcion, marca, caracteristicas, unidad, fecha_registro, categoria, activo) VALUES($idDestino, $gremio, '$cod2bend', '$descripcion', '$marca', '$caracteristicas', '$unidad', '$fechaActual', '$categoria', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {

                $query = "INSERT INTO t_subalmacenes_items_stock(id_subalmacen, id_destino, id_item_global, stock_actual, stock_teorico, fecha_movimiento, fecha_creacion, activo) VALUES($idSubalmacen, $idDestino, $idItem, '$stockActual', '$stockTeorico', '$fechaActual', '$fechaActual', 1)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 1;
                }
            }
        }
        echo json_encode($resp);
    }


    if ($action == "finalizarCarrito") {
        $idDestino = $_GET["idDestino"];
        $idUsuario = $_GET["idUsuario"];
        $idSubalmacen = $_GET["idSubalmacen"];
        $tipoSalida = $_GET["tipoSalida"];
        $OT = $_GET["OT"];
        $array = array();
        $resp = 0;

        // VARIABLES PARA EL TIPO DE SALIDAS
        $idEquipo = 0;
        $idMCE = 0;
        $idMCTG = 0;
        $idMP = 0;
        $motivo = 0;
        $gift = 0;
        $existe = "NO";


        if ($tipoSalida == "FALLA") {
            $OT = preg_replace('([^0-9])', '', $OT);
            $query = "SELECT t_mc.id 'idFalla', t_equipos_america.id 'idEquipo' 
            FROM t_mc
            INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id 
            WHERE t_mc.id = $OT and t_mc.id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMCE = $x['idFalla'];
                    $idEquipo = $x['idEquipo'];
                    $existe = "SI";
                }
            }
        } elseif ($tipoSalida == "TAREA") {
            $OT = preg_replace('([^0-9])', '', $OT);
            $query = "SELECT t_mp_np.id 'idTarea', t_equipos_america.id 'idEquipo' 
            FROM t_mp_np
            INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id 
            WHERE t_mp_np.id = $OT and t_mp_np.id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMCTG = $x['idTarea'];
                    $idEquipo = $x['idEquipo'];
                    $existe = "SI";
                }
            }
        } elseif ($tipoSalida == "TG") {
            $OT = preg_replace('([^0-9])', '', $OT);
            $query = "SELECT id 'idTarea' 
            FROM t_mp_np
            WHERE id = $OT and id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMCTG = $x['idTarea'];
                    $existe = "SI";
                }
            }
        } elseif ($tipoSalida == "MP") {
            $OT = preg_replace('([^0-9])', '', $OT);
            $query = "SELECT t_mp_planificacion_iniciada.id 'idMP', t_equipos_america.id 'idEquipo' 
            FROM t_mp_planificacion_iniciada
            INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id 
            WHERE t_mp_planificacion_iniciada.id = $OT and t_equipos_america.id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMP = $x['idMP'];
                    $idEquipo = $x['idEquipo'];
                    $existe = "SI";
                }
            }
        } elseif ($tipoSalida == "GIFT") {
            $existe = "SI";
            $gift = $OT;
        } elseif ($tipoSalida == "OTRO") {
            $existe = "SI";
            $motivo = $OT;
        }

        if ($existe === "SI") {
            $query = "SELECT id, id_usuario, id_subalmacen, id_destino, id_item_global, stock_salida 
            FROM t_subalmacenes_items_stock_salidas 
            WHERE id_usuario = $idUsuario and id_destino = $idDestino and id_subalmacen = $idSubalmacen and status = 'ESPERA'";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {

                    // VALORES DE CARRITO
                    $idRegistro = $x["id"];
                    $idUsuarioX = $x["id_usuario"];
                    $idSubalmacenX = $x["id_subalmacen"];
                    $idDestinoX = $x["id_destino"];
                    $idItem = $x["id_item_global"];
                    $stockSalida = $x["stock_salida"];

                    // VALORES INICIALES
                    $idStock = 0;
                    $stockActual = 0;

                    // CONSULTA PARA RECURSOS DEL CARRITO
                    $query = "SELECT id, stock_actual, stock_teorico FROM t_subalmacenes_items_stock WHERE id_subalmacen = $idSubalmacenX and id_destino = $idDestinoX and id_item_global = $idItem LIMIT 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idStock = $x['id'];
                            $stockActual = $x['stock_actual'];
                            $stockTeorico = $x['stock_teorico'];
                        }
                    }

                    // VALORES FINALES
                    $nuevaCantidad = $stockActual - $stockSalida;

                    if ($nuevaCantidad >= 0) {
                        // PROCESO PARA FINALIZAR CARRITO
                        $query = "UPDATE t_subalmacenes_items_stock SET 
                        stock_actual = $nuevaCantidad, 
                        stock_anterior = $stockActual,
                        fecha_movimiento = '$fechaActual'
                        WHERE id = $idStock";
                        if ($result = mysqli_query($conn_2020, $query)) {

                            // MARCA COMO FINALIZADOS LOS REGISTROS
                            $query = "UPDATE t_subalmacenes_items_stock_salidas SET
                            tipo_salida = '$tipoSalida',
                            id_equipo = $idEquipo,
                            id_MCE = $idMCE, 
                            id_MCTG = $idMCTG, 
                            id_MP = $idMP, 
                            motivo = '$motivo',
                            gift = '$gift',
                            status = 'FINALIZADO',  
                            fecha_movimiento = '$fechaActual'
                            WHERE id = $idRegistro";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $resp = 1;
                            }
                        }
                    }

                    // $array[] = array(
                    //   "idRegistro" => $idRegistro,
                    //   "idStock" => $idStock,
                    //   "idUsuario" => $idUsuarioX,
                    //   "idSubalmacen" => $idSubalmacenX,
                    //   "idDestino" => $idDestinoX,
                    //   "idItem" => $idItem,
                    //   "stockSalida" => $stockSalida,
                    //   "stockActual" => $stockActual,
                    //   "NuevaCantidad" => $nuevaCantidad,
                    //   "idMCE" => $idMCE,
                    //   "existe" => $existe,
                    //   "OT" => $OT,
                    //   "resp" => $resp
                    // );
                }
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE TODOS LOS ITEMS DISPONIBLES PARA EL DESTINO
    if ($action == "obtenerItems") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $palabraBuscar = $_GET['palabraBuscar'];
        $resp = 0;

        if ($palabraBuscar != "") {
            $filtroPalabraBuscar = "and (categoria LIKE '%$palabraBuscar%' OR cod2bend LIKE '%$palabraBuscar%' OR descripcion_cod2bend LIKE '%$palabraBuscar%' OR caracteristicas LIKE '%$palabraBuscar%' OR marca LIKE '%$palabraBuscar%')";
        } else {
            $filtroPalabraBuscar = "";
        }

        $query = "SELECT id, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, id_seccion, area, categoria, stock_teorico, marca, modelo, caracteristicas, subfamilia  
        FROM t_subalmacenes_items_globales 
        WHERE id_destino = $idDestino and activo = 1 $filtroPalabraBuscar";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemGlobal = $x['id'];
                $cod2bend = $x['cod2bend'];
                $descripcionCod2bend = $x['descripcion_cod2bend'];
                $servicioTecnico = $x['descripcion_servicio_tecnico'];
                $idSeccion = $x['id_seccion'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $stockTeoricoX = $x['stock_teorico'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];
                $subfamilia = $x['subfamilia'];

                #SECCION
                $seccion = "ND";
                $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $seccion = $x['seccion'];
                    }
                }

                #STOCK
                $idItemStock = 0;
                $stockActual = 0;
                $stockTeorico = 0;
                $query = "SELECT id, stock_actual, stock_teorico 
                FROM t_subalmacenes_items_stock 
                WHERE id_item_global = $idItemGlobal and id_destino = $idDestino and id_subalmacen = $idSubalmacen and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idItemStock = $x['id'];
                        $stockActual = $x['stock_actual'];
                        $stockTeorico = $x['stock_teorico'];
                    }
                }

                if ($idItemStock == 0) {
                    $query = "INSERT INTO t_subalmacenes_items_stock(id_subalmacen, id_destino, id_item_global, stock_actual, stock_anterior, stock_teorico, fecha_movimiento, fecha_creacion, activo) VALUES($idSubalmacen, $idDestino, $idItemGlobal, 0, 0, $stockTeoricoX, '$fechaActual', '$fechaActual', 1)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 1;
                    }
                }

                #SUBALMACEN
                $subalmacen = "";
                $query = "SELECT nombre FROM t_subalmacenes WHERE id = $idSubalmacen";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $subalmacen = $x['nombre'];
                    }
                }

                $stockCantidadEntrada = "";
                $query = "SELECT stock_entrada
                FROM t_subalmacenes_items_stock_entradas 
                WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $stockCantidadEntrada = $x['stock_entrada'];
                    }
                }

                $stockCantidadSalida = "";
                $query = "SELECT stock_salida
                FROM t_subalmacenes_items_stock_salidas 
                WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $stockCantidadSalida = $x['stock_salida'];
                    }
                }

                $array[] = array(
                    "idItemGlobal" => intval($idItemGlobal),
                    "idSubalmacen" => intval($idSubalmacen),
                    "cod2bend" => $cod2bend,
                    "descripcionCod2bend" => $descripcionCod2bend,
                    "servicioTecnico" => $servicioTecnico,
                    "seccion" => $seccion,
                    "area" => $area,
                    "categoria" => $categoria,
                    "stockTeorico" => $stockTeorico,
                    "stockActual" => $stockActual,
                    "marca" => $marca,
                    "modelo" => $modelo,
                    "caracteristicas" => $caracteristicas,
                    "subfamilia" => $subfamilia,
                    "subalmacen" => $subalmacen,
                    "stockCantidadEntrada" => $stockCantidadEntrada,
                    "stockCantidadSalida" => $stockCantidadSalida,
                    "resp" => $resp
                );
            }
        }
        echo json_encode($array);
    }


    // AGREGA ENTRADAS AL CARRITO
    if ($action == "agregarEntrada") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $idItemGlobal = $_GET['idItemGlobal'];
        $cantidad = $_GET['cantidad'];
        $resp = "ERROR";

        #COMPRUEBA SI EXISTE REGISTRO
        $idRegistro = 0;
        $query = "SELECT id
        FROM t_subalmacenes_items_stock_entradas 
        WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and 
        id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idRegistro = $x['id'];
            }
        }

        #STOCK
        $stockTeorico = 0;
        $stockActual = 0;
        $query = "SELECT stock_teorico, stock_actual 
        FROM t_subalmacenes_items_stock 
        WHERE id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and 
        activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $stockTeorico = $x['stock_teorico'];
                $stockActual = $x['stock_actual'];
            }
        }

        #COMPRUEBA SI EXISTE EL REGISTRO, SINO LO CREA
        if ($idRegistro > 0 and $cantidad >= 0) {
            $query = "UPDATE t_subalmacenes_items_stock_entradas SET stock_entrada = $cantidad, stock_actual = $stockActual, stock_teorico = $stockTeorico, status = 'ESPERA', fecha_movimiento = '$fechaActual' 
            WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "ACTUALIZADO";
            }
        } elseif ($idRegistro == 0 and $cantidad > 0) {
            $query = "INSERT INTO t_subalmacenes_items_stock_entradas(id_usuario, id_subalmacen, id_destino, id_item_global, stock_entrada, stock_actual, status, fecha_movimiento, fecha_creacion) 
            VALUES($idUsuario, $idSubalmacen, $idDestino, $idItemGlobal, $cantidad, $stockActual, 'ESPERA', '$fechaActual', '$fechaActual')";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "AGREGADO";
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE TODAS LAS ENTRADAS PENDIENTES DEL CARRITO
    if ($action == "consultaEntradaCarrito") {
        $idSubalmacen = $_GET['idSubalmacen'];

        $query = "SELECT 
        t_subalmacenes_items_globales.id,
        t_subalmacenes_items_stock_entradas.stock_entrada,
        t_subalmacenes_items_globales.descripcion_cod2bend,
        t_subalmacenes_items_globales.caracteristicas,
        t_subalmacenes_items_globales.precio
        FROM t_subalmacenes_items_stock_entradas 
        INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock_entradas.id_item_global = t_subalmacenes_items_globales.id
        WHERE t_subalmacenes_items_stock_entradas.id_usuario = $idUsuario 
        AND t_subalmacenes_items_stock_entradas.id_subalmacen = $idSubalmacen 
        AND t_subalmacenes_items_stock_entradas.id_destino = $idDestino 
        AND t_subalmacenes_items_stock_entradas.status = 'ESPERA' 
        AND t_subalmacenes_items_stock_entradas.activo = 1
        AND t_subalmacenes_items_stock_entradas.stock_entrada > 0";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemGlobal = $x['id'];
                $stockEntrada = $x['stock_entrada'];
                $descripcion = $x['descripcion_cod2bend'];
                $caracteristicas = $x['caracteristicas'];
                $coste = $x['precio'];

                $array[] = array(
                    "idItemGlobal" => $idItemGlobal,
                    "stockEntrada" => $stockEntrada,
                    "descripcion" => $descripcion,
                    "caracteristicas" => $caracteristicas,
                    "coste" => $coste
                );
            }
        }
        echo json_encode($array);
    }


    // CONFIRMA ENTRADAS DE ITEMS
    if ($action == "confirmarEntradaSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $resp = 0;

        $query = "UPDATE t_subalmacenes_items_stock
        INNER JOIN t_subalmacenes_items_stock_entradas ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes_items_stock_entradas.id_subalmacen and t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_stock_entradas.id_item_global
        SET t_subalmacenes_items_stock.stock_anterior = t_subalmacenes_items_stock.stock_actual,
        t_subalmacenes_items_stock.stock_actual = t_subalmacenes_items_stock.stock_actual + t_subalmacenes_items_stock_entradas.stock_entrada, t_subalmacenes_items_stock_entradas.status = 'FINALIZADO',
        t_subalmacenes_items_stock.fecha_movimiento = '$fechaActual', 
        t_subalmacenes_items_stock_entradas.fecha_movimiento = '$fechaActual'
        WHERE t_subalmacenes_items_stock_entradas.id_subalmacen = $idSubalmacen and t_subalmacenes_items_stock_entradas.id_destino = $idDestino and t_subalmacenes_items_stock_entradas.status = 'ESPERA' and t_subalmacenes_items_stock_entradas.id_usuario = $idUsuario and t_subalmacenes_items_stock_entradas.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // RESTABLECE CARRITO ENTRADAS DE ITEMS
    if ($action == "restablecerEntradaSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $resp = 0;

        $query = "UPDATE t_subalmacenes_items_stock_entradas
        SET status = 'CANCELADO', fecha_movimiento = '$fechaActual'
        WHERE id_subalmacen = $idSubalmacen and id_destino = $idDestino and status = 'ESPERA' and id_usuario = $idUsuario and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // RESTABLECE CARRITO ENTRADAS DE ITEMS
    if ($action == "consultaExistenciasSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $palabraBuscar = $_GET['palabraBuscar'];

        if ($palabraBuscar != "") {
            $palabraBuscar = "AND (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' 
            OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' 
            OR t_subalmacenes_items_globales.descripcion_cod2bend LIKE '%$palabraBuscar%' 
            OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' 
            OR bitacora_gremio.nombre_gremio LIKE '%$palabraBuscar%' 
            OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
        } else {
            $palabraBuscar = "";
        }

        $query = "SELECT nombre, fase FROM t_subalmacenes WHERE id = $idSubalmacen";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $nombre = $x['nombre'];
                $fase = $x['fase'];
            }
        }

        $query = "SELECT
        t_subalmacenes_items_globales.id,
        t_subalmacenes_items_globales.categoria,
        t_subalmacenes_items_globales.cod2bend,
        t_subalmacenes_items_globales.tipo_material,
        t_subalmacenes_items_globales.descripcion_cod2bend,
        t_subalmacenes_items_globales.caracteristicas,
        t_subalmacenes_items_globales.marca,
        t_subalmacenes_items_globales.unidad,
        t_subalmacenes_items_stock.stock_teorico,
        t_subalmacenes_items_stock.stock_actual,
        bitacora_gremio.nombre_gremio
        FROM t_subalmacenes_items_stock 
        INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global =  t_subalmacenes_items_globales.id
        INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio =  bitacora_gremio.id
        WHERE t_subalmacenes_items_stock.id_subalmacen = $idSubalmacen 
        AND t_subalmacenes_items_stock.id_destino = $idDestino
        $palabraBuscar";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $categoria = $x['categoria'];
                $cod2bend = $x['cod2bend'];
                $gremio = $x['nombre_gremio'];
                $descripcion = $x['descripcion_cod2bend'];
                $caracteristicas = $x['caracteristicas'];
                $marca = $x['marca'];
                $cantidadActual = floatval($x['stock_actual']);
                $cantidadTeorico = floatval($x['stock_teorico']);
                $unidad = $x['unidad'];

                $array[] = array();
            }
        }

        echo json_encode($array);
    }


    // OBTIENE TODOS LOS ITEMS DISPONIBLES PARA EL DESTINO
    if ($action == "obtenerItemsx") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $palabraBuscar = $_GET['palabraBuscar'];
        $resp = 0;

        if ($palabraBuscar != "") {
            $filtroPalabraBuscar = "and (categoria LIKE '%$palabraBuscar%' OR cod2bend LIKE '%$palabraBuscar%' OR descripcion_cod2bend LIKE '%$palabraBuscar%' OR caracteristicas LIKE '%$palabraBuscar%' OR marca LIKE '%$palabraBuscar%')";
        } else {
            $filtroPalabraBuscar = "";
        }

        $query = "SELECT t_subalmacenes.nombre, c_fases.fase 
        FROM t_subalmacenes 
        INNER JOIN c_fases ON t_subalmacenes.id_fase = c_fases.id
        WHERE t_subalmacenes.id = $idSubalmacen";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $subalmacen = $x['nombre'];
                $fase = $x['fase'];

                $array['subalmacen'] = array(
                    "subalmacen" => $subalmacen,
                    "fase" => $fase
                );
            }
        }

        $query = "SELECT id, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, id_seccion, area, categoria, stock_teorico, marca, modelo, caracteristicas, subfamilia  
        FROM t_subalmacenes_items_globales 
        WHERE id_destino = $idDestino and activo = 1 $filtroPalabraBuscar";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemGlobal = $x['id'];
                $cod2bend = $x['cod2bend'];
                $descripcionCod2bend = $x['descripcion_cod2bend'];
                $servicioTecnico = $x['descripcion_servicio_tecnico'];
                $idSeccion = $x['id_seccion'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $stockTeoricoX = $x['stock_teorico'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];
                $subfamilia = $x['subfamilia'];

                #SECCION
                $seccion = "ND";
                $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $seccion = $x['seccion'];
                    }
                }

                #STOCK
                $idItemStock = 0;
                $stockActual = 0;
                $stockTeorico = 0;
                $query = "SELECT id, stock_actual, stock_teorico 
                FROM t_subalmacenes_items_stock 
                WHERE id_item_global = $idItemGlobal and id_destino = $idDestino and id_subalmacen = $idSubalmacen and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idItemStock = $x['id'];
                        $stockActual = $x['stock_actual'];
                        $stockTeorico = $x['stock_teorico'];
                    }
                }

                if ($idItemStock == 0) {
                    $query = "INSERT INTO t_subalmacenes_items_stock(id_subalmacen, id_destino, id_item_global, stock_actual, stock_anterior, stock_teorico, fecha_movimiento, fecha_creacion, activo) VALUES($idSubalmacen, $idDestino, $idItemGlobal, 0, 0, $stockTeoricoX, '$fechaActual', '$fechaActual', 1)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 1;
                    }
                }

                #SUBALMACEN
                $subalmacen = "";
                $query = "SELECT nombre FROM t_subalmacenes WHERE id = $idSubalmacen";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $subalmacen = $x['nombre'];
                    }
                }

                $stockCantidad = "";
                $query = "SELECT stock_entrada
                FROM t_subalmacenes_items_stock_entradas 
                WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $stockCantidad = $x['stock_entrada'];
                    }
                }

                $array['items'][] = array(
                    "idItemGlobal" => intval($idItemGlobal),
                    "idSubalmacen" => intval($idSubalmacen),
                    "cod2bend" => $cod2bend,
                    "descripcionCod2bend" => $descripcionCod2bend,
                    "servicioTecnico" => $servicioTecnico,
                    "seccion" => $seccion,
                    "area" => $area,
                    "categoria" => $categoria,
                    "stockTeorico" => $stockTeorico,
                    "stockActual" => $stockActual,
                    "marca" => $marca,
                    "modelo" => $modelo,
                    "caracteristicas" => $caracteristicas,
                    "subfamilia" => $subfamilia,
                    "subalmacen" => $subalmacen,
                    "stockCantidad" => $stockCantidad,
                    "resp" => $resp
                );
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE CARRITO DE SALIDA
    if ($action == "consultaSalidacarrito") {
        $idSubalmacen = $_GET['idSubalmacen'];

        $query = "SELECT 
        t_subalmacenes_items_globales.id,
        t_subalmacenes_items_stock_salidas.stock_entrada,
        t_subalmacenes_items_globales.descripcion_cod2bend,
        t_subalmacenes_items_globales.caracteristicas,
        t_subalmacenes_items_globales.precio
        FROM t_subalmacenes_items_stock_salidas 
        INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock_salidas.id_item_global = t_subalmacenes_items_globales.id
        WHERE t_subalmacenes_items_stock_salidas.id_usuario = $idUsuario 
        AND t_subalmacenes_items_stock_salidas.id_subalmacen = $idSubalmacen 
        AND t_subalmacenes_items_stock_salidas.id_destino = $idDestino 
        AND t_subalmacenes_items_stock_salidas.status = 'ESPERA' 
        AND t_subalmacenes_items_stock_salidas.activo = 1
        AND t_subalmacenes_items_stock_salidas.stock_entrada > 0";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemGlobal = $x['id'];
                $stockEntrada = $x['stock_entrada'];
                $descripcion = $x['descripcion_cod2bend'];
                $caracteristicas = $x['caracteristicas'];
                $coste = $x['precio'];

                $array[] = array(
                    "idItemGlobal" => $idItemGlobal,
                    "stockEntrada" => $stockEntrada,
                    "descripcion" => $descripcion,
                    "caracteristicas" => $caracteristicas,
                    "coste" => $coste
                );
            }
        }
        echo json_encode($array);
    }

    // AGREGA ENTRADAS AL CARRITO
    if ($action == "agregarSalida") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $idItemGlobal = $_GET['idItemGlobal'];
        $cantidad = $_GET['cantidad'];
        $resp = "ERROR";

        #COMPRUEBA SI EXISTE REGISTRO
        $idRegistro = 0;
        $query = "SELECT id
        FROM t_subalmacenes_items_stock_salidas 
        WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and 
        id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idRegistro = $x['id'];
            }
        }

        #STOCK
        $stockTeorico = 0;
        $stockActual = 0;
        $query = "SELECT stock_teorico, stock_actual 
        FROM t_subalmacenes_items_stock 
        WHERE id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and 
        activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $stockTeorico = $x['stock_teorico'];
                $stockActual = $x['stock_actual'];
            }
        }

        #COMPRUEBA SI EXISTE EL REGISTRO, SINO LO CREA, Y SI HAY CANTIDAD SUFICIENTE
        if ($stockActual >= $cantidad) {
            if ($idRegistro > 0 and $cantidad >= 0) {
                $query = "UPDATE t_subalmacenes_items_stock_salidas SET stock_salida = $cantidad, stock_actual = $stockActual, stock_teorico = $stockTeorico, status = 'ESPERA', fecha_movimiento = '$fechaActual' 
                WHERE id = $idRegistro";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "ACTUALIZADO";
                }
            } elseif ($idRegistro == 0 and $cantidad > 0) {
                $query = "INSERT INTO t_subalmacenes_items_stock_salidas(id_usuario, id_subalmacen, id_destino, id_item_global, stock_salida, stock_actual, stock_teorico, status, fecha_movimiento, fecha_creacion) 
                VALUES($idUsuario, $idSubalmacen, $idDestino, $idItemGlobal, $cantidad, $stockActual, $stockTeorico, 'ESPERA', '$fechaActual', '$fechaActual')";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "AGREGADO";
                }
            }
        } else {
            $resp = "INSUFICIENTE";
        }
        echo json_encode($resp);
    }


    // RESTABLECE CARRITO ENTRADAS DE ITEMS
    if ($action == "restablecerSalidasSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $resp = 0;

        $query = "UPDATE t_subalmacenes_items_stock_salidas
        SET status = 'CANCELADO', fecha_movimiento = '$fechaActual'
        WHERE id_subalmacen = $idSubalmacen and id_destino = $idDestino and status = 'ESPERA' and id_usuario = $idUsuario and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // OBTIENE TODAS LAS ENTRADAS PENDIENTES DEL CARRITO
    if ($action == "consultaSalidaCarrito") {
        $idSubalmacen = $_GET['idSubalmacen'];

        $query = "SELECT 
        t_subalmacenes_items_globales.id,
        t_subalmacenes_items_stock_salidas.stock_salida,
        t_subalmacenes_items_globales.descripcion_cod2bend,
        t_subalmacenes_items_globales.caracteristicas,
        t_subalmacenes_items_globales.precio
        FROM t_subalmacenes_items_stock_salidas 
        INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock_salidas.id_item_global = t_subalmacenes_items_globales.id
        WHERE t_subalmacenes_items_stock_salidas.id_usuario = $idUsuario 
        AND t_subalmacenes_items_stock_salidas.id_subalmacen = $idSubalmacen 
        AND t_subalmacenes_items_stock_salidas.id_destino = $idDestino 
        AND t_subalmacenes_items_stock_salidas.status = 'ESPERA' 
        AND t_subalmacenes_items_stock_salidas.activo = 1
        AND t_subalmacenes_items_stock_salidas.stock_salida > 0";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemGlobal = $x['id'];
                $stockSalida = $x['stock_salida'];
                $descripcion = $x['descripcion_cod2bend'];
                $caracteristicas = $x['caracteristicas'];
                $coste = $x['precio'];

                $array[] = array(
                    "idItemGlobal" => $idItemGlobal,
                    "stockSalida" => $stockSalida,
                    "descripcion" => $descripcion,
                    "caracteristicas" => $caracteristicas,
                    "coste" => $coste
                );
            }
        }
        echo json_encode($array);
    }


    // CONFIRMA ENTRADAS DE ITEMS
    if ($action == "confirmarSalidaSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $tipoSalida = $_GET['tipoSalida'];
        $OTSalida = $_GET['OTSalida'];
        $idX = 0;
        $resp = 0;
        if ($tipoSalida == "INCIDENCIA") {
            $query = "SELECT id FROM t_mc WHERE activo = 1 and id = $OTSalida and id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idX = $x['id'];
                }
            }
        } elseif ($tipoSalida == "INCIDENCIAGENERAL") {
            $query = "SELECT id FROM t_mp_np WHERE activo = 1 and id = $OTSalida and id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idX = $x['id'];
                }
            }
        } elseif ($tipoSalida == "PREVENTIVO") {
            $query = "SELECT t_mp_planificacion_iniciada.id 
            FROM t_mp_planificacion_iniciada
            INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
            WHERE t_mp_planificacion_iniciada.activo = 1 and t_mp_planificacion_iniciada.id = $OTSalida and t_equipos_america.id_destino = $idDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idX = $x['id'];
                }
            }
        }

        if ($tipoSalida == "INCIDENCIA" || $tipoSalida == "INCIDENCIAGENERAL" || $tipoSalida == "PREVENTIVO") {
            if ($idX == $OTSalida) {
                $query = "UPDATE t_subalmacenes_items_stock
                INNER JOIN t_subalmacenes_items_stock_salidas ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes_items_stock_salidas.id_subalmacen and t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_stock_salidas.id_item_global
                SET t_subalmacenes_items_stock.stock_anterior = t_subalmacenes_items_stock.stock_actual,
                t_subalmacenes_items_stock.stock_actual = t_subalmacenes_items_stock.stock_actual - t_subalmacenes_items_stock_salidas.stock_salida, t_subalmacenes_items_stock_salidas.status = 'FINALIZADO', t_subalmacenes_items_stock.fecha_movimiento = '$fechaActual', 
                t_subalmacenes_items_stock_salidas.fecha_movimiento = '$fechaActual', t_subalmacenes_items_stock_salidas.tipo_salida = '$tipoSalida', t_subalmacenes_items_stock_salidas.id_ot = '$OTSalida'
                WHERE t_subalmacenes_items_stock_salidas.id_subalmacen = $idSubalmacen and t_subalmacenes_items_stock_salidas.id_destino = $idDestino and t_subalmacenes_items_stock_salidas.status = 'ESPERA' and t_subalmacenes_items_stock_salidas.id_usuario = $idUsuario and t_subalmacenes_items_stock_salidas.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 1;
                }
            } else {
                $resp = 2;
            }
        } elseif ($tipoSalida == "GIFT" and $OTSalida != "") {
            $query = "UPDATE t_subalmacenes_items_stock
            INNER JOIN t_subalmacenes_items_stock_salidas ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes_items_stock_salidas.id_subalmacen and t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_stock_salidas.id_item_global
            SET t_subalmacenes_items_stock.stock_anterior = t_subalmacenes_items_stock.stock_actual,
            t_subalmacenes_items_stock.stock_actual = t_subalmacenes_items_stock.stock_actual - t_subalmacenes_items_stock_salidas.stock_salida, t_subalmacenes_items_stock_salidas.status = 'FINALIZADO',
            t_subalmacenes_items_stock.fecha_movimiento = '$fechaActual', 
            t_subalmacenes_items_stock_salidas.fecha_movimiento = '$fechaActual', t_subalmacenes_items_stock_salidas.tipo_salida = '$tipoSalida', t_subalmacenes_items_stock_salidas.id_ot = '$OTSalida'
            WHERE t_subalmacenes_items_stock_salidas.id_subalmacen = $idSubalmacen and t_subalmacenes_items_stock_salidas.id_destino = $idDestino and t_subalmacenes_items_stock_salidas.status = 'ESPERA' and t_subalmacenes_items_stock_salidas.id_usuario = $idUsuario and t_subalmacenes_items_stock_salidas.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } else if ($tipoSalida == "OTRO" and $OTSalida != "") {
            $query = "UPDATE t_subalmacenes_items_stock
            INNER JOIN t_subalmacenes_items_stock_salidas ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes_items_stock_salidas.id_subalmacen and t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_stock_salidas.id_item_global
            SET t_subalmacenes_items_stock.stock_anterior = t_subalmacenes_items_stock.stock_actual,
            t_subalmacenes_items_stock.stock_actual = t_subalmacenes_items_stock.stock_actual - t_subalmacenes_items_stock_salidas.stock_salida, t_subalmacenes_items_stock_salidas.status = 'FINALIZADO',
            t_subalmacenes_items_stock.fecha_movimiento = '$fechaActual', 
            t_subalmacenes_items_stock_salidas.fecha_movimiento = '$fechaActual', t_subalmacenes_items_stock_salidas.tipo_salida = '$tipoSalida', t_subalmacenes_items_stock_salidas.justifiacion_salida = '$OTSalida'
            WHERE t_subalmacenes_items_stock_salidas.id_subalmacen = $idSubalmacen and t_subalmacenes_items_stock_salidas.id_destino = $idDestino and t_subalmacenes_items_stock_salidas.status = 'ESPERA' and t_subalmacenes_items_stock_salidas.id_usuario = $idUsuario and t_subalmacenes_items_stock_salidas.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    // AGREGA ITEM GLOBAL POR DESTINO
    if ($action == "agregarItem") {
        $cod2bend = $_POST['cod2bendItem'];
        $idSeccion = $_POST['seccionItem'];
        $descripcionCod2bend = $_POST['descripcionCod2bendItem'];
        $SST = $_POST['SSTItem'];
        $area = $_POST['areaItem'];
        $categoria = $_POST['categoriaItem'];
        $stockTeorico = $_POST['stockTeoricoItem'];
        $marca = $_POST['marcaItem'];
        $subfamilia = $_POST['subfamiliaItem'];
        $modelo = $_POST['modeloItem'];
        $caracteristicas = $_POST['caracteristicasItem'];
        $resp = 0;

        $query = "INSERT INTO t_subalmacenes_items_globales(id_destino, id_seccion, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, area, categoria, stock_teorico, marca, subfamilia, modelo, caracteristicas, fecha_registro, activo) VALUES($idDestino, $idSeccion, '$cod2bend', '$descripcionCod2bend', '$SST', '$area', '$categoria', '$stockTeorico', '$marca', '$subfamilia', '$modelo', '$caracteristicas', '$fechaActual', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // OBTIENE INFORMACIÓN DEL ITEM SELECCIONADO
    if ($action == "obtenerItem") {
        $idItem = $_GET['idItem'];

        $query = "SELECT id_seccion, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, area, categoria, stock_teorico, marca, subfamilia, modelo, caracteristicas
        FROM t_subalmacenes_items_globales WHERE id = $idItem";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $cod2bend = $x['cod2bend'];
                $idSeccion = $x['id_seccion'];
                $descripcionCod2bend = $x['descripcion_cod2bend'];
                $SST = $x['descripcion_servicio_tecnico'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $stockTeorico = $x['stock_teorico'];
                $marca = $x['marca'];
                $subfamilia = $x['subfamilia'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];

                $array['cod2bend'] = $cod2bend;
                $array['idSeccion'] = $idSeccion;
                $array['descripcionCod2bend'] = $descripcionCod2bend;
                $array['SST'] = $SST;
                $array['area'] = $area;
                $array['categoria'] = $categoria;
                $array['stockTeorico'] = $stockTeorico;
                $array['marca'] = $marca;
                $array['subfamilia'] = $subfamilia;
                $array['modelo'] = $modelo;
                $array['caracteristicas'] = $caracteristicas;
            }
        }
        echo json_encode($array);
    }


    // ACTUALIZA ITEM GLOBAL SELECCIONADO
    if ($action == "actualizarItem") {
        $idItem = $_POST['idItem'];
        $cod2bend = $_POST['cod2bendItem'];
        $idSeccion = $_POST['seccionItem'];
        $descripcionCod2bend = $_POST['descripcionCod2bendItem'];
        $SST = $_POST['SSTItem'];
        $area = $_POST['areaItem'];
        $categoria = $_POST['categoriaItem'];
        $stockTeorico = $_POST['stockTeoricoItem'];
        $marca = $_POST['marcaItem'];
        $subfamilia = $_POST['subfamiliaItem'];
        $modelo = $_POST['modeloItem'];
        $caracteristicas = $_POST['caracteristicasItem'];
        $resp = 0;

        $query = "UPDATE  t_subalmacenes_items_globales SET 
        id_seccion = $idSeccion, 
        cod2bend = '$cod2bend', 
        descripcion_cod2bend = '$descripcionCod2bend',
        descripcion_servicio_tecnico = '$SST',
        area = '$area',
        categoria = '$categoria',
        stock_teorico = '$stockTeorico',
        marca = '$marca',
        subfamilia = '$subfamilia',
        modelo = '$modelo',
        caracteristicas = '$caracteristicas' 
        WHERE id = $idItem";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    if ($action == "procesoExcel") {
        $idSubalmacen = $_GET['idSubalmacen'];

        $data = json_decode(file_get_contents('php://input'), true);

        foreach ($data as $x) {
            $cod2bend = $x['cod2bend'];
            $descripcionCod2bend = $x['descripcionCod2bend'];
            $descripcionServiciosTecnicos = $x['descripcionServiciosTecnicos'];
            $idSeccion = $x['idSeccion'];
            $area = $x['area'];
            $categoria = strtoupper($x['categoria']);
            $stockTeorico = floatval($x['stockTeorico']);
            $marca = $x['marca'];
            $modelo = $x['modelo'];
            $caracteristicas = $x['caracteristicas'];
            $subfamilia = strtoupper($x['subfamilia']);
            $idItem_Registrado = 0;

            $palabraBuscar = strstr($descripcionCod2bend, ' ', true);

            if (($descripcionCod2bend == "" || $descripcionCod2bend == " ")) {
                $palabraBuscar = "xxxxxxxxxxxxxxxxxxxxxxxxx";
            }

            #BUSCA ITEM
            $query = "SELECT id, cod2bend, descripcion_cod2bend
            FROM t_subalmacenes_items_globales
            WHERE cod2bend = '$cod2bend' and descripcion_cod2bend LIKE '%$palabraBuscar%' and id_destino = $idDestino
            and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idItem_Registrado = $x['id'];
                    $cod2bend_Registrado = $x['cod2bend'];
                    $descripcionCod2bend_Registrado = $x['descripcion_cod2bend'];

                    $array[] = array(
                        "idItem_Registrado" => $idItem_Registrado,
                        "cod2bend_Registrado" => $cod2bend_Registrado,
                        "cod2bend_Nuevo" => $cod2bend,
                        "Descripcion_Registrado" => $descripcionCod2bend_Registrado,
                        "Descripcion_Nuevo" => $descripcionCod2bend,
                    );
                }
            }

            #AGREGA EL ITEM
            if ($idItem_Registrado <= 0) {
                $query = "INSERT INTO t_subalmacenes_items_globales(id_destino, id_seccion, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, area, categoria, stock_teorico, marca, modelo, caracteristicas, subfamilia, tipo_material, unidad, precio, activo) VALUES($idDestino, $idSeccion, '$cod2bend', '$descripcionCod2bend', '$descripcionServiciosTecnicos', '$area', '$categoria', 
                $stockTeorico, '$marca', '$modelo', '$caracteristicas', '$subfamilia', '', 'ND', '0.0', 1)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 1;
                }
            }
        }
        echo json_encode($array);
    }
}
