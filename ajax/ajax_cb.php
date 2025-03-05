<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) { // ~ user is logged in
    $total_from_user = 0;
    $tr_color = "";
    
    if(isset($_GET["total_"])) {
        $total_from_user = (int)($_GET["total_"]);
    }
    $current_balance = $hstkp_transactions->current_balance($data->user_id);
    echo "N",$current_balance;
} else { // ~ user is not logged in
    echo "not available, kindly log in.";
}
?>