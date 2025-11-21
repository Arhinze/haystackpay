<?php

if (!isset($_POST['message'])) {
    $message = htmlentities($_POST["message"]);
}

if ($message = "send 5000 to Francis"){
    return "Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye";
}

?>