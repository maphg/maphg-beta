<?php
$botToken = "1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E";
$botApi = "https://api.telegram.org/bot" . $botToken;
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];
$userId = $update["message"]['from']['id'];
$firstname = $update["message"]['from']['username'];
$message = $update["message"]["text"];

//No requieren variables del usuario.
switch ($message) {
    case '/ayuda':
        $response = "Tranquilo, estoy contigo.";
        sendMessage($chatId, $response);
        break;
    case '/pendiente':
        $response = "Tranquilo, estoy contigo.";
        $keyboard = '["Gracias"],["Pos Ok"]';
        sendMessage($chatId, $response, $keyboard);
        break;
}



function sendMessage($chatId, $response)
{
    $url = $GLOBALS["botApi"] . '/sendMessage?chat_id=' . $chatId . '&parse_mode=HTML&text=' . urlencode($response);
    file_get_contents($url);
}
