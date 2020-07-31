<?php
session_start();
include_once 'php/template.php';
include 'php/conexion.php';
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
$layout = new Template();
$conn = new Conexion();
$conn->conectar();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    $conn->conectar();
    $idUsuario = $_SESSION['usuario'];
    //Obtener datos del usuario
    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
    try {
        $resp = $conn->obtDatos($query);
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $idColaborador = $dts['id_colaborador'];
                $idPermiso = $dts['id_permiso'];
                $idDestino = $dts['id_destino'];
                $idFase = $dts['fase'];
                $dec = $dts['DECC'];
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

                $query = "SELECT * FROM c_permisos WHERE id = $idPermiso";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $permiso = $dts['permiso'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

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
                            if ($dts['foto'] != "") {
                                $foto = $dts['foto'];
                            } else {
                                $foto = "";
                            }
                            $idSeccion = $dts['id_seccion'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                $query = "SELECT * FROM c_cargos WHERE id = $idCargo";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $cargo = $dts['cargo'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $seccion = $dts['seccion'];
                            $imgSeccion = $dts['url_image'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $destino = $dts['destino'];
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
}

if ($idDestino == 10) {
    if (isset($_SESSION['idDestino'])) {
        $idDestinoT = $_SESSION['idDestino'];
    } else {
        $idDestinoT = $idDestino;
    }
} else {
    $idDestinoT = $idDestino;
}

$query = "SELECT * FROM c_destinos WHERE id = $idDestinoT";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $destino = $dts['destino'];
            $bandera = $dts['bandera'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

$query = "SELECT * FROM t_eventos WHERE id_usuario = $idUsuario";
try {
    $eventos = $conn->obtDatos($query);
} catch (Exception $ex) {
    echo $ex;
}

//Log de accesos
$fechaAcceso = date('Y-m-d H:i:s');
$query = "INSERT INTO t_accesos(id_usuario, pagina, fecha) VALUES($idUsuario, 'PEDIDOS', '$fechaAcceso')";
try {
    $resp = $conn->consulta($query);
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <title>MAPHG</title>

    <?php echo $layout->styles(); ?>
    <link href='../fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href="../datedropper/datedropper.css" rel="stylesheet">
    <link href="../timedropper/timedropper.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="../DataTables/datatables.css">
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <div class="wrapper">
        <!-- Sidebar  -->
        <?php
        echo $layout->menu($destino);
        ?>

        <!-- Page Content  -->
        <div id="content" class="active">
            <!--navbar top-->
            <nav class="navbar fixed-top navbar-expand-lg navbar-light my-bg-light" style="height: 40px; position: absolute; display:none;">
                <div class="container-fluid">
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <div class="dropdown">
                        <span class="navbar-brand" href="#" style="font-size:15px; cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            if ($foto != "") :
                            ?>
                                <img class="rounded-circle" src="img/users/<?php echo $foto; ?>" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                            <?php
                            else :
                            ?>
                                <img class="rounded-circle" src="https://ui-avatars.com/api/?uppercase=false&name=<?php echo $nombre . "+" . $apellido; ?>&background=d8e6ff&rounded=true&color=4886ff&size=100%" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                            <?php
                            endif;
                            ?>
                            <!--<img class="rounded-circle" src="../img/users/<?php echo $foto; ?>" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">-->
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-right: 10;">
                            <a class="dropdown-item" href="perfil.php"><i class="ti-user"></i> <span class="small">Perfil</span></a>
                            <a class="dropdown-item" href="configuraciones.php"><i class="ti-settings"></i> <span class="small">Configuracion</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mLogout"><i class="ti-power-off"></i> <span class="small">Cerrar sesión</span></a>
                        </div>
                    </div>

                </div>

            </nav>

            <div class="mt-4 container-fluid">
                <div class="row mb-3">
                    <div class="col-8 col-md-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-1">
                                        <img src="svg/banderas/<?php echo $bandera; ?>" width="15">
                                    </div>
                                    <div class="col-9">
                                        <select id="cbDestinos" class="form-control form-control-sm input-texto" onchange="cargarTareasDestino();">
                                            <?php
                                            $query = "SELECT * FROM c_destinos ORDER BY destino";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {
                                                        $idDest = $dts['id'];
                                                        $nombreDest = $dts['destino'];
                                                        if ($idDestino == 10) {
                                                            if ($idDest == $idDestinoT) {
                                                                echo "<option value=\"$idDest\" selected>$nombreDest</option>";
                                                            } else {
                                                                echo "<option value=\"$idDest\">$nombreDest</option>";
                                                            }
                                                        } else {
                                                            if ($idDest == $idDestino) {
                                                                echo "<option value=\"$idDest\">$nombreDest</option>";
                                                            }
                                                        }
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container-fluid bg-white mt-3 rounded py-2">
                <div class="row">
                    <div class="col">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pedidos-sin-orden-tab" data-toggle="tab" href="#pedidos-sin-orden" role="tab" aria-controls="pedidos-sin-orden" aria-selected="false">Pedidos sin orden de compra</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="pedidos-pendientes-tab" data-toggle="tab" href="#pedidos-pendientes" role="tab" aria-controls="pedidos-pendientes" aria-selected="true">Pedidos pendientes de entrega</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="pedidos-entregados-tab" data-toggle="tab" href="#pedidos-entregados" role="tab" aria-controls="pedidos-entregados" aria-selected="true">Pedidos entregados</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pedidos-sin-orden" role="tabpanel" aria-labelledby="pedidos-sin-orden-tab">
                                <div class="row justify-content-center mt-3">
                                    <div class="col-6 text-center">
                                        <h5 class="spSemibold">Listado de pedidos sin orden de compra</h5>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table id="pedidos-sin-orden-compra" class="table table-bordered table-hover table-sm fs-10" style="width: 100%">
                                                <thead class="spSemibold">
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>

                                                        <th>CECO</th>
                                                        <th># Solicitud</th>
                                                        <th>Material</th>
                                                        <th>Fecha Solicitud</th>
                                                        <th>Cantidad solicitada</th>
                                                        <th>Unidad Medida</th>
                                                        <th>Tipo</th>
                                                        <th>Descripción</th>
                                                        <th>Sección</th>
                                                        <th>Solicitud Borrada</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                        <th>CECO</th>
                                                        <th># Solicitud</th>
                                                        <th>Material</th>
                                                        <th>Fecha Solicitud</th>
                                                        <th>Cantidad solicitada</th>
                                                        <th>Unidad Medida</th>
                                                        <th>Tipo</th>
                                                        <th>Descripción</th>
                                                        <th>Sección</th>
                                                        <th>Solicitud Borrada</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if ($idDestinoT == 10) {
                                                        $query = "SELECT t_pedidos_sin_orden_compra.id 'ID', "
                                                            . "t_pedidos_sin_orden_compra.id_destino 'IDDESTINO' ,"
                                                            . "t_pedidos_sin_orden_compra.ceco 'CECO', "
                                                            . "t_pedidos_sin_orden_compra.solicitud_pedido 'SOLPEDIDO', "
                                                            . "t_pedidos_sin_orden_compra.fecha_solicitud 'FECHASOL', "
                                                            . "t_pedidos_sin_orden_compra.text_breve 'TEXTO', "
                                                            . "t_pedidos_sin_orden_compra.cantidad_solicitada 'CANTSOL', "
                                                            . "t_pedidos_sin_orden_compra.unidad_medida 'UMEDIDA', "
                                                            . "t_pedidos_sin_orden_compra.grupo_compras 'GRUPOCOMPRAS', "
                                                            . "c_destinos.destino 'DESTINO', "
                                                            . "c_cecos.nombre_ceco 'NOMBRECEO'"
                                                            . "FROM t_pedidos_sin_orden_compra "
                                                            . "INNER JOIN c_destinos ON t_pedidos_sin_orden_compra.id_destino = c_destinos.id "
                                                            . "INNER JOIN c_cecos ON t_pedidos_sin_orden_compra.ceco = c_cecos.ceco"
                                                            . "ORDER BY id_destino";
                                                    } else {
                                                        $query = "SELECT t_pedidos_sin_orden_compra.id 'ID', "
                                                            . "t_pedidos_sin_orden_compra.id_destino 'IDDESTINO' ,"
                                                            . "t_pedidos_sin_orden_compra.ceco 'CECO', "
                                                            . "t_pedidos_sin_orden_compra.solicitud_pedido 'SOLPEDIDO', "
                                                            . "t_pedidos_sin_orden_compra.fecha_solicitud 'FECHASOL', "
                                                            . "t_pedidos_sin_orden_compra.text_breve 'TEXTO', "
                                                            . "t_pedidos_sin_orden_compra.cantidad_solicitada 'CANTSOL', "
                                                            . "t_pedidos_sin_orden_compra.unidad_medida 'UMEDIDA', "
                                                            . "t_pedidos_sin_orden_compra.grupo_compras 'GRUPOCOMPRAS', "
                                                            . "c_destinos.destino 'DESTINO', "
                                                            . "c_cecos.nombre_ceco 'NOMBRECEO' "
                                                            . "FROM t_pedidos_sin_orden_compra "
                                                            . "INNER JOIN c_destinos ON t_pedidos_sin_orden_compra.id_destino = c_destinos.id "
                                                            . "INNER JOIN c_cecos ON t_pedidos_sin_orden_compra.ceco = c_cecos.ceco "
                                                            . "WHERE id_destino = $idDestinoT";
                                                    }

                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idPedido = $dts['ID'];
                                                                $idDestinoPedido = $dts['IDDESTINO'];
                                                                $idCeco = $dts['CECO'];
                                                                $documentoCompras = $dts['SOLPEDIDO'];
                                                                $fechaSolicitud = $dts['FECHASOL'];
                                                                $material = $dts['TEXTO'];
                                                                $cantPedida = $dts['CANTSOL'];
                                                                $destino = $dts['DESTINO'];
                                                                $nombreCeco = $dts['NOMBRECEO'];
                                                                $grupo = $dts['GRUPOCOMPRAS'];
                                                                $umedida = $dts['UMEDIDA'];

                                                                if ($grupo != "") {
                                                                    if ($grupo == "001") {
                                                                        $grupo = "001 - ALMACEN";
                                                                    } else {
                                                                        $grupo = "002 - SUBALMACEN";
                                                                    }
                                                                } else {
                                                                    $grupo = "";
                                                                }

                                                                echo "<tr data-toggle=\"modal\" data-target=\"#modal-editar-item\">"
                                                                    . "<td style=\"display:none;\">$idPedido</td>";

                                                                if ($idDestinoT == 10) {
                                                                    echo "<td>$destino</td>";
                                                                }


                                                                echo "<td>$nombreCeco</td>"
                                                                    . "<td>$documentoCompras</td>"
                                                                    . "<td>$material</td>"
                                                                    . "<td>$fechaSolicitud</td>"
                                                                    . "<td>$cantPedida</td>"
                                                                    . "<td>$umedida</td>"
                                                                    . "<td>$grupo</td>"
                                                                    . "</tr>";
                                                            }
                                                        } else {
                                                            "No Results";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pedidos-pendientes" role="tabpanel" aria-labelledby="pedidos-pendientes-tab">
                                <div class="row justify-content-center mt-3">
                                    <div class="col-6 text-center">
                                        <h5 class="spSemibold">Listado de pedidos pendientes por entregar</h5>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table id="pedidos" class="table table-bordered table-hover table-sm fs-10" style="width: 100%">
                                                <thead class="spSemibold">
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>

                                                        <th>CECO</th>
                                                        <th># Documento Compras</th>
                                                        <th>Proveedor</th>
                                                        <th>Material</th>
                                                        <th>Fecha Documento</th>
                                                        <th>Fecha Entrega</th>
                                                        <th>Unidades por entregar</th>
                                                        <th>Valor USD</th>
                                                        <th>Seccion</th>
                                                        <th>Area</th>
                                                        <th>Estatus</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                        <th>CECO</th>
                                                        <th># Documento Compras</th>
                                                        <th>Proveedor</th>
                                                        <th>Material</th>
                                                        <th>Fecha Documento</th>
                                                        <th>Fecha Entrega</th>
                                                        <th>Unidades por entregar</th>
                                                        <th>Valor USD</th>
                                                        <th>Seccion</th>
                                                        <th>Area</th>
                                                        <th>Estatus</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if ($idDestinoT == 10) {
                                                        $query = "SELECT * FROM t_pedidos_por_entregar WHERE status = 'P' ORDER BY id_destino";
                                                    } else {
                                                        $query = "SELECT * FROM t_pedidos_por_entregar WHERE id_destino = $idDestinoT AND status = 'P'";
                                                    }

                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idPedido = $dts['id'];
                                                                $idDestinoPedido = $dts['id_destino'];
                                                                $idCeco = $dts['ceco'];
                                                                $documentoCompras = $dts['documento_compras'];
                                                                $fechaEntrega = $dts['fecha_entrega'];
                                                                $fechaDocumento = $dts['fecha_documento'];
                                                                $proveedor = $dts['proveedor'];
                                                                $material = $dts['texto_breve'];
                                                                $valorUSD = $dts['valor_usd'];
                                                                $cantPedida = $dts['cantidad_pedido'];
                                                                $cantPorEntregar = $dts['cantidad_por_entregar'];
                                                                $idSeccionP = $dts['id_seccion'];
                                                                $idSubseccionP = $dts['id_subseccion'];
                                                                $status = $dts['status'];
                                                                $tipo = $dts['tipo'];
                                                                $grupo = $dts['grupo_de_compras'];

                                                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoPedido";
                                                                try {
                                                                    $result = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($result as $d) {
                                                                            $destino = $d['destino'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                $query = "SELECT * FROM c_cecos WHERE ceco = '$idCeco'";
                                                                try {
                                                                    $result = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($result as $d) {
                                                                            $nombreCeco = $d['nombre_ceco'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                if ($idSeccionP != "") {
                                                                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionP";
                                                                    try {
                                                                        $result = $conn->obtDatos($query);
                                                                        if ($conn->filasConsultadas > 0) {
                                                                            foreach ($result as $d) {
                                                                                $seccion = $d['seccion'];
                                                                            }
                                                                        } else {
                                                                            $seccion = "";
                                                                        }
                                                                    } catch (Exception $ex) {
                                                                        echo $ex;
                                                                    }
                                                                } else {
                                                                    $seccion = "";
                                                                }

                                                                if ($idSubseccionP != "") {
                                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionP";
                                                                    try {
                                                                        $result = $conn->obtDatos($query);
                                                                        if ($conn->filasConsultadas > 0) {
                                                                            foreach ($result as $d) {
                                                                                $subseccion = $d['grupo'];
                                                                            }
                                                                        } else {
                                                                            $subseccion = "";
                                                                        }
                                                                    } catch (Exception $ex) {
                                                                        echo $ex;
                                                                    }
                                                                } else {
                                                                    $subseccion = "";
                                                                }

                                                                if ($status != "") {
                                                                    if ($status == "P") {
                                                                        $status = "PENDIENTE";
                                                                    } else {
                                                                        $status = "ENTREGADO";
                                                                    }
                                                                } else {
                                                                    $status = "";
                                                                }


                                                                if ($grupo != "") {
                                                                    if ($grupo == "001") {
                                                                        $grupo = "001 - ALMACEN";
                                                                    } else {
                                                                        $grupo = "002 - SUBALMACEN";
                                                                    }
                                                                } else {
                                                                    $grupo = "";
                                                                }

                                                                echo "<tr data-toggle=\"modal\" data-target=\"#modal-editar-item\">"
                                                                    . "<td style=\"display:none;\">$idPedido</td>";

                                                                if ($idDestinoT == 10) {
                                                                    echo "<td>$destino</td>";
                                                                }


                                                                echo "<td>$nombreCeco</td>"
                                                                    . "<td>$documentoCompras</td>"
                                                                    . "<td>$proveedor</td>"
                                                                    . "<td>$material</td>"
                                                                    . "<td>$fechaDocumento</td>"
                                                                    . "<td>$fechaEntrega</td>"
                                                                    . "<td>$cantPorEntregar</td>"
                                                                    . "<td>" . money_format("%.2n", $valorUSD) . "</td>"
                                                                    . "<td>$seccion</td>"
                                                                    . "<td>$subseccion</td>"
                                                                    . "<td>$status</td>"
                                                                    . "<td>$grupo</td>"
                                                                    . "</tr>";
                                                            }
                                                        } else {
                                                            "No Results";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pedidos-entregados" role="tabpanel" aria-labelledby="pedidos-sin-orden-tab">
                                <div class="row justify-content-center mt-3">
                                    <div class="col-6 text-center">
                                        <h5 class="spSemibold">Listado de pedidos entregados</h5>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table id="pedidos-entregados-table" class="table table-bordered table-hover table-sm fs-10" style="width: 100%">
                                                <thead class="spSemibold">
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>

                                                        <th>CECO</th>
                                                        <th># Documento Compras</th>
                                                        <th>Proveedor</th>
                                                        <th>Material</th>
                                                        <th>Fecha Documento</th>
                                                        <th>Fecha Entrega</th>
                                                        <th>Unidades por entregar</th>
                                                        <th>Valor USD</th>
                                                        <th>Seccion</th>
                                                        <th>Area</th>
                                                        <th>Estatus</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th style="display:none;">ID</th>
                                                        <?php
                                                        if ($idDestinoT == 10) :
                                                        ?>
                                                            <th>Destino</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                        <th>CECO</th>
                                                        <th># Documento Compras</th>
                                                        <th>Proveedor</th>
                                                        <th>Material</th>
                                                        <th>Fecha Documento</th>
                                                        <th>Fecha Entrega</th>
                                                        <th>Unidades por entregar</th>
                                                        <th>Valor USD</th>
                                                        <th>Seccion</th>
                                                        <th>Area</th>
                                                        <th>Estatus</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if ($idDestinoT == 10) {
                                                        $query = "SELECT * FROM t_pedidos_por_entregar WHERE status = 'E' ORDER BY id_destino";
                                                    } else {
                                                        $query = "SELECT * FROM t_pedidos_por_entregar WHERE id_destino = $idDestinoT AND status = 'E'";
                                                    }

                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idPedido = $dts['id'];
                                                                $idDestinoPedido = $dts['id_destino'];
                                                                $idCeco = $dts['ceco'];
                                                                $documentoCompras = $dts['documento_compras'];
                                                                $fechaEntrega = $dts['fecha_entrega'];
                                                                $fechaDocumento = $dts['fecha_documento'];
                                                                $proveedor = $dts['proveedor'];
                                                                $material = $dts['texto_breve'];
                                                                $valorUSD = $dts['valor_usd'];
                                                                $cantPedida = $dts['cantidad_pedido'];
                                                                $cantPorEntregar = $dts['cantidad_por_entregar'];
                                                                $idSeccionP = $dts['id_seccion'];
                                                                $idSubseccionP = $dts['id_subseccion'];
                                                                $status = $dts['status'];
                                                                $tipo = $dts['tipo'];
                                                                $grupo = $dts['grupo_de_compras'];

                                                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoPedido";
                                                                try {
                                                                    $result = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($result as $d) {
                                                                            $destino = $d['destino'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                $query = "SELECT * FROM c_cecos WHERE ceco = '$idCeco'";
                                                                try {
                                                                    $result = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($result as $d) {
                                                                            $nombreCeco = $d['nombre_ceco'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                if ($idSeccionP != "") {
                                                                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionP";
                                                                    try {
                                                                        $result = $conn->obtDatos($query);
                                                                        if ($conn->filasConsultadas > 0) {
                                                                            foreach ($result as $d) {
                                                                                $seccion = $d['seccion'];
                                                                            }
                                                                        } else {
                                                                            $seccion = "";
                                                                        }
                                                                    } catch (Exception $ex) {
                                                                        echo $ex;
                                                                    }
                                                                } else {
                                                                    $seccion = "";
                                                                }

                                                                if ($idSubseccionP != "") {
                                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionP";
                                                                    try {
                                                                        $result = $conn->obtDatos($query);
                                                                        if ($conn->filasConsultadas > 0) {
                                                                            foreach ($result as $d) {
                                                                                $subseccion = $d['grupo'];
                                                                            }
                                                                        } else {
                                                                            $subseccion = "";
                                                                        }
                                                                    } catch (Exception $ex) {
                                                                        echo $ex;
                                                                    }
                                                                } else {
                                                                    $subseccion = "";
                                                                }

                                                                if ($status != "") {
                                                                    if ($status == "P") {
                                                                        $status = "PENDIENTE";
                                                                    } else {
                                                                        $status = "ENTREGADO";
                                                                    }
                                                                } else {
                                                                    $status = "";
                                                                }


                                                                if ($grupo != "") {
                                                                    if ($grupo == "001") {
                                                                        $grupo = "001 - ALMACEN";
                                                                    } else {
                                                                        $grupo = "002 - SUBALMACEN";
                                                                    }
                                                                } else {
                                                                    $grupo = "";
                                                                }

                                                                echo "<tr data-toggle=\"modal\" data-target=\"#modal-editar-item\">"
                                                                    . "<td style=\"display:none;\">$idPedido</td>";

                                                                if ($idDestinoT == 10) {
                                                                    echo "<td>$destino</td>";
                                                                }


                                                                echo "<td>$nombreCeco</td>"
                                                                    . "<td>$documentoCompras</td>"
                                                                    . "<td>$proveedor</td>"
                                                                    . "<td>$material</td>"
                                                                    . "<td>$fechaDocumento</td>"
                                                                    . "<td>$fechaEntrega</td>"
                                                                    . "<td>$cantPorEntregar</td>"
                                                                    . "<td>" . money_format("%.2n", $valorUSD) . "</td>"
                                                                    . "<td>$seccion</td>"
                                                                    . "<td>$subseccion</td>"
                                                                    . "<td>$status</td>"
                                                                    . "<td>$grupo</td>"
                                                                    . "</tr>";
                                                            }
                                                        } else {
                                                            "No Results";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!--content-->
        </div>

        <div class="modal fade" id="mLogout" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Cerrar sesión?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="msg" class="modal-body">
                        ¿Desea cerrar su sesión?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>

                        <button type="button" class="btn btn-primary btn-sm" onclick="logout();">Cerrar sesión</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal-editar-item" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mLogout" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="hddIdPedido">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>SECCION</label>
                                    <select id="cbSecciones" class="form-control form-control-sm" onchange="cargarSubsecciones()">
                                        <option>SECCION</option>
                                        <?php
                                        $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $idSec = $dts['id'];
                                                    $nombreSeccion = $dts['seccion'];
                                                    echo "<option value=\"$idSec\">$nombreSeccion</option>";
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            echo $ex;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label>AREA</label>
                                <select id="cbSubsecciones" class="form-control form-control-sm">
                                    <option>AREA</option>
                                    <?php
                                    $query = "SELECT * FROM c_subsecciones ORDER BY id_seccion";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $idSubsec = $dts['id'];
                                                $nombreSubseccion = $dts['grupo'];
                                                echo "<option value=\"$idSubsec\">$nombreSubseccion</option>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label>ESTATUS</label>
                                <select id="cbStatus" class="form-control form-control-sm">
                                    <option>ESTATUS</option>
                                    <option value="P">Pendiente</option>
                                    <option value="E">Entregado</option>
                                </select>
                            </div>
                            <!--                                <div class="col">
                                                                    <select id="cbTipo" class="form-control form-control-sm">
                                                                        <option>TIPO</option>
                                                                        <option value="001">001 - Almacen</option>
                                                                        <option value="002">002 - Subalmacen</option>
                                                                    </select>
                                                                </div>-->
                            <div class="col-12">
                                <textarea id="txtComentarios" class="form-control form-control-sm" placeholder="Comentarios"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="actualizarRegistro();">Guardar <i class="fa fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <?php echo $layout->scripts(); ?>
    <script src="../js/pedidosJS.js"></script>
    <script src="../DataTables/datatables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            setInterval(function() {
                $.ajax({
                    type: 'post',
                    url: 'php/verificarSesionActiva.php',
                    data: 'action=1',
                    success: function(data) {}
                });
            }, 5000);

            setTimeout(function() {
                $(".loader").fadeOut('slow');
            }, 100);

            $('#sidebarCollapse').on('click', function() {
                //$('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var pedidos = $('#pedidos').DataTable({
                "order": [
                    [1, "asc"]
                ],
                "select": true,
                "scrollY": '45vh',
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                autoWidth: true,
                //                    "columnDefs": [
                //                        {"width": "50px", "targets": [4, 5]}
                //                    ],
                //                    fixedColumns: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        title: 'Reporte ',
                        className: 'btn-primary btn-sm'
                    },
                    {
                        extend: 'pdf',
                        title: 'Reporte ',
                        orientation: 'landscape',
                        className: 'btn-primary btn-sm'

                    },
                ],

                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }

            });

            pedidos
                .on('select', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                    var idPedido = rowData[0][0];
                    $("#hddIdPedido").val(idPedido);
                    $.ajax({
                        type: 'post',
                        url: 'php/pedidosPHP.php',
                        data: 'action=2&idPedido=' + idPedido,
                        success: function(data) {
                            try {
                                var datos = JSON.parse(data);
                                $("#cbSecciones").val(datos.idSeccion);
                                $("#cbSubsecciones").val(datos.idSubseccion);
                                $("#cbStatus").val(datos.status);
                                //$("#cbTipo").val(datos.tipo);
                                $("#txtComentarios").val(datos.comentarios);
                            } catch (ex) {}
                        }
                    });
                })
                .on('deselect', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                });


            var pedidosSinOrden = $('#pedidos-sin-orden-compra').DataTable({
                "order": [
                    [1, "asc"]
                ],
                "select": true,
                "scrollY": '45vh',
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                autoWidth: true,
                //                    "columnDefs": [
                //                        {"width": "50px", "targets": [4, 5]}
                //                    ],
                //                    fixedColumns: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        title: 'Reporte ',
                        className: 'btn-primary btn-sm'
                    },
                    {
                        extend: 'pdf',
                        title: 'Reporte ',
                        orientation: 'landscape',
                        className: 'btn-primary btn-sm'

                    },
                ],

                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }

            });

            pedidosSinOrden
                .on('select', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                    var idPedido = rowData[0][0];
                    $("#hddIdPedido").val(idPedido);
                    $.ajax({
                        type: 'post',
                        url: 'php/pedidosPHP.php',
                        data: 'action=2&idPedido=' + idPedido,
                        success: function(data) {
                            try {
                                var datos = JSON.parse(data);
                                $("#cbSecciones").val(datos.idSeccion);
                                $("#cbSubsecciones").val(datos.idSubseccion);
                                $("#cbStatus").val(datos.status);
                                //$("#cbTipo").val(datos.tipo);
                                $("#txtComentarios").val(datos.comentarios);
                            } catch (ex) {}
                        }
                    });
                })
                .on('deselect', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                });


            var pedidosEntregados = $('#pedidos-entregados-table').DataTable({
                "order": [
                    [1, "asc"]
                ],
                "select": true,
                "scrollY": '45vh',
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                autoWidth: true,
                //                    "columnDefs": [
                //                        {"width": "50px", "targets": [4, 5]}
                //                    ],
                //                    fixedColumns: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        title: 'Reporte ',
                        className: 'btn-primary btn-sm'
                    },
                    {
                        extend: 'pdf',
                        title: 'Reporte ',
                        orientation: 'landscape',
                        className: 'btn-primary btn-sm'

                    },
                ],

                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }

            });

            pedidosEntregados
                .on('select', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                    var idPedido = rowData[0][0];
                    $("#hddIdPedido").val(idPedido);
                    $.ajax({
                        type: 'post',
                        url: 'php/pedidosPHP.php',
                        data: 'action=2&idPedido=' + idPedido,
                        success: function(data) {
                            try {
                                var datos = JSON.parse(data);
                                $("#cbSecciones").val(datos.idSeccion);
                                $("#cbSubsecciones").val(datos.idSubseccion);
                                $("#cbStatus").val(datos.status);
                                //$("#cbTipo").val(datos.tipo);
                                $("#txtComentarios").val(datos.comentarios);
                            } catch (ex) {
                                alert(ex);
                            }
                        }
                    });
                })
                .on('deselect', function(e, dt, type, indexes) {
                    var rowData = pedidos.rows(indexes).data().toArray();
                });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
</body>

</html>