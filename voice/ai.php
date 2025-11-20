<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/config/chatgpt.php");
$api_key = $ai_secret_key;
$text = $_POST['message'];

$url = "https://api.openai.com/v1/chat/completions";

$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "user", "content" => $text]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
