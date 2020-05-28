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

            $electricidad = $row['electricidad'];   
            $agua = $row['agua'];   
            $gas = $row['gas'];   
            $diesel = $row['diesel'];
            $ocupacion = $row['ocupacion'];
            $pax = $row['pax'];

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

        $query = "SELECT* FROM bitacora_energeticos_acontecimientos WHERE id_destino = $idDestino AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND activo=1";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
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
            }
        }


        // Comprueba si tiene información, de lo contrario le manda uns msj.
        if($dataAcontecimientosElectricidad == ""){
            $dataAcontecimientosElectricidad = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Datos
            </div>
            ";
        }

        if($dataAcontecimientosElectricidadAgua == ""){
            $dataAcontecimientosElectricidadAgua = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Datos
            </div>
            ";
        }

        if($dataAcontecimientosElectricidadGas == ""){
            $dataAcontecimientosElectricidadGas = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Datos
            </div>
            ";
        }

        if($dataAcontecimientosElectricidadDiesel == ""){
            $dataAcontecimientosElectricidadDiesel = 
            "
            <div class=\"flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1 font-bold\">
            Sin Datos
            </div>
            ";
        }



        $arrayAcontecimientos['dataAcontecimientosElectricidad'] = $dataAcontecimientosElectricidad;

        $arrayAcontecimientos['dataAcontecimientosElectricidadAgua'] = $dataAcontecimientosElectricidadAgua;

        $arrayAcontecimientos['dataAcontecimientosElectricidadGas'] = $dataAcontecimientosElectricidadGas;

        $arrayAcontecimientos['dataAcontecimientosElectricidadDiesel'] = $dataAcontecimientosElectricidadDiesel;


        echo json_encode($arrayAcontecimientos);
    }


} // Cierre de $action.


?>