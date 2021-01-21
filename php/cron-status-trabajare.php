<?php

include 'conexion.php';
$APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=STATUS T: ';
$resp = "FALLO INCIDENCIAS";
$query = "UPDATE t_mc SET status_trabajare = '' WHERE status_trabajare != ''";
if ($result = mysqli_query($conn_2020, $query)) {
	$resp = "Restaurado en Incidencias EQUIPOS";
}
file_get_contents($APIERROR . $resp);


$resp = "FALLO INCIDENCIAS GENERALES";
$query = "UPDATE t_mp_np SET status_trabajando = 0 WHERE status_trabajando = 1";
if ($result = mysqli_query($conn_2020, $query)) {
	$resp = "Restaurado en Incidencias Generales";
}
file_get_contents($APIERROR . $resp);

$resp = "FALLO PREVENTIVOS";
$query = "UPDATE t_mp_planificacion_iniciada SET status_trabajando = 0 WHERE status_trabajando = 1";
if ($result = mysqli_query($conn_2020, $query)) {
	$resp = "Restaurado en PREVENTIVOS";
}
file_get_contents($APIERROR . $resp);

$resp = "FALLO PLANES DE ACCIÓN";
$query = "UPDATE t_proyectos_planaccion SET status_trabajando = 0 WHERE status_trabajando = 1";
if ($result = mysqli_query($conn_2020, $query)) {
	$resp = "Restaurado en PLANES DE ACCIÓN";
}
file_get_contents($APIERROR . $resp);
// Fin de la función.
