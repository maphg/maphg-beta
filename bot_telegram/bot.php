<?php
$botToken = "1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E";
$website = "https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E";
$update = file_get_contents('php://input');
$update = json_decode($update);
$chatId = "989320528";
$chatType = $update["message"]["chat"]["type"];
$message = $update["message"]["text"];

switch ($message) {
    case 'ayuda':
        $response = "Pendiente 1";
        sendMessageX($chatId, $response);
        break;
    case 'pendientes':
        $response = "Pendiente 2";
        sendMessageX($chatId, $response);
        break;
}



function sendMessageX($chatId, $response)
{
    // $url = $GLOBALS["website"] . '/sendMessage?chat_id=' . $chatId . '&text=' . urlencode($response);
    $url = "https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=spoifsdffdsf";
    file_get_contents($url);
}
