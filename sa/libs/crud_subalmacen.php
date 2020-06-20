<?php
include "conexion.php";

if(isset($_POST['action'])) {
    
    $action = $_POST['action'];
    
    
        if($action =="Agregar"){
            $idDestino = $_POST['idDestino'];
            $idFase = $_POST['idFase'];
            $subalmacen = $_POST['subalmacen'];
    
            switch ($idFase){
                case 1:
                    $fase="GP";
                break;
    
                case 2:
                    $fase="TRS";
                break;
    
                case 3:
                    $fase="ZI";
                break;
            }
    
    
            $query= "INSERT INTO  t_subalmacenes(id_destino, id_fase, nombre, fase) VALUES($idDestino, $idFase, '$subalmacen', '$fase')";
            $result = mysqli_query($conn_2020, $query);
            if($result){
                echo "1";
            }else{
                echo "0";
            }
        }
    
        if($action =="Actualizar"){
            $idDestino = $_POST['idDestino'];
            $idFase = $_POST['idFase'];
            $subalmacen = $_POST['subalmacen'];
            $idSubalmacen = $_POST['idSubalmacen'];
    
            switch ($idFase){
                case 1:
                    $fase="GP";
                break;
    
                case 2:
                    $fase="TRS";
                break;
    
                case 3:
                    $fase="ZI";
                break;
            }
    
    
            $query= "UPDATE  t_subalmacenes SET nombre='$subalmacen', id_fase=$idFase,  fase='$fase' WHERE id=$idSubalmacen";
            $result = mysqli_query($conn_2020, $query);
            if($result){
                echo "Agregado";
            }else{
                echo "Error Agregar";
            }
        }
    
        if($action == "eliminarSubalmacen"){
            $idDestino = $_POST['idDestino'];
            $idFase = $_POST['idFase'];
            $subalmacen = $_POST['subalmacen'];
            $idSubalmacen = $_POST['idSubalmacen'];
    
            switch ($idFase){
                case 1:
                    $fase="GP-eliminado";
                break;
    
                case 2:
                    $fase="TRS-eliminado";
                break;
    
                case 3:
                    $fase="ZI-eliminado";
                break;
            }
    
    
            $query= "UPDATE  t_subalmacenes SET fase='$fase' WHERE id=$idSubalmacen";
            $result = mysqli_query($conn_2020, $query);
            if($result){
                echo "Agregado";
            }else{
                echo "Error Agregar";
            }
        }


    
    if($action == "consultaSubalmacen"){
        $salida = array();
        $idSubalmacen = $_POST['idSubalmacen'];

        $query = "SELECT* FROM t_subalmacenes WHERE id=$idSubalmacen"; 
        $result = mysqli_query($conn_2020, $query);

        while($row = mysqli_fetch_array($result)){
            $salida['nombreSubalmacen'] = $row["nombre"];
            $salida['fase'] = $row["id_fase"];
        }
        echo json_encode($salida);
    }


    // Nuevas funciones para la version Beta_2020.

    if ($action == "eliminarSubalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $query = "";
        if (mysqli_query($conn_2020, $query)) {
            echo "Subalmacén Eliminado";
        }else{
            echo "Error al Eliminar Subalmacén";
        }
    }


}//Fin $action.