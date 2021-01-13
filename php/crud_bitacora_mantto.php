<?php
date_default_timezone_set("America/Cancun");
session_start();

include 'conexion.php';


if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $arrayDestino = array(0 => "NA", 1 => "RM", 7 => "CMU", 2 => "PVR", 6 => "MBJ", 5 => "PUJ", 11 => "CAP", 3 => "SDQ", 4 => "SSA", 10 => "AME");

    // Variables Globales de la Sessión del Usuario al iniciar.
    $idUsuario = $_SESSION["usuario"];
    $idDestino = $_SESSION["idDestino"];

    // Variables Generales.
    if (isset($_POST['idDestino'])) {
        $idDestino = $_POST['idDestino'];
        $idDestinoSeleccionado = $_POST['idDestino'];
    }


    if (isset($_POST['zona'])) {
        $zona = $_POST['zona'];
    }


    // Proceso para calcular rango de fecha seleccionada.
    if (isset($_POST['dateGeneral'])) {
        $fecha = $_POST['dateGeneral'];
        $fecha = new DateTime($fecha);
        $fecha = $fecha->format('Y-m-d');

        if ($fecha != "") {
            $fechaDia = date("$fecha 06:00:00");
        } else {
            $fecha = date("Y-m-d");
            $fechaDia = date("Y-m-d H:m:s");
        }

        $fecha_seleccionada = new DateTime($fecha);

        $fecha_inicial = $fecha_seleccionada->add(new DateInterval('PT7H00S'));
        $fecha_inicial_12 = $fecha_inicial->format('Y-m-d 19:00:00');
        $fecha_inicial = $fecha_inicial->format('Y-m-d H:i:s');

        $fecha_final = $fecha_seleccionada->sub(new DateInterval('PT24H00S'));
        $fecha_final_12 = $fecha_final->format('Y-m-d 19:00:00');
        $fecha_final = $fecha_final->format('Y-m-d H:i:s');


        //  FECHA DE 6 DÍAS ANTERIORES MÁS EL DÍA SELECCIONADO, DONDE FECHA_0 ES MAYOR QUE FECHA_7, OCUPAL LA BARIBALE DONDE SE ASIGNA EL (FORMAT).

        // FECHA_PRINCIPAL, ES EL PUNTO DE FECHA DE PARTIDA DE LA FECHA SELECCIONADA, SE MANEJA 24H PORQUE EN LA DB IGUAL SON 24H, SI SE COLOCA 12H NO RECONOCE EL RANGO DE FECHA CON HORARIO ESTABLECIDO.
        $fecha_0 = date("$fecha 19:00:00");
        $fecha_principal = new DateTime($fecha_0);
        $fecha_dia_0 = $fecha_principal->format("w");

        // UN DÍA ANTES
        $fecha_1 = $fecha_principal->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_1 = $fecha_1->format("w");
        $fecha_1 = $fecha_1->format("Y-m-d H:m:s");
        // DOS DÍAS ANTES
        $fecha_2 = new DateTime($fecha_1);
        $fecha_2 = $fecha_2->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_2 = $fecha_2->format("w");
        $fecha_2 = $fecha_2->format("Y-m-d H:m:s");
        // TRES DÍAS ANTES
        $fecha_3 = new DateTime($fecha_2);
        $fecha_3 = $fecha_3->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_3 = $fecha_3->format("w");
        $fecha_3 = $fecha_3->format("Y-m-d H:m:s");
        // CUATRO DÍAS ANTES
        $fecha_4 = new DateTime($fecha_3);
        $fecha_4 = $fecha_4->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_4 = $fecha_4->format("w");
        $fecha_4 = $fecha_4->format("Y-m-d H:m:s");
        // CINCO DÍAS ANTES
        $fecha_5 = new DateTime($fecha_4);
        $fecha_5 = $fecha_5->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_5 = $fecha_5->format("w");
        $fecha_5 = $fecha_5->format("Y-m-d H:m:s");
        // SEIS DÍAS ANTES
        $fecha_6 = new DateTime($fecha_5);
        $fecha_6 = $fecha_6->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_6 = $fecha_6->format("w");
        $fecha_6 = $fecha_6->format("Y-m-d H:m:s");
        // SIETE DÍAS ANTES
        $fecha_7 = new DateTime($fecha_6);
        $fecha_7 = $fecha_7->sub(new DateInterval('P0Y0M1DT0H0M0S'));
        $fecha_dia_7 = $fecha_7->format("w");
        $fecha_7 = $fecha_7->format("Y-m-d H:m:s");

        // ARRAY PARA BUSCAR EL DÍA DE LA SEMANA SEGUN LA POSICIÓN DE FECHA, DONDE 0 ES LUNES Y 6 ES DOMINGO, LA VAIRBALE $FEHCA_DIA_X OBTINE EL NUMERO PARA BUSCAR EL DIA EN EL ARRAY. POR EJEMPLO: $ARRAYSEMANA($FEHCA_DIA_X) -> OBTIENE: lUNES.
        $arraySemana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        // $arraySemana = array("Sábado", "Viernes", "Jueves", "Miércoles", "Martes", "Lunes", "Domingo"); 

        $dia_1 = $arraySemana[$fecha_dia_6];
        $dia_2 = $arraySemana[$fecha_dia_5];
        $dia_3 = $arraySemana[$fecha_dia_4];
        $dia_4 = $arraySemana[$fecha_dia_3];
        $dia_5 = $arraySemana[$fecha_dia_2];
        $dia_6 = $arraySemana[$fecha_dia_1];
        $dia_7 = $arraySemana[$fecha_dia_0];

        $arrayDia = array("$dia_1", "$dia_2", "$dia_3", "$dia_4", "$dia_5", "$dia_6", "$dia_7");
        $arrayFecha = array($fecha_0, $fecha_1, $fecha_2, $fecha_3, $fecha_4, $fecha_5, $fecha_6);
        $arrayFecha_1 = array($fecha_1, $fecha_2, $fecha_3, $fecha_4, $fecha_5, $fecha_6, $fecha_7);
        $arrayTotal = array($fecha_6 => $fecha_7, $fecha_5 => $fecha_6, $fecha_4 => $fecha_5, $fecha_3 => $fecha_4, $fecha_2 => $fecha_3, $fecha_1 => $fecha_2,  $fecha_0 => $fecha_1);
    }



    if ($action == "bitacoraPersonal") {
        // Variables enviadas desde PlannerJS por AJAX.
        $idTurno = $_POST['turnoSeleccionado'];
        $idGremio = $_POST['gremio'];
        $cantidadPorGremio = $_POST['cantidadPorGremio'];
        $idDestino = $_POST['idDestino'];
        $totalPlantillaPorTurno = $_POST['totalPlantillaPorTurno'];
        $zona = $_POST['zona'];

        if ($idDestino != 10) {
            $destino = "id_destino = $idDestino AND";
        } else {
            $destino = "";
        }

        $query_total_plantilla = "SELECT* FROM bitacora_personal_total WHERE $destino id_turno = $idTurno AND fecha BETWEEN '$fecha_final' AND '$fecha_inicial' AND zona='$zona'";
        $result_total_plantilla = mysqli_query($conn_2020, $query_total_plantilla);

        if (mysqli_num_rows($result_total_plantilla) != 0) {
            $query_total_plantilla_1 = "UPDATE bitacora_personal_total SET total_turno=$totalPlantillaPorTurno 
            WHERE id_destino = $idDestino AND id_turno = $idTurno AND zona = '$zona'";
            $result_total_plantilla_1 = mysqli_query($conn_2020, $query_total_plantilla_1);
            if ($result_total_plantilla_1) {
                echo "Total Atualizada!";
            } else {
                echo "Error al Actualizar Total!";
            }
        } else {
            $query_total_plantilla_2 = "INSERT INTO bitacora_personal_total(id_destino, id_turno, zona, total_turno, fecha) VALUES ($idDestino, $idTurno, '$zona', $totalPlantillaPorTurno, '$fechaDia')";
            $result_total_plantilla_2 = mysqli_query($conn_2020, $query_total_plantilla_2);
            if ($result_total_plantilla_2) {
                echo "Total Ingresado!" . $fechaDia . "--";
            } else {
                echo "Error al Ingresar Total!";
            }
        }

        $query = "INSERT INTO bitacora_personal(capturado_por, id_destino, id_turno, id_gremio, zona, cantidad_personal_gremio, fecha) VALUES ($idUsuario, $idDestino, $idTurno, $idGremio, '$zona', $cantidadPorGremio, '$fechaDia')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Captura completa" . $idUsuario . " - " . $fechaDia;
        } else {
            echo "Error de Captura" . mysqli_errno($result) . $idUsuario;
        }
    }


    if ($action == "consultaGremiocantidad") {
        $data = array();
        $gremioCantidad = "";
        $idTurno = $_POST['turnoSeleccionado'];
        $idDestino = $_POST['idDestino'];
        $fechaGeneral = $_POST['dateGeneral'];
        $zona = $_POST['zona'];
        if ($idDestino != 10) {
            $destino =  "bitacora_personal.id_destino = $idDestino AND";
        } else {
            $destino = "";
        }

        $query = "SELECT 
        bitacora_personal.id, 
        bitacora_personal.cantidad_personal_gremio,
        bitacora_gremio.nombre_gremio
        FROM bitacora_personal
        INNER JOIN bitacora_gremio ON bitacora_personal.id_gremio = bitacora_gremio.id
        WHERE $destino bitacora_personal.id_turno = $idTurno AND zona='$zona' 
        AND bitacora_personal.activo =1
        -- AND bitacora_personal.fecha BETWEEN  '$fecha_inicial' AND '$fecha_final'
        AND bitacora_personal.fecha BETWEEN  '$fecha_final' AND '$fecha_inicial'
        ORDER BY bitacora_personal.fecha DESC
        ";

        if ($result = mysqli_query($conn_2020, $query)) {

            $query_total_plantilla = "SELECT total_turno FROM bitacora_personal_total WHERE id_destino = $idDestino AND id_turno = $idTurno AND fecha BETWEEN '$fecha_final' AND '$fecha_inicial' AND zona='$zona'";
            if ($resultTotal = mysqli_query($conn_2020, $query_total_plantilla)) {
                foreach ($resultTotal as $value) {
                    $data['cantidadTurno'] = $value['total_turno'];
                }
            } else {
                $data['cantidadTurno'] = 0;
            }

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $id = $row['id'];
                    $cantidad = $row['cantidad_personal_gremio'];
                    $nombreGremio = $row['nombre_gremio'];

                    $gremioCantidad .= "<h1 class=\"font-semibold text-xl text-gray-500 my-2\"><span>$cantidad</span> $nombreGremio <span><i class=\"fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarItemPersonal('bitacora_personal',$id,'modal-personal');\"></i></span></h1>";
                }
            } else {
                $gremioCantidad = "<h1 class=\"font-semibold text-xl text-gray-500 my-2\"><span></span> Sin Datos <span><i class=\"fad fa-times-circle text-red-400 text-xl\"></i></span></h1>";
            }
            $data['gremioCantidad'] = $gremioCantidad;
        }
        echo json_encode($data);
    }

    // Proceso para eliminar un Item, donde recibe la TABLA y ID del registro a eliminar. 
    // Solo realiza un camio de activo=1 por activo=0, para ocultar el registro.
    if ($action == "eliminarItemPersonal") {
        $tabla = $_POST['tabla'];
        $id = $_POST['id'];

        $query = "UPDATE $tabla SET activo=0 WHERE id=$id";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Registro Eliminado!";
        } else {
            echo "Error de Registro!";
        }
    }


    if ($action == "cantidadTurno") {
        $cantidadTurno_array = array();
        $idDestino = $_POST['idDestino'];
        $fechaGeneral = $_POST['dateGeneral'];
        $zona = $_POST['zona'];
        $cantidadTotal = "";
        if ($idDestino != 10) {
            $destino  = "bitacora_personal.id_destino=$idDestino AND";
        } else {
            $destino = "";
        }

        // Query para cualcular Plantilla Total por turno.
        $query_1 = "SELECT 
        sum(cantidad_personal_gremio),
        sum(total_turno), 
        bitacora_personal_total.total_turno
        FROM bitacora_personal
        INNER JOIN bitacora_personal_total ON bitacora_personal.id_destino = bitacora_personal_total.id_destino 
        AND bitacora_personal.zona = bitacora_personal_total.zona
        WHERE $destino bitacora_personal.id_turno=1 AND bitacora_personal_total.id_turno = 1 AND bitacora_personal.activo = 1 
        AND bitacora_personal.zona = '$zona' 
        AND bitacora_personal.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'
        AND bitacora_personal_total.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'";

        $result_1 = mysqli_query($conn_2020, $query_1);

        if ($row_1 = mysqli_fetch_array($result_1)) {
            $cantidadTurno = $row_1['sum(cantidad_personal_gremio)'];

            $cantidadPlantilla_1 = $cantidadTurno;
            $cantidadPlantillaGlobal_1 = $cantidadTotal;

            if ($idDestino != 10) {
                $cantidadTotal = $row_1['total_turno'];
            } else {
                $cantidadTotal = $row_1['sum(total_turno)'];
            }



            if ($cantidadTurno > 0 && $cantidadTotal > 0) {
                $cantidadTurno_array['total_turno_1_1'] = $cantidadTurno;
                $cantidadTurno_array['total_turno_1_2'] = "" . $cantidadTotal;
            } else {
                $cantidadTurno_array['total_turno_1_1'] = "0 ";
                $cantidadTurno_array['total_turno_1_2'] = "  0$cantidadTotal";
            }
        } else {
            $cantidadTurno_array['total_turno_1_1'] = "0 ";
            $cantidadTurno_array['total_turno_1_2'] = "  0";
        }

        $query_2 = "SELECT 
        sum(cantidad_personal_gremio),
        sum(total_turno), 
        bitacora_personal_total.total_turno
        FROM bitacora_personal
        INNER JOIN bitacora_personal_total ON bitacora_personal.id_destino = bitacora_personal_total.id_destino 
        AND bitacora_personal.zona = bitacora_personal_total.zona
        WHERE $destino bitacora_personal.id_turno=2 AND bitacora_personal_total.id_turno=2 AND bitacora_personal.activo=1
        AND bitacora_personal.zona = '$zona'
        AND bitacora_personal.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'
        AND bitacora_personal_total.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'";

        $result_2 = mysqli_query($conn_2020, $query_2);

        if ($row_2 = mysqli_fetch_array($result_2)) {
            $cantidadTurno = $row_2['sum(cantidad_personal_gremio)'];
            $cantidadTotal = $row_2['sum(total_turno)'];
            $cantidadTotal = $row_2['total_turno'];
            $cantidadPlantilla_2 = $cantidadTurno;
            $cantidadPlantillaGlobal_2 = $cantidadTotal;

            if ($idDestino != 10) {
                $cantidadTotal = $row_2['total_turno'];
            } else {
                $cantidadTotal = $row_2['sum(total_turno)'];
            }


            if ($cantidadTurno > 0 && $cantidadTotal > 0) {
                $cantidadTurno_array['total_turno_2_1'] = $cantidadTurno;
                $cantidadTurno_array['total_turno_2_2'] = "" . $cantidadTotal;
            } else {
                $cantidadTurno_array['total_turno_2_1'] = "0 ";
                $cantidadTurno_array['total_turno_2_2'] = "  0$cantidadTotal";
            }
        } else {
            $cantidadTurno_array['total_turno_2_1'] = "0 ";
            $cantidadTurno_array['total_turno_2_2'] = "  0";
        }

        $query_3 = "SELECT 
        sum(cantidad_personal_gremio),
        sum(total_turno), bitacora_personal_total.total_turno
        FROM bitacora_personal
        INNER JOIN bitacora_personal_total ON bitacora_personal.id_destino = bitacora_personal_total.id_destino
        AND bitacora_personal.zona = bitacora_personal_total.zona 
        WHERE $destino bitacora_personal.id_turno=3 AND bitacora_personal_total.id_turno=3 AND bitacora_personal.activo=1
        AND bitacora_personal.zona = '$zona'
        AND bitacora_personal.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'
        AND bitacora_personal_total.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'";

        $result_3 = mysqli_query($conn_2020, $query_3);

        if ($row_3 = mysqli_fetch_array($result_3)) {
            $cantidadTurno = $row_3['sum(cantidad_personal_gremio)'];
            $cantidadTotal = $row_3['sum(total_turno)'];
            $cantidadTotal = $row_3['total_turno'];
            $cantidadPlantilla_3 = $cantidadTurno;
            $cantidadPlantillaGlobal_3 = $cantidadTotal;

            if ($idDestino != 10) {
                $cantidadTotal = $row_3['total_turno'];
            } else {
                $cantidadTotal = $row_3['sum(total_turno)'];
            }


            if ($cantidadTurno > 0 && $cantidadTotal > 0) {
                $cantidadTurno_array['total_turno_3_1'] = $cantidadTurno;
                $cantidadTurno_array['total_turno_3_2'] = "" . $cantidadTotal;
            } else {
                $cantidadTurno_array['total_turno_3_1'] = "0$cantidadTotal";
                $cantidadTurno_array['total_turno_3_2'] = " 0$cantidadTotal";
            }
        } else {
            $cantidadTurno_array['total_turno_3_1'] = "0 ";
            $cantidadTurno_array['total_turno_3_2'] = " 0";
        }

        // Guarda toda la informacion obtenida para imprimir por id de elementos.
        echo json_encode($cantidadTurno_array);
    }


    if ($action == "graficaGremio") {
        $arrayGremio = array();
        $idDestino = $_POST['idDestino'];
        $fechaGeneral = $_POST['dateGeneral'];
        $zona = $_POST['zona'];
        $labelNombre = "";
        $labelData = "";

        if ($idDestino != 10) {
            $destino = "bitacora_personal.id_destino = $idDestino AND";
        } else {
            $destino = "";
        }

        $query_gremio = "SELECT 
        bitacora_personal.cantidad_personal_gremio,
        bitacora_gremio.nombre_gremio
        FROM bitacora_personal 
        INNER JOIN bitacora_gremio ON bitacora_personal.id_gremio = bitacora_gremio.id
        WHERE $destino bitacora_personal.activo=1 AND zona='$zona'
        AND bitacora_personal.fecha BETWEEN '$fecha_final' AND '$fecha_inicial'
        ";
        $result_gremio = mysqli_query($conn_2020, $query_gremio);
        if ($result_gremio) {
            $arrayGremio['labelNombre'] = "";
            $arrayGremio['labelData'] = "";
            while ($row_gremio = mysqli_fetch_array($result_gremio)) {
                $nombreGremio = $row_gremio['nombre_gremio'];
                $cantidadGremio = $row_gremio['cantidad_personal_gremio'] . ",";

                $labelNombre = $nombreGremio . "," . $labelNombre;
                $labelData = $cantidadGremio . $labelData;
            }
            $arrayGremio['labelNombre'] = "$labelNombre";
            $arrayGremio['labelData'] = "$labelData 0";
        }
        echo json_encode($arrayGremio);
    }


    if ($action == "MPMCPROYECTOS") {
        $fechaGeneral = $_POST['dateGeneral'];
        $MPMCPROYECTOS = array();
        $idDestino = $_POST['idDestino'];
        $zona = $_POST['zona'];
        $bitacoraProyecto = "";
        $bitacoraMC = "";
        $bitacoraMP = "";
        $totalmc = 0;
        $totalmc_2 = 0;
        $ZI = "";
        $GP = "";
        $TRS = "";
        $comentario_mc = "";


        $query_ZI = "
            SELECT c_rel_seccion_subseccion.fase, c_rel_seccion_subseccion.id_subseccion
            FROM c_rel_destino_seccion
            INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
            INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
            INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
            WHERE c_rel_destino_seccion.id_destino = $idDestino AND (c_rel_seccion_subseccion.fase LIKE '%ZI%' OR c_secciones.id = 12)
        ";
        $result_ZI = mysqli_query($conn_2020, $query_ZI);

        while ($row_ZI = mysqli_fetch_array($result_ZI)) {
            $fase = $row_ZI['fase'];
            $idSubseccionZI = $row_ZI['id_subseccion'] . ", ";

            $ZI .= $idSubseccionZI;
        }

        $query_GP = "
            SELECT c_rel_seccion_subseccion.fase, c_rel_seccion_subseccion.id_subseccion
            FROM c_rel_destino_seccion
            INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
            INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
            INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
            WHERE c_rel_destino_seccion.id_destino = $idDestino AND c_rel_seccion_subseccion.fase LIKE '%GP%'
        ";
        $result_GP = mysqli_query($conn_2020, $query_GP);

        while ($row_GP = mysqli_fetch_array($result_GP)) {
            $idSubseccionGP = $row_GP['id_subseccion'] . ", ";

            $GP .= $idSubseccionGP;
        }

        $query_TRS = "
            SELECT c_rel_seccion_subseccion.fase, c_rel_seccion_subseccion.id_subseccion
            FROM c_rel_destino_seccion
            INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
            INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
            INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
            WHERE c_rel_destino_seccion.id_destino = $idDestino AND c_rel_seccion_subseccion.fase LIKE '%TRS%'
        ";
        $result_TRS = mysqli_query($conn_2020, $query_TRS);

        while ($row_TRS = mysqli_fetch_array($result_TRS)) {
            $idSubseccionTRS = $row_TRS['id_subseccion'] . ", ";

            $TRS .= $idSubseccionTRS;
        }

        $ZI .= $ZI . "0";
        $GP .= $GP . "0";
        $TRS .= $TRS . "0";

        // $bitacoraMC .="-ZI $ZI -ZI";
        // $bitacoraMP .="-GP $GP -GP";
        // $bitacoraProyecto .="-TRS $TRS -TRS";

        // Validaciones para saber Destinos a seleccionar y las secciones.
        if ($idDestino != 10) {
            $destinoMC = "AND t_mc.id_destino=$idDestino";
            $destinoMP = "AND t_ordenes_trabajo.id_destino=$idDestino";
            $destinoMPNP = "AND t_mp_np.id_destino=$idDestino";
            $destino = "AND reporte_status_proyecto.id_destino=$idDestino";
            $filtroDestinoMP2 = "and id_equipo = $idDestino";
        } else {
            // Filtro para seleccionar destino, según la session.
            $destinoMC = "";
            $destinoMP = "";
            $destinoMPNP = "";
            $destino = "";
            $filtroDestinoMP2 = "";

            // Filtros para subseccion de las Fases(ZI, GP, TRS).
            $zonaFiltroMC = "";
            $zonaFiltroMP = "";
            $zonaFiltroMP2 = "";
            $zonaFiltroMPNP = "";
            $zonaFiltro = "";
        }

        // RM
        if ($idDestino == 1 and $zona == "ZI") {
            //En ZI admite solo: DEC(1) - AUTO(24) - ZIA(8) - ZIC(9) - ZIE(10) - ZIL(11) - ZHP(12).
            // La función LIKE solo funciona para correctivos. 
            $zonaFiltroMC = "AND (t_mc.id_seccion IN(1, 24, 8, 9, 10, 11) OR t_mc.zona LIKE '%ZI%' OR t_mc.bitacora_zi = 1)";
            $zonaFiltroMP = "AND t_equipos.id_seccion IN(1, 24, 8, 9, 10, 11, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(1, 24, 8, 9, 10, 11, 12)";
            $zonaFiltroMPNP = "AND (t_mp_np.id_seccion IN(1, 24, 8, 9, 10, 11, 12) OR t_mp_np.bitacora_zi = 1)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_seccion IN(1, 24, 8, 9, 10, 11) OR t_proyectos.fase LIKE '%ZI%')";
        } elseif ($idDestino == 1 and $zona == "TRS") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($TRS) OR t_mc.zona LIKE '%TRS%' OR t_mc.bitacora_trs = 1)";
            $zonaFiltroMP = "AND t_equipos.id_subseccion IN($TRS)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($TRS)";
            $zonaFiltroMPNP = "AND (t_mp_np.id_subseccion IN($TRS) OR t_mp_np.bitacora_trs = 1)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($TRS) OR t_proyectos.fase LIKE '%TRS%')";
        } elseif ($idDestino == 1 and $zona == "GP") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($GP) OR t_mc.zona LIKE '%GP%' OR t_mc.bitacora_gp = 1)";
            $zonaFiltroMP = "AND t_equipos.id_subseccion IN($GP)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($GP)";
            $zonaFiltroMPNP = "AND (t_mp_np.id_subseccion IN($GP) OR t_mp_np.bitacora_gp = 1)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($GP) OR t_proyectos.fase LIKE '%GP%')";

            // PVR
        } elseif ($idDestino == 2 and $zona == "ZI") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
        } elseif ($idDestino == 2 and $zona == "GP") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMP = "AND c_secciones.id IN(23,19,5,6,7)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(23,19,5,6,7)";

            // SDQ
        } elseif ($idDestino == 3 and $zona == "ZI") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1)";
        } elseif ($idDestino == 3 and $zona == "GP") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMP = "AND c_secciones.id IN(23,19,5,6,7)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(23,19,5,6,7)";

            // SSA
        } elseif ($idDestino == 4 and $zona == "ZI") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1)";
        } elseif ($idDestino == 4 and $zona == "GP") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMP = "AND c_secciones.id IN(23,19,5,6,7)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(23,19,5,6,7)";

            // MBJ
        } elseif ($idDestino == 6 and $zona == "ZI") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1)";
        } elseif ($idDestino == 6 and $zona == "GP") {
            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMP = "AND c_secciones.id IN(23,19,5,6,7)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(23,19,5,6,7)";

            // CAP
        } elseif ($idDestino == 11 and $zona == "ZI") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(11, 24, 8, 9, 10, 1, 12)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(11, 24, 8, 9, 10, 1)";
        } elseif ($idDestino == 11 and $zona == "TRS") {

            $zonaFiltro = "AND reporte_status_proyecto.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMC = "AND t_mc.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMP = "AND c_secciones.id IN(23,19,5,6,7)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(23,19,5,6,7)";
            $zonaFiltroMPNP = "AND c_secciones.id IN(23,19,5,6,7)";

            //CMU 
        } elseif ($idDestino == 7 and $zona == "ZI") {

            //En ZI admite solo: DEC(1) - AUTO(24) - ZIA(8) - ZIC(9) - ZIE(10) - ZIL(11) - ZHP(12).
            // La función LIKE solo funciona para correctivos. 
            $zonaFiltroMC = "AND (t_mc.id_seccion IN(1, 24, 8, 9, 10, 11, 12) OR t_mc.zona LIKE '%ZI%')";
            $zonaFiltroMP = "AND t_equipos.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltroMPNP = "AND t_equipos.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_seccion IN(1, 24, 8, 9, 10, 11) OR t_proyectos.fase LIKE '%ZI%')";
        } elseif ($idDestino == 7 and $zona == "TRS") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($TRS) OR t_mc.zona LIKE '%TRS%')";
            $zonaFiltroMP = "AND t_equipos.id_subseccion IN($TRS)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($TRS)";
            $zonaFiltroMPNP = "AND t_equipos.id_subseccion IN($TRS)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($TRS) OR t_proyectos.fase LIKE '%TRS%')";
        } elseif ($idDestino == 7 and $zona == "GP") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($GP) OR t_mc.zona LIKE '%GP%')";
            $zonaFiltroMP = "AND t_equipos.id_subseccion IN($GP)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($GP)";
            $zonaFiltroMPNP = "AND t_equipos.id_subseccion IN($GP)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($GP) OR t_proyectos.fase LIKE '%GP%')";

            // PUJ
        } elseif ($idDestino == 5 and $zona == "ZI") {

            //En ZI admite solo: DEC(1) - AUTO(24) - ZIA(8) - ZIC(9) - ZIE(10) - ZIL(11) - ZHP(12).
            // La función LIKE solo funciona para correctivos. 
            $zonaFiltroMC = "AND (t_mc.id_seccion IN(1, 24, 8, 9, 10, 11, 12) OR t_mc.zona LIKE '%ZI%')";
            $zonaFiltroMP = "AND t_equipos.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltroMPNP = "AND t_equipos.id_seccion IN(1, 24, 8, 9, 10, 11)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_seccion IN(1, 24, 8, 9, 10, 11) OR t_proyectos.fase LIKE '%ZI%')";
        } elseif ($idDestino == 5 and $zona == "TRS") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($TRS) OR t_mc.zona LIKE '%TRS%')";
            $zonaFiltroMP = "AND t_equipos.id_subseccion IN($TRS)";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($TRS)";
            $zonaFiltroMPNP = "AND t_equipos.id_subseccion IN($TRS)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($TRS) OR t_proyectos.fase LIKE '%TRS%')";
        } elseif ($idDestino == 5 and $zona == "GP") {

            $zonaFiltroMC = "AND (t_mc.id_subseccion IN($GP) OR t_mc.zona LIKE '%GP%')";
            $zonaFiltroMP2 = "AND t_equipos_america.id_subseccion IN($GP)";
            $zonaFiltroMPNP = "AND t_equipos.id_subseccion IN($GP)";
            $zonaFiltro = "AND (reporte_status_proyecto.id_subseccion IN($GP) OR t_proyectos.fase LIKE '%ZI%')";
        }


        // MP NO Planificado -> TAREAS.            
        $query_t_mp_np = "SELECT
            t_mp_np.id, 
            t_mp_np.id_destino,
            t_mp_np.id_equipo, 
            t_mp_np.titulo, 
            t_mp_np.status,
            t_mp_np.status_trabajando,
            c_secciones.seccion, 
            c_subsecciones.grupo, 
            t_equipos.equipo
            FROM t_mp_np
            LEFT JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id
            INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id
            WHERE t_mp_np.activo = 1 AND (t_mp_np.status='F' OR t_mp_np.status_trabajando = 1)
            $destinoMPNP
            $zonaFiltroMPNP
            AND t_mp_np.fecha_finalizado BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'
            ORDER BY t_mp_np.fecha_finalizado DESC
        ";

        $result_t_mp_np = mysqli_query($conn_2020, $query_t_mp_np);
        $total_mp_np = mysqli_num_rows($result_t_mp_np);

        while ($row_t_mp_np = mysqli_fetch_array($result_t_mp_np)) {
            $id = $row_t_mp_np['id'];
            $id_destino = $row_t_mp_np['id_destino'];
            $nombreDestino = $arrayDestino[$id_destino];
            $seccion = $row_t_mp_np['seccion'];
            $subseccion = $row_t_mp_np['grupo'];
            $equipo = $row_t_mp_np['equipo'];
            $titulo = $row_t_mp_np['titulo'];
            $status = $row_t_mp_np['status'];
            $sTrabajando = $row_t_mp_np['status_trabajando'];

            if ($equipo == "") {
                $equipo = "TG";
            }

            $query_comentario_mp_np = "SELECT comentario FROM comentarios_mp_np WHERE id_mp_np=$id 
            ORDER BY fecha DESC LIMIT 1";

            $result_comentario_mp_np = mysqli_query($conn_2020, $query_comentario_mp_np);
            if ($row_comentario_mp_np = mysqli_fetch_array($result_comentario_mp_np)) {
                $comentario_mp_np = $row_comentario_mp_np['comentario'];
                if ($comentario_mp_np == "") {
                    $comentario_mp_np = "Sin Comentario";
                }
            } else {
                $comentario_mp_np = "Sin Comentario";
            }

            if ($sTrabajando == 1) {
                $tag_statusT = "Trabajando";
            } else {
                $tag_statusT = "";
            }

            if ($status == 'F') {
                $tag_statusF = "Finalizado";
            } else {
                $tag_statusF = "";
            }

            if ($sTrabajando == 1) {
                $bitacoraMC .= "
                    <div class=\"flex justify-left items-center w-full bg-red-200 rounded mb-2 text-green-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id,'$nombreDestino', '$seccion', '$subseccion', 'Equipo($equipo) $titulo ', '$comentario_mp_np', '$tag_statusT', '$tag_statusF');\">
                    <h1 class=\"font-bold\">$nombreDestino</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\" \"> <h1 class=\"font-black text-lg text-blue-600 mx-1 bg-blue-300 px-2 rounded-md\"> T </h1> $seccion</h1><!-- SECION -->
                    <P class=\"font-black mx-1 truncate\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$subseccion</h1><!-- SUBSECCION -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$equipo</h1><!-- NOMBRE EQUIPO o TAREA GENERAL-->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"font-bold\">$titulo</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$comentario_mp_np</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";
            } else {
                $bitacoraMC .= "
                <div class=\"flex justify-left items-center w-full bg-red-200 rounded mb-2 text-green-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id,'$nombreDestino', '$seccion', '$subseccion', 'Equipo($equipo) $titulo ', '$comentario_mp_np', '$tag_statusT', '$tag_statusF');\">
                <h1 class=\"font-bold\">$nombreDestino</h1>
                <P class=\"font-black mx-1\">/</P>
                <h1 class=\" \">$seccion</h1><!-- SECION -->
                <P class=\"font-black mx-1 truncate\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$subseccion</h1><!-- SUBSECCION -->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$equipo</h1><!-- NOMBRE EQUIPO o TAREA GENERAL-->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"font-bold\">$titulo</h1><!-- DESCRIPCION DE LA TAREA -->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$comentario_mp_np</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                </div>
                ";
            }
        }


        // Query MC
        $query_t_mc = "SELECT
        t_mc.id,
        t_mc.id_destino,
		t_mc.status,
        t_mc.actividad,
        t_mc.id_seccion, 
        t_mc.id_subseccion,
		t_mc.status_trabajare,
        c_secciones.seccion,
        c_subsecciones.grupo
        FROM t_mc 
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
        WHERE t_mc.status = 'F'  AND t_mc.activo = 1
        $destinoMC
        $zonaFiltroMC
        AND t_mc.fecha_realizado <= '$fecha_inicial_12' 
        AND t_mc.fecha_realizado >= '$fecha_final_12'
        ";
        // Sentencia SQL donde se almacena la información.
        $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
        if ($totalmc = mysqli_num_rows($result_t_mc)) {
            $totalmc = $totalmc;
        }

        while ($row_t_mc = mysqli_fetch_array($result_t_mc)) {
            $id = $row_t_mc['id'];
            $id_destino = $row_t_mc['id_destino'];
            $nombreDestino = $arrayDestino[$id_destino];
            $seccion = $row_t_mc['seccion'];
            $subseccion = $row_t_mc['grupo'];
            $descripcion = $row_t_mc['actividad'];
            $status_finalizado = $row_t_mc['status'];
            $status_trabajare = $row_t_mc['status_trabajare'];
            $comentario_mc = "Sin Comentarios";

            $query_comentario_mc = "SELECT comentario FROM t_mc_comentarios 
            WHERE id_mc=$id ORDER BY fecha DESC LIMIT 1";
            $result_comentario_mc = mysqli_query($conn_2020, $query_comentario_mc);
            if ($row_comentario_mc = mysqli_fetch_array($result_comentario_mc)) {
                $comentario_mc = $row_comentario_mc['comentario'];
            }

            $tag_status = "<h1 class=\"font-black text-lg text-blue-600 mx-1 bg-blue-300 px-2 rounded-md\">T</h1>";
            $tag_status1 = "Trabajando";
            $tag_finalizado = "<h1 class=\"font-black text-lg text-green-600 mx-1 bg-green-300 px-2 rounded-md\">F</h1>";
            $tag_status2 = "Finalizado";

            if ($status_trabajare == "") {
                $tag_status = "";
                $tag_status1 = "";
            }

            if ($status_finalizado == "") {
                $tag_finalizado = "";
                $tag_status2 = "";
            }


            $bitacoraMC .= "<div class=\"flex justify-left items-center w-full bg-red-200 rounded mb-2 text-red-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id, '$nombreDestino', ' $seccion', '$subseccion', '$descripcion', '$comentario_mc', '$tag_status1', '$tag_status2');\">"
                . "<h1 class=\"font-bold\">$nombreDestino</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . " $tag_finalizado $tag_status <h1 class=\"\">  $seccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$subseccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate font-bold\">$descripcion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$comentario_mc</h1>"
                . "</div>";
        }

        $query_MC_trabajare = "SELECT 
        t_mc.id,
        t_mc.id_destino,
		t_mc.status,
        t_mc.actividad,
        t_mc.id_seccion, 
        t_mc.id_subseccion,
		t_mc.status_trabajare,
        c_secciones.seccion,
        c_subsecciones.grupo
        FROM t_mc 
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
        WHERE t_mc.status_trabajare != ''  AND t_mc.activo = 1 AND t_mc.status != 'F'
        $destinoMC
        $zonaFiltroMC
        ";

        $result_MC_trabajare = mysqli_query($conn_2020, $query_MC_trabajare);
        if ($totalmc_2 = mysqli_num_rows($result_MC_trabajare)) {
            $total = $totalmc_2;
        }

        while ($row_MC_trabajare = mysqli_fetch_array($result_MC_trabajare)) {
            $id = $row_MC_trabajare['id'];
            $id_destino = $row_MC_trabajare['id_destino'];
            $nombreDestino = $arrayDestino[$id_destino];
            $seccion = $row_MC_trabajare['seccion'];
            $subseccion = $row_MC_trabajare['grupo'];
            $descripcion = $row_MC_trabajare['actividad'];
            $status_finalizado = $row_MC_trabajare['status'];
            $status_trabajare = $row_MC_trabajare['status_trabajare'];

            $comentario_mc = "Sin Comentario";
            $query_comentario_mc = "SELECT comentario FROM t_mc_comentarios 
            WHERE id_mc=$id ORDER BY fecha DESC LIMIT 1";
            $result_comentario_mc = mysqli_query($conn_2020, $query_comentario_mc);

            if ($row_comentario_mc = mysqli_fetch_array($result_comentario_mc)) {
                $comentario_mc = $row_comentario_mc['comentario'];
            }

            $tag_status = "<h1 class=\"font-black text-lg text-blue-600 mx-1 bg-blue-300 px-2 rounded-md\">T</h1>";
            $tag_status1 = "Trabajando";
            $tag_finalizado = "<h1 class=\"font-black text-lg text-green-600 mx-1 bg-green-300 px-2 rounded-md\">F</h1>";
            $tag_status2 = "Finalizado";


            if ($status_trabajare == "") {
                $tag_status = "";
                $tag_status1 = "";
            }

            if ($status_finalizado != "F") {
                $tag_finalizado = "";
                $tag_status2 = "";
            }


            $bitacoraMC .=
                "<div class=\"flex justify-left items-center w-full bg-red-200 rounded mb-2 text-red-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id, '$nombreDestino', '$seccion', '$subseccion', '$descripcion', '$comentario_mc', '$tag_status1', '$tag_status2');\">"
                . "<h1 class=\"font-bold\">$nombreDestino</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . " $tag_finalizado $tag_status <h1 class=\"\">  $seccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$subseccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate font-bold\">$descripcion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$comentario_mc</h1>"
                . "</div>";
        }
        //$bitacoraMC = "";


        // Se obtiene el resultado total de los solucionados y Trabajando MC.
        $MPMCPROYECTOS['bitacoraMC'] = $bitacoraMC;
        $MPMCPROYECTOS['totalmc'] = intval($totalmc) + intval($total_mp_np);


        //QUERY MP Planificado.
        $query = "SELECT t_mp_planificacion_iniciada.id, t_mp_planificacion_iniciada.comentario, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos_america.equipo
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        WHERE t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and
        t_mp_planificacion_iniciada.fecha_finalizado 
        BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'
        $zonaFiltroMP2
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOTX = intval($x['id']);
                $destinoX = $x['destino'];
                $seccionX = $x['seccion'];
                $subseccionX = $x['grupo'];
                $equipoX = $x['equipo'];
                $comentarioX = $x['comentario'];

                $bitacoraMP .= "
                    <div class=\"flex justify-left items-center w-full bg-green-200 rounded mb-2 text-green-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($idOTX,'$destinoX', '$seccionX', '$subseccionX', '$equipoX (Folio OT: $idOTX)', '$comentarioX', '', '');\">
                    <h1 class=\"font-bold\">$destinoX</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\" \">$seccionX</h1><!-- SECION -->
                    <P class=\"font-black mx-1 truncate\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$subseccionX</h1><!-- SUBSECCIONX -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$equipoX</h1><!-- NOMBRE EQUIPO o TAREA GENERAL-->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"font-bold\">Folio OT: $idOTX</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$comentarioX</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";
            }
        }




        $query_t_mp = "SELECT
		 	t_ordenes_trabajo.id,
            t_ordenes_trabajo.id_destino,
            t_ordenes_trabajo.folio,
            t_ordenes_trabajo.id_equipo,
            t_ordenes_trabajo.lista_actividades_realizadas,
            t_equipos.equipo,
            t_equipos.id_seccion,
            t_equipos.id_subseccion,
            c_secciones.seccion,
            c_subsecciones.grupo

            FROM t_ordenes_trabajo
            INNER JOIN t_equipos ON t_ordenes_trabajo.id_equipo = t_equipos.id
            INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id
            WHERE 
            t_ordenes_trabajo.status='F'
            $destinoMP
            $zonaFiltroMP
            AND t_ordenes_trabajo.fecha_realizado BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'
            ORDER BY t_ordenes_trabajo.fecha_realizado DESC
            ";

        $result_t_mp = mysqli_query($conn_2020, $query_t_mp);
        $totalMP = mysqli_num_rows($result_t_mp);

        while ($row_t_mp = mysqli_fetch_array($result_t_mp)) {
            $id = $row_t_mp['id'];
            $id_destino = $row_t_mp['id_destino'];
            $nombreDestino = $arrayDestino[$id_destino];
            $seccion = $row_t_mp['seccion'];
            $subseccion = $row_t_mp['grupo'];
            $equipo = $row_t_mp['equipo'];
            $folio = $row_t_mp['folio'];
            $comentario_mp = "Sin Comentario";


            $query_comentario_mp = "SELECT t_mp_comentarios.comentarios
            FROM t_mp_comentarios WHERE id_ot=$id
            ORDER BY fecha DESC LIMIT 1
                        ";
            $result_comentario_mp = mysqli_query($conn_2020, $query_comentario_mp);
            if ($row_comentario_mp = mysqli_fetch_array($result_comentario_mp)) {
                $comentario_mp = $row_comentario_mp['comentarios'];
            }

            $bitacoraMP .= "
                <div class=\"flex justify-left items-center w-full bg-green-200 rounded mb-2 text-green-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id,'$nombreDestino', '$seccion', '$subseccion', '$equipo (Folio OT: $folio)', '$comentario_mp', '', '');\">
                <h1 class=\"font-bold\">$nombreDestino</h1>
                <P class=\"font-black mx-1\">/</P>
                <h1 class=\" \">$seccion</h1><!-- SECION -->
                <P class=\"font-black mx-1 truncate\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$subseccion</h1><!-- SUBSECCION -->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$equipo</h1><!-- NOMBRE EQUIPO o TAREA GENERAL-->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"font-bold\">Folio OT: $folio</h1><!-- DESCRIPCION DE LA TAREA -->
                <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                <h1 class=\"truncate\">$comentario_mp</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                </div>
                ";
        }

        // Json 
        $MPMCPROYECTOS['totalMP'] = $totalMP;
        $MPMCPROYECTOS['bitacoraMP'] = $bitacoraMP;



        // Query Proyecto.
        // echo $fecha_final . " - " . $fecha_inicial ." - " .$zona. " - ". $idDestino;
        //if(date('Y-m-d H:m:s') < date('Y-m-d 16:00:00')){
        $trabahareFiltro = "OR reporte_status_proyecto.status = 'status_trabajare'";
        //}else{
        //	$trabahareFiltro ="";
        //}
        $query_t_proyectos = " SELECT 
            reporte_status_proyecto.id,
            reporte_status_proyecto.id_destino,
            reporte_status_proyecto.fecha_inicio,
            reporte_status_proyecto.id_seccion,
            reporte_status_proyecto.id_subseccion,
            reporte_status_proyecto.id_proyecto,
            reporte_status_proyecto.id_planaccion,
            reporte_status_proyecto.status,
            c_secciones.seccion,
            c_subsecciones.grupo,
            t_proyectos.titulo,
            t_proyectos_planaccion.actividad

            FROM reporte_status_proyecto
            INNER JOIN c_secciones ON reporte_status_proyecto.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON reporte_status_proyecto.id_subseccion = c_subsecciones.id
            INNER JOIN t_proyectos ON reporte_status_proyecto.id_proyecto = t_proyectos.id 
            INNER JOIN t_proyectos_planaccion ON reporte_status_proyecto.id_planaccion = t_proyectos_planaccion.id 

            WHERE
            ((reporte_status_proyecto.status = 'status_solucionado') OR (reporte_status_proyecto.status = 'status_trabajare'))
            $destino
            $zonaFiltro
            AND reporte_status_proyecto.fecha_inicio >= '$fecha_final_12' 
            AND reporte_status_proyecto.fecha_inicio <= '$fecha_inicial_12'
            ORDER BY reporte_status_proyecto.fecha_inicio DESC
            ";
        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);



        while ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {
            $id = $row_t_proyectos['id'];
            $id_destino = $row_t_proyectos['id_destino'];
            $nombreDestino = $arrayDestino[$id_destino];
            $seccion = $row_t_proyectos['seccion'];
            $subseccion = $row_t_proyectos['grupo'];
            $proyecto = $row_t_proyectos['titulo'];
            $planaccion = $row_t_proyectos['actividad'];
            $id_planaccion = $row_t_proyectos['id_planaccion'];
            $status = $row_t_proyectos['status'];
            $comentario = "Sin Comentarios";

            $tag_status = "<h1 class=\"font-black text-lg text-blue-600 mx-1 bg-blue-300 px-2 rounded-md\">T</h1>";
            $tag_status1 = "Trabajando";
            $tag_finalizado = "<h1 class=\"font-black text-lg text-green-600 mx-1 bg-green-300 px-2 rounded-md\">F</h1>";
            $tag_status2 = "Solucionado";

            $query_comentario = "SELECT comentario FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $id_planaccion ORDER BY fecha DESC";
            $result_comentario = mysqli_query($conn_2020, $query_comentario);
            if ($row_comentario = mysqli_fetch_array($result_comentario)) {
                $comentario = $row_comentario['comentario'];
            }



            if ($status != "status_trabajare") {
                $tag_status = "";
                $tag_status1 = "";
            }

            if ($status != "status_solucionado") {
                $tag_finalizado = "";
                $tag_status2 = "";
            }


            $bitacoraProyecto .= "<div class=\"flex justify-left items-center w-full bg-yellow-200 rounded mb-2 text-yellow-700 cursor-pointer py-2 text-xs px-1\" onclick=\"toggleModal('modalMCMPProyectos'); consultaMPMCPROYECTOS($id_planaccion,'$nombreDestino', '$seccion', '$subseccion', '$proyecto -> $planaccion', '$comentario', '$tag_status1', '$tag_status2');\">"
                . "<h1 class=\"font-bold\">$nombreDestino</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "$tag_finalizado $tag_status <h1 class=\"\">$seccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$subseccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$proyecto</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate font-bold\">$planaccion</h1>"
                . "<P class=\"font-black mx-1\">/</P>"
                . "<h1 class=\"truncate\">$comentario</h1>"
                . "</div>";
        }

        // JSON DONDE SE GUARDAN LOS RESULTADOS DE LOS PROYECTOS SEGUN EL DIA.
        $MPMCPROYECTOS['totalProyecto'] = mysqli_num_rows($result_t_proyectos);
        $MPMCPROYECTOS['bitacoraProyecto'] = $bitacoraProyecto;

        // SE RECORRE EL ARREGLO PARA OBTENER EL RANGO DE FECHAS 6 DÍAS ANTES DE LA FECHA SELECCIONADA.
        foreach ($arrayTotal as $key => $value) {

            // MC
            $query_MC = "SELECT* FROM t_mc WHERE 
            fecha_realizado BETWEEN '$value' AND '$key'
            $destinoMC $zonaFiltroMC
            ";
            $result_MC = mysqli_query($conn_2020, $query_MC);
            $total_MC = "0";
            $total_MC = mysqli_num_rows($result_MC);


            // MP NO Planificado.
            $query_MPNP = "SELECT t_mp_np.id
            FROM t_mp_np
            INNER JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id
            INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id
            WHERE
            t_mp_np.status='F' AND t_mp_np.activo = 1 AND
            t_mp_np.fecha_finalizado BETWEEN '$value' AND '$key'
            $destinoMPNP $zonaFiltroMPNP
            ";
            $result_MPNP = mysqli_query($conn_2020, $query_MPNP);
            $total_MPNP = 0;
            $total_MPNP = mysqli_num_rows($result_MPNP);

            $graficaMC[] = $total_MC + $total_MPNP;

            // MP Planificado.
            $query_MP = "SELECT 
            t_ordenes_trabajo.id_equipo,
            t_equipos.id_seccion
            FROM t_ordenes_trabajo
            INNER JOIN t_equipos ON t_ordenes_trabajo.id_equipo = t_equipos.id
            INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
            WHERE
            t_ordenes_trabajo.status='F' AND 
            t_ordenes_trabajo.fecha_realizado BETWEEN '$value' AND '$key'
            $destinoMP $zonaFiltroMP
            ";
            $result_MP = mysqli_query($conn_2020, $query_MP);
            $total_MP = 0;
            $total_MP = mysqli_num_rows($result_MP);

            $graficaMP[] = $total_MP;


            // Proyectos
            $query_p = "SELECT*

            FROM reporte_status_proyecto
            INNER JOIN c_secciones ON reporte_status_proyecto.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON reporte_status_proyecto.id_subseccion = c_subsecciones.id
            INNER JOIN t_proyectos ON reporte_status_proyecto.id_proyecto = t_proyectos.id 
            INNER JOIN t_proyectos_planaccion ON reporte_status_proyecto.id_planaccion = t_proyectos_planaccion.id 

            WHERE
            ((reporte_status_proyecto.status = 'status_solucionado') OR (reporte_status_proyecto.status = 'status_trabajare'))
            $destino
            $zonaFiltro

            -- AND reporte_status_proyecto.fecha_inicio BETWEEN '$value' AND '$key'
            AND reporte_status_proyecto.fecha_inicio >= '$value' 
            AND reporte_status_proyecto.fecha_inicio <= '$key'
            ";
            $result_p = mysqli_query($conn_2020, $query_p);

            if ($total_p = mysqli_num_rows($result_p)) {
                $total_p = $total_p;
            } else {
                $total_p = 0;
            }


            $graficaProyectos[] = $total_p;
            $graficaFecha = $key . $value;
        }

        $MPMCPROYECTOS['graficaMC'] = $graficaMC;
        $MPMCPROYECTOS['graficaMP'] = $graficaMP;
        $MPMCPROYECTOS['graficaP'] = $graficaProyectos;
        $MPMCPROYECTOS['fecha'] = $graficaFecha;
        $MPMCPROYECTOS['diaSemana'] = $arrayDia;

        // SIEMPRE DEBE TENER DE ULTIMO PARA QUE ALMACENE TODO LA INFROMACIO OBTENIDA EN LOS PROCESOS
        echo json_encode($MPMCPROYECTOS);
    }


    // Empresas Externas
    if ($action == "empresasExternasCaptura") {
        $empresa = $_POST['empresa'];
        $motivo = $_POST['motivo'];

        $query = "INSERT INTO bitacora_empresas_externas(id_usuario, id_destino, zona, empresa, motivo, fecha) VALUES($idUsuario, $idDestino, '$zona', '$empresa', '$motivo', '$fechaDia')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Registro Capturado!";
        } else {
            echo "Error de Registro!";
        }
    }


    if ($action == "consultaEmpresas") {

        $totalEmpresas = "0";
        $consultaEmpresas = "";
        $consultaEmpresasModal = "";
        $bitacoraEmpresas = array();

        if ($idDestino != 10) {
            $query = "SELECT id, empresa, motivo FROM bitacora_empresas_externas WHERE id_destino=$idDestino AND zona='$zona' AND activo=1 
        AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'";
        } else {
            $query = "SELECT id, empresa, motivo FROM bitacora_empresas_externas WHERE zona='$zona' AND activo=1 
        AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'";
        }
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $totalEmpresas = mysqli_num_rows($result);
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $empresa = $row['empresa'];
                $motivo = $row['motivo'];
                $consultaEmpresas .= "
                    <div class=\"flex justify-leftr items-center w-full bg-blue-200 rounded mb-2 text-blue-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\" font-bold\">$empresa</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$motivo</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";

                $consultaEmpresasModal .= "
                    <div class=\"px-3 flex justify-between my-2\">
                    <h1 class=\"\">$empresa</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"mx-3\">/</P><!-- DIVISION -->
                    <h1 class=\"\">$motivo<span><i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarItemPersonal('bitacora_empresas_externas', $id,'modal-empresas')\"></i></span></h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";
            }
        }

        foreach ($arrayTotal as $key => $value) {

            // Empresas
            if ($idDestino != 10) {
                $query_Empresas = "SELECT* FROM bitacora_empresas_externas WHERE fecha BETWEEN '$value' AND '$key' AND zona='$zona' AND id_destino=$idDestino AND activo=1 ";
            } else {
                $query_Empresas = "SELECT* FROM bitacora_empresas_externas WHERE 
            fecha BETWEEN '$value' AND '$key'
            AND zona='$zona' AND activo=1
            ";
            }
            $result_Empresas = mysqli_query($conn_2020, $query_Empresas);
            $total_Empresas = "0";
            $total_Empresas = mysqli_num_rows($result_Empresas);

            $graficaEmpresas[] = $total_Empresas;
        }

        // Arrays donde se guarda la informacion obtenida
        $bitacoraEmpresas['consultaEmpresas'] = $consultaEmpresas;
        $bitacoraEmpresas['consultaEmpresasModal'] = $consultaEmpresasModal;
        $bitacoraEmpresas['totalEmpresas'] = $totalEmpresas;
        $bitacoraEmpresas['graficaEmpresas'] = $graficaEmpresas;
        $bitacoraEmpresas['diaSemana'] = $arrayDia;
        echo json_encode($bitacoraEmpresas);
    }


    // Acontecimientos
    if ($action == "acontecimientoCaptura") {
        $acontecimiento = $_POST['acontecimiento'];
        $descripcion = $_POST['descripcion'];

        $query = "INSERT INTO bitacora_acontecimiento(id_usuario, id_destino, zona, acontecimiento, descripcion, fecha) VALUES($idUsuario, $idDestino, '$zona', '$acontecimiento', '$descripcion', '$fechaDia')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Registro Capturado!";
        } else {
            echo "Error de Registro!";
        }
    }


    if ($action == "consultaAcontecimiento") {

        $consultaAconteciminetoGrafica = "";
        $consultaAcontecimiento = "";
        $consultaAcontecimientoModal = "";
        $bitacoraAcontecimiento = array();

        if ($idDestino != 10) {
            $query = "SELECT id, acontecimiento, descripcion FROM bitacora_acontecimiento WHERE id_destino=$idDestino AND zona='$zona' AND activo=1 
        AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'";
        } else {
            $query = "SELECT id, acontecimiento, descripcion FROM bitacora_acontecimiento WHERE zona='$zona' AND activo=1 
        AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'";
        }
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $totalAcontecimiento = mysqli_num_rows($result);
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $acontecimiento = $row['acontecimiento'];
                $descripcion = $row['descripcion'];

                $consultaAcontecimiento .= "
                    <div class=\"flex justify-left items-center w-full bg-yellow-200 rounded mb-2 text-yellow-900 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\" font-bold\">$acontecimiento</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"font-black mx-1\">/</P><!-- DIVISION -->
                    <h1 class=\"truncate\">$descripcion</h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";

                $consultaAcontecimientoModal .= "
                    <div class=\"px-3 flex justify-between my-2\">
                    <h1 class=\"\">$acontecimiento</h1><!-- DESCRIPCION DE LA TAREA -->
                    <P class=\"mx-3\">/</P><!-- DIVISION -->
                    <h1 class=\"\">$descripcion<span><i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarItemPersonal('bitacora_acontecimiento', $id,'modal-acontecimientos')\"></i></span></h1><!-- ULTIMO COMENTARIO DE LA TAREA -->
                    </div>
                ";
            }
        }

        foreach ($arrayTotal as $key => $value) {

            // Acontecimientos.
            if ($idDestino != 10) {
                $query_Empresas = "SELECT* FROM bitacora_acontecimiento WHERE 
                fecha BETWEEN '$value' AND '$key'
                AND zona='$zona' AND id_destino=$idDestino AND activo=1
                ";
            } else {
                $query_Empresas = "SELECT* FROM bitacora_acontecimiento WHERE 
                fecha BETWEEN '$value' AND '$key'
                AND zona='$zona' AND activo=1
                ";
            }

            $result_Empresas = mysqli_query($conn_2020, $query_Empresas);
            $total_Acontecimiento = "0";
            $total_Acontecimiento = mysqli_num_rows($result_Empresas);

            $graficaAcontecimiento[] = $total_Acontecimiento;
        }

        // Arrays donde se guarda la informacion obtenida
        $bitacoraAcontecimiento['consultaAcontecimiento'] = $consultaAcontecimiento;
        $bitacoraAcontecimiento['consultaAcontecimientoModal'] = $consultaAcontecimientoModal;
        $bitacoraAcontecimiento['totalAcontecimiento'] = $totalAcontecimiento;
        $bitacoraAcontecimiento['graficaAcontecimiento'] = $graficaAcontecimiento;
        $bitacoraAcontecimiento['diaSemana'] = $arrayDia;
        echo json_encode($bitacoraAcontecimiento);
    }


    if ($action == "giftHabitacionesCaptura") {

        $pendientes = $_POST['pendientes'];
        $solucionados = $_POST['solucionados'];
        $media_solucion_tiempo = $_POST['media_solucion_tiempo'];
        $media_asignacion_tiempo = $_POST['media_asignacion_tiempo'];
        $media_reparacion_tiempo = $_POST['media_reparacion_tiempo'];
        $satisfaccion = $_POST['satisfaccion'];
        $no_alojado_origen = $_POST['no_alojado_origen'];
        $trabajador_origen = $_POST['trabajador_origen'];
        $husped_origen = $_POST['husped_origen'];
        $tipificacion_top1 = $_POST['tipificacion_top1'];
        $total_top1 = $_POST['total_top1'];
        $tipificacion_top2 = $_POST['tipificacion_top2'];
        $total_top2 = $_POST['total_top2'];
        $tipificacion_top3 = $_POST['tipificacion_top3'];
        $total_top3 = $_POST['total_top3'];
        $tipificacion_top4 = $_POST['tipificacion_top4'];
        $total_top4 = $_POST['total_top4'];
        $tipificacion_top5 = $_POST['tipificacion_top5'];
        $total_top5 = $_POST['total_top5'];
        $id = $_POST['id'];


        if ($id > 0) {

            $query = "UPDATE bitacora_gift_habitaciones SET 
            pendientes=$pendientes, solucionados = $solucionados, 
            media_solucion_tiempo = '$media_solucion_tiempo', media_asignacion_tiempo = '$media_asignacion_tiempo', media_reparacion_tiempo = '$media_reparacion_tiempo', 
            satisfaccion = $satisfaccion,
            no_alojado_origen = $no_alojado_origen, trabajador_origen = $trabajador_origen, husped_origen = $husped_origen,
            tipificacion_top1 = '$tipificacion_top1', total_top1 = $total_top1,
            tipificacion_top2 = '$tipificacion_top2', total_top2 = $total_top2,
            tipificacion_top3 = '$tipificacion_top3', total_top3 = $total_top3,
            tipificacion_top4 = '$tipificacion_top4', total_top4 = $total_top4,
            tipificacion_top5 = '$tipificacion_top5', total_top5 = $total_top5
            WHERE id=$id";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Registro Actualizado!";
            } else {
                echo "Error";
            }
        } else {

            $query = "INSERT INTO bitacora_gift_habitaciones
            (
            id_usuario, id_destino, zona, 
            pendientes, solucionados, 
            media_solucion_tiempo, media_asignacion_tiempo, media_reparacion_tiempo, 
            satisfaccion,
            no_alojado_origen, trabajador_origen, husped_origen,
            tipificacion_top1, total_top1,
            tipificacion_top2, total_top2,
            tipificacion_top3, total_top3,
            tipificacion_top4, total_top4,
            tipificacion_top5, total_top5,
            fecha
            )
            VALUES
            (
            $idUsuario, $idDestino, '$zona',
            $pendientes, $solucionados,
           '$media_solucion_tiempo', '', '',
            $satisfaccion,
            $no_alojado_origen, $trabajador_origen, $husped_origen,
            '$tipificacion_top1', $total_top1, 
            '$tipificacion_top2', $total_top2, 
            '$tipificacion_top3', $total_top3, 
            '$tipificacion_top4', $total_top4, 
            '$tipificacion_top5', $total_top5,
            '$fechaDia'
            )";

            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Registro Capturado!";
            } else {
                echo "Error de Captura!";
            }
        }
    }

    if ($action == "giftHabitacionesConsulta") {
        $giftHabitacionesConsulta  = array();

        if ($idDestino != 10) {
            $destino = "AND id_destino = $idDestino";
        } else {
            $destino = "AND id_destino <>0";
        }

        $query_select = "SELECT*
            FROM bitacora_gift_habitaciones 
            WHERE id_destino=$idDestino AND zona='$zona' AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12' AND activo=1
        ";

        $result_select = mysqli_query($conn_2020, $query_select);

        if (mysqli_num_rows($result_select) > 0) {

            if ($row_select = mysqli_fetch_array($result_select)) {
                $giftHabitacionesConsulta['idGiftHabitaciones'] = $row_select['id'];
                $giftHabitacionesConsulta['pendientes'] = $row_select['pendientes'];
                $giftHabitacionesConsulta['solucionados'] = $row_select['solucionados'];
                $giftHabitacionesConsulta['media_solucion_tiempo'] = $row_select['media_solucion_tiempo'];
                $giftHabitacionesConsulta['media_asignacion_tiempo'] = $row_select['media_asignacion_tiempo'];
                $giftHabitacionesConsulta['media_reparacion_tiempo'] = $row_select['media_reparacion_tiempo'];
                $giftHabitacionesConsulta['satisfaccion'] = $row_select['satisfaccion'];
                $giftHabitacionesConsulta['no_alojado_origen'] = $row_select['no_alojado_origen'];
                $giftHabitacionesConsulta['trabajador_origen'] = $row_select['trabajador_origen'];
                $giftHabitacionesConsulta['husped_origen'] = $row_select['husped_origen'];
                $giftHabitacionesConsulta['tipificacion_top1'] = $row_select['tipificacion_top1'];
                $giftHabitacionesConsulta['total_top1'] = $row_select['total_top1'];
                $giftHabitacionesConsulta['tipificacion_top2'] = $row_select['tipificacion_top2'];
                $giftHabitacionesConsulta['total_top2'] = $row_select['total_top2'];
                $giftHabitacionesConsulta['tipificacion_top3'] = $row_select['tipificacion_top3'];
                $giftHabitacionesConsulta['total_top3'] = $row_select['total_top3'];
                $giftHabitacionesConsulta['tipificacion_top4'] = $row_select['tipificacion_top4'];
                $giftHabitacionesConsulta['total_top4'] = $row_select['total_top4'];
                $giftHabitacionesConsulta['tipificacion_top5'] = $row_select['tipificacion_top5'];
                $giftHabitacionesConsulta['total_top5'] = $row_select['total_top5'];
                $giftHabitacionesConsulta['graficaTop5Cocinas'] = $row_select['total_top5'];
                $giftHabitacionesConsulta['btnGiftHabitaciones'] = "Actualizar";
            }
        } else {
            $giftHabitacionesConsulta['btnGiftHabitaciones'] = "Agregar";
        }
        echo json_encode($giftHabitacionesConsulta);
    }


    if ($action == "giftCocinasCaptura") {
        $giftCocinasCaptura = array();
        $id = $_POST['id'];
        $giftCocinasPendientes = $_POST['giftCocinasPendientes'];
        $giftCocinasSolucionados = $_POST['giftCocinasSolucionados'];
        $giftCocinasMediaSolucion = $_POST['giftCocinasMediaSolucion'];
        $giftCocinasMediaAsignacion = $_POST['giftCocinasMediaAsignacion'];
        $giftCocinasMediaReparacion = $_POST['giftCocinasMediaReparacion'];
        $giftCocinasAveriaTop1 = $_POST['giftCocinasAveriaTop1'];
        $giftCocinasTop1  = $_POST['giftCocinasTop1'];
        $giftCocinasAveriasTop2 = $_POST['giftCocinasAveriasTop2'];
        $giftCocinasTop2  = $_POST['giftCocinasTop2'];
        $giftCocinasAveriasTop3  = $_POST['giftCocinasAveriasTop3'];
        $giftCocinasTop3  = $_POST['giftCocinasTop3'];
        $giftCocinasAveriasTop4  = $_POST['giftCocinasAveriasTop4'];
        $giftCocinasTop4  = $_POST['giftCocinasTop4'];
        $giftCocinasAveriasTop5  = $_POST['giftCocinasAveriasTop5'];
        $giftCocinasTop5  = $_POST['giftCocinasTop5'];

        if ($id > 0) {
            $query = "UPDATE bitacora_gift_cocinas SET 
            pendientes = $giftCocinasPendientes,
            solucionados = $giftCocinasSolucionados,
            media_solucion_tiempo = '$giftCocinasMediaSolucion',
            media_asignacion_tiempo = '$giftCocinasMediaAsignacion',
            media_reparacion_tiempo = '$giftCocinasMediaReparacion',
            tipificacion_top1 = '$giftCocinasAveriaTop1',
            total_top1 = $giftCocinasTop1,
            tipificacion_top2 = '$giftCocinasAveriasTop2',
            total_top2 = $giftCocinasTop2,
            tipificacion_top3 = '$giftCocinasAveriasTop3',
            total_top3 = $giftCocinasTop3,
            tipificacion_top4 = '$giftCocinasAveriasTop4',
            total_top4 = $giftCocinasTop4,
            tipificacion_top5 = '$giftCocinasAveriasTop5',
            total_top5 = $giftCocinasTop5
            WHERE id=$id
            ";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Registro GIFT COCINAS Actualizado!";
            } else {
                echo "Error al Actualizar!";
            }
        } else {
            $query = "INSERT INTO bitacora_gift_cocinas(
                id_usuario,
                id_destino,
                zona,
                pendientes,
                solucionados,
                media_solucion_tiempo,
                media_asignacion_tiempo,
                media_reparacion_tiempo,
                tipificacion_top1,
                total_top1,
                tipificacion_top2,
                total_top2,
                tipificacion_top3,
                total_top3,
                tipificacion_top4,
                total_top4,
                tipificacion_top5,
                total_top5,
                fecha
                )
                VALUES (
                    $idUsuario,
                    $idDestino,
                    '$zona',
                    $giftCocinasPendientes,
                    $giftCocinasSolucionados,
                    '$giftCocinasMediaSolucion',
                    '$giftCocinasMediaAsignacion',
                   '$giftCocinasMediaReparacion',
                    '$giftCocinasAveriaTop1',
                    $giftCocinasTop1,
                    '$giftCocinasAveriasTop2',
                    $giftCocinasTop2,
                    '$giftCocinasAveriasTop3',
                    $giftCocinasTop3,
                    '$giftCocinasAveriasTop4',
                    $giftCocinasTop4,
                    '$giftCocinasAveriasTop5',
                    $giftCocinasTop5,
                    '$fechaDia'
                )";
            $result = mysqli_query($conn_2020, $query);
            if ($result) {
                echo "Registro GIFT COCINAS Agregado!";
            } else {
                echo "Error de Registro!";
            }
        }
    }


    if ($action == "giftCocinasConsulta") {
        $giftCocinasConsulta = array();
        $query = "SELECT* FROM bitacora_gift_cocinas WHERE id_destino=$idDestino AND zona='$zona' AND activo=1 AND fecha BETWEEN '$fecha_final_12' AND '$fecha_inicial_12'";
        $result = mysqli_query($conn_2020, $query);
        if (mysqli_num_rows($result) > 0) {

            if ($row = mysqli_fetch_array($result)) {
                $giftCocinasConsulta['id'] = $row['id'];
                $giftCocinasConsulta['pendientes'] = $row['pendientes'];
                $giftCocinasConsulta['solucionados'] = $row['solucionados'];
                $giftCocinasConsulta['media_solucion_tiempo'] = $row['media_solucion_tiempo'];
                $giftCocinasConsulta['media_asignacion_tiempo'] = $row['media_asignacion_tiempo'];
                $giftCocinasConsulta['media_reparacion_tiempo'] = $row['media_reparacion_tiempo'];
                $giftCocinasConsulta['tipificacion_top1'] = $row['tipificacion_top1'];
                $giftCocinasConsulta['total_top1'] = $row['total_top1'];
                $giftCocinasConsulta['tipificacion_top2'] = $row['tipificacion_top2'];
                $giftCocinasConsulta['total_top2'] = $row['total_top2'];
                $giftCocinasConsulta['tipificacion_top3'] = $row['tipificacion_top3'];
                $giftCocinasConsulta['total_top3'] = $row['total_top3'];
                $giftCocinasConsulta['tipificacion_top4'] = $row['tipificacion_top4'];
                $giftCocinasConsulta['total_top4'] = $row['total_top4'];
                $giftCocinasConsulta['tipificacion_top5'] = $row['tipificacion_top5'];
                $giftCocinasConsulta['total_top5'] = $row['total_top5'];
                $giftCocinasConsulta['btnGiftCocinas'] = "Actualizar";
            } else {
                echo "Error!";
            }
        } else {
            $giftCocinasCaptura['btnGiftCocinas'] = "Agregar";
        }

        echo json_encode($giftCocinasConsulta);
    }
} else {
    echo "Error Desconocido";
}
