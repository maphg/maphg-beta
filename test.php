
<?php
class test{
    public function obtenerEquipos($idGrupo, $idDestino, $idCategoria, $idSubcategoria, $idRelCatSubcat) {
        date_default_timezone_set('America/Mexico_City');
        $currentWeek = date("W");

        $conn = new Conexion();
        $conn->conectar();
        $lstEquipo = [];

        $salida = "<div class=\"row\">"
                . "<div class=\"col-12\">"
                . "<div class=\"table-responsive\">"
                . "<table id=\"tablePlaneacion\" class=\"table table-sm fs-10\" style=\"width: 100%;\">"
                . "<thead class=\"spSemibold\">"
                . "<tr>"
                . "<th style=\"min-width: 300px;\">EQUIPO</th>";

        for ($i = 1; $i <= 52; $i++) {
            if ($i == $currentWeek) {
                $salida .= "<th class=\"bg-rojoc\">S$i</th>";
            } else {
                $salida .= "<th>S$i</th>";
            }
        }

        if ($idDestino == 10) {
            $query = "SELECT * FROM t_mc WHERE id_subseccion = $idGrupo AND id_categoria = 6 AND activo = 1 AND status = 'N'";
        } else {
            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idGrupo AND id_categoria = 6 AND activo = 1 AND status = 'N'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $penCategoria = $conn->filasConsultadas;
        } catch (Exception $ex) {
            echo $ex;
        }

        $salida .= "</tr>"
                . "<tr>"
                . "<td style=\"min-width: 300px;\" class=\"manita fs-10\" data-toggle=\"modal\" data-target=\"#modal-detalle-planaccion\" onclick=\"obtDetalleSubcategoria($idGrupo, $idDestino, 6, $idSubcategoria, $idRelCatSubcat);\">"
                . "<div class=\"row\"><div class=\"col-10 spSemibold\">TAREAS GENERALES DEL AREA</div><div class=\"col-1\">";
        if ($penCategoria > 0) {
            $salida .= "<span class=\"badge bg-rojof text-white fs-10\">$penCategoria</span>";
        }
        $salida .= "</div></div></td>";
        for ($i = 1; $i <= 52; $i++) {
            $salida .= "<td></td>";
        }
        $salida .= "</tr>";
        $salida .= "</thead>"
                . "<tbody class=\"\">";

        if ($idDestino == 10) {
            if ($idCategoria == 1) {
                $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo ORDER BY id_destino";
            } else {
                $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo AND categoria = $idCategoria AND pap = $idSubcategoria ORDER BY id_destino";
            }
        } else {
            if ($idCategoria == 1) {
                $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino ORDER BY equipo";
            } else {
                $query = "SELECT * FROM t_equipos WHERE id_subseccion = $idGrupo AND id_destino = $idDestino AND categoria = $idCategoria AND pap = $idSubcategoria ORDER BY equipo";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];

                    $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND activo = 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        $numeroPendientes = $conn->filasConsultadas;
                    } catch (Exception $ex) {
                        echo $ex;
                    }

                    $equipo = ["idEquipo" => $idEquipo, "cantPendientes" => $numeroPendientes];

                    $lstEquipo[] = $equipo;
                }
            }
        } catch (Exception $ex) {
            echo $ex;
        }

        foreach ($lstEquipo as $key => $row) {
            $aux[$key] = $row['cantPendientes'];
        }
        if (count($lstEquipo) > 0 && count($aux) > 0) {
            array_multisort($aux, SORT_DESC, $lstEquipo);

            foreach ($lstEquipo as $eq) {
                $query = "SELECT * FROM t_equipos WHERE id = " . $eq['idEquipo'] . " AND id_subseccion = $idGrupo AND status = 'A' ORDER BY equipo";

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
                            }

                            $query = "SELECT * FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalPenEquipo = $conn->filasConsultadas;
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            $salida .= "<tr>"
                                    . "<td style=\"min-width: 300px;\" class=\"manita fs-8\" data-toggle=\"modal\" data-target=\"#modal-detalle-tarea\" onclick=\"obtDetalleEquipo($idEquipo, $idGrupo, $idDestino, $idCategoria, $idSubcategoria)\"><div class=\"row\"><div class=\"col-10\">" . strtoupper($equipo) . "</div><div class=\"col-1\"> ";
                            if ($totalPenEquipo > 0) {
                                $salida .= "<span class=\"badge bg-rojof text-white fs-10\">$totalPenEquipo</span>";
                            }

                            $salida .= "</div></div></td>";
                            for ($i = 1; $i <= 52; $i++) {
                                $finalizados = 0;
                                $programados = 0;
                                $proceso = 0;
                                $query = "SELECT * FROM t_mp_planeacion WHERE id_equipo = $idEquipo AND semana = $i AND activo = 1";
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

                                        $salida .= "<td class=\"manita\" data-toggle=\"modal\" data-target=\"#modal-gant-equipo\" onclick=\"obtGantEquipo($idEquipo, 'acumulado');\"><img src=\"svg/$colors\" width=\"15\"></td>";
                                    } else {
                                        $salida .= "<td><img src=\"svg/nulo.svg\" width=\"15\"></td>";
                                    }
                                } catch (Exception $ex) {
                                    $salida = $ex;
                                }
                            }
                            $salida .= "</tr>";
                        }
                    }
                } catch (Exception $ex) {
                    $salida = $ex;
                }
            }
        }


        $salida .= "</tbody>"
                . "</table>"
                . "</div>"
                . "</div>"
                . "</div>";
        $conn->cerrar();
        return $salida;
    }
}

