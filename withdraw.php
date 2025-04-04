<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {// that means user is logged in:
    if(isset($_POST["withdrawal_amount"])) { //paystack initialization starts
        $with_amt = (int)htmlentities($_POST["withdrawal_amount"]);
        $bank_name = htmlentities($_POST["bank"]);
        $acct_num = htmlentities($_POST["account_number"]);
        echo "<div class='pop_up' style='color:#fff;background-color:#ff9100'>This feature is coming soon</div>";

        //Initialize Paystack:
        // ...
        //- End of Initialize Paystack:   
        // Mail user . . this should come after successful paystack withdraw integration:
        //$mail_user = mail($data->user_email, "Attempt to withdraw N$with_amt detected", $user_attempt_withdrawal_message, $headers);  
        //check_mail_status($mail_user);
        
        // Mail admin . . this should come after successful paystack withdraw integration:
        //$mail_admin = mail($sender, "A user is attempting to withdraw a sum of N$with_amt", $admin_user_attempt_withdrawal_message, $headers);  
        //check_mail_status($mail_admin); 
        
        // Mail user . . this should come after successful paystack withdraw integration:
        $mail_user = $cm->send_quick_mail($data->user_email, "Attempt to withdraw N$with_amt detected", $user_attempt_withdrawal_message); 
        check_mail_status($mail_user);
        $mail->clearAddresses();
        
        // Mail admin . . this should come after successful paystack withdraw integration:
        $mail_admin = $cm->send_quick_mail($sender, "A user is attempting to withdraw a sum of N$with_amt", $admin_user_attempt_withdrawal_message); 
        check_mail_status($mail_admin);
        $mail->clearAddresses();
    } //paystack initialization ends

    //display header: ~ still under if($data), placed here to avoid header() already initialised error
    //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title="Withdraw - ".SITE_NAME);  
?>

<div style="margin:180px 15px 90px 15px">
    
    <?=Dashboard_Segments::dashboard_body_top()?>

    <h2>Withdraw Money</h2>
    <form method="post" action="" class="dashboard_form">
        <input type="number" class="dashboard_input" id="withdrawal_amount" name="withdrawal_amount" placeholder="How much would you like to withdraw" onkeyup="check_withdraw_status()" required/>
        
        <div id="withraw_status"></div>
        <div style="margin-bottom:12px"><?="Current Balance: <b>N <span id='cb_on_wp'>",$hstkp_transactions->current_balance($data->user_id),"</span></b>"?></div>

        <input type="number" class="dashboard_input" id="account_number" name="account_number" placeholder="Account Number: " minlength="10" required />

        <select name = "bank"  class="dashboard_input" style="margin-bottom:15px" placeholder="Choose your bank" required>
            <option value = "Access" class="input">Access</option>
            <option value = "UBA" class="input">United Bank for Africa</option>
            <option value = "Sterling" class="input">Sterling</option>
            <option value = "Stanbic IBTC" class="input">Stanbic IBTC</option>
            <option value = "Eco Bank" class="input">Eco Bank</option>
            <option value = "Opay" class="input">Opay</option>
            <option value = "Zenith" class="input">Zenith</option>
        </select>

        <button type="submit" class="long-action-button" id="withdraw_confirm_button" style="background-color:green;color:#fff;width:96%">
            Confirm
        </button>
    </form>
</div>

<script>
    function check_withdraw_status() {
        cb_on_wp = Number(document.getElementById("cb_on_wp").innerHTML);
        withdraw_confirm_button = document.getElementById("withdraw_confirm_button");
        withdrawal_amount = Number(document.getElementById("withdrawal_amount").value);

        if(withdrawal_amount > cb_on_wp) {
            withdraw_confirm_button.style = "background-color:#888;color:#fff;width:96%";
            withdraw_confirm_button.disabled = true;
        } else {
            withdraw_confirm_button.style = "background-color:green;color:#fff;width:96%";
            withdraw_confirm_button.disabled = false;
        }
    }
</script>
<?php
    Dashboard_Segments::dashboard_footer(); 
} else { /*end of if($data) for cookie name and pass .. else means user is not logged in*/
    header("location:/login");
} 
?>