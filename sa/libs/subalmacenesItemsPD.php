<?php
include 'subalmacenesItemsAD.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action == "agregarItem"){
        $item = new SubalmacenesItemsINFO();
        $item->idSubalmacen = $_POST['idSubalmacen'];
        $item->cod2bend = $_POST['cod2bend'];
        $item->descripcion = $_POST['material'];
        $item->caracteristicas = $_POST['caracteristicas'];
        $item->cantidad = $_POST['cantidad'];
        $item->marca = $_POST['marca'];
        $item->categoria = $_POST['categoria'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->agregarItem($item);
        echo $resp;
        
    }
    
    if($action == "obtenerItem"){
        $idItem = $_POST['idItem'];
        $items = new subalmacenesItemsAD();
        $item = $items->obtenerItem($idItem);
        echo json_encode($item);
    }
    
    if($action == "actualizarItem"){
        $item = new SubalmacenesItemsINFO();
        $item->id = $_POST['idItem'];
        $item->cod2bend = $_POST['cod2bend'];
        $item->descripcion = $_POST['material'];
        $item->caracteristicas = $_POST['caracteristicas'];
        $item->marca = $_POST['marca'];
        $item->categoria = $_POST['categoria'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->actualizarItem($item);
        echo $resp;
    }
    
    if($action == "buscarEquipo"){
        $palabra = $_POST['palabra'];
        $idSubalmacen = $_POST['idSubalmacen'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->buscarItem($palabra, $idSubalmacen);
        echo $resp;
    }
    
    if($action == "buscarItemSalida"){
        $palabra = $_POST['palabra'];
        $idSubalmacen = $_POST['idSubalmacen'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->buscarItem($palabra, $idSubalmacen);
        echo $resp;
    }
    
    if($action == "actualizarStock"){
        $idUsuario = $_POST['idUsuario'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->actualizarStock($idUsuario);
        echo $resp;
    }
    
    if($action == "registrarSalidaMaterial"){
        $idUsuario = $_POST['idUsuario'];
        $idSubalmacen = $_POST['idSubalmacen'];
        $idGift = $_POST['idGift'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->registrarSalidaMaterial($idUsuario, $idSubalmacen, $idGift);
        echo $resp;
    }
    
    if($action == "registrarSalidaMaterialZI"){
        $idUsuario = $_POST['idUsuario'];
        $idSubalmacen = $_POST['idSubalmacen'];
        $tipo = $_POST['tipo'];
        $motivo = $_POST['motivo'];
        $items = new SubalmacenesItemsPD();
        $resp = $items->registrarSalidaMaterialZI($idUsuario, $idSubalmacen, $tipo, $motivo);
        echo $resp;
    }
    
    if($action == "obtEquipo"){
        $idDestino = $_POST['idDestino'];
        $subseccion = $_POST['subseccion'];
        $obj = new SubalmacenesItemsPD();
        $resp = $obj->obtenerEquipos($subseccion, $idDestino);
        echo $resp;
    }
    
    if($action == "obtMotivos"){
        $idEquipo = $_POST['idEquipo'];
        $tipo = $_POST['tipo'];
        $obj = new SubalmacenesItemsPD();
        $resp = $obj->obtenerMotivos($idEquipo, $tipo);
        echo $resp;
    }
    
    
}


Class SubalmacenesItemsPD{
    
    public function obtenerListaSubalmacenes($idDestino, $fase){
        $items = new subalmacenesItemsAD();
        return $salida = $items->obtenerListaSubalmacenes($idDestino, $fase);
    }
    
    public function obtenerListaItems($idSubalmacen){
        $items = new subalmacenesItemsAD();
        return $listaItems = $items->obtenerListaItesm($idSubalmacen);
    } 
    
    public function agregarItem($item){
        $items = new subalmacenesItemsAD();
        return $items->agregarItem($item);
    }
    
    public function obtenerItem($idItem){
        $items = new subalmacenesItemsAD();
        return $items->obtenerItem($idItem);
    }
    
    public function actualizarItem($item) {
         $items = new subalmacenesItemsAD();
        return $items->actualizarItem($item);
    }
    
    public function buscarItem($palabra, $idSubalmacen) {
        $items = new subalmacenesItemsAD();
        return $items->buscarItem($palabra, $idSubalmacen);
    }
    
    public function buscarItemSalida($palabra, $idSubalmacen) {
        $items = new subalmacenesItemsAD();
        return $items->buscarItemSalida($palabra, $idSubalmacen);
    }
    
    public function actualizarStock($idUsuario) {
        $items = new subalmacenesItemsAD();
        return $items->actualizarStock($idUsuario);
    }
    
    public function registrarSalidaMaterial($idUsuario, $idSubalmacen, $idGift){
        $items = new subalmacenesItemsAD();
        return $items->registrarSalidaMaterial($idUsuario, $idSubalmacen, $idGift);
    }
    
    public function registrarSalidaMaterialZI($idUsuario, $idSubalmacen, $tipo, $motivo){
        $items = new subalmacenesItemsAD();
        return $items->registrarSalidaMaterialZI($idUsuario, $idSubalmacen, $tipo, $motivo);
    }
    
    public function obtenerEquipos($idSubseccion, $idDestino){
        $obj = new subalmacenesItemsAD();
        return $obj->obtenerEquipos($idSubseccion, $idDestino);
    }
    
    public function obtenerMotivos($idEquipo, $tipo) {
        $obj = new subalmacenesItemsAD();
        return $obj->obtenerMotivos($idEquipo, $tipo);
    }
}

?>