$equipo->planMC .= "<div class=\"row pda rounded-3 spdisplaysemibold fs-10 text-uppercase justify-content-center\">";
                    if ($destinoCreador == 10) {
                        $equipo->planMC .= "<div class=\"col-12 bg-rojoc rounded-3\">";
                    } else {
                        $equipo->planMC .= "<div class=\"col-12\">";
                    }
                    $equipo->planMC .= "<div class=\"row pb-1 mb-1 mx-1\">"
                            . "<div class=\"col-8 col-md-8 col-lg-8\">"
                            . "<div class=\"row\">"
                            . "<div class=\"col-10 col-md-11\">"
                            . "<div class=\"custom-control custom-checkbox checklist mt-2\">";
                    if ($statusAccion == "F") {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" >";
                            } else {
                                $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                            }
                        } else {
                            $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" checked onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                        }
                    } else {
                        if ($idDestinoActividad == 10) {
                            if ($_SESSION['usuario'] == 4) {
                                $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                            } else {
                                $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\" disabled>";
                            }
                        } else {
                            $equipo->planMC .= "<input type=\"checkbox\" class=\"custom-control-input\" id=\"chkb_$idAccion\" onchange=\"completarTarea($idAccion, this, " . $_SESSION["usuario"] . ")\">";
                        }
                    }


                    $equipo->planMC .= "<label class=\"custom-control-label fs-11 checklist pt-1\" for=\"chkb_$idAccion\">($des) $actividad</label>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "<div class=\"col text-center\">"
                            . "<a href=\"#\" class=\"rounded-circle btn2 \" data-toggle=\"\" data-placement=\"top\" title=\"Responsable: $nombreR $apellidoR\">";
                    if ($pagina == 0) {
                        if ($fotoR == "advertencia.svg") {
                            $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"img/users/$fotoR\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                        } else {
                            if ($fotoR == "") {
                                $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombreR+$apellidoR&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            } else {
                                $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"img/users/$fotoR\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            }
                        }
                    } else {
                        if ($foto == "advertencia.svg") {
                            $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"../img/users/$fotoR\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                        } else {
                            if ($foto == "") {
                                $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"https://ui-avatars.com/api/?uppercase=false&name=$nombreR+$apellidoR&background=d8e6ff&rounded=true&color=4886ff&size=100%\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            } else {
                                $equipo->planMC .= "<img onclick=\"setIdActividad($idAccion);\" data-toggle=\"modal\" data-target=\"#modal-agregar-responsable\" src=\"../img/users/$fotoR\" class=\"rounded-circle mt-2\" width=\"20px\" height=\"20px\"></a>";
                            }
                        }
                    }

//                                        echo "<img class=\"rounded-circle img-fluid\" width=\"40px\" src=\"https://picsum.photos/id/870/300/300?grayscale&blur=2\">";

                    if ($pagina == 1) {
                        $more = "../svg/adjuntos3.svg";
                    } else {
                        $more = "svg/adjuntos3.svg";
                    }
                    $equipo->planMC .= "</a></div>"
                            . "<div class=\"col  text-right px-0 py-1 mt-2\">"
                            . "<span class=\"rounded-circle img-fluid text-right mt-3\" data-toggle=\"collapse\" data-target=\"#collapse_$idAccion\" aria-expanded=\"false\" aria-controls=\"collapseExample\" onclick=\"obtenerComentariosST($pagina, $idAccion);\">Ver mas</span>"
                            . "</div>"
                            . "<div class=\"col text-right px-0 py-1 mt-2\">";
                    if ($tieneAdjuntos == "SI") {
                        $equipo->planMC .= "<img class=\"rounded-circle img-fluid\" src=\"$more\" width=\"20\">";
                    }


                    //Seccion de planeacion de MC
                    $query = "SELECT * FROM t_mc_planeacion WHERE id_mc = $idAccion";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $calendar = "calendariook.svg";
                        } else {
                            $calendar = "calendar.svg";
                        }
                    } catch (Exception $ex) {
                        $equipo = $ex;
                    }
                    $equipo->planMC .= "</div>"
                            . "<div class=\"col text-right px-0 py-1 mt-2\">"
                            . "<img class=\"img-fluid\" src=\"svg/$calendar\" width=\"20\" data-toggle=\"collapse\" data-target=\"#gant_$idAccion\" aria-expanded=\"false\" aria-controls=\"collapseExample\">"
                            . "</div>"
                            . "<div class=\"col-12\">"
                            //Collapse del gant de tareas
                            . "<div class=\"collapse\" id=\"gant_$idAccion\" data-parent=\"#planAccionPA\">"
                            . "<div class=\"table-responsive\">"
                            . "<table class=\"table table-sm\">"
                            . "<thead>"
                            . "<tr>";

                    for ($i = 1; $i <= 52; $i++) {
                        if ($currentWeek == $i) {
                            $equipo->planMC .= "<th class=\"bg-danger\">S$i</th>";
                        } else {
                            $equipo->planMC .= "<th >S$i</th>";
                        }
                    }

                    $equipo->planMC .= "</tr>"
                            . "</thead>"
                            . "<tbody>"
                            . "<tr>";
                    for ($i = 1; $i <= 52; $i++) {

                        $auxMC = false;
                        foreach ($resp as $d) {
                            $semanaMC = $d['semana'];
                            if ($semanaMC == $i) {
                                $auxMC = true;
                                //$equipo->planMC .= "<td onclick=\"agregarPlaneacionMC($idAccion, $i);\"><img class=\"img-fuid\" src=\"svg/P.svg\" width=\"15\"></td>";
                                //$equipo->planMC .= "<td ><img class=\"img-fuid\" src=\"svg/P.svg\" width=\"15\"></td>";
                                if ($semanaI == $i) {
                                    $equipo->planMC .= "<td class=\"text-center bg-success\"><div class=\"custom-control custom-checkbox ml-2\">
                                    <input type=\"checkbox\" class=\"custom-control-input\" id=\"chkbPMCPA$idAccion$i\" onchange=\"agregarPlaneacionMC($idAccion, $i);\" checked>
                                    <label class=\"custom-control-label\" for=\"chkbPMCPA$idAccion$i\"></label>
                                  </div></td>";
                                } else {
                                    $equipo->planMC .= "<td class=\"text-center\"><div class=\"custom-control custom-checkbox ml-2\">
                                    <input type=\"checkbox\" class=\"custom-control-input\" id=\"chkbPMCPA$idAccion$i\" onchange=\"agregarPlaneacionMC($idAccion, $i);\" checked>
                                    <label class=\"custom-control-label\" for=\"chkbPMCPA$idAccion$i\"></label>
                                  </div></td>";
                                }
                            } else {
                                //$equipo->planMC .= "<td onclick=\"agregarPlaneacionMC($idAccion, $i);\"><img class=\"img-fuid\" src=\"svg/nulo.svg\" width=\"15\"></td>";
                            }
                        }
                        if ($auxMC != true) {
                            //$equipo->planMC .= "<td onclick=\"agregarPlaneacionMC($idAccion, $i);\"><img class=\"img-fuid\" src=\"svg/nulo.svg\" width=\"15\"></td>";
                            if ($semanaI == $i) {
                                $equipo->planMC .= "<td class=\"text-center bg-success\"><div class=\"custom-control custom-checkbox ml-2\">
                                    <input type=\"checkbox\" class=\"custom-control-input\" id=\"chkbPMCPA$idAccion$i\" onchange=\"agregarPlaneacionMC($idAccion, $i);\">
                                    <label class=\"custom-control-label\" for=\"chkbPMCPA$idAccion$i\"></label>
                                  </div></td>";
                            } else {
                                $equipo->planMC .= "<td class=\"text-center\"><div class=\"custom-control custom-checkbox ml-2\">
                                    <input type=\"checkbox\" class=\"custom-control-input\" id=\"chkbPMCPA$idAccion$i\" onchange=\"agregarPlaneacionMC($idAccion, $i);\">
                                    <label class=\"custom-control-label\" for=\"chkbPMCPA$idAccion$i\"></label>
                                  </div></td>";
                            }
                        }
                    }
                    $equipo->planMC .= "</tr>"
                            . "</tbody>"
                            . "</table>"
                            . "</div>"
                            . "</div>"

                            //collapse de los comentarios
                            . "<div class=\"collapse\" id=\"collapse_$idAccion\" data-parent=\"#planAccionPA\">";

                    if ($destinoCreador == 10) {
                        $equipo->planMC .= "<div class=\"card card-body border-0 bg-rojoc\">";
                    } else {
                        $equipo->planMC .= "<div class=\"card card-body border-0 bg-white\">";
                    }

                    $equipo->planMC .= "<div class=\"row justify-content-center\">"
                            . "<div class=\"col-12 col-md-12 col-lg-9\">"
                            . "<input id=\"txtComentarioST$idAccion\" type=\"text\" class=\"form-control form-control-sm border-0 fs-10\" placeholder=\"Escriba aqui sus comentarios, al terminar presione ENTER\" onkeypress=\"agregarComentarioActividad($pagina, $idAccion, " . $_SESSION["usuario"] . ");\">"
                            . "</div>"
                            . "<div class=\"col-12 col-md-4 col-lg-1 mt-2\">"
                            . "<div class=\"btn-group btn-block\" role=\"group\" >"
                            . "<div class=\"upload-btn-wrapper\"><button class=\"btn btn-sm bg-body text-negron fs-10\">Adjuntar</button><input type=\"file\" id=\"tareaDoc$idAccion\" name=\"tareaDoc$idAccion\" onchange=\"upload_files(0, $idAccion);\"/></div>"
                            . "<button onclick=\"obtenerInfoST($idAccion, $pagina);\" data-toggle=\"modal\" data-target=\"#modal-editar-subtarea\" class=\"btn btn-sm bg-body text-negron fs-10 ml-1\">Editar</button>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>";

