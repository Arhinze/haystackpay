<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

    if($data){ //$data variable from php/account-manager.php
        // that means user is logged in:
        
        //display header
        Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username, $title="Settings - ".$site_name);

        if (isset($_POST["edit_account_data"])){
            //Update Data:
            $us = $pdo->prepare("UPDATE miners SET real_name = ?, twitter_username = ?, avax_wallet_address = ?, aguat_wallet_address = ?, user_email = ? WHERE user_id = ?");

            $us->execute([htmlentities($_POST["full_name"]), htmlentities($_POST["email"]), $data->user_id]);

            $stmt = $pdo->prepare("SELECT * FROM miners WHERE username = ? AND `password` = ?");
            $stmt->execute([$data->username, $password]);
            
            $data = $stmt->fetch(PDO::FETCH_OBJ);

            echo "<div class='pop_up'>Successfully updated account data <i class='fa fa-check-circle-o'></i><span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_up()'></i></span></div>";
        }
?>

<form method="post" action="">

<div class="dashboard_div">

<div class="sign-in-welcome">
    <h3 style="color:#fff"><i class="fa fa-gear"></i>&nbsp; Settings</h3>
    <a href="/"><i class="fa fa-home"> Home</i></a> - Profile
</div>

<!-- Account Data: -->

<div class="clear" style="padding:6px 8px;border-top:1px solid #888;margin:12px">
    <div style="width:30%;float:left">Username:</div>
    <div style="width:60%;float:right"><?=$data->username?></div>
</div>

<div class="clear" style="padding:6px 8px;border-top:1px solid #888;margin:12px">
    <div style="width:30%;float:left">Registration Date:</div>
    <div style="width:60%;float:right"><input type="text" name="" value="<?=date("D M jS Y - h:i a", strtotime($data->entry_date))?>" class="input"/></div>
</div>

<div class="clear" style="padding:6px 8px;border-top:1px solid #888;margin:12px">
    <div style="width:30%;float:left">Your Full name:</div>
    <div style="width:60%;float:right"><input type="text" name="full_name" value="<?=$data->real_name?>" class="input"/></div>
</div>

<div class="clear" style="padding:18px 8px 10px 8px;border-top:1px solid #888;margin:12px" >
&nbsp; <a class = "button" style="background-color:#0bee3ccc" href="/reset-password">Reset Password <i class="fa fa-pencil"></i></a>
</div>


<div class="clear" style="padding:6px 8px;border-top:1px solid #888;margin:12px">
    <div style="width:30%;float:left">Your E-mail Address:</div>
    <div style="width:60%;float:right"><input type="text" name="email" value="<?=$data->user_email?>" class="input"/></div>
</div>

<input type="hidden" name="edit_account_data"/>

<div class="clear" style="padding:6px 8px;border-top:1px solid #888;margin:12px">

<div style="float:right"><button type="submit" class="button" style="background-color:#0bee3ccc"><i class="fa fa-gear"></i> Change Account Data</button></div>

</div>

<!-- Account Data Ends here... -->
</div> 

</form>

<?php
    Dashboard_Segments::dashboard_footer();
    } /*end of count($data) for cookie name and pass*/ else {
        header("location:/login");
    } 
?>