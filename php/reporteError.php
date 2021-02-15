<?php
if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

    if ($action = "reporteError") {
        $error = $_GET['error'];
        $pagina = $_GET['pagina'];
        $funcion = $_GET['funcion'];

        $resp = file_get_contents($APIERROR . $error . " | " . $pagina . " | " . $funcion);
        echo json_encode('ok');
    }
}