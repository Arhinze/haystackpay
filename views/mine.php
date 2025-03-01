<?php

include_once("/home/u590828029/domains/aguanit.com/public_html/views/Dashboard_Segments.php");
 
if (((isset($_POST["f_username_or_email"])) && ((isset($_POST["f_password"]))))) {
    $user_id = $_POST["f_username_or_email"];
    $password = $_POST["f_password"];

    $stmt = $pdo->prepare("SELECT * FROM miners WHERE (username = ? OR user_email = ?) AND `password` = ?");
    $stmt->execute([$user_id, $user_id, $password]);
    
    $f_data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(count($f_data)>0){
        setcookie("username_or_email", $_POST["f_username_or_email"], time()+(24*3600), "/");
        setcookie("password", $_POST["f_password"], time()+(24*3600), "/");

        header("location:$site_url/redirect_to_mining_page");
    } else {
        echo "Incorrect username/email combination. Wait a minute though, How did you get here in the first place? :)";
    }
} 

if ($data){//$data from account-manager.php
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $site_mining_page_url = SITE_MINING_PAGE_URL, $Hi_user = $data->username); 

    $mining_stat = $data->mining_status;
    $amount_mined = $data->total_amount_mined;
    $mining_style = "";
    $mining_hours_left = "00";
    $mining_minutes_left = "00";
    $mining_seconds_left = "00";
    $mining_time_left = "00:00:00";
    
    if ($mining_stat == "active"){
        $amount_mined += ((time() - strtotime($data->mining_start_time))*0.0000058);   
        $mining_style = "rotate_360";

        $total_mining_seconds_left = ((strtotime($data->mining_start_time)+(48*60*60)) - time());
        $total_mining_minutes_left = floor($total_mining_seconds_left/60);
        $mining_hours_left = floor($total_mining_minutes_left/60);
        $mining_minutes_left = $total_mining_minutes_left - ($mining_hours_left*60);
        $mining_seconds_left = $total_mining_seconds_left - ($total_mining_minutes_left*60);
        //OR:
        //$mining_seconds_left = ($total_mining_seconds_left % (60))

        //so it appears in 00:00:00 format instead of 0:0:00 or otherwise
        $mining_hours_left = $mining_hours_left >= 10 ? $mining_hours_left : "0$mining_hours_left";
        $mining_minutes_left = $mining_minutes_left >= 10 ? $mining_minutes_left : "0$mining_minutes_left";
        $mining_seconds_left = $mining_seconds_left >= 10 ? $mining_seconds_left : "0$mining_seconds_left";
        
        $mining_time_left = "$mining_hours_left:$mining_minutes_left:$mining_seconds_left";
    }

    //Get Referral bonus:
    $ref_stmt = $pdo->prepare("SELECT * FROM miners WHERE referred_by = ? LIMIT ?, ?");
    $ref_stmt->execute([$data->username, 0, 500]);
    
    $ref_data = $ref_stmt->fetchAll(PDO::FETCH_OBJ);
    $referral_bonus = count($ref_data);
?>
    
<?php
//Tests: 
/*
echo "<b>Tests:</b><br /><br />";
echo "mining start time: ",strtotime($data->mining_start_time)+(48*60*60),"<br/>";
echo "mining end time: ",date("Y-m-d h:i:a",strtotime($data->mining_start_time)+(48*60*60)),"<br/>";
echo "current time: ".time()."<br/>";
echo "total_mining_seconds_left: $total_mining_seconds_left <br/>";
echo "total_mining_minutes_left: $total_mining_minutes_left <br/>";
echo "mining_hours_left: $mining_hours_left <br/>";
echo "mining_minutes_left: $mining_minutes_left <br/>";
echo "mining_seconds_left: $mining_seconds_left <br/>";
echo "mining_seconds_left(2nd formula):",($total_mining_seconds_left % (60));

echo "<br /><br />";
echo "mining_time_left: $mining_time_left"; 
*/
?> 

<!--<div id="test"></div>-->

    <div style="margin-top:135px" class="dashboard_div">
    <center>
        <div id="mining_status" style="display:none"><?=$mining_stat?></div>  
        
        <div id="ajax_mine"></div>
        <div id="boost_mining_speed"></div>

        <div style="font-size:45px;font-weight:bold;font-family:Arial;margin-bottom:30px;display:flex;justify-content:center;margin-top:18px">
            <div style="margin-right:9px;margin-top:-2px">
                <img src="<?=$site_url?>/static/images/logo.png" style="width:51px;height:51px" onclick="rotate_360()" id="small_coin"/>
            </div>
            <div>
                <span id="amount_mined"><?=round($amount_mined, 6)?></span>
            </div>
        </div>

        <div style="position:relative;width:225px;height:225px">
            <img onclick="start_mining(u_name='<?=$data->username?>', u_password='<?=$data->password?>')"  src="<?=$site_url?>/static/images/logo.png" id="inner_button" class="<?=$mining_style?>"/>
            <!--<i class="fa fa-power-off" style="" id="inner_button"></i>-->
        </div>

        <div class="mining_cards_parent" >
            <div class="mining_cards" style="width:260px;margin-top:30px;">
                <div class="mining_cards_head" style="position:relative">
                    <div style="position:absolute;float:left">Current mining rate</div>
                    <div style="position:absolute;float:right;right:3px;color:#0bee3ccc;font-weight:bold" onclick="boost_mining_speed()"><i class="fa fa-plane"></i> Boost</div>
                </div>
                <div class="mining_cards_body"><i class="fa fa-bolt"></i> <?=0.0000058*60?><?=" $".$token_name." / h"?></div>
            </div>
        </div>

        <div class="mining_cards_parent" style="margin-bottom:30px">
            <div class="mining_cards">
                <div class="mining_cards_head">Mining time left</div>
                <div class="mining_cards_body">
                    <i class="fa fa-clock-o"></i>
                    <span id="mining_time_left"><?=$mining_time_left?></span></div>
            </div>

            <div class="mining_cards">
                <div class="mining_cards_head">Bonus from referrals</div>
                <div class="mining_cards_body"><i class="fa fa-bullseye"></i><?=$referral_bonus?> $AGUAT</div>
            </div>
        </div>
    </center>
    </div>

<?php
    Dashboard_Segments::dashboard_footer(); 
} else {
    header("location:$site_url/login");
}
?>