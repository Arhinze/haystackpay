<?php

if (!isset($_GET['message'])) {
    $message = htmlentities($_GET["message"]);
}

$style= "position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:30%;left:5%";

if ($message = "send 5000 to Francis"){
    echo "<div style=$style>Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye</div>";
} else if ($message = "send 5000 to Frances"){
    echo "<div style=$style>Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye</div>";
} else {
    echo "<div style=$style>Sorry, this user is not a saved beneficiary</div>";
}

?>