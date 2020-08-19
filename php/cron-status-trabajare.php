<?php

// Función para Inicializar el Status_Trabajare. en t_mc.
//date_default_timezone_set('America/Cancun');
// setlocale(LC_MONETARY, 'es_ES');
include 'conexion.php';
//$fecha_hoy = date('Y-m-d G:m:s');
//$fecha_fin_horario = date('Y-m-d 16:00:00');


$query = "UPDATE t_mc SET status_trabajare = '' WHERE status_trabajare != ''";
if ($result = mysqli_query($conn_2020, $query)) {
	echo  "Horario Finalizado, el Status Trabajare se Inicializo. Enviado por: SOPORTE@MAPHG.COM";
} else {
	echo "Parametros No Esperados, para Inicializar el Status Finalizado.  Enviado por: SOPORTE@MAPHG.COM";
}

$query = "UPDATE t_mp_np SET status_trabajando = 0 WHERE status_trabajare = 1";

if ($result = mysqli_query($conn_2020, $query)) {
	echo  "Horario Finalizado, el Status Trabajare se Inicializo. Enviado por: SOPORTE@MAPHG.COM";
} else {
	echo "Parametros No Esperados, para Inicializar el Status Finalizado.  Enviado por: SOPORTE@MAPHG.COM";
}
// Fin de la función.
