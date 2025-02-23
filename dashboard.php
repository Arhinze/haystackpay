<?php

include_once("views/Dashboard_Segments.php");

//include Account Management File
include_once($_SERVER["DOCUMENT_ROOT"]."/php/account-manager.php");

    if($data){
        // that means user is logged in:

        //Get Last seen:
        $last_seen_stmt = $pdo->prepare("SELECT * FROM investors WHERE user_id = ?");
        $last_seen_stmt->execute([$data->user_id]);
        $last_seen_data = $last_seen_stmt->fetch(PDO::FETCH_OBJ);

        $last_seen = $last_seen_data->last_seen;

        if($last_seen == null) {
            $last_seen = date("Y-m-d h:i:s", time());
        }

        //update last seen:
        $stmt = $pdo->prepare("UPDATE investors SET last_seen = ? WHERE username = ? AND `password` = ?");
        $stmt->execute([date("Y-m-d h:i:s", time()), $username, $password]);


        //get pending withdrawals value:
        $pending_withdraw_stmt = $pdo->prepare("SELECT * FROM user_requests WHERE user_id = ? AND rq_type = ?");
        $pending_withdraw_stmt->execute([$data->user_id, "Withdraw"]);
        $pending_withdraw_data = $pending_withdraw_stmt->fetchAll(PDO::FETCH_OBJ);
        
        $pending_withdraw_amt = 0;
        if (count($pending_withdraw_data) > 0) {
            foreach ($pending_withdraw_data as $pd) {
                $pending_withdraw_amt = $pd->rq_amount;
            }
        }
        
          
        //display header:
        Dashboard_Segments::header();
        
?>

<div class="dashboard_div">

    <!--Wallets--> 
    <div class="wallet">
        <div class="wallet_left">
            <span class="wallet_left_top">$<?=$current_balance?></span><br />
            Current Balance<br />
        </div>
    
        <div class="wallet_right">
            <i class="fa fa-dollar"></i> <!--fa fa-wallet-->
        </div>
    </div>


    <div class="wallet">
        <div class="wallet_left">
            <span class="wallet_left_top">$<?=$total_withdraw?></span>
            
            <br />Total Withdrawals <br />
        </div>
        <div class="wallet_right">
            <i class="fa fa-cloud-download"></i>
        </div>
    </div>
    

    <div class="wallet">
        <div class="wallet_left">
            <span class="wallet_left_top">$<?=$pending_withdraw_amt?></span>
            
            <br />Pending Withdrawals <br />
        </div>
        <div class="wallet_right">
            <i class="fa fa-users"></i>
        </div>
    </div>
    <!--Wallets end--> 

    <br />
</div> <!--Dahboard div ends--> 

<center>
    <a href="/deposit" class="action_button" style="background-color:#2b8eeb;color:#fff;border:1px solid #fff;border-radius:4px">
        Make Deposit
    
        &nbsp;
        <i class="fa fa-angle-right"></i>
        <i class="fa fa-angle-right"></i>
    </a>
    
    &nbsp;
    
    <a href="/withdraw" class="action_button" style="background-color:#01123c;color:#fff;border:1px solid #fff;border-radius:4px">
        Make Withdrawal
    
        &nbsp;
        <i class="fa fa-angle-right"></i>
        <i class="fa fa-angle-right"></i>
    </a>
</center>

<br />
    
<!--Dashboard Lower div--> 
<div class="dashboard_lower_div">
    <div style="background-color:#2b8eeb;padding:6px">Dashboard</div>
    <div style="padding:12px">
        Active Deposit &nbsp; &nbsp; $<?=$active_deposit?>
    </div> 

    <div style="padding:12px">
        Last Access &nbsp; &nbsp; &nbsp; &nbsp; <?=date("D M jS Y - h:i a", strtotime($last_seen))?>
    </div> 
</div>
<!--Dashboard Lower div ends--> 


<!-- Referral Link section starts -->
    <div style="padding:12px">
        <!-- style="color:#afabab" --><h3 style="color:#000">Your Referral Link</h3>
        
        <input style="height:24px;border:1px solid #2b8eeb;
        border-right:30px solid #2b8eeb;width:80%;
        border-radius:4px;margin-top:8px" id = 'referral_link'
        value="https://<?=$site_url_short?>/?ref=<?=$_COOKIE['username']?>"/>
        
        <i style="margin-left:-27px" class="fa fa-copy" onclick="copyText('referral_link')"></i>
        <br /> 
    </div>
<!-- Referral Link section ends -->



<?php
Dashboard_Segments::footer();
    } /*end of count($data) for cookie name and pass*/ else {
        header("location:/login");
    } 
?>