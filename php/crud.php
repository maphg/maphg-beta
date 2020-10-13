<?php

date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
session_start();

include 'conexion.php';

if (isset($_POST['action'])) {

    $action = $_POST['action'];


    // Variables Generales.
    $array_destino = array(1 => "RM", 2 => "PVR", 3 => "SDQ", 4 => "SSA", 5 => "PUJ", 6 => "MBJ", 7 => "CMU", 10 => "AME", 11 => "CAP");
    $arrayDEPNombre = array(62 => "RRHH", 211 => "Finanzas", 212 => "Dirección", 213 => "Compras Almacén", 214 => "Calidad", 200 => "Proyectos");


    // Lista de Proyectos
    if ($action == "listarProyectos") {

        $id_Destino = $_POST["id_Destino"];
        $id_Seccion = $_POST["id_Seccion"];
        $idSubseccion = $_POST["idSubseccion"];
        $idUsuarioP = $_POST["idUsuario"];
        $statusProyecto = $_POST["statusProyecto"];

        if ($idSubseccion == 62 || $idSubseccion == 211 || $idSubseccion == 212 || $idSubseccion == 213 || $idSubseccion == 214) {
            $subseccion = "AND id_subseccion=$idSubseccion";
            $subseccionDEP = "<div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\"  onclick=\" show_hide_modal('modal-proyectos','hide'); reporteStatusDEP($idSubseccion, $id_Destino , 23, 0, 0, 0, ' $array_destino[$id_Destino]', '$arrayDEPNombre[$idSubseccion]',''); \">
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
        } else {
            $subseccion = "AND id_subseccion=200";
            $subseccionDEP = "<div class=\" modal columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\"  onclick=\" show_hide_modal('modal-proyectos','hide'); reporteStatusDEP($idSubseccion, $id_Destino , 23, 0, 0, 0, ' $array_destino[$id_Destino]', '$arrayDEPNombre[$idSubseccion]',''); \">
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

        if ($id_Destino != 10) {
            $query = "SELECT* FROM t_proyectos WHERE id_destino=$id_Destino AND id_seccion=$id_Seccion AND status='$statusProyecto' AND activo=1 $subseccion ORDER BY id DESC";
        } else {
            $query = "SELECT* FROM t_proyectos WHERE id_seccion=$id_Seccion AND status='$statusProyecto' AND activo=1 $subseccion ORDER BY id DESC";
        }


        $result = mysqli_query($conn_2020, $query);

        // Columna para DEP.
        // reporteStatusDEP(214, 10, 23, 0, 0, 0, 'destinoTNombre', 'seccionNombre','Calidad' );
        echo $subseccionDEP;


        while ($row_proyectos = mysqli_fetch_array($result)) {

            // Variables.
            $idProyecto = $row_proyectos['id'];


            // $query_status_urgente = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and status='status_urgente'";
            // $result_status_urgente = mysqli_query($conn_2020, $query_status_urgente);
            // if (mysqli_num_rows($result_status_urgente) > 0) {
            //     $status_principal = "<span><i class=\"has-text-danger fad fa-siren-on mr-1 fa-lg animated infinite flash\"></i>i</span>";
            // }

            $query_status_urgente = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and status='status_urgente'";
            $result_status_urgente = mysqli_query($conn_2020, $query_status_urgente);
            if (mysqli_num_rows($result_status_urgente) > 0) {
                $urgente_icono = "<span><i class=\"has-text-danger fad fa-siren-on mr-1 fa-lg animated infinite flash\"></i></span>";
            } else {
                $urgente_icono = "";
            }

            echo "
                <div class=\"columns is-gapless my-1 cursor mx-4\" >
                    <div class=\"column is-one-third modal-button\" data-target=\"modal-id\">
                        <div class=\"columns\">
                            <div class=\"column\">
                                <div class=\"tarea is-small is-danger overflow \">
                ";

            $query_t_users = "SELECT* FROM t_users WHERE id =" . $row_proyectos['creado_por'] . "";
            $result_t_users = mysqli_query($conn_2020, $query_t_users);
            if ($row_t_users = mysqli_fetch_array($result_t_users)) {

                $query_Colaborador = "SELECT* FROM t_colaboradores WHERE id =" . $row_t_users['id_colaborador'] . "";
                $result_Colaborador = mysqli_query($conn_2020, $query_Colaborador);
                if ($row_Colaborador = mysqli_fetch_array($result_Colaborador)) {
                    if ($row_Colaborador['id'] == 7) {
                        echo "<p class=\"tarea-body\">$urgente_icono<strong>" . $row_proyectos['titulo'] . "</strong><span><i class=\"fas fa-star mx-2 has-text-danger fa-lg\"></i>" . $row_Colaborador['nombre'] . " " . $row_Colaborador['apellido'] . "&nbsp;</span><span class=\"has-text-grey-light\">" . $array_destino[$row_proyectos['id_destino']] . "</span></p>";
                    } else {
                        echo "<p class=\"tarea-body\">$urgente_icono<strong>" . $row_proyectos['titulo'] . "</strong> <span><i class=\"fad fa-user mx-2 has-text-danger fa-lg\"></i>" . $row_Colaborador['nombre'] . " " . $row_Colaborador['apellido'] . "&nbsp;</span><span class=\"has-text-grey-light\"> " . $array_destino[$row_proyectos['id_destino']] . "</span></p>";
                    }
                }
            }


            echo "         </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"column\">
                        <div class=\"columns is-gapless\">";
            $query_planAccion = "SELECT* FROM t_proyectos_planaccion WHERE id_proyecto=" . $row_proyectos['id'] . "";
            $result_planAccion = mysqli_query($conn_2020, $query_planAccion);
            $row_planAccion = mysqli_num_rows($result_planAccion);

            if ($row_planAccion > 0) {
                echo "<div class=\"column overflow\" onclick=\"hide_show_clase('sectionPlanAcion$idProyecto'); modalPlanAccion($idProyecto);\"><p class=\"filatarea\"><i class=\"fas fa-check has-text-success fa-lg\"></i></p></div>";
            } else {
                echo "<div class=\"column overflow\" onclick=\"hide_show_clase('sectionPlanAcion$idProyecto'); modalPlanAccion($idProyecto);\"><p class=\"filatarea\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p></div>";
            }

            echo "<div class=\"column overflow\" onclick=\"modalResponsable('$idProyecto');\">";

            $query_t_tareas_asignaciones = "SELECT id_usuario FROM t_tareas_asignaciones WHERE id_tarea =" . $row_proyectos['id'] . "";
            $result_t_tareas_asignaciones = mysqli_query($conn_2020, $query_t_tareas_asignaciones);

            if (mysqli_num_rows($result_t_tareas_asignaciones) > 0) {
                $idUsuario = mysqli_fetch_array($result_t_tareas_asignaciones);

                $query_2 = "SELECT* FROM t_users WHERE id=" . $idUsuario['id_usuario'] . "";
                $result_2 = mysqli_query($conn_2020, $query_2);

                $idColaborador = mysqli_fetch_array($result_2);
                $query_3 = "SELECT* FROM t_colaboradores WHERE id=" . $idColaborador['id_colaborador'] . "";
                $result_3 = mysqli_query($conn_2020, $query_3);
                $row_3 = mysqli_fetch_array($result_3);

                echo '<p class="filatarea">' . $row_3['nombre'] . ' ' . $row_3['apellido'] . '</p>';
            } else {
                echo '<p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }

            echo '</div>
                            <div class="column overflow">';
            $fecha = date_create($row_proyectos['fecha_creacion']);
            echo '    <p class="filatarea">' . date_format($fecha, 'M-y') . '</i></p>
                            </div>';

            echo "<div class=\"column overflow\" onclick=\"modalSubirArchivo('t_proyectos_adjuntos'," . $row_proyectos['id'] . ");\">";

            $query_cotizacion = "SELECT* FROM t_proyectos_adjuntos WHERE id_proyecto=" . $row_proyectos['id'] . " and status=1";
            $result_cotizacion = mysqli_query($conn_2020, $query_cotizacion);

            if (mysqli_num_rows($result_cotizacion) > 0) {
                echo "<p class=\"filatarea\"><i class=\"fas fa-check has-text-success fa-lg\"></i></p>";
            } else {
                echo "<p class=\"filatarea\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p>";
            }

            echo '</div>
                            <div class="column overflow">';

            if ($row_proyectos['tipo'] != "") {
                echo '<p class="filatarea" onclick="modalTipo(' . $row_proyectos['id'] . ')">' . $row_proyectos['tipo'] . '</p>';
            } else {
                echo '<p class="filatarea" onclick="modalTipo(' . $row_proyectos['id'] . ')"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }

            echo '</div>
                            <div class="column overflow">';

            if ($row_proyectos['justificacion'] != "") {
                echo "<p class=\"filatarea\" onclick=\"modalJustificacion($idProyecto);\"><i class=\"fas fa-check has-text-success fa-lg\"></i></p>";
            } else {
                echo "<p class=\"filatarea\" onclick=\"modalJustificacion($idProyecto);\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p>";
            }
            echo '</div>';

            echo "<div class=\"column overflow\">";

            if ($row_proyectos['coste'] != 0) {
                echo '<p class="filatarea" onclick="modalCosto(' . $row_proyectos['id'] . ',' . $row_proyectos['coste'] . ')"> $' . $row_proyectos['coste'] . '</p>';
            } else {
                echo '<p class="filatarea" onclick="modalCosto(' . $row_proyectos['id'] . ',' . $row_proyectos['coste'] . ')"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }
            echo ' </div>
                            <div class="column overflow" onclick="modalStatus(' . $row_proyectos['id'] . '); consultaFaseProyectoDEP(' . $row_proyectos['id'] . ');">
                            <p class="filatarea modal-button" onclick="modalStatus(' . $row_proyectos['id'] . ')" data-target="modal-id">';

            //Horario para ocultar status 'T'
            $fecha_inicio = date('Y-m-d 16:01:00');
            $fecha_fin = date("Y-m-d 16:01:00 ", strtotime($fecha_inicio . "- 1 days"));

            $query_status = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and status !='' and status != 'status_urgente' and status != 'status_solucionado'";
            $result_status = mysqli_query($conn_2020, $query_status);
            if (mysqli_num_rows($result_status) <= 0) {
                echo " <i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i>";
            } else {

                $query_status_trabajare = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and status='status_trabajare' and fecha_inicio >= '$fecha_fin' and fecha_inicio <= '$fecha_inicio'";
                $result_status_trabajare = mysqli_query($conn_2020, $query_status_trabajare);
                if (mysqli_num_rows($result_status_trabajare) > 0) {
                    $T = "<strong class=\"mr-1 fa-lg has-text-info\">T</strong>";
                } else {
                    $T = "";
                }

                $query_status_material = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and status='status_material'";
                $result_status_material = mysqli_query($conn_2020, $query_status_material);
                if (mysqli_num_rows($result_status_material) > 0) {
                    $M = "<strong class=\"mr-1 fa-lg\">M</strong>";
                } else {
                    $M = "";
                }

                $query_status_departamento = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto AND  status LIKE '%status_departamento%'";
                $result_status_departamento = mysqli_query($conn_2020, $query_status_departamento);
                if (mysqli_num_rows($result_status_departamento) > 0) {
                    $D = "<strong class=\"mr-1 fa-lg has-text-primary\">D</strong>";
                } else {
                    $D = "";
                }

                $query_status_energeticos = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto AND status LIKE '%status_energetico%' ";
                $result_status_energeticos = mysqli_query($conn_2020, $query_status_energeticos);
                if (mysqli_num_rows($result_status_energeticos) > 0) {
                    $E = "<strong class=\"mr- fa-lg has-text-warning\">E</strong>";
                } else {
                    $E = "";
                }

                if ($T != "" || $M != "" || $D != "" || $E != "") {
                    echo $T;
                    echo $M;
                    echo $D;
                    echo $E;
                } else {
                    echo " <i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i>";
                }
            }
            echo '</p>
                            </div>
                        </div>
                    </div>
                </div>
            ';

            echo "
            <section id=\"sectionPlanAcion$idProyecto\" class=\"box modal mt-0 mb-4 cursor mx-4\">
                <div class=\"columns\">

                    <div class=\"column is-one-third\">
                        <h4 class=\"subtitle is-4 has-text-centered\">Plan de acción</h4>
                        <div class=\"field has-addons\">
                            <div class=\"control is-expanded\">
                                <input id=\"inputPlanAccion$idProyecto\" class=\"input is-rounded\" type=\"text\" placeholder=\"Agregar Plan Acción\" maxlength=\"60\">
                            </div>
                            <div class=\"control\">
                                <a class=\"button is-primary is-rounded\" onclick=\"agregarPlanAccion($idProyecto);\">
                                    <i class=\"fad fa-plus-circle\"></i>
                                </a>
                            </div>
                        </div>
                        <div class=\"timeline is-left\">
                            <div id=\"planAccion$idProyecto\"></div>
            ";
            if ($statusProyecto == "F") {
                echo "
                <div class=\"columns has-text-center ml-5 my-2\">
                    <button class=\"column button is-warning is-6 py-1\" 
                    onclick=\"restaurarProyecto($idProyecto);\">
                        <span class=\"icon is-small\">
        					<i class=\"fas fa-undo-alt\"></i>
						</span>
                        <span>Restaurar Proyecto</span>
                    </button>
                </div>
                ";
            }

            echo "
                        </div>
                    </div>

                    <div class=\" column is-one-third\">
                        <h4 class=\"subtitle is-4 has-text-centered\">Comentarios</h4>
                        <div class=\"field has-addons\">
                            <div class=\"control is-expanded\">
                                <input id=\"inputComentarioPlanAccion$idProyecto\" class=\"input is-rounded\" type=\"text\" placeholder=\"Agregar Comentarios\" maxlength=\"150\">
                            </div>
                            <div class=\"control\">
                                <a class=\"button is-primary is-rounded\" onclick=\"agregarComentarioPlanAccion($idProyecto);\">
                                    <i class=\"fad fa-plus-circle\"></i>
                                </a>
                            </div>
                        </div>

                        <div id=\"comentarioPlanAccion$idProyecto\"> </div>
                    </div>

                    <div class=\"column is-one-third has-text-centered\">
                        <h4 class=\"subtitle is-4\">Adjuntos</h4>
                        <input id=\"inputAdjuntoPlanAccion$idProyecto\" class=\"button is-primary\" type=\"button\" onclick=\"show_hide_modal('modalSubirArchivo', 'show');\" value=\"Adjuntos\"><br>
                        <div id=\"adjuntosPlanAccion$idProyecto\">
                            Sin Adjuntos
                        </div>
                    </div>
                </div>
            </section>
            ";
        }
    }

    if ($action == "restaurarProyecto") {
        $idProyecto = $_POST['idProyecto'];
        $query = "UPDATE t_proyectos SET status = 'N' WHERE id = $idProyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    if ($action == "consultaFaseProyectoDEP") {
        $idProyecto = $_POST['idProyecto'];

        $query = "SELECT fase, id_seccion, id_subseccion FROM t_proyectos WHERE id = $idProyecto";
        $result = mysqli_query($conn_2020, $query);
        if ($row = mysqli_fetch_array($result)) {
            $idSeccion = $row['id_seccion'];
            $idSubseccion = $row['id_subseccion'];
            $fase = $row['fase'];

            if ($fase != "") {
                $fase = explode(",", $fase);

                if ($idSeccion == 23 and $idSubseccion == 200) {

                    if ($fase[0] == "0") {
                        $ZI = "";
                    } else {
                        $ZI = "checked";
                    }

                    if ($fase[1] == "0") {
                        $GP = "";
                    } else {
                        $GP = "checked";
                    }

                    if ($fase[2] == "0") {
                        $TRS = "";
                    } else {
                        $TRS = "checked";
                    }

                    echo "
                        <label class=\"checkbox px-2 has-text-weight-bold\">
                        <input type=\"checkbox\" $ZI onclick=\"agregarFaseProyectoDEP('ZI')\">
                        ZI
                        </label>

                        <label class=\"checkbox px-2 has-text-weight-bold\">
                        <input type=\"checkbox\" $GP onclick=\"agregarFaseProyectoDEP('GP')\">
                        GP
                        </label>

                        <label class=\"checkbox px-2 has-text-weight-bold\">
                        <input type=\"checkbox\" $TRS onclick=\"agregarFaseProyectoDEP('TRS')\">
                        TRS
                        </label>
                    ";
                }
            } else {
                echo "";
            }
        }
    }


    if ($action == "agregarFaseProyectoDEP") {
        $fase = $_POST['fase'];
        $idProyecto = $_POST['idProyecto'];
        $faseArray_aux = "";


        $query = "SELECT* FROM t_proyectos WHERE id = $idProyecto";
        $result = mysqli_query($conn_2020, $query);
        if ($row = mysqli_fetch_array($result)) {
            $faseArray = $row['fase'];
            $faseArray = explode(",", $faseArray);

            if ($fase == "ZI") {
                if ($faseArray[0] == "ZI") {
                    $faseArray[0] = "0";
                } else {
                    $faseArray[0] = "ZI";
                }
            }

            if ($fase == "GP") {
                if ($faseArray[1] == "GP") {
                    $faseArray[1] = "0";
                } else {
                    $faseArray[1] = "GP";
                }
            }

            if ($fase == "TRS") {
                if ($faseArray[2] == "TRS") {
                    $faseArray[2] = "0";
                } else {
                    $faseArray[2] = "TRS";
                }
            }
            $data = $faseArray[0] . "," . $faseArray[1] . "," . $faseArray[2];

            $query = "UPDATE t_proyectos SET fase = '$data' WHERE id = $idProyecto";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                $query_1 = "UPDATE reporte_status_proyecto SET fase = '$data' WHERE id_proyecto = $idProyecto";
                $result_1 = mysqli_query($conn_2020, $query_1);
                if ($result_1) {
                    echo "Fase Actualizada $result_1 . $result . $idProyecto. $data";
                } else {
                    echo "Error al Actualizar la Fase";
                }
            } else {
                echo "Error al Actualizar la Fase";
            }
        }
    }


    // Lista de Proyectos
    if ($action == "proyectosFinalizados") {

        $id_Destino = $_POST["id_Destino"];
        $id_Seccion = $_POST["id_Seccion"];

        if ($id_Destino != 10) {
            $query = "SELECT* FROM t_proyectos WHERE id_destino=$id_Destino AND id_seccion=$id_Seccion AND id_subseccion=200 AND status='F' AND activo=1";
        } else {
            $query = "SELECT* FROM t_proyectos WHERE id_seccion=$id_Seccion AND id_subseccion=200 AND status='F' AND activo=1";
        }


        $result = mysqli_query($conn_2020, $query);
        while ($row_proyectos = mysqli_fetch_array($result)) {



            echo '
                <div class="columns is-gapless my-1 cursor mx-4">
                    <div class="column is-one-third modal-button" data-target="modal-id">
                        <div class="columns">
                            <div class="column">
                                <div class="tarea is-small is-danger overflow">
                ';

            $query_t_users = "SELECT* FROM t_users WHERE id =" . $row_proyectos['creado_por'] . "";
            $result_t_users = mysqli_query($conn_2020, $query_t_users);
            if ($row_t_users = mysqli_fetch_array($result_t_users)) {

                $query_Colaborador = "SELECT* FROM t_colaboradores WHERE id =" . $row_t_users['id_colaborador'] . "";
                $result_Colaborador = mysqli_query($conn_2020, $query_Colaborador);
                if ($row_Colaborador = mysqli_fetch_array($result_Colaborador)) {
                    if ($row_Colaborador['id'] == 7) {
                        echo '<p class="tarea-body">' . $row_proyectos['status_urgente'] . '<strong>' . $row_proyectos['titulo'] . '</strong> <span><i class="fad fa-user mx-2 has-text-danger fa-lg"></i><i class="fas fa-star mx-2 has-text-danger fa-lg"></i>' . $row_Colaborador['nombre'] . ' ' . $row_Colaborador['apellido'] . '</span></p>';
                    } else {
                        echo '<p class="tarea-body">' . $row_proyectos['status_urgente'] . ' <strong>' . $row_proyectos['titulo'] . '</strong> <span><i class="fad fa-user mx-2 has-text-danger fa-lg"></i>' . $row_Colaborador['nombre'] . ' ' . $row_Colaborador['apellido'] . '</span></p>';
                    }
                }
            }


            echo '          </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-gapless">
                            <div class="column overflow">';

            $query_t_tareas_asignaciones = "SELECT id_usuario FROM t_tareas_asignaciones WHERE id_tarea =" . $row_proyectos['id'] . "";
            $result_t_tareas_asignaciones = mysqli_query($conn_2020, $query_t_tareas_asignaciones);

            if (mysqli_num_rows($result_t_tareas_asignaciones) > 0) {
                $idUsuario = mysqli_fetch_array($result_t_tareas_asignaciones);

                $query_2 = "SELECT* FROM t_users WHERE id=" . $idUsuario['id_usuario'] . "";
                $result_2 = mysqli_query($conn_2020, $query_2);

                $idColaborador = mysqli_fetch_array($result_2);
                $query_3 = "SELECT* FROM t_colaboradores WHERE id=" . $idColaborador['id_colaborador'] . "";
                $result_3 = mysqli_query($conn_2020, $query_3);
                $row_3 = mysqli_fetch_array($result_3);

                echo '<p class="filatarea">' . $row_3['nombre'] . ' ' . $row_3['apellido'] . '</p>';
            } else {
                echo '<p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }

            echo '</div>
                            <div class="column overflow">';
            $fecha = date_create($row_proyectos['fecha_creacion']);
            echo '    <p class="filatarea">' . date_format($fecha, 'M-y') . '</i></p>
                            </div>
                            <div class="column overflow">
                                <p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>
                            </div>
                            <div class="column overflow">';
            echo "<p class=\"filatarea\">comentario</p>";
            echo '</div>
                            <div class="column overflow">
                                <p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>
                            </div>
                            <div class="column overflow">';

            if ($row_proyectos['tipo'] != "") {
                echo '<p class="filatarea")">' . $row_proyectos['tipo'] . '</p>';
            } else {
                echo '<p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }

            echo '</div>
                            <div class="column overflow">';

            if ($row_proyectos['justificacion'] != "") {
                echo '<p class="filatarea"><i class="fas fa-check has-text-success fa-lg"></i></p>';
            } else {
                echo '<p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }
            echo '</div>
                            <div class="column overflow"> ';

            if ($row_proyectos['coste'] != 0) {
                echo '<p class="filatarea" > $' . $row_proyectos['coste'] . '</p>';
            } else {
                echo '<p class="filatarea"><i class="fad fa-minus has-text-danger fa-2x"></i></p>';
            }
            echo ' </div>
                            <div class="column overflow">
                            <p class="filatarea modal-button" data-target="modal-id">
                                  <span class="has-text-success"><i class="fas fa-check mr-2"></i></span>
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        echo "<br>";
    }


    // Crea los proyectos
    if ($action == "nuevoProyecto") {

        $id_DestinoProyecto = $_POST["id_DestinoProyecto"];
        $id_SeccionProyecto = $_POST["id_SeccionProyecto"];
        $idSubseccionProyecto = $_POST["idSubseccionProyecto"];
        $tituloProyecto = $_POST["tituloProyecto"];
        $fechaActual = date('Y-m-d H:i:s');
        $id_UsuarioProyecto = $_POST["id_UsuarioProyecto"];
        echo $id_DestinoProyecto . $id_SeccionProyecto . $tituloProyecto . $id_UsuarioProyecto . $fechaActual;

        $query = "INSERT INTO t_proyectos (id_destino, id_seccion, id_subseccion, titulo, fecha_creacion, creado_por, status, activo ) values ($id_DestinoProyecto, $id_SeccionProyecto, $idSubseccionProyecto, '$tituloProyecto', '$fechaActual', $id_UsuarioProyecto, 'N', 1)";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Proyecto Creado";
        }
    }


    if ($action == "eliminarProyecto") {
        $idProyecto = $_POST['idProyecto'];
        $query = "UPDATE t_proyectos SET activo=0 WHERE id=$idProyecto";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Proyecto Eliminado";
        } else {
            echo "Error de Proyecto";
        }
    }

    if ($action == "editarProyecto") {
        $idProyecto = $_POST['idProyecto'];
        $tituloProyecto = $_POST['tituloProyecto'];
        $query = "UPDATE t_proyectos SET titulo='$tituloProyecto' WHERE id=$idProyecto";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Proyecto Actualizado";
        } else {
            echo "Error de Proyecto";
        }
    }



    if ($action == "actualizarCostoProyecto") {
        $idProyecto = $_POST["idProyecto"];
        $costo = $_POST["costo"];

        $query_costo = "UPDATE t_proyectos SET coste=$costo WHERE id=$idProyecto";
        $result_costo = mysqli_query($conn_2020, $query_costo);

        if ($result_costo) {
            echo "Costo Actualizado";
        }
    }


    if ($action == "actualizarJustificacionProyecto") {

        $idProyecto = $_POST["idProyecto"];
        $justificacion = $_POST["justificacion"];

        $query_justificacion = "UPDATE t_proyectos SET justificacion = '$justificacion' WHERE id = $idProyecto";
        $result_justificacion = mysqli_query($conn_2020, $query_justificacion);

        if ($result_justificacion) {
            echo "Justificacion Actualizada";
        }
    }


    if ($action == "consultaJustificacionProyecto") {

        $idProyecto = $_POST["idProyecto"];

        $query_justificacion = "SELECT* FROM t_proyectos WHERE id = $idProyecto";
        $result_justificacion = mysqli_query($conn_2020, $query_justificacion);

        if ($row_justificacion = mysqli_fetch_array($result_justificacion)) {
            echo $row_justificacion['justificacion'];
        }
    }


    if ($action == "actualizarTipoProyecto") {

        $idProyecto = $_POST['idProyecto'];
        $tipo = $_POST['tipo'];

        $query_tipo = "UPDATE t_proyectos SET tipo='$tipo' WHERE id=$idProyecto";
        $result_tipo = mysqli_query($conn_2020, $query_tipo);

        if ($result_tipo)
            echo "Tipo Actualizado";
    }

    if ($action == "asignarResponsableProyecto") {

        $idProyecto = $_POST['idProyecto'];
        $idUsuario = $_POST['idUsuario'];

        $query = "SELECT* FROM t_tareas_asignaciones WHERE id_tarea=$idProyecto";
        $result = mysqli_query($conn_2020, $query);

        if (mysqli_num_rows($result) > 0) {
            $query_u = "UPDATE t_tareas_asignaciones SET id_usuario=$idUsuario WHERE id_tarea=$idProyecto";
            $result_u = mysqli_query($conn_2020, $query_u);
            echo "actualizado";
        } else {

            $query_t_tareas_asignadas = "INSERT INTO t_tareas_asignaciones (id_tarea, id_usuario) VALUES ($idProyecto, $idUsuario)";
            $result_t_tareas_asignadas = mysqli_query($conn_2020, $query_t_tareas_asignadas);
            echo "insert";
        }
    }



    if ($action == "agregarComentarioProyecto") {
        $idUsuario = $_POST['idUsuario'];
        $idProyecto = $_POST['idProyecto'];
        $comentario = $_POST['comentario'];

        $query = "INSERT INTO t_proyectos_comentarios(id_proyecto, comentario, usuario) VALUES($idProyecto, '$comentario', $idUsuario)";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "ok";
        } else {
            echo "Error";
        }
    }


    if ($action == "consultaComentariosProyecto") {

        $idProyecto = $_POST['idProyecto'];

        $query = "SELECT* FROM t_proyectos_comentarios WHERE id_proyecto=$idProyecto";
        $result = mysqli_query($conn_2020, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo '
                <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                <p class="has-text-justified">' . $row['comentario'] . '</p>
                </div>
                </div>';
        }
    }



    if ($action == "agregarStatusProyecto") {
        $idProyecto = $_POST['idProyecto'];
        $statusProyecto = $_POST['statusProyecto'];

        switch ($statusProyecto) {


            case "urgente":
                $status_aux = "status_urgente";
                $status = '<i class="fad fa-siren-on fa-lg animated infinite flash mr-3"></i>';
                break;

            case "trabajare":
                $status_aux = "status_trabajare";
                $status = '<span class="tag is-info fa-lg mr-2"">T</span>';
                break;

            case "material":
                $status_aux = "status_material";
                $status = '<span class="tag is-dark fa-lg"">M</span>';
                break;
        }


        $query_status = "SELECT* FROM t_proyectos WHERE id=$idProyecto";
        $result_status = mysqli_query($conn_2020, $query_status);

        $row_status = mysqli_fetch_array($result_status);

        echo $row_status[$status_aux];

        if ($row_status[$status_aux] == "$status") {
            $query = "UPDATE t_proyectos SET status_default='', status_$statusProyecto='' WHERE id=$idProyecto";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Ok!";
            }
        } else {
            $query = "UPDATE t_proyectos SET status_default='', status_$statusProyecto='$status' WHERE id=$idProyecto";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Ok!";
            }
        }
    }


    if ($action == "finalizarProyecto") {
        $idProyecto = $_POST['idProyecto'];
        $usuario = $_SESSION['usuario'];
        $fecha_finalizado = date('Y-m-d H:m:s');

        $query = "UPDATE t_proyectos SET status='F', finalizado_por = $usuario, fecha_finalizado='$fecha_finalizado' WHERE id=$idProyecto";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Ok!";
        }
    }


    // Fin codigo Proyectos.



    if ($action == "staff") {

        $id_Destino = $_POST['idDestino'];
        $cantidadStaff = $_POST['cantidadStaff'];
        $idFase = $_POST['idFase'];

        $query = "SELECT* FROM covid_19_staff WHERE id_destino=$id_Destino and id_fase = $idFase";
        $result = mysqli_query($conn_2020, $query);
        if ($row = mysqli_fetch_array($result)) {
            if ($row['staff'] != "") {

                $query = "UPDATE covid_19_staff set staff=$cantidadStaff WHERE id_destino=$id_Destino and id_fase=$idFase";
                $result = mysqli_query($conn_2020, $query);
                if ($result) {
                    echo "Actualizar";
                } else {
                    echo "Error";
                }
            } else {
                echo "Error";
            }
        } else {
            $query_staff = "INSERT INTO covid_19_staff (id_destino, id_fase, staff) VALUES($id_Destino, $idFase, $cantidadStaff)";
            $result_staff = mysqli_query($conn_2020, $query_staff);
            if ($result_staff) {
                echo $id_Destino . " " . $cantidadStaff . " " . $idFase;
            } else {
                echo "error";
            }
        }
    }




    if ($action == "agregarComentario") {

        $idFase = $_POST['idFase'];
        $idDestino = $_POST['idDestino'];
        $idUsuario = $_POST['idUsuario'];
        $idSubseccion = $_POST['idSubseccion'];
        $comentario = $_POST['comentario'];


        $query = "INSERT INTO covid_19_comentarios (id_fase, id_covid_19_subsecciones, id_destino , id_usuario, comentario) VALUES($idFase, $idSubseccion, $idDestino, $idUsuario, '$comentario')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Comentario Creado";
        } else {
            echo "Error Comentario";
        }
    }


    if ($action == "consulaComentario") {

        $idFase = $_POST['idFase'];
        $idDestino = $_POST['idDestino'];
        $idSubseccion = $_POST['idSubseccion'];

        $query_c = "SELECT* FROM covid_19_comentarios WHERE id_covid_19_subsecciones=$idSubseccion  and id_fase=$idFase  and id_destino=$idDestino";
        $result_c = mysqli_query($conn_2020, $query_c);

        if ($result_c) {

            while ($row_c = mysqli_fetch_array($result_c)) {
                echo '
                <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                <p class="has-text-justified">' . $row_c['comentario'] . '</p>
                </div>
                </div>';
            }
        } else {
            echo "Sin Datos" . $idFase . " " . $idDestino . " " . $idSubseccion;
        }
    }



    // Codigo para Check List



    if ($action == "agregarFecha") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion1 = $_POST['idSeccion1'];
        $idSubseccion1 = $_POST['idSubseccion1'];
        $fecha = $_POST['fecha'];

        $query = "SELECT* FROM covid_check_list_form WHERE id_destino =$idDestino and id_seccion=$idSeccion1 and id_subseccion =$idSubseccion1";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE covid_check_list_form set fecha=\"$fecha\" WHERE id_usuario=$idUsuario and id_destino=$idDestino and id_seccion=$idSeccion1 and id_subseccion=$idSubseccion1";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Fecha Actualizada 1";
            } else {
                echo "fecha error 2";
            }
        } else {
            $query = "INSERT INTO covid_check_list_form (id_usuario, id_destino, id_seccion, id_subseccion, fecha) VALUES($idUsuario, $idDestino, $idSeccion1, $idSubseccion1, \"$fecha\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Fecha Agregada 3 ";
            } else {
                echo "Error al Agregar 4";
            }
        }
    }

    if ($action == "agregarStatus") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion1 = $_POST['idSeccion1'];
        $idSubseccion1 = $_POST['idSubseccion1'];
        $status = $_POST['status'];

        $query = "SELECT* FROM covid_check_list_form WHERE id_destino =$idDestino and id_seccion=$idSeccion1 and id_subseccion =$idSubseccion1";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE covid_check_list_form set opcion=\"$status\" WHERE id_usuario=$idUsuario and id_destino=$idDestino and id_seccion=$idSeccion1 and id_subseccion=$idSubseccion1";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Actualizada 1";
            } else {
                echo "Status error 2";
            }
        } else {
            $query = "INSERT INTO covid_check_list_form (id_usuario, id_destino, id_seccion, id_subseccion, opcion) VALUES($idUsuario, $idDestino, $idSeccion1, $idSubseccion1, \"$status\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Agregada 3 ";
            } else {
                echo "Error al Status 4";
            }
        }
    }


    if ($action == "consultaComentarios1") {
        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion1 = $_POST['idSeccion1'];
        $idSubseccion1 = $_POST['idSubseccion1'];

        $query = "SELECT* FROM covid_check_list_comentario WHERE id_destino=$idDestino and id_seccion=$idSeccion1 and id_subseccion=$idSubseccion1";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '
            <div class="timeline-item">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
            <p class="has-text-justified">' . $row['comentario'] . '</p>
            </div>
            </div>';
        }
    }

    if ($action == "agregarComentario1") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion1 = $_POST['idSeccion1'];
        $idSubseccion1 = $_POST['idSubseccion1'];
        $comentario = $_POST['comentario'];

        $query = "INSERT INTO covid_check_list_comentario (id_usuario, id_destino, id_seccion, id_subseccion, comentario) VALUES($idUsuario, $idDestino, $idSeccion1, $idSubseccion1, '$comentario')";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $query = "SELECT* FROM covid_check_list_comentario WHERE id_destino=$idDestino and id_seccion=$idSeccion1 and id_subseccion=$idSubseccion1";
            $result = mysqli_query($conn_2020, $query);

            while ($row = mysqli_fetch_array($result)) {
                echo '
                <div class="timeline-item">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                <p class="has-text-justified">' . $row['comentario'] . '</p>
                </div>
                </div>';
            }
        } else {
            echo "Error Comentario" . $idUsuario . $idDestino . $idSeccion1 . $idSubseccion1 . "$comentario";
        }
    }



    // Check Habitaciones.
    if ($action == "consultarZona") {

        $idDestinoT = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $idCheck = $_POST['idCheck'];
        $idList = $_POST['idList'];
        $idList2 = $_POST['idList2'];
        $idList3 = $_POST['idList3'];
        $query_secciones = "SELECT* FROM covid_check_list_secciones WHERE id=" . $idList . " or id=$idList2 or id=$idList3";
        $result_secciones = mysqli_query($conn_2020, $query_secciones);
        while ($row_secciones = mysqli_fetch_array($result_secciones)) {

            echo "	<div class='columns is-gapless mx-4 rounded mb-3 has-text-white'>
						<div class='column is-half'>
							<div class='columns'>
								<div class='column'>
									<p class='barratitulos has-background-link' data-tooltip='Responsable'>" . $row_secciones['seccion'] . "</p>
								</div>
							</div>
						</div>

						<div class='column '>
							<div class='columns is-gapless'>
								<div class='column'>
									<p class='barratitulos' data-tooltip='Responsable'>SI-NO-N/A</p>
								</div>
								<div class='column'>
									<p class='barratitulos' data-tooltip='Fecha estimada de solucion'>Fecha</p>
								</div>
								<div class='column'>
									<p class='barratitulos' data-tooltip='Documentos e imagenes adjuntoas'>Responsable</p>
								</div>
								<div class='column'>
									<p class='barratitulos' data-tooltip='Feedback/Comentarios'>Observaciones</p>
								</div>
							</div>
						</div>
					</div>
				";


            $query_subsecciones = "SELECT* FROM covid_check_list WHERE id_seccion =" . $row_secciones['id'] . "";
            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);

            while ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                $query_comentario = "SELECT* FROM covid_check_list_comentario WHERE id_destino=$idDestinoT and id_seccion=" . $row_secciones['id'] . " and id_subseccion=" . $row_subsecciones['id'] . "";
                $query_form = "SELECT* FROM check_habitaciones_form WHERE id_destino=$idDestinoT and id_zona=$idZona and id_check =" . $row_subsecciones['id'] . "";
                $result_comentario = mysqli_query($conn_2020,  $query_form);
                $result_form_responsable = mysqli_query($conn_2020, $query_form);
                $result_form_fecha = mysqli_query($conn_2020, $query_form);
                $result_form_status = mysqli_query($conn_2020, $query_form);


                echo "
					<div class='columns is-gapless my-1 cursor mx-4'>
						<div class='column is-half'>
							<div class='columns'>
								<div class='column'>
									<div class='tarea is-small is-link overflow'>
										<h4 class='tarea-body'><strong>" . $row_subsecciones['subseccion'] . "</strong></h4>
									</div>
								</div>
							</div>
						</div>
						<div class='column'>
							<div class='columns is-gapless'>
								<div class='column overflow'>

									<div class='control filatarea'>";
                if ($row_form_status = mysqli_fetch_array($result_form_status)) {

                    if ($row_form_status['opcion'] == "SI") :
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"SI\");' checked>SI</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"NO\");'>NO</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"N/A\");'>N/A</label>";

                    elseif ($row_form_status['opcion'] == "NO") : // Tenga en cuenta la combinación de las palabras.

                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"SI\");'>SI</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"NO\");' checked>NO</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"N/A\");'>N/A</label>";
                    else :
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"SI\");'>SI</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"NO\");'>NO</label>";
                        echo "<label class='radio'><input type='radio' name='" . $row_subsecciones['id'] . "' onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"N/A\");' checked>N/A</label>";
                    endif;
                } else {
                    echo "<label class='radio'><input type='radio'  onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"SI\");'>SI</label>";
                    echo "<label class='radio'><input type='radio'  onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"NO\");'>NO</label>";
                    echo "<label class='radio'><input type='radio'  onclick='agregarStatusH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ",\"N/A\");'>N/A</label>";
                }

                echo "</div>
								</div>
								<div class='column overflow' onClick='modalFechaH(" . $row_subsecciones['id'] . ");'>";
                if ($row_form_fecha = mysqli_fetch_array($result_form_fecha)) {
                    echo "<p class='filatarea'>" . $row_form_fecha['fecha'] . "</p>";
                } else {
                    echo "<p class='filatarea'><i class='fad fa-minus has-text-danger fa-2x'></i></p>";
                }


                echo "</div>
								<div class='column overflow' onClick='modalResponsableH(" . $row_subsecciones['id'] . ");'>";

                if ($row_form_responsable = mysqli_fetch_array($result_form_responsable)) {
                    echo "<p class='filatarea'>" . $row_form_responsable['responsable'] . "</p>";
                } else {
                    echo "<p class='filatarea'><i class='fad fa-minus has-text-danger fa-2x'></i></p>";
                }
                echo "
								</div>
								<div class='column overflow' onClick='modalComentarioH(" . $idDestinoT . "," . $idZona . "," . $row_subsecciones['id'] . ");'>";
                if ($row_comentario = mysqli_fetch_array($result_comentario)) {
                    echo "<p class='filatarea'>" . $row_comentario['comentario'] . "</p>";
                } else {
                    echo "<p class='filatarea'><i class='fad fa-minus has-text-danger fa-2x'></i></p>";
                }
                echo "</div>
							</div>
						</div>
					</div>

					";
            }
        }
    }

    if ($action == "agregarSubseccion") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $seccion = $_POST['seccion'];
        $subseccion = $_POST['subseccion'];
        $idList = $_POST['idList'];

        $query = "INSERT INTO check_habitaciones (id_usuario, id_destino, seccion, subseccion, id_list)  VALUES ($idUsuario, $idDestino, '$seccion', '$subseccion', $idList)";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Agregado";
        } else {
            echo "Error";
        }
    }


    if ($action == "agregarResponsableH") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $responsable = $_POST['responsable'];
        $idCheck = $_POST['idCheck'];

        $query = "SELECT* FROM check_habitaciones_form WHERE id_destino =$idDestino and id_zona=$idZona and id_check=$idCheck";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE check_habitaciones_form set responsable=\"$responsable\" WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Responsable Actualizado 1";
            } else {
                echo "Responsable error 2";
            }
        } else {
            $query = "INSERT INTO check_habitaciones_form (id_usuario, id_destino, id_zona, id_check, responsable) VALUES($idUsuario, $idDestino, $idZona, $idCheck, \"$responsable\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Agregado 3 ";
            } else {
                echo "Error al Agregar 4 -" . $idDestino . $idUsuario . $idSubseccion . $responsable;
            }
        }
    }

    if ($action == "agregarFechaH") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $fecha = $_POST['fecha'];
        $idCheck = $_POST['idCheck'];

        $query = "SELECT* FROM check_habitaciones_form WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE check_habitaciones_form set fecha=\"$fecha\" WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Actualizada:";
            } else {
                echo "fecha error 2";
            }
        } else {
            $query = "INSERT INTO check_habitaciones_form (id_usuario, id_destino, id_zona, id_check, fecha) VALUES($idUsuario, $idDestino, $idZona, $idCheck, \"$fecha\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Fecha Agregada 3 ";
            } else {
                echo "Error al Agregar 4 " . $row_cnt;
            }
        }
    }


    if ($action == "agregarStatusH") {

        $idDestino = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $idCheck = $_POST['idCheck'];
        $status = $_POST['status'];

        $query = "SELECT* FROM check_habitaciones_form WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE check_habitaciones_form set opcion=\"$status\" WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Actualizada: ";
            } else {
                echo "Status error 2";
            }
        } else {
            $query = "INSERT INTO check_habitaciones_form (id_destino, id_zona, id_check, opcion) VALUES($idDestino, $idZona, $idCheck, \"$status\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Agregada 3 ";
            } else {
                echo "Error al Status 4";
            }
        }
    }

    if ($action == "consultaComentariosH") {
        $idDestino = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $idCheck = $_POST['idCheck'];

        $query = "SELECT* FROM check_habitaciones_comentario WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '
            <div class="timeline-item">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
            <p class="has-text-justified">' . $row['comentario'] . '</p>
            </div>
            </div>';
        }
    }


    if ($action == "agregarComentarioH") {

        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idZona = $_POST['idZona'];
        $idCheck = $_POST['idCheck'];
        $comentario = $_POST['comentario'];
        $comentario_S = "<i class='fas fa-check has-text-success fa-lg'></i>";

        $query = "SELECT* FROM check_habitaciones_form WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
        $result = mysqli_query($conn_2020, $query);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0) {
            $query = "UPDATE check_habitaciones_form set comentario=\"$comentario_S\" WHERE id_destino=$idDestino and id_zona=$idZona and id_check=$idCheck";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Actualizada:";
                $query = "INSERT INTO check_habitaciones_comentario (id_usuario, id_destino, id_zona , id_check, comentario) VALUES($idUsuario, $idDestino, $idZona, $idCheck, '$comentario')";
                $result = mysqli_query($conn_2020, $query);
                if ($result) {
                    echo "Comentario Creado";
                } else {
                    echo "Error Comentario";
                }
            } else {
                echo "fecha error 2";
            }
        } else {
            $query = "INSERT INTO check_habitaciones_form (id_usuario, id_destino, id_zona, id_check, comentario) VALUES($idUsuario, $idDestino, $idZona, $idCheck, \"$comentario_S\")";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Fecha Agregada 3 ";
                $query = "INSERT INTO check_habitaciones_comentario (id_usuario, id_destino, id_zona , id_check, comentario) VALUES($idUsuario, $idDestino, $idZona, $idCheck, '$comentario')";
                $result = mysqli_query($conn_2020, $query);
                if ($result) {
                    echo "Comentario Creado";
                } else {
                    echo "Error Comentario";
                }
            } else {
                echo "Error al Agregar 4 " . $row_cnt;
            }
        }
    }



    // Agregar codigo eliminar Zona

    if ($action == "eliminarZona") {
        $idZona = $_POST['idZona'];

        $query = "UPDATE check_habitaciones SET activo=0 WHERE id=$idZona";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "ok";
        } else {
            echo "Error";
        }
    }


    // Crud Modulo Paradas de Equipos: Secciones -> Subsecciones -> Equipos -> Comentarios.

    if ($action == "consultaEquipos") {

        $idDestino = $_POST['idDestino'];
        $query_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino=" . $idDestino . "";
        $result_seccion = mysqli_query($conn_2020, $query_seccion);

        while ($row_seccion = mysqli_fetch_array($result_seccion)) {

            $query_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_seccion['id'] . "";
            $result_subseccion = mysqli_query($conn_2020, $query_subseccion);

            $query_s = "SELECT* FROM c_secciones WHERE id =" . $row_seccion['id_seccion'] . " and status='A'";
            $row_s = mysqli_query($conn_2020, $query_s);

            if ($row_s = mysqli_fetch_array($row_s)) {
                echo "<div class=\"column is-one-third has-text-centered\">";
                echo  '<img class="img" src="svg/secciones/' . strtolower($row_s['seccion']) . '.svg" width="55"<br>';
            }

            $query_subsecciones = "SELECT* FROM c_rel_seccion_subseccion  WHERE id_rel_seccion=" . $row_s['id'] . "";
            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);

            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                $query_subsecciones_nombre = "SELECT* FROM c_subsecciones WHERE id_seccion=" . $row_subsecciones['id_rel_seccion'] . " ORDER BY grupo DESC";
                $result_subsecciones_nombre = mysqli_query($conn_2020, $query_subsecciones_nombre);

                while ($row_subsecciones_nombre = mysqli_fetch_array($result_subsecciones_nombre)) {
                    echo '<a class="btn-subsecciones" href="#">
                                <div class="columns is-gapless my-1 is-mobile">
                                    <div class="column is-9">
                                        <p class="t-normal has-text-left px-4">' . $row_subsecciones_nombre['grupo'] . '</p>
                                    </div>';

                    echo "                <div class=\"column is-1\" onclick=\"toggleEquipos(" . $row_subsecciones_nombre['id'] . ");\">";
                    echo '            <p id="toggle" class="t-normal has-text-left px-4"><span class="icon has-text-success"><i class="fas fa-2x fa-angle-down"></i></span</i></p>
                                    </div >
                                </div>
                            </a>';

                    echo "
                            <div class=\"field is-grouped\">
					            <p class=\"control is-one-quarter\">
						            <input id=\"" . $row_subsecciones_nombre['id'] . "\" class=\"input\" type=\"text\" placeholder=\"Nombre del Equipo\">
						            <p class=\"control has-text-centered\" onclick=\"agregarEquipo(" . $idDestino . "," . $row_s['id'] . "," . $row_subsecciones_nombre['id'] . "); toggleEquipos(" . $row_subsecciones_nombre['id'] . ");\"><a class=\"button is-success\"><i class=\"fas fa-plus\"></i></a></p>
					            </p>
				            </div>";

                    $query_equipos = "SELECT* FROM equipos_covid WHERE id_destino=$idDestino and id_seccion=" . $row_subsecciones['id_rel_seccion'] . " and id_subseccion=" . $row_subsecciones_nombre['id'] . "";
                    $result_equipos = mysqli_query($conn_2020, $query_equipos);
                    echo "<div class='listaEquipos " . $row_subsecciones_nombre['id'] . " listaEquiposHide'>";

                    while ($row_equipos = mysqli_fetch_array($result_equipos)) {

                        echo  "<p class=\"column is-6 t-equipo " . $row_subsecciones_nombre['id'] . "\" onclick=\"comentarioEquipo(" . $idDestino . "," . $row_subsecciones["id_rel_seccion"] . "," . $row_subsecciones_nombre["id"] . "," . $row_equipos["id"] . ",'" . $row_equipos['equipo'] . "');\"> " . $row_equipos['equipo'] . " <span><i class='fas " . $row_equipos['comentario_status'] . "'></i></span></p>";
                    }
                    echo "</div>";
                    echo "<br>";
                }
                echo "</div>";
            }
        }
    }



    if ($action == "agregarEquipo") {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $nombreEquipo = $_POST['nombreEquipo'];

        $query = "INSERT INTO equipos_covid (id_destino, id_seccion, id_subseccion, equipo) VALUES($idDestino, $idSeccion, $idSubseccion, '$nombreEquipo')";
        $result = mysqli_query($conn_2020, $query);


        if ($result) {
            echo $nombreEquipo;
        } else {
            echo "Error";
        }
    }



    if ($action == "comentarioEquipoCovid") {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idEquipo = $_POST['idEquipo'];


        $query = "SELECT* FROM comentario_equipo_covid WHERE id_destino=$idDestino and id_seccion=$idSeccion and id_subseccion=$idSubseccion and id_equipo=$idEquipo";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '
				<div class="timeline-item">
				<div class="timeline-marker"></div>
				<div class="timeline-content">
				<p class="has-text-justified">' . $row['comentario'] . '</p>
				</div>
				</div>';
        }
    }

    if ($action == "agregarComentarioEquipo1") {
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idEquipo = $_POST['idEquipo'];
        $comentario = $_POST['comentario'];

        $query = "INSERT INTO comentario_equipo_covid (id_destino, id_seccion, id_subseccion, id_equipo, comentario) VALUES ($idDestino, $idSeccion, $idSubseccion, $idEquipo, '$comentario')";
        $result = mysqli_query($conn_2020, $query);


        if ($result) {
            $query_comentario_status = "UPDATE equipos_covid SET comentario_status='fas fa-comment' WHERE id=$idEquipo";
            $result_comentario_status = mysqli_query($conn_2020, $query_comentario_status);
            if ($result_comentario_status) {
                echo "status comentario actualizado!";
            } else {
                echo "status comentario NO actualizado!";
            }
            echo "Comentario Agregado!";
        } else {
            echo "Comentario Error";
        }
    }


    // Crud para Status MC.
    if ($action == "agregarStatusMC") {
        $idMC = $_POST['idMC'];
        $idUsuarioMC = $_POST['idUsuarioMC'];
        $statusMC = $_POST['statusMC'];
        $fecha_captura = date('Y-m-d G:m:s');

        if ($statusMC == "material") {
            $codigoSeguimiento = $_POST['codigoSeguimiento'];
            $statusMaterialSeguimiento = ", cod2bend = '$codigoSeguimiento'";
        } else {
            $statusMaterialSeguimiento = "";
        }

        switch ($statusMC) {

            case "urgente":
                $status_aux = "status_urgente";
                $status = '<i class="fad fa-siren-on fa-lg animated infinite flash mr-3"></i>';
                break;

            case "trabajare":
                $status_aux = "status_trabajare";
                // Actualizar en DB doble comilla
                $status = '<span class="tag is-info fa-lg mr-2">T</span>';
                break;

            case "material":
                $status_aux = "status_material";
                // Actualizar en DB doble comilla
                $status = '<span class="tag is-dark fa-lg">M</span>';
                break;
        }


        $query_status = "SELECT* FROM t_mc WHERE id=$idMC";
        $result_status = mysqli_query($conn_2020, $query_status);
        $row_status = mysqli_fetch_array($result_status);

        if ($row_status[$status_aux] == "$status") {
            $query = "UPDATE t_mc SET status_$statusMC='' WHERE id=$idMC";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Ok!";
            }
        } else {
            $query = "UPDATE t_mc SET status_$statusMC='$status' $statusMaterialSeguimiento WHERE id=$idMC";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                if ($result_status) {
                    $query = "INSERT INTO reporte_status_mc(id_usuario, id_mc, status, fecha) VALUES($idUsuarioMC, $idMC, 'status_$statusMC', '$fecha_captura')";
                    $result = mysqli_query($conn_2020, $query);
                    if ($result) {
                        echo "Tigger!";
                    } else {
                        echo "Error Tigger";
                    }
                }
            }
        }
    }


    if ($action == "finalizarMC") {

        $idMC = $_POST['idMC'];
        $fecha_finalizado = date('Y-m-d H:m:s');

        $query = "UPDATE t_mc set status='F', fecha_realizado='$fecha_finalizado' WHERE id=$idMC";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Mantenimiento Correctivo Finalizado";
        } {
            echo "Error al Finalizar Mantinimiento Correctivo";
        }
    }

    if ($action == "restaurarMC") {

        $idMC = $_POST['idMC'];

        $query = "UPDATE t_mc set status='N' WHERE id=$idMC";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Mantenimiento Correctivo Finalizado";
        } {
            echo "Error al Finalizar Mantinimiento Correctivo";
        }
    }

    // Crud para Tareas Gemerales MC.
    if ($action == "eliminarMC") {
        $idMC = $_POST['idMC'];

        $query = "UPDATE t_mc SET activo=0 WHERE id=$idMC";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Proceso Completado";
        } else {
            echo "Proceso Fallido";
        }
    }


    if ($action == "editarMC") {
        $idMC = $_POST['idMC'];
        $tituloMC = $_POST['tituloMC'];

        $query = "UPDATE t_mc SET actividad='$tituloMC' WHERE id=$idMC";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Tarea General, Actualizada";
        } else {
            echo "Error al Actualizar";
        }
    }


    if ($action == "subirArchivoGeneral") {
        $tabla = $_POST['tabla'];
        $idGeneral = $_POST['idGeneral'];
        $nombreArchivo = $_POST['fileName'];
        $textoArchivo = preg_replace('([^A-Za-z0-9 .])', '', $nombreArchivo);
        $fileName = $idGeneral . "_" . $textoArchivo;
        $usuario = $_SESSION['usuario'];
        $fecha = date("Y-m-d H:i:s");

        if ($tabla == "t_proyectos_planaccion_adjuntos") {
            $query = "INSERT INTO $tabla(id_actividad, url_adjunto, subido_por, fecha_creado) VALUES($idGeneral, '$fileName', $usuario, '$fecha')";
        } else {
            $query = "INSERT INTO $tabla(id_proyecto, url_adjunto, subido_por, fecha) VALUES($idGeneral, '$fileName', $usuario, '$fecha')";
        }

        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Archivo Cargado: " . " <strong> $fileName</strong>";
        } else {
            echo "Proceso Cancelado";
        }
    }


    if ($action == "consultaArchivo") {
        $tabla = $_POST['tabla'];
        $idGeneral = $_POST['id'];

        if ($tabla == "t_proyectos_planaccion_adjuntos") {
            $query = "SELECT* FROM $tabla WHERE id_actividad=$idGeneral and status=1";
        } else {
            $query = "SELECT* FROM $tabla WHERE id_proyecto=$idGeneral and status=1";
        }

        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {

            if ($tabla == "t_proyectos_planaccion_adjuntos") {
                $idAdjunto = $row['id_actividad'];
            } else {
                $idAdjunto = $row['id_proyecto'];
            }

            $foo = $row['url_adjunto'];
            $adjunto = $row['url_adjunto'];
            $file_1 = "../planner/proyectos/$adjunto";
            $tipoAux = substr(strrchr($foo, "."), 1);

            if ($tipoAux == "jpg" || $tipoAux == "jpeg" || $tipoAux == "png") {

                if (file_exists("$file_1")) {
                    echo "
                        <div class=\"has-text-justified\">
                            <a class=\"delete is-medium\" onclick=\"eliminarArchivo(" . $row['id'] . ", '$tabla', $idAdjunto);\"></a>
                            <a href=\"planner/proyectos/$adjunto\" target=\"_blank\"><img src=\"planner/proyectos/$adjunto\" alt=\"\" width=\"120\" height=\"120\">
                            <span class=\"is-size-7 has-text-primary\">$adjunto</span></a>
                        </div>
                    ";
                } else {
                    echo "
                        <div class=\"has-text-justified\">
                            <a class=\"delete is-medium\" onclick=\"eliminarArchivo(" . $row['id'] . ", '$tabla', $idAdjunto);\"></a>
                            <a href=\"../planner/proyectos/$adjunto\" target=\"_blank\"><img src=\"../planner/proyectos/$adjunto\" alt=\"\" width=\"120\" height=\"120\">
                            <span class=\"is-size-7 has-text-primary\">$adjunto</span></a>
                        </div>
                    ";
                }
            } else {
                if (file_exists("$file_1")) {
                    echo "
                        <div class=\"has-text-justified\">
                            <a class=\"delete is-medium\" onclick=\"eliminarArchivo(" . $row['id'] . ", '$tabla', $idAdjunto);\"></a>
                            <span><a href=\"planner/proyectos/$adjunto\" target=\"_blank\"><img src=\"svg/formatos/$tipoAux.svg\" alt=\"\" width=\"110\" height=\"110\"><span class=\"is-size-7 has-text-primary\">$adjunto</span></a></span>

                        </div>
                    ";
                } else {
                    echo "
                        <div class=\"has-text-justified\">
                            <a class=\"delete is-medium\" onclick=\"eliminarArchivo(" . $row['id'] . ", '$tabla', $idAdjunto);\"></a>
                            <span><a href=\"../planner/proyectos/$adjunto\" target=\"_blank\"><img src=\"svg/formatos/$tipoAux.svg\" alt=\"\" width=\"110\" height=\"110\"><span class=\"is-size-7 has-text-primary\">$adjunto</span></a></span>

                        </div>
                    ";
                }
            }
            echo "<br>";
        }
    }


    if ($action == "eliminarArchivo") {
        $tabla = $_POST['tabla'];
        $idArchivo = $_POST['idArchivo'];
        $query = "UPDATE $tabla SET status=0 WHERE id=$idArchivo";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "ok";
        } else {
            echo "Error Eliminar Archivo";
        }
    }


    if ($action == "consultaPlanAccion") {
        $idProyecto = $_POST['idProyecto'];

        $query = "SELECT* FROM t_proyectos_planaccion WHERE id_proyecto=$idProyecto and actividad !='' and activo=1 ORDER BY fecha_creacion DESC";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $contadorPF = 0;
            $contadorPAF = 0;
            while ($row = mysqli_fetch_array($result)) {

                $id = $row['id'];
                $actividad = $row['actividad'];
                $fecha = $row['fecha_creacion'];
                $id_usuario = $row['creado_por'];

                // Query para Consultar el Usuario que Escribio el Comentario.
                $query_usuario_comentario = "SELECT t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador=t_colaboradores.id
                WHERE t_users.id=$id_usuario";
                $result_usuario_comentario = mysqli_query($conn_2020, $query_usuario_comentario);
                $row_usuario_comentario = mysqli_fetch_array($result_usuario_comentario);
                $usuario = $row_usuario_comentario['nombre'] . " " . $row_usuario_comentario['apellido'];

                $query_t_proyectos = "SELECT* FROM t_proyectos WHERE id=$idProyecto";
                $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);
                if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {
                    $idUsuario = $row_t_proyectos['creado_por'];
                    $idDestino = $row_t_proyectos['id_destino'];
                    $idSeccion = $row_t_proyectos['id_seccion'];
                    $idSubseccion = $row_t_proyectos['id_subseccion'];
                }

                if ($row['status'] == 'N') {
                    $background_status = "has-background-warning";
                    $contadorPF++;
                    $verPlan = "timeline-item";
                } else {
                    $background_status = "has-background-success";
                    $contadorPAF++;
                    $verPlan = "verPlan" . $idProyecto . " modal";
                }


                echo "
                <div class=\"$verPlan  my-0 py-0\">
                    <div class=\"timeline-marker\"></div>
                    <div class=\"timeline-content\">
                        <p class=\"heading \"><strong>$usuario</strong> - $fecha</p>

                        <div class=\"field has-addons\">
                            <div class=\"control is-expanded\">
                            <p id=\"$id\" class=\"has-text-justified manita $background_status px-3 py-1 rounded-pill has-text-white planAccionActividad has-text-weight-light\" onclick=\"planAccionClic($id);comentariosPlanAccion($id, $idProyecto); adjuntosPlanAccion($id); show_hide_modal('modalSubirArchivo','hide');\">$actividad</p>
                            </div>
                            <div class=\"control ml-3\" data-tooltip=\"Agregar Status\" onclick=\"show_hide_modal('modalStatusPlanAccion','show'); datosStatusProyecto($idDestino, $idSeccion, $idSubseccion, $idProyecto, $id, 'reporte_status_proyecto'); obtenerStatusPlanaccion($id);\">";

                $query_status = "SELECT* FROM reporte_status_proyecto WHERE id_planaccion=$id";
                $result_status = mysqli_query($conn_2020, $query_status);
                if (mysqli_num_rows($result_status) < 1) {
                    echo " <i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i>";
                } else {

                    $query_status_material = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and id_planaccion=$id and status='status_material'";
                    $result_status_material = mysqli_query($conn_2020, $query_status_material);
                    if (mysqli_num_rows($result_status_material) > 0) {
                        echo "<strong class=\"mr-1 fa-lg\">M</strong>";
                    }

                    $query_status_trabajare = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and id_planaccion=$id and status='status_trabajare'";
                    $result_status_trabajare = mysqli_query($conn_2020, $query_status_trabajare);
                    if (mysqli_num_rows($result_status_trabajare) > 0) {
                        echo "<strong class=\"mr-1 fa-lg has-text-info\">T</strong>";
                    }

                    $query_status_urgente = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto and id_planaccion=$id and status='status_urgente'";
                    $result_status_urgente = mysqli_query($conn_2020, $query_status_urgente);
                    if (mysqli_num_rows($result_status_urgente) > 0) {
                        echo "<i class=\"has-text-danger fad fa-siren-on mr-1 fa-lg animated infinite flash\"></i>";
                    }

                    $query_status_departamento = "SELECT* FROM reporte_status_proyecto WHERE id_planaccion=$id AND
                                status LIKE '%status_departamento%'";
                    $result_status_departamento = mysqli_query($conn_2020, $query_status_departamento);
                    if (mysqli_num_rows($result_status_departamento) > 0) {
                        echo "<strong class=\"mr-1 fa-lg has-text-primary\">D</strong>";
                    }


                    $query_status_energeticos = "SELECT* FROM reporte_status_proyecto WHERE id_proyecto=$idProyecto AND id_planaccion=$id AND
                                status LIKE '%status_energetico%' ";
                    $result_status_energeticos = mysqli_query($conn_2020, $query_status_energeticos);
                    if (mysqli_num_rows($result_status_energeticos) > 0) {
                        echo "<strong class=\"mr-1 fa-lg has-text-warning\">E</strong>";
                    }
                }
                echo "</div>
                        </div>
                    </div>
                </div>";
            }
            echo "
			<div class=\"timeline-item\">
            	<div class=\"timeline-marker is-icon\">
                	<i class=\"fad fa-genderless\"></i>
                </div>
        	</div>
			";

            if ($contadorPF <= 0) {
                echo "
				<div class=\"column\">
					<button class=\"mt-1 mx-5 has-text-centered button is-danger\" onclick=\"finalizarProyecto($idProyecto);\">
						<span class=\"icon is-small\">
							<i class=\"fas fa-check\"></i>
						</span >
						<span>¿Finalizar Proyecto?</span>
					</button>
				</div>
				";
            }

            if ($contadorPAF > 0) {
                echo "
				<div class=\"column\">
					<button class=\"mt-1 mx-5 has-text-centered button is-success\" onclick=\"verPlan($idProyecto);\">
    					<span class=\"icon is-small\">
        					<i class=\"fas fa-tasks\"></i>
						</span>
    					<span>Plan Acción - Finalizados</span>
					</button>
				</div>
				";
            }
        } else {
            echo mysqli_error($result);
        }
    }


    if ($action == "comentarioPlanAccion") {

        $idPlanAccion = $_POST['idPlanAccion'];
        $query = "SELECT* FROM t_proyectos_planaccion_comentarios WHERE id_actividad=$idPlanAccion ORDER BY fecha DESC";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            // Inicio de timeline
            echo "<div class=\"timeline is-centered\">";

            while ($row = mysqli_fetch_array($result)) {

                $comentario = $row['comentario'];
                $fecha = $row['fecha'];
                $id_usuario = $row['usuario'];

                // Query para Consultar el Usuario que Escribio el Comentario.
                $query_usuario_comentario = "SELECT t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador=t_colaboradores.id
                WHERE t_users.id=$id_usuario";
                $result_usuario_comentario = mysqli_query($conn_2020, $query_usuario_comentario);
                $row_usuario_comentario = mysqli_fetch_array($result_usuario_comentario);
                $usuario = $row_usuario_comentario['nombre'] . " " . $row_usuario_comentario['apellido'];

                // Body de timeline
                echo
                    "<div class=\"timeline-item\">
                    <div class=\"timeline-marker\"></div>
                    <div class=\"timeline-content\">
                        <p class=\"heading \"><strong>$usuario</strong></p>
                        <p class=\"heading \">$fecha</p>
                        <p class=\"has-text-justified p-3 has-background-white-bis rounded text-wrap border border-light has-text-weight-light\">$comentario</p>
                    </div>
                </div>";
            }
            // Footer del imeline
            echo "<div class=\"timeline-item \">
                            <div class=\"timeline-marker\"></div>
                        </div>

                        <div class=\"timeline-item\">
                            <div class=\"timeline-marker is-icon\">
                                <i class=\"fad fa-genderless\"></i>
                            </div>
                        </div>
                    </div>";
        } else {
            echo "Error";
        }
    }


    if ($action == "agregarPlanAccion") {
        $idProyecto = $_POST['idProyecto'];
        $actividad = $_POST['actividad'];
        $usuario = $_SESSION['usuario'];
        $fechaActual = date('Y-m-d H:i:s');

        $query = "INSERT INTO t_proyectos_planaccion (id_proyecto, actividad, status, creado_por, fecha_creacion, activo) VALUES ($idProyecto, '$actividad', 'N', $usuario, '$fechaActual', 1 )";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "ok";
        } else {
            echo "Error";
        }
    }

    if ($action == "agregarComentarioPlanAccion") {
        $idPlanAccion = $_POST['idPlanAccion'];
        $comentario = $_POST['comentario'];
        $usuario = $_SESSION['usuario'];
        $fechaActual = date('Y-m-d H:i:s');

        $query = "INSERT INTO t_proyectos_planaccion_comentarios (id_actividad, comentario, usuario, fecha) VALUES ($idPlanAccion, '$comentario', $usuario, '$fechaActual')";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "Ok!";
        } else {
            echo mysqli_errno($result);
        }
    }


    if ($action == "eliminarPlanAccion") {
        $idPlan = $_POST['idPlan'];

        $query = "UPDATE t_proyectos_planaccion SET activo=0 WHERE id=$idPlan";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Plan de Acción, Eliminado!";
        } else {
            echo "Error al Eliminar!";
        }
    }

    if ($action == "actualizarPlanAccion") {
        $idPlan = $_POST['idPlan'];
        $tituloPlan = $_POST['tituloPlan'];

        $query = "UPDATE t_proyectos_planaccion SET actividad='$tituloPlan' WHERE id=$idPlan";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Plan de Acción, Actualizado!";
        } else {
            echo "Error al Actualizar!";
        }
    }


    // Agregar
    if ($action == "agregarStatusProyectoPlanAccion") {
        $usuario = $_SESSION['usuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idTabla = $_POST['idTabla'];
        $idPlanAccion = $_POST['idPlanAccion'];
        $tabla = $_POST['tabla'];
        $statusProyecto = "status_" . $_POST['statusProyecto'];
        $idCampoTabla = "id_proyecto";
        $fechaActual = date('Y-m-d H:i:s');


        $query = "INSERT INTO $tabla(id_usuario, id_destino, id_seccion, id_subseccion, id_proyecto, id_planaccion, status) VALUES($usuario, $idDestino, $idSeccion, $idSubseccion, $idTabla, $idPlanAccion, '$statusProyecto')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "ok!";
        }
    }

    if ($action == "obtenerStatusPlanaccion") {
        $idPlanAccion = $_POST['idPlanAccion'];
        $data = array();
        $dataStatus = "";

        $query = "SELECT* FROM reporte_status_proyecto WHERE id_planaccion = $idPlanAccion AND status IN('status_departamento_rrhh', 'status_departamento_finanzas', 'status_departamento_direccion', 'status_departamento_calidad', 'status_departamento_compras')";

        if ($result = mysqli_query($conn_2020, $query)) {
            while ($row = mysqli_fetch_array($result)) {
                $idStatus = $row['id'];
                $status = $row['status'];

                if ($status == "status_trabajare") {
                    $status = "T";
                } elseif ($status == "status_material") {
                    $status = "M";
                } elseif ($status == "status_urgente") {
                    $status = "Urgente";
                } elseif ($status == "status_energetico_electricidad") {
                    $status = "Electricidad";
                } elseif ($status == "status_energetico_agua") {
                    $status = "Agua";
                } elseif ($status == "status_energetico_diesel") {
                    $status = "Diesel";
                } elseif ($status == "status_energetico_gas") {
                    $status = "Gas";
                } elseif ($status == "status_departamento_rrhh") {
                    $status = "RRHH";
                } elseif ($status == "status_departamento_finanzas") {
                    $status = "Finanzas";
                } elseif ($status == "status_departamento_direccion") {
                    $status = "Dirección";
                } elseif ($status == "status_departamento_calidad") {
                    $status = "Calidad";
                } elseif ($status == "status_departamento_compras") {
                    $status = "Compras";
                }

                $dataStatus .= "
                    <span class=\"tag is-primary m-1\">
                        <p class=\"notifiaction subtitle is-6\">$status</p>
                        <button class=\"delete \" onclick=\"eliminarStatusPlanAccion($idPlanAccion,'$status');\"></button>
                    </span>
                ";
            }
        }
        $data['dataStatus'] = $dataStatus;
        echo json_encode($data);
    }

    if ($action == "eliminarStatusPlanAccion") {
        $idPlanAccion = $_POST['idPlanAccion'];
        $status = $_POST['status'];
        $query = "UPDATE reporte_status_proyecto SET status = '' WHERE id_planaccion = $idPlanAccion AND status LIKE '%$status%'";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo "Eliminado $idPlanAccion $status";
        } else {
            echo "Error $idPlanAccion $status";
        }
    }


    // Agregar
    if ($action == "finalizarPlanAccion") {
        $usuario = $_SESSION['usuario'];
        $idPlanAccion = $_POST['idPlanAccion'];
        $query = "UPDATE t_proyectos_planaccion set status='F' WHERE id =$idPlanAccion";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "ok!";
        } else {
            echo "Error";
        }
    }

    //Proceso para Status de los Departamentos.
    if ($action == "reporteStatusDEP") {
        $idDestino = $_POST['idDestino'];
        $idSubseccion = $_POST['idGrupo'];
        $idSeccion = $_POST['idSeccion'];
        $data = "";

        if ($idSubseccion == 213) {
            $status = "AND (t_mc.status_material != '' OR t_mc.departamento_compras != '')";
            $status_P = "AND t_proyectos_planaccion.status_material != 0";
            $columnaProyectos = "status_material";
            $status_T = "AND t_mp_np.status_material != '0'";
        } elseif ($idSubseccion == 62) {
            $status = "AND t_mc.departamento_rrhh != ''";
            $status_P = "AND t_proyectos_planaccion.departamento_rrhh != 0";
            $columnaProyectos = "departamento_rrhh";
            $status_T = "AND t_mp_np.departamento_rrhh != '0'";
        } elseif ($idSubseccion == 211) {
            $status = "AND t_mc.departamento_finanzas != ''";
            $status_P = "AND t_proyectos_planaccion.departamento_finanzas != 0";
            $columnaProyectos = "departamento_finanzas";
            $status_T = "AND t_mp_np.departamento_finanzas != '0'";
        } elseif ($idSubseccion == 212) {
            $status = "AND t_mc.departamento_direccion != ''";
            $status_P = "AND t_proyectos_planaccion.departamento_direccion != 0";
            $columnaProyectos = "departamento_direccion";
            $status_T = "AND t_mp_np.departamento_direccion != '0'";
        } elseif ($idSubseccion == 214) {
            $status = "AND t_mc.departamento_calidad != ''";
            $status_P = "AND t_proyectos_planaccion.departamento_calidad != 0";
            $columnaProyectos = "departamento_calidad";
            $status_T = "AND t_mp_np.departamento_calidad != '0'";
        } else {
            $status = "AND t_mc.departamento_calidad != '-'";
            $status_P = "AND t_proyectos_planaccion.departamento_calidad != '-'";
            $columnaProyectos = "";
            $status_T = "";
        }

        if ($idDestino != 10) {
            $destino = "AND t_mc.id_destino = $idDestino";
            $destino_P = "AND t_proyectos.id_destino = $idDestino";
            $destino_T = "AND t_mp_np.id_destino = $idDestino";
        } else {
            $destino = "";
            $destino_P = "";
            $destino_T = "";
        }

        // FALLAS
        $query = "SELECT
        t_mc.id, t_mc.actividad, t_mc.fecha_creacion, t_mc.status_material, t_mc.status_trabajare, t_mc.responsable, t_colaboradores.nombre, t_colaboradores.apellido, t_mc.departamento_finanzas, t_mc.departamento_rrhh, t_mc.departamento_direccion, t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.cod2bend, t_mc.codsap
        FROM t_mc
        INNER JOIN t_users ON t_mc.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mc.status='N' AND t_mc.activo=1 $status $destino ORDER BY t_mc.id DESC";

        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $idMC = $row['id'];
            $actividad = $row['actividad'];
            $responsable = $row['responsable'];
            $fechaCreacionDEP = $row['fecha_creacion'];
            $fechaCreacionDEP = new DateTime($fechaCreacionDEP);
            $fechaCreacionDEP = $fechaCreacionDEP->format("d-m-Y");
            $creadoNombre = $row['nombre'];
            $creadoApellido = $row['apellido'];
            $status_material = $row['status_material'];
            $status_trabajare = $row['status_trabajare'];
            $status_compras = $row['departamento_compras'];
            $status_finanzas = $row['departamento_finanzas'];
            $status_rrhh = $row['departamento_rrhh'];
            $status_direccion = $row['departamento_direccion'];
            $status_calidad = $row['departamento_calidad'];
            $cod2bend = $row['cod2bend'];
            $codsap = $row['codsap'];

            if ($idSubseccion == 213) {
                $codsapInput = "
                <p class=\"t-normal p-1\">
                <input id=\"codsapMC$idMC\" class=\"input\" type=\"text\" value=\"$codsap\" placeholder=\"#\" onkeyup=\"capturarCodigo($idMC, 'codsap', 't_mc');\">
                </p>";

                $cod2bendInput = "
                <p class=\"t-normal p-1\">
                    <input id=\"cod2bendMC$idMC\" class=\"input\" type=\"text\" value=\"$cod2bend\" placeholder=\"#\" onkeyup=\"capturarCodigo($idMC, 'cod2bend', 't_mc');\">
                </p>";
            } else {
                $cod2bendInput = "<p class=\"t-normal\">NA</p>";
                $codsapInput = "<p class=\"t-normal\">NA</p>";
            }


            // Busca el Responsable.
            $query_responsable = "SELECT
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_users
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_users.id=$responsable";

            $result_responsable = mysqli_query($conn_2020, $query_responsable);
            if ($row_responsable = mysqli_fetch_array($result_responsable)) {

                $responsableN  = $row_responsable['nombre'] . " " . $row_responsable['apellido'];
            } else {
                $responsableN = "-";
            }
            // Comprube si tiene información las variables, sino, le asigna uno por defecto.

            if ($fechaCreacionDEP == "") {
                $fechaCreacionDEP = " <p class=\"t-icono-rojo p-0\"><i class=\"fad fa-calendar-times\"></i></p>";
            }
            if ($responsableN == "") {
                $responsableN = "<p class=\"t-normal\">-</p>";
            }

            if ($status_compras != "" || $status_finanzas != "" || $status_rrhh != "" || $status_direccion != "" || $status_calidad != '') {
                $departamento = "<span class=\"fa-lg p-0\"><strong class=\"has-text-primary\">D</strong></span> ";
            } else {
                $departamento = "";
            }

            $data .= "
                <div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">
                    <div class=\"column is-half\">
                        <div class=\"columns\">
                            <div class=\"column\">
                                <div class=\"message is-small is-danger\">
                                    <p class=\"message-body\"><strong>$actividad</strong><span><i class=\"fad fa-user-circle mx-2 fa-lg\"></i>$creadoNombre $creadoApellido</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"column\">
                        <div class=\"columns is-gapless\">
                            <div class=\"column\">
                                <p class=\"t-normal truncate\">$responsableN</p>
                            </div>
                            <div class=\"column\">
                                <p class=\"t-normal\">$fechaCreacionDEP</p>
                            </div>
                            <div class=\"column\">
                                <p class=\"t-icono-rojo\"><i class=\"fad fa-file-minus\"></i></p>
                            </div>
                            <div class=\"column\">
                                <p class=\"t-icono-rojo\"><i class=\"fad fa-comment-alt-times\"></i></p>
                            </div>
                            <div class=\"column\">
                                <p class=\"t-normal\">
                                $departamento
                                $status_material $status_trabajare
                                </p>
                            </div>
                            <div class=\"column\">
                            $codsapInput
                            </div>
                            <div class=\"column\">
                            $cod2bendInput
                            </div>
                        </div>
                    </div>
                </div>
            ";
            $responsableN = "";
        }

        // TAREAS
        $query = "SELECT
        t_mp_np.id, t_mp_np.titulo, t_mp_np.rango_fecha, t_mp_np.fecha, t_mp_np.status_material, t_mp_np.status_trabajando, t_mp_np.responsable, t_colaboradores.nombre, t_colaboradores.apellido, t_mp_np.departamento_finanzas, t_mp_np.departamento_rrhh, t_mp_np.departamento_direccion, t_mp_np.departamento_calidad, t_mp_np.departamento_compras, t_mp_np.codsap
        FROM t_mp_np
        LEFT JOIN t_users ON t_mp_np.id_usuario = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.activo = 1 AND (t_mp_np.status='N' OR t_mp_np.status='P') $status_T $destino_T ORDER BY t_mp_np.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            while ($row = mysqli_fetch_array($result)) {
                $idTarea = $row['id'];
                $titulo = $row['titulo'];
                $responsable = $row['responsable'];
                $rangoFechaCreacionDEP = $row['rango_fecha'];
                $fechaCreacionDEP = (new DateTime($row['fecha']))->format('Y-m-d');
                $creadoNombre = $row['nombre'];
                $creadoApellido = $row['apellido'];
                $status_material = $row['status_material'];
                $status_trabajare = $row['status_trabajando'];
                $status_compras = $row['departamento_compras'];
                $status_finanzas = $row['departamento_finanzas'];
                $status_rrhh = $row['departamento_rrhh'];
                $status_direccion = $row['departamento_direccion'];
                $status_calidad = $row['departamento_calidad'];
                $codsap = $row['codsap'];
                $cod2bend = $row['cod2bend'];

                if ($idSubseccion == 213) {
                    $codsapInput = "
                    <p class=\"t-normal p-1\">
                        <input id=\"codsapTAREA$idTarea\" class=\"input\" type=\"text\" value=\"$codsap\" placeholder=\"#\" onkeyup=\"capturarCodigo($idTarea, 'codsap', 't_mp_np');\" >
                    </p>";

                    $cod2bendInput = "
                    <p class=\"t-normal p-1\">
                        <input id=\"cod2bendTAREA$idMC\" class=\"input\" type=\"text\" value=\"$cod2bend\" placeholder=\"#\"  onkeyup=\"capturarCodigo($idTarea, 'cod2bend', 't_mp_np');\">
                    </p>";
                } else {
                    $codsapInput = "<p class=\"t-normal\">NA</p>";
                }

                // Busca el Responsable.
                $query_responsable = "SELECT
                t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = 0";

                $result_responsable = mysqli_query($conn_2020, $query_responsable);
                if ($row_responsable = mysqli_fetch_array($result_responsable)) {

                    $responsableN  = $row_responsable['nombre'] . " " . $row_responsable['apellido'];
                } else {
                    $responsableN = "-";
                }

                // Comprube si tiene información las variables, sino, le asigna uno por defecto.

                if ($rangoFechaCreacionDEP == "") {
                    $fechaCreacionDEP = $fechaCreacionDEP;
                } else {
                    $fechaCreacionDEP = $rangoFechaCreacionDEP;
                }

                if ($responsableN == "") {
                    $responsableN = "<p class=\"t-normal\">-</p>";
                }

                if ($status_compras != "" || $status_finanzas != "" || $status_rrhh != "" || $status_direccion != "" || $status_calidad != '') {
                    $departamento = "<span class=\"fa-lg p-0\"><strong class=\"has-text-primary\">D</strong></span> ";
                } else {
                    $departamento = "";
                }

                if ($status_material != "0") {
                    $status_material = "<span class=\"tag is-dark fa-lg\">M</span>";
                } else {
                    $status_material = "";
                }

                if ($status_trabajare != "0") {
                    $status_trabajare = "<span class=\"tag is-info fa-lg mr-2\">T</span>";
                } else {
                    $status_trabajare = "";
                }

                $data .= "
                    <div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">
                        <div class=\"column is-half\">
                            <div class=\"columns\">
                                <div class=\"column\">
                                    <div class=\"message is-small is-danger\">
                                        <p class=\"message-body\"><strong>$titulo</strong><span><i class=\"fad fa-user-circle mx-2 fa-lg\"></i>$creadoNombre $creadoApellido</span><span class=\"has-text-grey-light\"> Tarea</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"column\">
                            <div class=\"columns is-gapless\">
                                <div class=\"column\">
                                    <p class=\"t-normal truncate\">$responsableN</p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal\">$fechaCreacionDEP</p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-icono-rojo\"><i class=\"fad fa-file-minus\"></i></p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-icono-rojo\"><i class=\"fad fa-comment-alt-times\"></i></p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal\">
                                    $departamento
                                    $status_material 
                                    $status_trabajare
                                    </p>
                                </div>
                                <div class=\"column\">
                                $codsapInput
                                </div>
                                <div class=\"column\">
                                $cod2bendInput
                                </div>
                            </div>
                        </div>
                    </div>
                ";
                $responsableN = "";
            }
        }

        // PROYECTOS
        $query_P = "SELECT
        t_proyectos_planaccion.id,
        t_proyectos_planaccion.codsap,
        t_proyectos_planaccion.cod2bend,
        t_proyectos_planaccion.status_material,
        t_proyectos_planaccion.departamento_rrhh,
        t_proyectos_planaccion.departamento_finanzas,
        t_proyectos_planaccion.departamento_direccion,
        t_proyectos_planaccion.departamento_calidad,
        t_proyectos_planaccion.actividad,
        t_proyectos_planaccion.creado_por,
        t_proyectos_planaccion.fecha_creacion,
        t_proyectos_planaccion.responsable,
        t_proyectos.titulo,
        t_colaboradores.nombre,
        t_colaboradores.apellido
        FROM t_proyectos_planaccion
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion.activo = 1 and t_proyectos_planaccion.status = 'N' $status_P $destino_P";

        $result = mysqli_query($conn_2020, $query_P);
        if ($result) {

            while ($row_P = mysqli_fetch_array($result)) {
                $idPlanaccion =  $row_P['id'];
                $proyecto =  $row_P['titulo'];
                $planaccion =  $row_P['actividad'];
                $creado_por  = $row_P['nombre'] . " " . $row_P['apellido'];
                $responsable = $row_P['responsable'];
                $status = $row_P[$columnaProyectos];
                $codsapPlanaccion = $row_P['codsap'];
                $cod2bendPlanaccion = $row_P['cod2bend'];

                $fecha_creacion = $row_P['fecha_creacion'];
                $fecha_creacion = new DateTime($fecha_creacion);
                $fecha_creacion = $fecha_creacion->format("d-m-Y");


                $query_responsable = "SELECT
                t_colaboradores.nombre,
                t_colaboradores.apellido
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id=$responsable
                ";

                // Comprobación de Resultados, si tiene información le asigna segun el resultado, sino, le agrega uno por defecto.
                $result_responsable = mysqli_query($conn_2020, $query_responsable);

                if ($row_responsable = mysqli_fetch_array($result_responsable)) {
                    $responsablePlanaccion = $row_responsable['nombre'] . " " . $row_responsable['apellido'];
                } else {
                    $responsablePlanaccion = "-";
                }

                if ($columnaProyectos == "departamento_finanzas" || $status == "departamento_rrhh" || $status == "departamento_direccion" || $status == "departamento_calidad") {
                    $departamento = "<span class=\"mr-4 fa-lg \"><strong class=\"has-text-primary\">D</strong></span> ";
                } else {
                    $departamento = "";
                }

                if ($columnaProyectos == "status_material") {
                    $status_material = "<span class=\"tag is-dark fa-lg\">M</span>";
                } else {
                    $status_material = "";
                }

                if ($columnaProyectos == "status_trabajare") {
                    $status_trabajare = "<span class=\"tag is-primary fa-lg\">T</span>";
                } else {
                    $status_trabajare = "";
                }

                if ($idSubseccion == 213) {

                    $codsapInput = "
                        <input id=\"codsapPlanaccion$idPlanaccion\" class=\"input\" type=\"text\" value=\"$codsapPlanaccion\" placeholder=\"#\" onkeyup=\"capturarCodigo($idPlanaccion, 'codsap', 't_proyectos_planaccion');\">
                    ";

                    $cod2bend = "
                        <input id=\"cod2bendPlanaccion$idPlanaccion\" class=\"input\" type=\"text\" value=\"$cod2bendPlanaccion\" placeholder=\"#\" onkeyup=\"capturarCodigo($idPlanaccion, 'cod2bend', 't_proyectos_planaccion');\">
                    ";
                } else {
                    $codsapInput = "NA";
                    $cod2bend = "NA";
                }

                $data .= "
                    <div class=\"columns is-gapless my-0 is-mobile hvr-grow-sm manita mx-2\">
                        <div class=\"column is-half\">
                            <div class=\"columns\">
                                <div class=\"column\">
                                    <div class=\"message is-small is-danger\">
                                        <p class=\"message-body\"><strong>$planaccion</strong><span><i class=\"fad fa-user-circle mx-2 fa-lg\"></i>$creado_por </span><span class=\"has-text-grey-light\"> Proyecto</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"column\">
                            <div class=\"columns is-gapless\">
                                <div class=\"column\">
                                    <p class=\"t-normal truncate\">$responsablePlanaccion</p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal\">$fecha_creacion</p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-icono-rojo\"><i class=\"fad fa-file-minus\"></i></p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-icono-rojo\"><i class=\"fad fa-comment-alt-times\"></i></p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal\">
                                        $departamento
                                        $status_material
                                        $status_trabajare
                                    </p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal p-1\">
                                        $codsapInput
                                    </p>
                                </div>
                                <div class=\"column\">
                                    <p class=\"t-normal p-1\">
                                        $cod2bend
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
        echo $data;
    }


    if ($action == "capturarCodigo") {
        $id = $_POST['id'];
        $tipoCodigo = $_POST['tipoCodigo'];
        $tabla = $_POST['tabla'];
        $codigo = $_POST['codigo'];

        if ($codigo != "") {
            $query = "UPDATE $tabla set $tipoCodigo = '$codigo' WHERE id = $id";

            if ($result = mysqli_query($conn_2020, $query)) {
                echo "ok";
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    }


    if ($action == "aplicarDepartamentoMC") {
        $idMC = $_POST['idMC'];
        $departamento = $_POST['departamento'];
        $departamentoHtml = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-primary\">D</strong></span>";
        $energeticoHtml = "<span class=\"mr-4 fa-lg\"><strong class=\"has-text-warning\">E</strong></span>";

        if ($departamento == "departamento_calidad" || $departamento == "departamento_compras" || $departamento == "departamento_direccion" || $departamento == "departamento_finanzas" || $departamento == "departamento_rrhh") {
            $query = "UPDATE t_mc SET $departamento = '$departamentoHtml' WHERE id=$idMC";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Aplicado!";
            } else {
                echo "Error de Status!";
            }
        } elseif ($departamento == "energetico_electricidad" || $departamento == "energetico_agua" || $departamento == "energetico_diesel" || $departamento == "energetico_gas") {
            $query = "UPDATE t_mc SET $departamento = '$energeticoHtml' WHERE id=$idMC";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Aplicado!";
            } else {
                echo "Error de Status!";
            }
        } else {
            echo "Error de Status!";
        }
    }

    if ($action == "consultaEDMC") {
        $idMC = $_POST['idMC'];
        $statusConsulta = $_POST['statusConsulta'];

        $query = "SELECT* FROM t_mc WHERE id=$idMC";
        $result = mysqli_query($conn_2020, $query);

        if ($statusConsulta == "energetico") {
            while ($row = mysqli_fetch_array($result)) {
                $agua = $row['energetico_agua'];
                $gas = $row['energetico_gas'];
                $electricidad = $row['energetico_electricidad'];
                $diesel = $row['energetico_diesel'];

                if ($agua != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-warning\">
                                <p class=\"notifiaction subtitle is-6\">- Agua</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','energetico_agua',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($gas != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-warning\">
                                <p class=\"notifiaction subtitle is-6\">- Gas</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','energetico_gas',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($electricidad != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-warning\">
                            <p class=\"notifiaction subtitle is-6\"> - Electricidad </p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','energetico_electricidad',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($diesel != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-warning\">
                                <p class=\"notifiaction subtitle is-6\">- Diesel</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','energetico_diesel',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }
            }
        }

        if ($statusConsulta == "departamento") {

            while ($row = mysqli_fetch_array($result)) {
                $departamento_calidad = $row['departamento_calidad'];
                $departamento_finanzas = $row['departamento_finanzas'];
                $departamento_compras = $row['departamento_compras'];
                $departamento_rrhh = $row['departamento_rrhh'];
                $departamento_direccion = $row['departamento_direccion'];

                if ($departamento_calidad != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-primary\">
                                <p class=\"notifiaction subtitle is-6\">- Calidad</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','departamento_calidad',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($departamento_finanzas != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-primary\">
                                <p class=\"notifiaction subtitle is-6\">- Finanzas</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','departamento_finanzas',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($departamento_compras != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-primary\">
                            <p class=\"notifiaction subtitle is-6\"> - Compras Almacén </p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','departamento_compras',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($departamento_rrhh != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-primary\">
                                <p class=\"notifiaction subtitle is-6\">- RRHH</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','departamento_rrhh',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }

                if ($departamento_direccion != "") {
                    echo "
                        <div class=\"mx-2 my-2\">
                            <span class=\"tag is-primary\">
                                <p class=\"notifiaction subtitle is-6\">- Dirección</p>
                                <button class=\"delete \" onclick=\"eliminarED('t_mc','departamento_direccion',$idMC);\"></button>
                            </span>
                        </div>
                    ";
                }
            }
        }
    }


    if ($action == "eliminarED") {
        $idMC = $_POST['idMC'];
        $tabla = $_POST['tabla'];
        $columna = $_POST['columna'];

        if ($idMC != "") {
            $query = "UPDATE $tabla SET $columna='' WHERE id=$idMC";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Status Eliminado!";
            } else {
                echo "Error al Eliminar!";
            }
        } else {
            $query = "Error al Eliminar...";
        }
    }


    if ($action == "consultaDEP") {
        $total = 1;
        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $data = "";

        if ($idDestino == 10) {
            $idDestinoF = "";
        } else {
            $idDestinoF = "AND t_mc.id_destino = $idDestino";
        }

        $query = "SELECT*
        FROM t_mc
        -- INNER JOIN
        WHERE t_mc.id_seccion = $idSeccion AND t_mc.id_subseccion = $idSubseccion and t_mc.status='N' AND t_mc.activo=1  $idDestinoF";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $actividad = $row['actividad'];
            $fechaCreacion = $row['fecha_creacion'];
            $idDestino = $row['id_destino'];

            // Convertir fecha MES-DIA
            $fechaCreacion = new DateTime($fechaCreacion);
            $fechaCreacion = $fechaCreacion->format("M-d");

            // Se guarda la información obtenida en variable $data.
            $data .= "<div class=\"columns is-gapless my-1 cursor mx-4\">
                    <div class=\"column is-one-third modal-button\" data-target=\"modal-id\">
                        <div class=\"columns\">
                            <div class=\"column\">
                                <div class=\"tarea is-small is-danger overflow \">
                <p class=\"tarea-body\">$total <strong> $actividad</strong> <span><i class=\"fad fa-user mx-2 has-text-danger fa-lg\"></i>Eduardo Meneses&nbsp;</span><span class=\"has-text-grey-light\"> $array_destino[$idDestino]</span></p>         </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"column\">
                        <div class=\"columns is-gapless\"><div class=\"column overflow\" onclick=\"hide_show_clase('sectionPlanAcion$id'); modalPlanAccion($id);\"><p class=\"filatarea\"><svg class=\"svg-inline--fa fa-check fa-w-16 has-text-success fa-lg\" aria-hidden=\"true\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z\"></path></svg><!-- <i class=\"fas fa-check has-text-success fa-lg\"></i> --></p></div><div class=\"column overflow\" onclick=\"modalResponsable('$id');\"><p class=\"filatarea\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p></div>
                        <div class=\"column overflow\">
                            <p class=\"filatarea\">$fechaCreacion</p>
                        </div>
                        <div class=\"column overflow\" onclick=\"modalSubirArchivo('t_proyectos_adjuntos',$id);\">
                        <p class=\"filatarea\"><svg class=\"svg-inline--fa fa-check fa-w-16 has-text-success fa-lg\" aria-hidden=\"true\" data-prefix=\"fas\" data-icon=\"check\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\"\"><path fill=\"currentColor\" d=\"M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z\"></path></svg><!-- <i class=\"fas fa-check has-text-success fa-lg\"></i> --></p></div>
                            <div class=\"column overflow\"><p class=\"filatarea\" onclick=\"modalTipo($id)\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p></div>
                            <div class=\"column overflow\"><p class=\"filatarea\" onclick=\"modalJustificacion($id);\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p></div><div class=\"column overflow\"><p class=\"filatarea\" onclick=\"modalCosto($id,)\"><i class=\"fad fa-minus has-text-danger fa-2x\"></i></p> </div>
                            <div class=\"column overflow\" onclick=\"modalStatus($id)\">
                            <p class=\"filatarea modal-button\" onclick=\"modalStatus($id)\" data-target=\"modal-id\"></p>
                            </div>
                        </div>
                    </div>
                </div>";

            // Contador de resultados Tareas Generales.
            $total++;

            $data .= "
                <section id=\"sectionPlanAcion$id\" class=\"box mt-0 mb-4 cursor mx-4 modal\">
                <div class=\"columns\">

                    <div class=\"column is-one-third\">
                        <h4 class=\"subtitle is-4 has-text-centered\">Plan de acción</h4>
                        <div class=\"field has-addons\">
                            <div class=\"control is-expanded\">
                                <input id=\"inputPlanAccion$id\" class=\"input is-rounded\" type=\"text\" placeholder=\"Agregar Plan Acción\" maxlength=\"60\">
                            </div>
                            <div class=\"control\">
                                <a class=\"button is-primary is-rounded\" onclick=\"agregarPlanAccion($id);\">
                                    <i class=\"fad fa-plus-circle\"></i>
                                </a>
                            </div>
                        </div>
                        <div class=\"timeline is-left\">
                            <div id=\"planAccion$id\">
                            </div>
                            <div class=\"timeline-item\">
                                <div class=\"timeline-marker is-icon\">
                                    <i class=\"fad fa-genderless\"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\" column is-one-third\">
                        <h4 class=\"subtitle is-4 has-text-centered\">Comentarios</h4>
                        <div class=\"field has-addons\">
                            <div class=\"control is-expanded\">
                                <input id=\"inputComentarioPlanAccion$id\" class=\"input is-rounded\" type=\"text\" placeholder=\"Agregar Comentarios\" maxlength=\"150\">
                            </div>
                            <div class=\"control\">
                                <a class=\"button is-primary is-rounded\" onclick=\"agregarComentarioPlanAccion($id);\">
                                    <i class=\"fad fa-plus-circle\"></i>
                                </a>
                            </div>
                        </div>

                        <div id=\"comentarioPlanAccion$id\"> </div>
                    </div>

                    <div class=\"column is-one-third has-text-centered\">
                        <h4 class=\"subtitle is-4\">Adjuntos</h4>
                        <input id=\"inputAdjuntoPlanAccion$id\" class=\"button is-primary\" type=\"button\" onclick=\"show_hide_modal('modalSubirArchivo', 'show');\" value=\"Adjuntos\"><br>
                        <div id=\"adjuntosPlanAccion$id\">
                            Sin Adjuntos
                        </div>
                    </div>
                </div>
            </section>";
        }
        echo $data;
    }


    if ($action == "agregarTitoloMPNP") {
        $titulo = $_POST['titulo'];
        $idUsuario = $_SESSION['usuario'];
        $idDestino = $_SESSION['idDestino'];
        $idEquipo = $_POST['idEquipo'];
        $fecha = date('Y-m-d H:m:s');
        $tipo = "MPNP";

        $query = "SELECT MAX(id) AS id FROM t_mp_np";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            if ($idNuevo = mysqli_fetch_array($result)) {

                $idNuevo = $idNuevo['id'] + 1;

                $query_titulo = "INSERT INTO
                t_mp_np(id, id_equipo, id_usuario, id_destino, tipo, titulo, status, activo)
                VALUES($idNuevo, $idEquipo, $idUsuario, $idDestino, '$tipo', '$titulo', 'P' ,1)";
                $result_titulo = mysqli_query($conn_2020, $query_titulo);
                if ($result_titulo) {
                    echo $idNuevo;
                } else {
                    echo "Error";
                }
            } else {
                echo   "Error";
            }
        }
    }

    if ($action == "consultaResponsableMPNP") {
        $idMPNP = $_POST['idMPNP'];
        $data = "";

        $query = "SELECT responsable FROM t_mp_np WHERE id = $idMPNP";
        $result = mysqli_query($conn_2020, $query);
        if ($row = mysqli_fetch_array($result)) {
            $responsable = $row['responsable'];
            $responsable = explode(",", $responsable);
            foreach ($responsable as $key => $value) {
                if ($value >= 1) {
                    $queryData = "SELECT
                    t_colaboradores.nombre,
                    t_colaboradores.apellido
                    FROM t_users
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $value";

                    $resultData = mysqli_query($conn_2020, $queryData);
                    if ($rowData = mysqli_fetch_array($resultData)) {
                        $nombre = $rowData['nombre'];
                        $apellido = $rowData['apellido'];

                        $data .= "
                            <div class=\"field is-grouped is-grouped-multiline\">
                                <div class=\"control\">
                                    <div class=\"tags has-addons\">
                                        <p class=\"tag is-primary\">
                                            <span class=\"mr-2\">
                                                <i class=\"fa fa-user\"></i>
                                            </span>
                                            $nombre $apellido
                                        </p>
                                        <p class=\"tag is-delete\" onclick=\"eliminarResponsableMPNP($key, $value, $idMPNP)\"></p>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                }
            }
            echo $data;
        }
    }


    if ($action == "agregarResponsableMPNP") {
        $arrayResponsable = array();
        $idResponsable = $_POST['idResponsable'];
        $idMPNP = $_POST['idMPNP'];

        $query = "SELECT responsable FROM t_mp_np WHERE id = $idMPNP";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            if ($row = mysqli_fetch_array($result)) {
                $resultResponsables = $row['responsable'];
                $resultResponsables = explode(",", $resultResponsables);

                $buscarResponsable = array_search($idResponsable, $resultResponsables, false);

                if ($buscarResponsable == "") {
                    $agregarResponsable = $row['responsable'] . ", $idResponsable";
                    $responsable = explode(",", $agregarResponsable);

                    $query_titulo = "UPDATE t_mp_np SET responsable = '$agregarResponsable' WHERE id = $idMPNP";

                    if ($result_titulo = mysqli_query($conn_2020, $query_titulo)) {
                        $arrayResponsable['msj'] = "Se Agrego Responsable";
                        $arrayResponsable['icon'] = "success";
                    } else {
                        $arrayResponsable['msj'] = "Error al Agregar Responsable";
                        $arrayResponsable['icon'] = "error";
                    }
                } else {
                    $arrayResponsable['msj'] = "El Usuario ya Existe";
                    $arrayResponsable['icon'] = "question";
                }
            }
        }
        echo json_encode($arrayResponsable);
    }


    if ($action == "eliminarResponsableMPNP") {
        $key = $_POST['key'];
        $value = $_POST['value'];
        $idMPNP = $_POST['idMPNP'];
        $responsable = "";
        $responsableActualizado = "";
        $data = "";

        $query = "SELECT responsable FROM t_mp_np WHERE id = $idMPNP";
        $result = mysqli_query($conn_2020, $query);
        if ($row_responsable = mysqli_fetch_array($result)) {
            $responsable = explode(",", $row_responsable['responsable']);
            unset($responsable[$key]);

            foreach ($responsable as $key_1 => $value_1) {
                if ($value >= 1) {
                    $responsableActualizado .= "$value_1, ";
                }
            }
            $actualizar = "UPDATE t_mp_np SET responsable = '$responsableActualizado' WHERE id = $idMPNP";
            $result = mysqli_query($conn_2020, $actualizar);
            if ($result) {

                $responsableActualizado = explode(",", $responsableActualizado);
                foreach ($responsable as $key => $value) {
                    if ($value >= 1) {
                        $queryData = "SELECT
                        t_colaboradores.nombre,
                        t_colaboradores.apellido
                        FROM t_users
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        WHERE t_users.id = $value";

                        $resultData = mysqli_query($conn_2020, $queryData);
                        if ($rowData = mysqli_fetch_array($resultData)) {
                            $nombre = $rowData['nombre'];
                            $apellido = $rowData['apellido'];

                            $data .= "
                                <div class=\"field is-grouped is-grouped-multiline\">
                                    <div class=\"control\">
                                        <div class=\"tags has-addons\">
                                            <p class=\"tag is-primary\">
                                                <span class=\"mr-2\">
                                                    <i class=\"fa fa-user\"></i>
                                                </span>
                                                $nombre $apellido
                                            </p>
                                            <p class=\"tag is-delete\" onclick=\"eliminarResponsableMPNP($key, $value, $idMPNP)\"></p>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    }
                }
                echo $data;
            } else {
                echo "Error al Actualizar";
            }
        } else {
            echo "Error";
        }
    }


    if ($action == "agregarActividadMPNP") {
        $arrayActividad = array();
        $idMPNP = $_POST['idMPNP'];
        $idUsuario = $_SESSION['usuario'];
        $actividadMPNP = $_POST['actividadMPNP'];
        $fecha = date('Y-m-d H:m:s');

        $query = "INSERT INTO actividad_mp_np
        (id_mp_np, actividad, creado_por, fecha)
        VALUES($idMPNP, '$actividadMPNP', $idUsuario, '$fecha')";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $arrayActividad['btnGuardarMPNP'] = 1;
            $arrayActividad['msj'] = "Actividad Agregada.";
            $arrayActividad['icon'] = "success";
        } else {
            $arrayActividad['btnGuardarMPNP'] = 1;
            $arrayActividad['msj'] = "Actividad NO Agregada.";
            $arrayActividad['icon'] = "error";
        }
        echo json_encode($arrayActividad);
    }


    if ($action == "consultaActividadMPNP") {
        $arrayConsultaActividad = array();
        $data = "";
        $idMPNP = $_POST['idMPNP'];
        $query = "SELECT actividad, id FROM actividad_mp_np WHERE id_mp_np = $idMPNP AND activo = 1 ORDER BY id DESC";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $actividad = $row['actividad'];
                $id = $row['id'];
                $data .= "
                    <div class=\"columns mb-1\">
                        <div class=\"column is-12\">
                            <div class=\"field has-text-left title is-5\">
                                <input class=\"is-checkradio is-success is-circle is-small\" type=\"checkbox\" name=\"listchkbPMOT_310\" id=\"chkbPMOT_310\" checked onclick=\"javascript: return false;\">
                                    <label for=\"chkbPMOT_310\" class=\"is-size-6 is-success ml-2 is-size-6\">
                                        $actividad
                                        <span class=\"is-success ml-2 is-size-7\" onclick=\"eliminarActividadMPNP($id);\">
                                        <a class=\"delete\"></a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }

            $arrayConsultaActividad['result'] = $data;
            $arrayConsultaActividad['total'] = mysqli_num_rows($result);
        } else {
            $arrayConsultaActividad['total'] = 0;
        }
        echo json_encode($arrayConsultaActividad);
    }

    if ($action == "eliminarActividadMPNP") {
        $id = $_POST['id'];

        $query = "UPDATE actividad_mp_np SET activo = 0 WHERE id = $id";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "Actividad Eliminada";
        } else {
            echo "Actividad NO Eliminada";
        }
    }


    if ($action == "btnConfirmarMPNP") {
        $titulo = $_POST['titulo'];
        $idMPNP = $_POST['idMPNP'];
        $idEquipo = $_POST['idEquipo'];
        $fecha = $_POST['fecha'];
        $fecha = new DateTime($fecha);
        $fecha = $fecha->format('Y-m-d H:m:s');
        $tipo = "MPNP";

        $query = "UPDATE t_mp_np
        SET titulo = '$titulo', fecha = '$fecha', status= 'F'

        WHERE id = $idMPNP AND id_equipo = $idEquipo";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "MP NO PLANEADO, Finalizado.";
        } else {
            echo "Error al Capturar MP NO PLANEADO.";
        }
    }


    if ($action == "consultaMPNP") {
        $data = "";
        $idEquipo = $_POST['idEquipo'];
        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.fecha, t_mp_np.id_usuario, t_mp_np.responsable, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_mp_np
        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.id_equipo = $idEquipo AND t_mp_np.activo=1 AND t_mp_np.status='F' ORDER BY t_mp_np.id DESC";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            // Variables iniciales.
            $id = $row['id']; //Id del MP NP.
            $titulo = $row['titulo'];
            $actividades = 0;
            $fecha = new DateTime($row['fecha']);
            $fecha = $fecha->format('Y - m - d');
            $creadoPor = $row['nombre'] . " " . $row['apellido'];
            $responsable = explode(",", $row['responsable']);


            // Querys Complementarios.

            // Busca las actividades relacionadas a un MP.
            $query_actividades = "SELECT id, actividad FROM actividad_mp_np WHERE id_mp_np = $id AND activo = 1 ORDER BY id DESC";
            $result_actividades = mysqli_query($conn_2020, $query_actividades);
            $actividades = mysqli_num_rows($result_actividades);

            // Busca los responsables asignados a un MP.
            $totalResponsables = 0;
            $responsable_nombre = "";
            foreach ($responsable as $key => $value) {
                if ($value >= 1) {
                    $totalResponsables++;

                    $query_responsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido
                    FROM t_users
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $value";
                    $result_responsable = mysqli_query($conn_2020, $query_responsable);
                    if ($row_responsable = mysqli_fetch_array($result_responsable)) {
                        $responsable_nombre .= $row_responsable['nombre'] . " " . $row_responsable['apellido'];
                    }
                }
            }


            // Se obtiene el total de los Adjuntos.
            $query_adjuntos = "SELECT id FROM adjuntos_mp_np WHERE id_mp_np = $id AND activo = 1";
            $result_adjuntos = mysqli_query($conn_2020, $query_adjuntos);
            $total_adjuntos = mysqli_num_rows($result_adjuntos);

            // Se obtiene el total de los comentarios.
            $query_comentarios = "SELECT id FROM comentarios_mp_np WHERE id_mp_np = $id AND activo = 1";
            $result_comentarios = mysqli_query($conn_2020, $query_comentarios);
            $total_comentarios = mysqli_num_rows($result_comentarios);

            if ($actividades >= 1) {
                $actividades = "<p class=\"t-normal\">$actividades</p>";
            } else {
                $actividades = "<p class=\"t-icono-rojo\">0</p>";
            }

            if ($fecha != "") {
                $fecha = "<p class=\"t-normal\">$fecha</p>";
            } else {
                $fecha = "<p class=\"t-icono-rojo\"><i class=\"fad fa-calendar-alt\"></i></p>";
            }

            if ($totalResponsables > 1) {
                $responsable_nombre = "<p class=\"t-normal\">$totalResponsables</p>";
            } else {
                $responsable_nombre = "<p class=\"t-normal\">$responsable_nombre</p>";
            }

            if ($total_comentarios >= 1) {
                $total_comentarios = "<p class=\"t-normal\">$total_comentarios</p>";
            } else {
                $total_comentarios = "<p class=\"t-icono-rojo\"><i class=\"fad fa-comment-alt-times\"></i></p>";
            }

            if ($total_adjuntos >= 1) {
                $total_adjuntos = "<p class=\"t-normal\">$total_adjuntos</p>";
            } else {
                $total_adjuntos = "<p class=\"t-icono-rojo\"><i class=\"fad fa-file-minus\"></i></p> ";
            }


            $data .= "
                <div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">
                    <div class=\"column is-half\" onclick=\"detalleMPNP($id);\">
                        <div class=\"columns\">
                            <div class=\"column\">
                                <div class=\"message is-small is-success\">
                                    <p class=\"message-body\"><strong>$titulo</strong>
                                        <span class=\"\">
                                            <i class=\"fad fa-user-circle mx-2 fa-lg\"></i>
                                            $creadoPor
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=\"column\">
                        <div class=\"columns is-gapless\">
                            <div class=\"column t-small t-normal\" onclick=\"detalleMPNP($id);\">
                                $actividades
                            </div>
                            <div class=\"column t-small t-normal\" onclick=\"detalleMPNP($id);\">
                                $responsable_nombre
                            </div>
                            <div class=\"column t-small t-normal\">
                                $fecha
                            </div>
                            <div class=\"column t-small t-normal\" onclick=\"adjuntosMPNP($id); showModal('modal-equipo-pictures');\">
                                $total_adjuntos
                            </div>
                            <div class=\"column t-small t-normal\" onclick=\"showModal('modal-equipo-comentarios'); comentariosMPNP($id, 'colComentariosEquipoMCMP')\">
                                $total_comentarios
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
        echo $data;
    }


    if ($action == "comentariosMPNP") {
        $idMPNP = $_POST['idMPNP'];
        $dataComentarios = "";
        $query = "SELECT
        comentarios_mp_np.id, comentarios_mp_np.id_usuario, comentarios_mp_np.comentario, comentarios_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido
        FROM comentarios_mp_np
        INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE comentarios_mp_np.id_mp_np = $idMPNP AND comentarios_mp_np.activo = 1
        ORDER BY comentarios_mp_np.id DESC";
        $result = mysqli_query($conn_2020, $query);

        // Cabecera para el diseño del modal.
        $dataComentarios .= "
            <div class=\"timeline is-left\">
                <h4 class=\"subtitle is-4 has-text-centered\">Comentarios Generales</h4>
                <div class=\"columns is-centered\">
                    <div class=\"column is-8\">
                        <div class=\"field\">
                            <p class=\"control has-icons-right\">
                                <input id=\"inputComentarioMPNP\" class=\"input\" type=\"text\" placeholder=\"Añadir comentario\" onkeyup=\"if(event.keyCode == 13) agregarComentarioMPNP($idMPNP);\" autocomplete=\"off\" maxlength=\"150\">

                                <span class=\"icon is-small is-right\">
                                    <i class=\"fad fa-comment-alt-medical\"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
        ";

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                // Variables para los comentarios.
                $idComentario = $row['id'];
                $usuario = $row['nombre'] . " " . $row['apellido'];
                $fecha = new DateTime($row['fecha']);
                $fecha = $fecha->format('Y-m-d H:m:s');
                $comentario = $row['comentario'];

                // Data de los comentarios
                $dataComentarios .=
                    "
                    <div class=\"timeline-item mb-0\">
                        <div class=\"timeline-marker\"></div>
                        <div class=\"timeline-content\">
                            <p class=\"heading \">
                                <strong>$usuario</strong>
                                <a class=\"delete has-text-success\" onclick=\"eliminarComentarioMPNP($idComentario, $idMPNP);\"></a>
                            </p>
                            <p class=\"heading has-text-info\">$fecha</p>
                            <p class=\"has-text-justified\">
                                $comentario
                            </p>
                        </div>
                    </div>
                ";
            }
        }

        // Footer de los Comentarios
        $dataComentarios .= "
                <div class=\"timeline-item \">
                    <div class=\"timeline-marker\"></div>
                </div>

                <div class=\"timeline-item\">
                    <div class=\"timeline-marker is-icon\">
                        <i class=\"fad fa-genderless\"></i>
                    </div>
                </div>
            </div>
        ";
        echo $dataComentarios;
    }


    if ($action == "agregarComentarioMPNP") {
        $idMPNP = $_POST['idMPNP'];
        $idUsuario = $_SESSION['usuario'];
        $comentario = $_POST['comentario'];
        $fecha = date('Y-m-d H:m:s');

        $query = "INSERT INTO comentarios_mp_np(id_mp_np, id_usuario, comentario, fecha)
        VALUES($idMPNP, $idUsuario, '$comentario', '$fecha')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo $result;
        } else {
            echo $result;
        }
    }


    if ($action == "eliminarComentarioMPNP") {
        $idComentario = $_POST['idComentario'];

        $query = "UPDATE comentarios_mp_np SET activo = 0 WHERE id = $idComentario";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "Comentario Eliminado.";
        } else {
            echo "Error al Eliminar Comentario";
        }
    }


    if ($action == "adjuntosMPNP") {
        $idMPNP = $_POST['idMPNP'];
        $dataAdjuntos = "";

        $query = "SELECT
        adjuntos_mp_np.id_usuario, adjuntos_mp_np.fecha, adjuntos_mp_np.url, adjuntos_mp_np.id, t_colaboradores.nombre, t_colaboradores.apellido
        FROM adjuntos_mp_np
        INNER JOIN t_users ON adjuntos_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE adjuntos_mp_np.id_mp_np = $idMPNP AND adjuntos_mp_np.activo = 1";
        $result = mysqli_query($conn_2020, $query);

        // Header.
        $dataAdjuntos .=
            "
            <div class=\"timeline is-left\">
                <h4 class=\"title is-4 has-text-centered\">Adjuntos MP</h4>
                <div class=\"columns is-centered\">
                    <div class=\"column is-8 has-text-centered\">
                        <a class=\"button is-success\">
                            <input class=\"file-input\" type=\"file\"
                                name=\"resume\" id=\"inputAdjuntoMPNP\" multiple=\"\" onchange=\"cargarAdjuntoMPNP($idMPNP);\">
                            <span class=\"icon\">
                                <i class=\"fad fa-file-archive\"></i>
                            </span>
                            <span>Añadir Adjuntos</span>
                        </a>
                    </div>
                </div>
        ";

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $usuario = $row['nombre'] . " " . $row['apellido'];
                $fecha = new DateTime($row['fecha']);
                $fecha = $fecha->format('Y-m-d H:m:s');
                $idImg = $row['id'];
                $url = $row['url'];
                $rutaImg = "img/equipos/mpnp/";

                // Body
                $dataAdjuntos .=
                    "
                    <div class=\"timeline-item\">
                        <div class=\"timeline-marker\"></div>
                        <div class=\"timeline-content\">
                            <p class=\"heading \">
                                <strong>$usuario</strong>
                                <a class=\"delete\" onclick=\"eliminarAdjuntoMPNP($idImg, $idMPNP);\"></a>
                            </p>
                            <p class=\"heading has-text-info\">$fecha</p>
                            <a href=\"$rutaImg$url\" target=\"_blank\">
                                <img src=\"$rutaImg$url\" alt=\"$rutaImg.$url\" width=\"130px\">
                            </a>
                        </div>
                    </div>
                ";
            }
        }

        // Footer
        $dataAdjuntos .=
            "
                <div class=\"timeline-item flex\">
                    <div class=\"timeline-marker\"></div>
                </div>
                <div class=\"timeline-item\">
                    <div class=\"timeline-marker is-icon\">
                        <i class=\"fad fa-genderless\"></i>
                    </div>
                </div>
            </div>
        ";
        echo $dataAdjuntos;
    }


    if ($action == "eliminarAdjuntoMPNP") {
        $idImg = $_POST['idImg'];
        $query = "UPDATE adjuntos_mp_np SET activo = 0 WHERE id = $idImg";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo "Adjunto Eliminado.";
        } else {
            echo "Adjunto NO Eliminado.";
        }
    }


    if ($action == "consultaTituloMPNP") {
        $idMPNP = $_POST['idMPNP'];

        $query = "SELECT titulo FROM t_mp_np WHERE id = $idMPNP";
        $result = mysqli_query($conn_2020, $query);

        if ($row = mysqli_fetch_array($result)) {
            $titulo = $row['titulo'];
            echo $titulo;
        } else {
            echo "Error al Cargar Datos";
        }
    }

    if ($action == "zonaMC") {
        $idMC = $_POST['idMC'];
        $zona = $_POST['zona'];

        $query = "UPDATE t_mc SET zona = '$zona' WHERE id = $idMC";

        if ($result = mysqli_query($conn_2020, $query)) {
            echo "Zona Seleccionada";
        } else {
            echo "ERROR, Zona Seleccionada";
        }
    }


    // Elimina la cotización agregada a un Equipo en Planner.
    if ($action == "eliminarCotEquipo") {
        $idCot = $_POST['idCot'];
        $nombreCot = $_POST['nombreCot'];
        $query = "UPDATE t_equipos_cotizaciones SET activo = 0";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo "Cotización Eliminada ($nombreCot)";
        } else {
            echo "Error al Eliminar Cotización ($nombreCot)";
        }
    }


    if ($action == "obtTareasP") {
        $statusTarea = $_POST['status'];
        $idDestino = $_SESSION['idDestino'];
        $data = array();
        $dataTareas = "";
        $idEquipo = $_POST['idEquipo'];
        $equipo = $_POST['equipo'];
        $btnFinalizar = "";
        $btnRestaurar = "";
        $idActividad = "";
        $query = "SELECT c_secciones.seccion, t_equipos.equipo  
        FROM t_equipos
        INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
        WHERE t_equipos.id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $seccion = $i['seccion'];
                $equipo = $i['equipo'];

                $data['seccion'] = $seccion;
                $data['equipo'] = $equipo;
            }
        }

        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.responsable, t_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido, t_mp_np.status_urgente, t_mp_np.status_material, t_mp_np.status_trabajando,
        t_mp_np.energetico_electricidad, t_mp_np.energetico_agua, t_mp_np.energetico_diesel, 
        t_mp_np.energetico_gas, t_mp_np.departamento_calidad, t_mp_np.departamento_compras, 
        t_mp_np.departamento_direccion, t_mp_np.departamento_finanzas, t_mp_np.departamento_rrhh
        FROM t_mp_np 
        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.id_equipo = $idEquipo AND t_mp_np.activo = 1 AND t_mp_np.status = '$statusTarea'";
        if ($result = mysqli_query($conn_2020, $query)) {
            if ($statusTarea == "F") {
                $statusTarea = "disabled";
            } else {
                $statusTarea = "";
            }
            foreach ($result as $i) {
                $idTareaP = $i['id'];
                $titulo = $i['titulo'];
                $nombreCompleto = $i['nombre'] . " " . $i['apellido'];
                $idResponsable = $i['responsable'];
                $idResponsable = explode(',', $idResponsable);
                $fechaCreado = (new DateTime($i['fecha']))->format('d-m-Y');
                $sUrgente = $i['status_urgente'];
                $sMaterial = $i['status_material'];
                $sTrabajando = $i['status_trabajando'];
                $eElectricidad = $i['energetico_electricidad'];
                $eAgua = $i['energetico_agua'];
                $eDiesel = $i['energetico_diesel'];
                $eGas = $i['energetico_gas'];
                $dCalidad = $i['departamento_calidad'];
                $dCompras = $i['departamento_compras'];
                $dDireccion = $i['departamento_direccion'];
                $dFinanzas = $i['departamento_finanzas'];
                $dRRHH = $i['departamento_rrhh'];

                // Default
                $responsable = "<i class=\"fad fa-minus has-text-danger fa-2x\"></i>";


                // Obtiene el responsable asignado.
                foreach ($idResponsable as $value) {
                    if ($value != "") {
                        $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                        FROM t_users 
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                        WHERE t_users.id= $value";
                        if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                            foreach ($resultResponsable as $i) {
                                $responsable = $i['nombre'] . " " . $i['apellido'];
                            }
                        }
                    }
                }

                // Obtiene el Numero de Comentarios.
                $queryComentario = "SELECT count(id) FROM comentarios_mp_np WHERE id_mp_np = $idTareaP AND activo = 1";
                if ($resultComentario = mysqli_query($conn_2020, $queryComentario)) {
                    foreach ($resultComentario as $i) {
                        $totalComentario = $i['count(id)'];
                    }
                }

                if ($totalComentario == 0 || $totalComentario == "") {
                    $totalComentario = "<i class=\"fad fa-minus has-text-danger fa-2x\"></i>";
                } else {
                    $totalComentario = $totalComentario;
                }

                // Obtiene el Numero de Adjuntos.
                $queryAdjuntos = "SELECT count(id) FROM adjuntos_mp_np WHERE id_mp_np = $idTareaP AND activo = 1";
                if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {
                    foreach ($resultAdjuntos as $i) {
                        $totalAdjuntos = $i['count(id)'];
                    }
                }

                if ($totalAdjuntos == 0 || $totalAdjuntos == "") {
                    $totalAdjuntos = "<i class=\"fad fa-minus has-text-danger fa-2x\"></i>";
                } else {
                    $totalAdjuntos = $totalAdjuntos;
                }


                // Status Principales
                if ($sUrgente == 1) {
                    $sUrgente = "<span><i class=\"has-text-danger fad fa-siren-on mr-2 fa-lg animated infinite flash\"></i></span>";
                } else {
                    $sUrgente = "";
                }

                if ($sMaterial == 1) {
                    $sMaterial = "<span class=\"fa-lg\"><strong>M</strong></span>";
                } else {
                    $sMaterial = "";
                }

                if ($sTrabajando == 1) {
                    $sTrabajando = "<span class=\"fa-lg\"><strong class=\"has-text-info bold\">T</strong></span>";
                } else {
                    $sTrabajando = "";
                }

                if ($dCalidad == 1 || $dCompras == 1 || $dDireccion == 1 || $dFinanzas == 1 || $dRRHH == 1) {
                    $statusDepartamento = "<span class=\"fa-lg\"><strong class=\"has-text-primary\">D</strong></span>";
                } else {
                    $statusDepartamento = "";
                }

                if ($eElectricidad == 1 || $eAgua == 1 || $eDiesel == 1 || $eGas == 1) {
                    $statusEnergetico = "<span class=\"fa-lg\"><strong class=\"has-text-warning\">E</strong></span>";
                } else {
                    $statusEnergetico = "";
                }

                // Cuando Ningun status esta activo
                if (
                    $sMaterial == "" and $sTrabajando == "" and $statusEnergetico == "" and
                    $statusDepartamento == ""
                ) {
                    $status = "<i class=\"fad fa-exclamation-circle has-text-info fa-2x\"></i>";
                } else {
                    $status = "";
                }

                // Tarea
                $dataTareas .= "
                    <div class=\"columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2\">
                        <div class=\"column is-half\">
                            <div class=\"columns\">
                                <div class=\"column\">
                                <div class=\"is-small is-success\">
                                
                                        <p class=\"message-body\"> $sUrgente <strong> $titulo</strong>
                                            <span class=\"\">
                                                <i class=\"fad fa-user-circle mx-2 fa-lg\"></i>
                                                $nombreCompleto
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"column\">
                            <div class=\"columns is-gapless\">
                                
                                <div class=\"column is-small t-normal\" 
                                onclick=\"obtUsuariosTareasP($idTareaP, $idEquipo, '$equipo');\">
                                    <p class=\"t-normal\">$responsable</p>
                                </div>
                               
                                <div class=\"column is-small t-normal\">
                                    <p class=\"t-normal\">$fechaCreado</p>
                                </div>
                                
                                <div class=\"column is-small t-normal\" onclick=\"adjuntosTareas($idTareaP, $idEquipo, '$equipo')\">
                                    <p class=\"t-normal\">$totalAdjuntos</p>
                                </div>

                                <div class=\"column is-small t-normal\" onclick=\"obtComentariosTarea($idEquipo, '$equipo', '$idTareaP', '" . preg_replace('([^A-Za-z0-9 ])', '', $titulo) . "');\">
                                    <p class=\"t-normal\">$totalComentario</p>
                                </div>

                                <div class=\"column is-small t-normal\" 
                                onclick=\"obtStatusActvidadTareaP($idTareaP, '" . preg_replace('([^A-Za-z0-9 ])', '', $titulo) . "' , $idEquipo, '$equipo');\">
                                    <p class=\"p-3\"> 
                                    $status $sMaterial $sTrabajando $statusEnergetico $statusDepartamento
                                    </p>
                                </div>
                                
                                <div class=\"column is-small t-normal\">
                                    <p class=\"t-normal\">N/A</p>
                                </div>

                            </div>
                        </div>
                    </div>
                ";
            }
            $data['dataTareas'] = $dataTareas;
        }
        echo json_encode($data);
    }


    if ($action == "agregarTareaP") {
        $idUsuario = $_SESSION['usuario'];
        $idDestino = $_SESSION['idDestino'];
        $titulo = $_POST['titulo'];
        $idEquipo = $_POST['idEquipo'];
        $fecha = date('Y-m-d H:m:s');

        $query = "INSERT INTO t_mp_np(id_equipo, id_usuario, id_destino, titulo, fecha, status ) VALUES($idEquipo, $idUsuario, $idDestino, '$titulo', '$fecha', 'P')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if ($action == "agregarActividadTareaP") {
        $idUsuario = $_SESSION['usuario'];
        $fecha = date('Y-m-d H:m:s');
        $idTareaP = $_POST['idTareaP'];
        $actividad = $_POST['actividad'];

        $query = "INSERT INTO actividad_mp_np(id_mp_np, actividad, creado_por, fecha) 
        VALUES($idTareaP, '$actividad', $idUsuario, '$fecha')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if ($action == "agregarComentarioActividad") {
        $idUsuario = $_SESSION['usuario'];
        $fecha = date('Y-m-d H:m:s');
        $idActividad = $_POST['idActividad'];
        $idTareaP = $_POST['idTareaP'];
        $comentario = $_POST['comentario'];
        $query = "INSERT INTO comentarios_mp_np(id_mp_np, id_actividad, id_usuario, comentario, fecha) VALUES($idTareaP, $idActividad, $idUsuario, '$comentario', '$fecha')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    if ($action == "obtenerComentarioActividad") {
        $idActividad = $_POST['idActividad'];
        $idTareaP = $_POST['idTareaP'];
        $query = "SELECT comentarios_mp_np.comentario, comentarios_mp_np.fecha, 
        t_colaboradores.nombre, t_colaboradores.apellido 
        FROM comentarios_mp_np 
        INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE comentarios_mp_np.id_mp_np = $idTareaP AND comentarios_mp_np.id_actividad = $idActividad AND comentarios_mp_np.activo = 1
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $nombreCompleto = $i['nombre'] . " " . $i['apellido'];
                $fecha = (new DateTime($i['fecha']))->format('d-m-Y');
                $comentario = $i['comentario'];

                echo "
                    <div class=\"timeline is-centered\"><div class=\"timeline-item p-0 pb-1\">
                        <div class=\"timeline-marker\"></div>
                        <div class=\"timeline-content\">
                            <p class=\"heading \"><strong>$nombreCompleto</strong></p>
                            <p class=\"heading \">$fecha</p>
                            <p class=\"has-text-justified p-1 has-background-white-bis rounded text-wrap border border-light has-text-weight-light\">$comentario</p>
                        </div>
                    </div>
                ";
            }
            echo "
                <div class=\"timeline-item\">
                    <div class=\"timeline-marker is-icon\">
                        <i class=\"fad fa-genderless\"></i>
                    </div>
                </div>            
            ";
        }
    }

    if ($action == "obtUsuariosTareasP") {
        $idEquipo = $_POST['idEquipo'];
        $equipo = $_POST['equipo'];
        $idTareaP = $_POST['idTareaP'];
        $idDestino = $_SESSION['idDestino'];
        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' AND (t_users.id_destino = $idDestino OR t_users.id_destino = 10)
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idUsuario = $i['id'];
                $nombreCompleto = $i['nombre'] . " " . $i['apellido'];
                echo "
                <h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"asignarResponsableTareasP($idTareaP, $idUsuario, $idEquipo, '$equipo')\">
                <span>
                <svg class=\"svg-inline--fa fa-user fa-w-14\" aria-hidden=\"true\" data-prefix=\"fas\" data-icon=\"user\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 448 512\" data-fa-i2svg=\"\">
                <path fill=\"currentColor\" d=\"M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z\"></path></svg><!-- <i class=\"fas fa-user\"></i> --></span> $nombreCompleto
                </h6>
                
                ";
            }
        }
    }

    if ($action == "asignarUsuarioTareasP") {
        $idTareaP = $_POST['idTarea'];
        $idUsuario = $_POST['idUsuario'];
        $query = "UPDATE t_mp_np SET responsable = $idUsuario WHERE id = $idTareaP";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    if ($action == "aplicarCambioActividad") {
        $idTareaP = $_POST['idTareaP'];
        $columna = $_POST['columna'];
        $nuevoTitulo = $_POST['nuevoTitulo'];
        $fechaActual = date('Y-m-d H:m:s');
        $codigoSeguimiento = $_POST['codigoSeguimiento'];

        if ($columna == "status_urgente" || $columna == "status_trabajando" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
            $query = "SELECT $columna FROM t_mp_np WHERE id = $idTareaP";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $valor = $i[$columna];
                    if ($valor == "0") {
                        $nuevoValor = "1";
                    } else {
                        $nuevoValor = "0";
                    }
                }
                $query = "UPDATE t_mp_np SET $columna = '$nuevoValor', fecha_finalizado = '$fechaActual' WHERE id = $idTareaP";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        } elseif ($columna == "titulo") {
            $query = "UPDATE t_mp_np SET titulo = '$nuevoTitulo' WHERE id = $idTareaP";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 2;
            } else {
                echo 0;
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mp_np SET activo = 0 WHERE id = $idTareaP";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 3;
            } else {
                echo 0;
            }
        } elseif ($columna == "statusP") {
            $query = "UPDATE t_mp_np SET status = 'F', fecha_finalizado = '$fechaActual' WHERE id = $idTareaP";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 4;
            } else {
                echo 0;
            }
        } elseif ($columna == "statusF") {
            $query = "UPDATE t_mp_np SET status = 'P' WHERE id = $idTareaP";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 5;
            } else {
                echo 0;
            }
        } elseif ($columna == "status_material") {
            if ($codigoSeguimiento != "") {
                $query = "UPDATE t_mp_np SET status_material ='1', cod2bend = '$codigoSeguimiento' WHERE id = $idTareaP";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 6;
                }
            } else {
                $query = "UPDATE t_mp_np SET status_material ='0' WHERE id = $idTareaP";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 7;
                }
            }
        }
    }


    if ($action == "consultarCodigoSeguimientoTareaas") {
        $idTareaP = $_POST['idTareaP'];
        $codsap = "";
        $query = "SELECT codsap FROM t_mp_np WHERE id = $idTareaP";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $codsap = $i['codsap'];
            }
            echo $codsap;
        }
    }

    if ($action == "finalizarTareaP") {
        $idTarea = $_POST['idTarea'];
        $status = $_POST['status'];
        $query = "UPDATE t_mp_np SET status = '$status' WHERE id = $idTarea";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    if ($action == "actualizarTarea") {
        $columna = $_POST['columna'];
        $idTarea = $_POST['idTarea'];
        $titulo = $_POST['titulo'];

        if ($columna == "titulo") {
            $query = "UPDATE t_mp_np SET titulo = '$titulo' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
            } else {
                echo 0;
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mp_np SET activo = 0 WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 2;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }


    if ($action == "adjuntosTareas") {
        $dataAdjuntos = "";
        $idTareas = $_POST['idTareas'];
        $idEquipo = $_POST['idEquipo'];
        $equipo = $_POST['equipo'];

        $query = "SELECT
        adjuntos_mp_np.id_usuario, adjuntos_mp_np.fecha, adjuntos_mp_np.url, adjuntos_mp_np.id, t_colaboradores.nombre, t_colaboradores.apellido
        FROM adjuntos_mp_np
        INNER JOIN t_users ON adjuntos_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE adjuntos_mp_np.id_mp_np = $idTareas AND adjuntos_mp_np.activo = 1";
        $result = mysqli_query($conn_2020, $query);

        // Header.
        $dataAdjuntos .=
            "
            <div class=\"timeline is-left\">
                <h4 class=\"title is-4 has-text-centered\">Adjuntos MP</h4>
                <div class=\"columns is-centered\">
                    <div class=\"column is-8 has-text-centered\">
                        <a class=\"button is-success\">
                            <input class=\"file-input\" type=\"file\"
                                name=\"resume\" id=\"inputAdjuntoTarea\" multiple=\"\" onchange=\"cargarAdjuntoTarea($idTareas, $idEquipo, '$equipo');\">
                            <span class=\"icon\">
                                <i class=\"fad fa-file-archive\"></i>
                            </span>
                            <span>Añadir Adjuntos</span>
                        </a>
                    </div>
                </div>
        ";

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $usuario = $row['nombre'] . " " . $row['apellido'];
                $fecha = new DateTime($row['fecha']);
                $fecha = $fecha->format('Y-m-d H:m:s');
                $idImg = $row['id'];
                $url = $row['url'];
                $rutaImg = "img/equipos/mpnp/";

                // Body
                $dataAdjuntos .=
                    "
                    <div class=\"timeline-item\">
                        <div class=\"timeline-marker\"></div>
                        <div class=\"timeline-content\">
                            <p class=\"heading \">
                                <strong>$usuario</strong>
                                <a class=\"delete\" onclick=\"eliminarAdjuntoTarea($idImg, $idTareas, $idEquipo, '$equipo');\"></a>
                            </p>
                            <p class=\"heading has-text-info\">$fecha</p>
                            <a href=\"$rutaImg$url\" target=\"_blank\">
                                <img src=\"$rutaImg$url\" alt=\"$rutaImg.$url\" width=\"130px\">
                            </a>
                        </div>
                    </div>
                ";
            }
        }

        // Footer
        $dataAdjuntos .=
            "
                <div class=\"timeline-item flex\">
                    <div class=\"timeline-marker\"></div>
                </div>
                <div class=\"timeline-item\">
                    <div class=\"timeline-marker is-icon\">
                        <i class=\"fad fa-genderless\"></i>
                    </div>
                </div>
            </div>
        ";
        echo $dataAdjuntos;
    }


    if ($action == "obtComentariosTarea") {
        $data = array();
        $dataComentarios = "";
        $idTareaP = $_POST['idTareaP'];
        $idEquipo = $_POST['idEquipo'];
        $titulo = $_POST['titulo'];
        $equipo = $_POST['equipo'];


        $query = "SELECT t_equipos.equipo, c_secciones.seccion
        FROM t_equipos 
        INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id 
        WHERE t_equipos.id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $equipo = $i['equipo'];
                $seccion = $i['seccion'];
                $estiloSeccion = strtolower($seccion);

                $dataHeaderComentario = "
                    <div class=\"navbar-start has-text-centered\">
                        <div class=\"navbar-item $estiloSeccion" . "-background\">
                            <p class=\"seccion-logo\">$seccion</p>
                        </div>
                        <a class=\"navbar-item\">$equipo / $titulo / 
                        <strong class=\"ml-1\"> COMENTARIOS</strong></a>
                    </div>    
                ";
            }
            $data['dataHeaderComentario'] = $dataHeaderComentario;
        }




        $query = "SELECT comentarios_mp_np.id, comentarios_mp_np.comentario, comentarios_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido
        FROM comentarios_mp_np 
        INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE comentarios_mp_np.id_mp_np = $idTareaP AND comentarios_mp_np.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idComentario = $i['id'];
                $comentario = $i['comentario'];
                $fecha = (new DateTime($i['fecha']))->format('d-m-Y');
                $nombreCompleto = $i['nombre'] . " " . $i['apellido'];

                $dataComentarios .= "
                    <div class=\"timeline-item\">
                        <div class=\"timeline-marker\"></div>
                        <div class=\"timeline-content\">
                            <p class=\"heading \"><strong>$nombreCompleto</strong> 
                            <a class=\"delete\" onclick=\"eliminarComentarioTarea($idComentario, $idEquipo, '$equipo', $idTareaP, '$titulo')\"></a></p>
                            <p class=\"heading \">$fecha</p>
                            <p class=\"has-text-justified\">
                            $comentario
                            </p>
                        </div>
                    </div>            
                ";
            }
            $dataComentarios .= "
                        <div class=\"timeline-item\">
                <div class=\"timeline-marker is-icon\">
                    <i class=\"fad fa-genderless\"></i>
                </div>
            </div> 
            ";

            $data['dataComentarios'] = $dataComentarios;
        }
        echo json_encode($data);
    }


    if ($action == "consultaCodigoSeguimientoMC") {
        $idMC = $_POST['idMC'];
        $codigoSeguimiento = "";

        $query = "SELECT cod2bend FROM t_mc WHERE id = $idMC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $codigoSeguimiento = $i['cod2bend'];
            }
            echo $codigoSeguimiento;
        }
    }

    if ($action == "statusMaterialesMC") {
        $idMC = $_POST['idMC'];
        $codigoSeguimiento = $_POST['codigoSeguimiento'];

        if ($codigoSeguimiento == "") {
            $query = "UPDATE t_mc SET status_material = '', cod2bend = '' WHERE id = $idMC";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
            }
        } else {
            $query = "UPDATE t_mc SET status_material = '<span class=\"tag is-dark fa-lg\">M</span>', cod2bend = '$codigoSeguimiento' WHERE id = $idMC";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 2;
            }
        }
    }


    //Cierre de IF para action.
}



// Codigo para Subir Archivos.
if (!empty($_FILES)) {
    $nombre_temporal = $_FILES['archivo']['tmp_name'];
    $nombre = $_FILES['archivo']['name'];
    $texto = preg_replace('([^A-Za-z0-9 .])', '', $nombre);
    $idGeneral = $_POST['idGeneral'];
    move_uploaded_file($nombre_temporal, '../planner/proyectos/' . $idGeneral . '_' . $texto);
}