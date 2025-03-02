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
            echo "<h2 style='text-align:center'>Bulk Transfer</h2>";
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
                    <button class="long-action-button" style="width:fit-content;padding:9px 15px;background-color:green;text-decoration:none" onclick="show_bt_input_div()"> 
                        Edit List . . &nbsp;<i class="fa fa-pencil"></i>
                    </button>
                </div>
                <div id="bt_input_div" class="bt_input_div" style="display:none">
                    <div class="close_bt_input_div" id="close_bt_input_div" onclick="close_bt_input_div()">
                        <div class="fa-x-icon"><i class ="fa fa-times"></i></div>
                    </div>
                    <!--
                    <div style="margin:12px">
                        <b>Do you intend to send money to multiple persons from a single account? <br />
                        <span style="color:#888">Enter their email addresses, one on each line:</span></b>
                    </div>
                    -->
                                    
                    <div style="font-size:15px;margin-bottom:-12px">Accepted numbering formats are: 1. , 1) or 1.)</div>
                    <form method = "post" action = "">
                        <textarea name="referred_accounts" class="index_textarea" placeholder="Eligible Accounts to Pay: \n  \n1.) abc@example.com \n2) def@example.com \n3. ghi@example.com \n4.) jkl@example.com \n5.) mno@example.com"><?=$all_referred_accounts?></textarea>
                        <br /><button class="long-action-button" type = "submit">Update List <i class="fa fa-angle-double-up"></i> </button><br /><br />
                    </form>
                </div>

                <form method="post" action="/confirm-transaction">
                    <div style="margin:15px 3px"><b>How much do you intend to pay these persons?</b></div>
                    <input type="number" name="amount_to_pay_each_person" id="amount_to_pay_each_person" class="input" onkeyup="calculate_total()" required/>
                    <div id="total_number" style="display:none"><?=$i?></div>
                    <div id="total_to_transfer_text"></div>

                    <input type="hidden" name="transaction_amount" value=""/>
                    <input type="hidden" name="transaction_type" value="bulk_transfer"/>
                    <input type="hidden" name="valid_emails" value="<?=json_encode($output)?>"/>
                    <br /><button class="long-action-button" type = "submit">Proceed to payment <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i> </button><br /><br />
                </form>
                
    <?php
            } //end of else stmt, that's (if $output !== 0)
        }    
    ?>
    </div>
<?php
Index_Segments::footer();