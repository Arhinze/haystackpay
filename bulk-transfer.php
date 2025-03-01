<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Index_Segments.php");

Index_Segments::header();

$managers_referrals = [];
$output = [];
$isset_of_ref = false;
$all_referred_accounts = "";

if(isset($_POST["referred_accounts"])){
    $isset_of_ref = true;
    $all_referred_accounts = htmlentities($_POST["referred_accounts"]);

    $managers_referrals = trim($all_referred_accounts);
    $managers_referrals = preg_replace("/[0-9]+\.|[0-9]+\)|[\)]/", "", $all_referred_accounts);
    $managers_referrals_arr = explode("\n", $managers_referrals);
    $managers_referrals_arr = array_map('strtolower', $managers_referrals_arr);
    $managers_referrals_arr = array_map('trim', $managers_referrals_arr);
    $managers_referrals_arr = array_unique($managers_referrals_arr);

    //For Haystack users: ~ to check if they've entered a valid email address:
    foreach($managers_referrals_arr as $man_ref){
        if(filter_var($man_ref, FILTER_VALIDATE_EMAIL) == true){
            $output[] = $man_ref;
        }
    }

    $i = 0;
}

?>

    <div style="margin:105px 9px 24px 9px">
    <?php
        if($isset_of_ref) {
            echo "<h2 style='text-align:center'>Bulk Payment</h2>";
            echo "<div style='margin-bottom:15px'><b style='text-align:center'>The valid email addresses within your list include:</b></div>";

            if(count($output) == 0) { //no valid email on the list
                echo "No valid email found / Empty field submitted.";
            } else {
                foreach($output as $out_put_) {
                    $i += 1;
                    echo "<b>$i.) ".$out_put_."</b><br />";
                }
    ?>
                <div style='margin:18px 6px'>
                    <b>Total number is: <?=$i?>.</b> 
                    <span class="long-action-button" style="width:fit-content;padding:6px 12px;background-color:green"> 
                        Edit List &nbsp;<i class="fa fa-pencil"></i>
                    </span>
                </div>
                <div>
                    <div style="margin:15px 3px"><b>How much do you intend to pay these persons?</b></div>
                    <input name="amount_to_pay" type="number" class="input" required/>
                </div>
                <br /><button class="long-action-button" type = "submit">Proceed to payment <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> </button><br /><br />
    <?php
            } //end of else stmt, that's (if $output !== 0)
        }    
    ?>
    </div>

<?php
Index_Segments::footer();