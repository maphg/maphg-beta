<?php
date_default_timezone_set("America/Cancun");
session_start();


include 'conexion.php';


if (isset($_POST['action'])) {
    // Asigna el valor de action.
    $action = $_POST['action'];

    // Variables Globales de la Sessión del Usuario al iniciar.
    $idUsuario = $_SESSION["usuario"];
    $idDestino = $_SESSION["idDestino"];


    // Variables generales enviadas desde AJAX.
    $idDestino = $_POST['idDestino'];
    $opcion = $_POST['opcion'];
    $fechaSeleccionada = $_POST['fechaSeleccionada'];
    $fechaSeleccionada = new DateTime($fechaSeleccionada);
    

    // Día Seleccionado.
    $fechaInicio = $fechaSeleccionada->format("Y-m-d 00:00:01");
    $fechaFin = $fechaSeleccionada->format("Y-m-d 23:59:00");

    // Día antes.
    $fechaInicio_dia_antes = date("Y-m-d 00:00:01", strtotime($fechaInicio."-1 days"));
    $fechaFin_dia_antes = date("Y-m-d 23:59:00", strtotime($fechaFin."-1 days"));

    // Inicio y Fin de Semana a partir del Día Seleccionado.
    $fechaFinSemana = date("Y-m-d 00:00:01", strtotime($fechaFin."-6 days"));
    $fechaInicioSemana = $fechaFin;


    // Calcula semana apartir de la fecha seleccionada.
    // Este segmento es el inicio del dia.
    $fechaFinSemana_0 = date("Y-m-d 00:00:01", strtotime($fechaFin."-0 days"));
    $fechaFinSemana_1 = date("Y-m-d 00:00:01", strtotime($fechaFin."-1 days"));
    $fechaFinSemana_2 = date("Y-m-d 00:00:01", strtotime($fechaFin."-2 days"));
    $fechaFinSemana_3 = date("Y-m-d 00:00:01", strtotime($fechaFin."-3 days"));
    $fechaFinSemana_4 = date("Y-m-d 00:00:01", strtotime($fechaFin."-4 days"));
    $fechaFinSemana_5 = date("Y-m-d 00:00:01", strtotime($fechaFin."-5 days"));
    $fechaFinSemana_6 = date("Y-m-d 00:00:01", strtotime($fechaFin."-6 days"));

    // Este segmento es el fin del día.
    $fechaFinSemana_fin_0 = date("Y-m-d 23:59:59", strtotime($fechaFin."-0 days"));
    $fechaFinSemana_fin_1 = date("Y-m-d 23:59:59", strtotime($fechaFin."-1 days"));
    $fechaFinSemana_fin_2 = date("Y-m-d 23:59:59", strtotime($fechaFin."-2 days"));
    $fechaFinSemana_fin_3 = date("Y-m-d 23:59:59", strtotime($fechaFin."-3 days"));
    $fechaFinSemana_fin_4 = date("Y-m-d 23:59:59", strtotime($fechaFin."-4 days"));
    $fechaFinSemana_fin_5 = date("Y-m-d 23:59:59", strtotime($fechaFin."-5 days"));
    $fechaFinSemana_fin_6 = date("Y-m-d 23:59:59", strtotime($fechaFin."-6 days"));


    // Calcula el Numero de Semana por la fecha.
    $dia_0 = (new DateTime($fechaFinSemana_0))->format("w");
    $dia_1 = (new DateTime($fechaFinSemana_1))->format("w");
    $dia_2 = (new DateTime($fechaFinSemana_2))->format("w");
    $dia_3 = (new DateTime($fechaFinSemana_3))->format("w");
    $dia_4 = (new DateTime($fechaFinSemana_4))->format("w");
    $dia_5 = (new DateTime($fechaFinSemana_5))->format("w");
    $dia_6 = (new DateTime($fechaFinSemana_6))->format("w");

    
    // Array para Buscar el Día de la semana.
    $arraySemana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");



    if ($action == "consumoDia") {
        $arrayComsumoDia = array();
        
        // Variables para Array.
        $dataElectricidad = 0;
        $dataAgua = 0;
        $dataGas = 0;
        $dataDiesel = 0; 
        $dataOcupacion = 0; 
        $dataPax = 0;

        // Variables para almacenar datos dia anterior.
        $dataElectricidad_dia_antes = 0;
        $dataAgua_dia_antes = 0;
        $dataGas_dia_antes = 0;
        $dataDiesel_dia_antes = 0; 
        $dataOcupacion_dia_antes = 0; 
        $dataPax_dia_antes = 0;

        $query = "SELECT* FROM bitacora_energeticos_consumo_dia WHERE id_destino = $idDestino AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND activo = 1";
        $result = mysqli_query($conn_2020, $query);

        
        $query_dia_antes = "SELECT* FROM bitacora_energeticos_consumo_dia WHERE id_destino = $idDestino AND fecha BETWEEN '$fechaInicio_dia_antes' AND '$fechaFin_dia_antes' AND activo = 1";
        $result_dia_antes = mysqli_query($conn_2020, $query_dia_antes);
        

        // Consulta de la fecha seleccionada.
        if ($row = mysqli_fetch_array($result)) {

            $electricidad =  number_format($row['electricidad'], 2, '.', '');   
            $agua = number_format($row['agua'], 2, '.', '');  
            $gas = number_format($row['gas'], 2, '.', '');   
            $diesel = number_format($row['diesel'], 2, '.', '');
            $ocupacion = number_format($row['ocupacion'], 2, '.', '');
            $pax = number_format($row['pax'], 0, '.', '');

            $dataElectricidad = $electricidad; 
            $dataAgua = $agua; 
            $dataGas = $gas; 
            $dataDiesel = $diesel; 
            $dataOcupacion = $ocupacion; 
            $dataPax = $pax; 
        }


        // Consulta Dia anterior de la fecha seleccionada
        if ($row_dia_antes = mysqli_fetch_array($result_dia_antes)) {

            $electricidad = $row_dia_antes['electricidad'];   
            $agua = $row_dia_antes['agua'];   
            $gas = $row_dia_antes['gas'];   
            $diesel = $row_dia_antes['diesel'];
            $ocupacion = $row_dia_antes['ocupacion'];
            $pax = $row_dia_antes['pax'];

            $dataElectricidad_dia_antes = $electricidad; 
            $dataAgua_dia_antes = $agua; 
            $dataGas_dia_antes = $gas; 
            $dataDiesel_dia_antes = $diesel; 
            $dataOcupacion_dia_antes = $ocupacion; 
            $dataPax_dia_antes = $pax; 
        }


        // Comparación de Resultados para Asignar icono correspondiente.
        if ($dataElectricidad > $dataElectricidad_dia_antes) {
            $iconElectricidad = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconElectricidad = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }

        if ($dataAgua > $dataAgua_dia_antes) {
            $iconAgua = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconAgua = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }
        
        if ($dataGas > $dataGas_dia_antes) {
            $iconGas = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconGas = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }
        
        if ($dataDiesel > $dataDiesel_dia_antes) {
            $iconDiesel = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconDiesel = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }
        
        if ($dataOcupacion > $dataOcupacion_dia_antes) {
            $iconOcupacion = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconOcupacion = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }
        
        if ($dataPax > $dataPax_dia_antes) {
            $iconPax = "<i class=\"text-red-500 fad fa-chevron-double-up\"></i>";
        } else {
            $iconPax = "<i class=\"text-green-500 fad fa-chevron-double-down\"></i>";
        }
        

        // Resultado de Cantidad Consumida por Día seleccionado.
        $arrayComsumoDia['dataElectricidad'] = $dataElectricidad;
        $arrayComsumoDia['dataAgua'] = $dataAgua;
        $arrayComsumoDia['dataGas'] = $dataGas;
        $arrayComsumoDia['dataDiesel'] = $dataDiesel;
        $arrayComsumoDia['dataOcupacion'] = $dataOcupacion . "<span class=\"text-2xl text-gray-500\">%</span>";
        $arrayComsumoDia['dataPax'] = $dataPax;


        // Resultado de Iconos.
        $arrayComsumoDia['iconElectricidad'] = $iconElectricidad;
        $arrayComsumoDia['iconAgua'] = $iconAgua;
        $arrayComsumoDia['iconGas'] = $iconGas;
        $arrayComsumoDia['iconDiesel'] = $iconDiesel;
        $arrayComsumoDia['iconOcupacion'] = $iconOcupacion;
        $arrayComsumoDia['iconPax'] = $iconPax;

        // Borrar.
        $arrayComsumoDia['fechaInicio'] = $fechaInicio;
        $arrayComsumoDia['fechaFin'] = $fechaInicio_dia_antes;
        
        echo json_encode($arrayComsumoDia);
    }


    if ($action == "consultaAcontecimientos") {
        $arrayAcontecimientos = array();

        // Variables Iniciales.
        $dataAcontecimientosElectricidad = "";
        $dataAcontecimientosElectricidadAgua = "";
        $dataAcontecimientosElectricidadGas = "";
        $dataAcontecimientosElectricidadDiesel = "";

        // Variables para enviar al modal de Acontecimientos.
        $dataModalAcontecimientosElectricidad = "";
        $dataModalAcontecimientosAgua = "";
        $dataModalAcontecimientosGas = "";
        $dataModalAcontecimientosDiesel = "";

        $query = "SELECT* FROM bitacora_energeticos_acontecimientos WHERE id_destino = $idDestino AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND activo=1";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            $energetico = $row['energetico'];
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];

            if($energetico == "electricidad"){

                $dataAcontecimientosElectricidad .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";

                $dataModalAcontecimientosElectricidad .=
                "
                <div class=\"px-3 flex justify-between my-2\">
                    <h1>$energetico</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$titulo</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$descripcion</h1>  
                    <i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarAcontecimiento($id, '$energetico: $titulo / $descripcion');\"></i>
                </div>
                ";
            }

            if($energetico == "agua"){
                $dataAcontecimientosElectricidadAgua .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";

                $dataModalAcontecimientosAgua .=
                "
                <div class=\"px-3 flex justify-between my-2\">
                    <h1>$energetico</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$titulo</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$descripcion</h1>  
                    <i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarAcontecimiento($id, '$energetico: $titulo / $descripcion');\"></i>
                </div>
                ";
            }

            if($energetico == "gas"){
                $dataAcontecimientosElectricidadGas .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";

                $dataModalAcontecimientosGas .=
                "
                <div class=\"px-3 flex justify-between my-2\">
                    <h1>$energetico</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$titulo</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$descripcion</h1>  
                    <i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarAcontecimiento($id, '$energetico: $titulo / $descripcion');\"></i>
                </div>
                ";
            }

            if($energetico == "diesel"){
                $dataAcontecimientosElectricidadDiesel .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";

                $dataModalAcontecimientosDiesel .=
                "
                <div class=\"px-3 flex justify-between my-2\">
                    <h1>$energetico</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$titulo</h1>
                    <h1 class=\"mx-3\"> / </h1>
                    <h1>$descripcion</h1>  
                    <i class=\"ml-3 fad fa-times-circle text-red-400 text-xl\" onclick=\"eliminarAcontecimiento($id, '$energetico: $titulo / $descripcion');\"></i>
                </div>
                ";
            }
        }


        // Comprueba si tiene información, de lo contrario le manda uns msj.
        if($dataAcontecimientosElectricidad == ""){
            $dataAcontecimientosElectricidad = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";


            $dataModalAcontecimientosElectricidad = $dataAcontecimientosElectricidad;
           
        }

        if($dataAcontecimientosElectricidadAgua == ""){
            $dataAcontecimientosElectricidadAgua = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
            $dataModalAcontecimientosAgua = $dataAcontecimientosElectricidadAgua;

            
        }

        if($dataAcontecimientosElectricidadGas == ""){
            $dataAcontecimientosElectricidadGas = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
            $dataModalAcontecimientosGas = $dataAcontecimientosElectricidadGas;
        }

        if($dataAcontecimientosElectricidadDiesel == ""){
            $dataAcontecimientosElectricidadDiesel = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
            $dataModalAcontecimientosDiesel = $dataAcontecimientosElectricidadDiesel;
        }


        // Se envian los datos para el apartado de Acontecimientos del Día.
        $arrayAcontecimientos['dataAcontecimientosElectricidad'] = $dataAcontecimientosElectricidad;

        $arrayAcontecimientos['dataAcontecimientosElectricidadAgua'] = $dataAcontecimientosElectricidadAgua;

        $arrayAcontecimientos['dataAcontecimientosElectricidadGas'] = $dataAcontecimientosElectricidadGas;

        $arrayAcontecimientos['dataAcontecimientosElectricidadDiesel'] = $dataAcontecimientosElectricidadDiesel;

        // Se envian los datos para el apartado de Modal Acontecimientos.
        $arrayAcontecimientos['dataModalAcontecimientosElectricidad'] = $dataModalAcontecimientosElectricidad;
      
        $arrayAcontecimientos['dataModalAcontecimientosAgua'] = $dataModalAcontecimientosAgua;
     
        $arrayAcontecimientos['dataModalAcontecimientosGas'] = $dataModalAcontecimientosGas;
     
        $arrayAcontecimientos['dataModalAcontecimientosDiesel'] = $dataModalAcontecimientosDiesel;


        echo json_encode($arrayAcontecimientos);
    }


    if ($action == "consultaAcontecimientosSemana") {

        $arrayAcontecimientosSemana = array();



        // Variables Iniciales.
        $dataAcontecimientosElectricidad = "";
        $dataAcontecimientosAgua = "";
        $dataAcontecimientosGas = "";
        $dataAcontecimientosDiesel = "";

        // Contadores para las graficas.
        $electricidad_dia_0 = 0;
        $electricidad_dia_1 = 0;
        $electricidad_dia_2 = 0;
        $electricidad_dia_3 = 0;
        $electricidad_dia_4 = 0;
        $electricidad_dia_5 = 0;
        $electricidad_dia_6 = 0;

        $agua_dia_0 = 0;
        $agua_dia_1 = 0;
        $agua_dia_2 = 0;
        $agua_dia_3 = 0;
        $agua_dia_4 = 0;
        $agua_dia_5 = 0;
        $agua_dia_6 = 0;

        $gas_dia_0 = 0;
        $gas_dia_1 = 0;
        $gas_dia_2 = 0;
        $gas_dia_3 = 0;
        $gas_dia_4 = 0;
        $gas_dia_5 = 0;
        $gas_dia_6 = 0;

        $diesel_dia_0 = 0;
        $diesel_dia_1 = 0;
        $diesel_dia_2 = 0;
        $diesel_dia_3 = 0;
        $diesel_dia_4 = 0;
        $diesel_dia_5 = 0;
        $diesel_dia_6 = 0;

        $sinDato = 0;

        $query = "SELECT* FROM bitacora_energeticos_acontecimientos WHERE id_destino = $idDestino AND fecha BETWEEN '$fechaFinSemana' AND '$fechaInicioSemana' AND activo=1 ORDER BY fecha DESC";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $energetico = $row['energetico'];
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $fecha_principal = new DateTime($row['fecha']);
            $fecha = $fecha_principal->format('d/m/Y');

            if($energetico == "electricidad"){
                $dataAcontecimientosElectricidad .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold mr-2\">$fecha</h1>
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";
            }

            if($energetico == "agua"){
                $dataAcontecimientosAgua .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold mr-2\">$fecha</h1>
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";
            }

            if($energetico == "gas"){
                $dataAcontecimientosGas .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold mr-2\">$fecha</h1>
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";
            }

            if($energetico == "diesel"){
                $dataAcontecimientosDiesel .=
                "
                <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1\">
                    <h1 class=\"font-bold mr-2\">$fecha</h1>
                    <h1 class=\"font-bold\">$titulo</h1>
                    <P class=\"font-black mx-1\">/</P>
                    <h1 class=\"truncate font-medium\">$descripcion</h1>
                </div>
                ";
            }
        }


        // Comprueba si tiene información, de lo contrario le manda uns msj.
        if($dataAcontecimientosElectricidad == ""){
            $dataAcontecimientosElectricidad = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
        }

        if($dataAcontecimientosAgua == ""){
            $dataAcontecimientosAgua = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
        }

        if($dataAcontecimientosGas == ""){
            $dataAcontecimientosGas = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
        }

        if($dataAcontecimientosDiesel == ""){
            $dataAcontecimientosDiesel = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Acontecimientos.
            </div>
            ";
        }




        $arrayAcontecimientosSemana['dataAcontecimientosElectricidad'] = $dataAcontecimientosElectricidad;
        
        $arrayAcontecimientosSemana['dataAcontecimientosAgua'] = $dataAcontecimientosAgua;
        
        $arrayAcontecimientosSemana['dataAcontecimientosGas'] = $dataAcontecimientosGas;
        
        $arrayAcontecimientosSemana['dataAcontecimientosDiesel'] = $dataAcontecimientosDiesel;

        $query_energeticos = "SELECT* FROM bitacora_energeticos_consumo_dia WHERE id_destino = $idDestino AND activo = 1 AND fecha BETWEEN '$fechaFinSemana' AND '$fechaInicioSemana' ORDER BY fecha DESC";
        $result_energeticos = mysqli_query($conn_2020, $query_energeticos);

        while ($row_energeticos = mysqli_fetch_array($result_energeticos)) {
           
            $electricidad = $row_energeticos['electricidad'];
            $agua = $row_energeticos['agua'];
            $gas = $row_energeticos['gas'];
            $diesel = $row_energeticos['diesel'];
            $fecha_contador = new DateTime($row_energeticos['fecha']);
            $fecha_contador =$fecha_contador->format("Y-m-d H:m:s");
            

            if ($electricidad != "") {
                
                if($fecha_contador >= $fechaFinSemana_0 AND $fecha_contador <= $fechaFinSemana_fin_0) $electricidad_dia_0 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_1 AND $fecha_contador <= $fechaFinSemana_fin_1) $electricidad_dia_1++;

                elseif($fecha_contador >= $fechaFinSemana_2 AND $fecha_contador <= $fechaFinSemana_fin_2) $electricidad_dia_2 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_3 AND $fecha_contador <= $fechaFinSemana_fin_3) $electricidad_dia_3 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_4 AND $fecha_contador <= $fechaFinSemana_fin_4) $electricidad_dia_4 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_4 AND $fecha_contador <= $fechaFinSemana_fin_4) $electricidad_dia_4 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_5 AND $fecha_contador <= $fechaFinSemana_fin_5) $electricidad_dia_5 = $electricidad;

                elseif($fecha_contador >= $fechaFinSemana_6 AND $fecha_contador <= $fechaFinSemana_fin_6) $electricidad_dia_6 = $electricidad;

                else $sinDato=0;
            }


            if ($agua != "") {    

                if($fecha_contador >= $fechaFinSemana_0 AND $fecha_contador <= $fechaFinSemana_fin_0) $agua_0 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_1 AND $fecha_contador <= $fechaFinSemana_fin_1) $agua_dia_1 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_2 AND $fecha_contador <= $fechaFinSemana_fin_2) $agua_dia_2 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_3 AND $fecha_contador <= $fechaFinSemana_fin_3) $agua_dia_3 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_4 AND $fecha_contador <= $fechaFinSemana_fin_4) $agua_dia_4 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_5 AND $fecha_contador <= $fechaFinSemana_fin_5) $agua_dia_5 = $agua;

                elseif($fecha_contador >= $fechaFinSemana_6 AND $fecha_contador <= $fechaFinSemana_fin_6) $agua_dia_6 = $agua;

                else $sinDato=0;
            }


            if ($gas != "") {
            
                if($fecha_contador >= $fechaFinSemana_0 AND $fecha_contador <= $fechaFinSemana_fin_0) $gas_dia_0 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_1 AND $fecha_contador <= $fechaFinSemana_fin_1) $gas_dia_1 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_2 AND $fecha_contador <= $fechaFinSemana_fin_2) $gas_dia_2 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_3 AND $fecha_contador <= $fechaFinSemana_fin_3) $gas_dia_3 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_4 AND $fecha_contador <= $fechaFinSemana_fin_4) $gas_dia_4 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_5 AND $fecha_contador <= $fechaFinSemana_fin_5) $agua_dia_5 = $gas;

                elseif($fecha_contador >= $fechaFinSemana_6 AND $fecha_contador <= $fechaFinSemana_fin_6) $gas_dia_6 = $gas;

                else $sinDato=0;
            }


            if ($diesel != "") {
            
                if($fecha_contador >= $fechaFinSemana_0 AND $fecha_contador <= $fechaFinSemana_fin_0) $diesel_dia_0 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_1 AND $fecha_contador <= $fechaFinSemana_fin_1) $diesel_dia_1 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_2 AND $fecha_contador <= $fechaFinSemana_fin_2) $diesel_dia_2 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_3 AND $fecha_contador <= $fechaFinSemana_fin_3) $diesel_dia_3 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_4 AND $fecha_contador <= $fechaFinSemana_fin_4) $diesel_dia_4 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_5 AND $fecha_contador <= $fechaFinSemana_fin_5) $diesel_dia_5 = $diesel;

                elseif($fecha_contador >= $fechaFinSemana_6 AND $fecha_contador <= $fechaFinSemana_fin_6) $diesel_dia_6 = $diesel;

                else $sinDato=0;
            }
            
        }

        // Datos para Generar las Graficas de Energeticos.
        $arrayAcontecimientosSemana['graficaSemanaGeneral'] =
        $arraySemana[$dia_6].",".
        $arraySemana[$dia_5].",".
        $arraySemana[$dia_4].",".
        $arraySemana[$dia_3].",".
        $arraySemana[$dia_2].",".
        $arraySemana[$dia_1].",".
        $arraySemana[$dia_0];

        // Se concatenan los valores obtenidos para crear el arreglo de la Grafica.
        $arrayAcontecimientosSemana['graficaElectricidadCantidad'] = 
        $electricidad_dia_6.",
        ".$electricidad_dia_5.",
        ".$electricidad_dia_4.",
        ".$electricidad_dia_3.",
        ".$electricidad_dia_2.",
        ".$electricidad_dia_1.",
        ".$electricidad_dia_0;

        $arrayAcontecimientosSemana['graficaAgua'] = 
        $agua_dia_6.",
        ".$agua_dia_5.",
        ".$agua_dia_4.",
        ".$agua_dia_3.",
        ".$agua_dia_2.",
        ".$agua_dia_1.",
        ".$agua_dia_0;

        $arrayAcontecimientosSemana['graficaGas'] = 
        $gas_dia_6.",
        ".$gas_dia_5.",
        ".$gas_dia_4.",
        ".$gas_dia_3.",
        ".$gas_dia_2.",
        ".$gas_dia_1.",
        ".$gas_dia_0;

        $arrayAcontecimientosSemana['graficaDiesel'] = 
        $diesel_dia_6.",
        ".$diesel_dia_5.",
        ".$diesel_dia_4.",
        ".$diesel_dia_3.",
        ".$diesel_dia_2.",
        ".$diesel_dia_1.",
        ".$diesel_dia_0;

        echo json_encode($arrayAcontecimientosSemana);
    }


    if ($action == "agregarAcontecimiento") {
        $arrayAgregar = array();
        $energetico = strtolower($_POST['energetico']);
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $respuestaAgregar = "";

        $query = "INSERT INTO bitacora_energeticos_acontecimientos(
            id_usuario, id_destino, energetico, titulo, descripcion, fecha
            ) 
            VALUES(
                $idUsuario,
                $idDestino,
                '$energetico',
                '$titulo',
                '$descripcion',
                '$fechaInicio'
            )";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            $respuestaAgregar = "Acontecimiento Agregado.";
        } else {
            $respuestaAgregar = "Error al Agregar Acontecimiento.";
        }

        $arrayAgregar['respuestaAgregar'] = $respuestaAgregar;

        echo json_encode($arrayAgregar);
    }


    if ($action == "eliminarAcontecimiento") {
        $idAcontacimiento = $_POST['idAcontecimiento'];
        $query = "UPDATE bitacora_energeticos_acontecimientos SET activo = 0 WHERE id = $idAcontacimiento";
        $result = mysqli_query($conn_2020, $query);

        if ($result) {
            echo "Acontecimiento Eliminado.";
        } else {
            echo "Error al Eliminar Acontecimiento.";
        }
        
    }


} // Cierre de $action.


?>