?>

<!--
<div class="column is-3 has-text-centered mr-5">
    <img src="svg/secciones/zia.svg" class="mb-4" width="40px" alt="">

    <div class="columns is-mobile" data-toggle="collapse" href="#aljibes" >
        <div class="column has-text-left is-11 pad-03">
            <h1 class="title is-5 text-truncate"><span><i class="fas fa-caret-right has-text-info"></i></span> ALJIBES</h1>
        </div>
        <div class="column is-1 pad-03">
            <div class="tags has-addons">
                <span class="tag is-danger">99</span>
            </div>
        </div>
    </div>


    <div class="column collapse pad-03" id="aljibes">
        <div class="columns is-mobile">
            <div class="column is-1">
            </div>
            <div class="column is-10 has-text-left is-three-fifths pad-03">
                <h1 class="title is-6" onclick="showHide('show');"><span><i class="fas fa-caret-right has-text-danger" ></i></span> MP/MC-EQUIPOS</h1>
            </div>
            <div class="column is-1 pad-03">
                <div class="tags has-addons">
                    <span class="tag is-danger">99</span>
                </div>
            </div>
        </div>

        <div class="columns is-mobile">
            <div class="column is-1">
            </div>
            <div class="column is-10 has-text-left is-three-fifths pad-03">
                <h1 class="title is-6"><span><i class="fas fa-caret-right has-text-danger"></i></span> BITÁCORAS</h1>
            </div>
            <div class="column is-1 pad-03">
                <div class="tags has-addons">
                    <span class="tag is-danger">99</span>
                </div>
            </div>
        </div>

        <div class="columns is-mobile">
            <div class="column is-1">
            </div>
            <div class="column is-10 has-text-left is-three-fifths pad-03">
                <h1 class="title is-6"><span><i class="fas fa-caret-right has-text-danger"></i></span> INFORMACIÓN</h1>
            </div>
            <div class="column is-1 pad-03">
                <div class="tags has-addons">
                    <span class="tag is-danger">99</span>
                </div>
            </div>
        </div>

        <div class="columns is-mobile">
            <div class="column is-1">
            </div>
            <div class="column is-10 has-text-left is-three-fifths pad-03">
                <h1 class="title is-6"><span><i class="fas fa-caret-right has-text-danger"></i></span> STOCK - PEDIDOS</h1>
            </div>
            <div class="column is-1 pad-03">
                <div class="tags has-addons">
                    <span class="tag is-danger">99</span>
                </div>
            </div>
        </div>
    </div>
</div>-->
