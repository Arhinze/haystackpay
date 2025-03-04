<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) { // ~ user is logged in
    $total_from_user = 0;
    $tr_color = "";
    
    if(isset($_GET["total_"])) {
        $total_from_user = (int)($_GET["total_"]);
    }
    
    $current_balance = $hstkp_transactions->current_balance($data->user_id);
    $tr_color = ($current_balance >= $total_from_user) ? "green" : "red";
    
    echo "Your current balance is: <b id='cb_id' style='color:$tr_color'> $current_balance </b>";
} else { // ~ user is not logged in
    echo "<div style='color:red;font-weight:bold;'> Please login to view your current balance. </div>";
}

?>

<script> 
    button_status = document.getElelmentById("proceed_to_pay_button");
    if((document.getElementById("cb_id").style.color) == "green") {
        $button_status.disabled = true;
    } else {
        $button_status.disabled = false;
    }
</script>