<?php

if (!isset($_GET['message'])) {
    $message = htmlentities($_GET["message"]);
}

//$style= "position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%";

if ($message = "send 5000 to Frances"){
    echo "<div id='pts' style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Do you wish to send 5000 Naira to 0095000000 Access Bank - Francis Arinze Okoye ".'<div class="button" onclick=show_div("pts")>'."Yes, Proceed <i class='fa fa-arrow-right'></i></div></div>";
} elseif($message = "send 5000 to Francis"){
    echo "<div style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Do you wish to send 5000 Naira to 0099000000 Access Bank - Frances Achalugo</div>";
} elseif ($message = "send 6000 to Cynthia"){
    echo "<div style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Do you wish to send 6000 Naira to 2218000000 UBA Bank - Cynthia Chidinma Ochuba</div>";
} elseif ($message = "send 10,000 to Pascal"){
    echo "<div style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Do you wish to send 10,000 Naira to 2291300000 Sterling Bank - Pascal Nnamdi Okafor</div>";
} elseif ($message = "send 3000 to Samuel"){
    echo "<div style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Do you wish to send 3000 Naira to 2254000000 Zenith Bank - Samuel Jaruma Ibrahim</div>";
} else {
    echo "<div style='position:fixed;z-index:5;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:150px;width:70%;text-align:center;font-weight:bold;top:25%;left:5%'>Sorry no response gotten/ this user is not a saved beneficiary</div>";
}

?>