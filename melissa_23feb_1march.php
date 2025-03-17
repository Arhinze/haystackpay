<?php

$linkedin_file = trim(htmlentities(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/static/files/linkedin_23feb_1march.txt")));

$linkedin_file = str_replace("+", "", $linkedin_file);
$all_active_accounts = explode("\n", $linkedin_file);
$all_active_accounts = array_map('strtolower', $all_active_accounts);
$all_active_accounts = array_map('trim', $all_active_accounts);
//echo "<h2>All active accounts:</h2>"; print_r($all_active_accounts);

$managers_referrals = [];
$output = [];
$isset_of_ref = false;
$all_referred_accounts = "";

if(isset($_POST["referred_accounts"])){
    $isset_of_ref = true;
    $all_referred_accounts = htmlentities($_POST["referred_accounts"]);

    $managers_referrals = trim($all_referred_accounts);
    $managers_referrals = preg_replace("/[0-9]+\.|[0-9]+\)|[\)]/", "", $all_referred_accounts);
    //echo "<h2>managers referrals: </h2>". $managers_referrals;
    $managers_referrals_arr = explode("\n", $managers_referrals);
    //$managers_json = json_encode($managers_referrals_arr);
    $managers_referrals_arr = array_map('strtolower', $managers_referrals_arr);
    $managers_referrals_arr = array_map('trim', $managers_referrals_arr);
    $managers_referrals_arr = array_unique($managers_referrals_arr);
    //echo "<h2>managers referrals array:</h2>"; print_r($managers_referrals_arr);
    
    foreach($all_active_accounts as $all_act_acct) { //if(!in_array()) could be used here in place of array_unique
        //if(in_array($managers_ref, $all_active_accounts)){
        //    $output[] = $managers_ref;
        //}
        if(strlen($all_act_acct) > 10) {
            $sub_all_act = substr($all_act_acct, 0, -6);
            $sub_all_act = trim($sub_all_act);

            if(preg_grep("/$all_act_acct|$sub_all_act/", $managers_referrals_arr)) {
                if(!empty($all_act_acct)){ 
                    $output[] = $all_act_acct;
                }
            }
        }
    }
    
    $i = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkedin Rentals</title>

    <link rel="stylesheet" href="/static/style.css?$css_version"/>
    <link rel="stylesheet" href="/static/font-awesome-4.7.0/css/font-awesome.min.css"/>


    <style>
        body{
            background-color:#f8f8f8;
            color:#000;/*#888*/
            font-family:tahoma;
            padding:30px 45px;
        }

        .body{
            padding:30px;
        }

        textarea{
            width:90%;
            height:150px;
            border:2px solid #ccc;
            box-sizing:border-box;
            background-color:#f8f8f8;
            border-radius:6px;
            font-size:15px;
            font-family:arial;
            padding:12px 16px;
            margin:15px;
        }

       .long-action-button{
            background-color:#ff9100;
            color:#fff;
            border-radius:5px;
            padding:15px 12px;
            text-align:center;
            width:90%;
            margin: 6px 15px;
        }
    </style>
</head>
<body>
    <h1 style = "text-align:center"><i class="fa fa-linkedin"></i> Linkedin Rentals</h1>
    <div>
        <div style="text-align:center;margin-bottom:24px">
            This program is created for managers to know if their tenants' accounts are still active on WANL(Melissa's company). <br /><br />

            <div style="color:#ff9100;font-weight:bold">Accepted numbering formats are: 1. , 1) or 1.)</div>
        </div>
        <div style="text-align:center;font-weight:bold;font-size:18px">
            Input all the emails you wish to seek for.<br />
            (one on each line).
        </div>
    </div>
    <form method = "post" action = "">
        <textarea name="referred_accounts"><?=$all_referred_accounts?></textarea>
        <br /><button class="long-action-button" type = "submit"><i class="fa fa-flash"></i> Submit</button><br /><br />
    </form>

    <div style="margin:24px 15px">
    <?php
        if($isset_of_ref) {
            echo "<h2 style='text-align:center'>This Manager's Referals' accounts still active for the week are:</h2>";

            if(count($output) == 0) {
                echo "No referrals for this manager the week / Empty field submitted.";
            } else {
                foreach($output as $out_put_) {
                    $i += 1;
                    echo "<b>$i.) ".$out_put_."</b><br />";
                }
            
                echo "<br /><br /><b>Total number is: $i.</b>";
            }
    ?>
        <form method="post" action="/melissa_view_file_23feb_1march">
            <input type="hidden" name="managers_accounts" value="<?=$all_referred_accounts?>"/>
            
            <button class="long-action-button" style="background-color:blue;color:#fff" type="submit"> <i class="fa fa-file"></i> View on File >> </button>
        </form>
   <?php
        }    
    ?>
    </div>
</body>
</html>

<!--
Nelsonaaron70@gmail.com
jonathanfavour7@gmail.com
dessien64@gmail.com
aulejosephine01@gmail.com
keshbentley020@gmail.com
Khalidzubair085@gmail.com
eebuka583@gmail.com
ijebus2004@gmail.com
joshuaisaac265@gmail.com
oyesinapaul0@gmail.com
dangkat123@gmail.com
olayiwolahissa484@gmail.com
oluwadarasimi765@gmail.com
Mmeaomajames2006@gmail.com
karmalrashid@gmail.com
Ohitzandrew@gmail.com
Hezekiel4real@yahoo.com
yisaedward@gmail.com
adewuyitobi730@gmail.com
sahmedtyabo90@gmail.com
favourakinnifesi@yahoo.com
mohammedibrahimarabi@gmail.com
davidoriyomi21@gmail.com
-->