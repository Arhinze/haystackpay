<?php

if (!isset($_GET['message'])) {
    $message = htmlentities($_POST["message"]);
}

if ($message = "send 5000 to Francis"){
    return "Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye";
} else if ($message = "send 5000 to Frances"){
    return "Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye";
} else {
    return "Sorry, this user is not a saved beneficiary";
}

?>