<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/config/groq.php");

$api_key = $grok_ai_secret_key;
$audioFile = $_FILES["audio"]["tmp_name"];
$url = "https://api.groq.com/openai/v1/audio/transcriptions";
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $api_key"
    ],
    CURLOPT_POSTFIELDS => [
        "file" => new CURLFile($audioFile),
        "model" => "whisper-large-v3"  // Groq model
    ]
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    exit;
}

curl_close($ch);

// Groq already returns proper JSON
header("Content-Type: application/json");
echo $response;

?>