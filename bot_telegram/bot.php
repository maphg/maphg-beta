<?php
$botToken = "1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E";
$website = "https://api.telegram.org/bot" . $botToken;
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
echo json_encode($update);
$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];
$message = $update["message"]["text"];

switch ($message) {
    case '/ayuda':
        $response = "Tranquilo, estoy contigo.";
        sendMessage($chatId, $response);
        break;
    case '/pendientes':
        $response = "Tranquilo, estoy contigo.";
        sendMessage($chatId, $response);
        break;
}



function sendMessage($chatId, $response)
{
    $url = $GLOBALS[website] . '/sendMessage?chat_id=' . $chatId . '&parse_mode=HTML&text=' . urlencode($response);
    file_get_contents($url);
}
