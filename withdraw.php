<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {// that means user is logged in:
    if(isset($_POST["withdrawal_amount"])) { //paystack initialization starts
        
        $with_amt = (int)htmlentities($_POST["withdrawal_amount"]);
        echo "<div class='pop_up' style='color:#fff;background-color:#ff9100'>This feature is coming soon</div>";
        //Initialize Paystack:
        
    } //paystack initialization ends

    //display header: ~ still under if($data), placed here to avoid header() already initialised error
    //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title="Withdraw - ".SITE_NAME);  
?>

<div style="margin:180px 15px 90px 15px">
    <h2>Withdraw Money</h2>
    <form method="post" action="" style="background-color:#fff;padding:12px;border-radius:9px;border:1px solid #ff9100">
        <input type="number" class="input" id="withdrawal_amount" name="withdrawal_amount" placeholder="How much would you like to withdraw" style="border:1px solid #888;margin:18px 3px;height:42px;width:96%" onkeyup="check_withdraw_status()" required/>
        
        <div id="withraw_status"></div>
        <div style="margin-bottom:12px"><?="Current Balance: <b>N <span id='cb_on_wp'>",$hstkp_transactions->current_balance($data->user_id),"</span></b>"?></div>

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