<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/config/grok.php");
// CHECK IF FILE EXISTS
if (!isset($_FILES['file'])) {
    die("No file received");
}

$audioFilePath = $_FILES['file']['tmp_name'];
$audioFileName = $_FILES['file']['name'];

// Prepare CURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.groq.com/openai/v1/audio/transcriptions");
curl_setopt($ch, CURLOPT_POST, true);

// **MULTIPART FORM DATA**
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "file" => new CURLFile($audioFilePath, mime_content_type($audioFilePath), $audioFileName),
    "model" => "grok-whisper"   // xAI model
]);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $grok_ai_secret_key"
]);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

if ($err) {
    echo "CURL Error: $err";
} else {
    echo $response;
}
?>