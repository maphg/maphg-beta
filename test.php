<?php 
$resultResponsables = [0,2,3,4,5,6,10];
$idResponsable = "10";
$buscarResponsable = array_search($idResponsable, $resultResponsables, false);

echo $buscarResponsable;
?>