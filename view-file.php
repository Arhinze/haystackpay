<?php
$linkedin_file = trim(htmlentities(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/static/files/linkedin.csv")));
//echo "<h2>All active accounts:</h2>".$linkedin_file;

$all_active_accounts = explode("\n", $linkedin_file);
$all_active_accounts = array_map('strtolower', $all_active_accounts);
$all_active_accounts = array_map('trim', $all_active_accounts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkedin Rentals Main File</title>

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
    <h1 style = "text-align:center"><i class="fa fa-linkedin"></i>Linkedin Rentals - WANL(Melissa)</h1>
    <div>
        <div style="text-align:center;margin:21px 12px;border-bottom:3px solid #888;padding:18px 12px">
            Below is a file showing all active accounts for the week on WANL(Melissa's company). <br /><br />
        </div>

        <div style="margin: 24px; 12px">
        <?php
            $i=0; var_dump($_POST);  echo "<br /><br /> Post_of_Managers_account";
            if(isset($_POST["managers_accounts"])){
                echo $_POST["managers_accounts"]; echo "<br /><br />";
                $managers_referrals = $_POST["managers_accounts"];
                $managers_referrals = trim($all_referred_accounts);
                $managers_referrals = preg_replace("/[0-9]+\.|[0-9]+\)|[\)]/", "", $all_referred_accounts);
                //echo "<h2>managers referrals: </h2>". $managers_referrals;
                $managers_referrals_arr = explode(" ", $managers_referrals);
                //$managers_json = json_encode($managers_referrals_arr);
                $managers_referrals_arr = array_map('strtolower', $managers_referrals_arr);
                $managers_referrals_arr = array_map('trim', $managers_referrals_arr);
                $managers_referrals_arr = array_unique($managers_referrals_arr);

                echo "managers_ref_arr: "; print_r($managers_referrals_arr); echo "<br />";

                foreach($all_active_accounts as $all_act_acct) {
                    $i++;
                    if(in_array($all_act_acct, $managers_referrals_arr)) {
                        echo "<b>$i.) $all_act_acct</b> <i class='fa fa-check-o'></i> <br />";
                    } else {
                        echo $i, ".) ", $all_act_acct, "<br />";
                    }
                }
            echo "<br /><br /><b>Managers Total Active Referrals:</b> ", count($managers_rentals);
            } else {
                foreach($all_active_accounts as $all_act_acct) {
                    $i++;
                    echo $i, ".) ", $all_act_acct, "<br />";
                }
            }
            echo "<br /><b>Total active accounts for the week:</b> ", count($all_active_accounts);
        ?>
        </div>
    </div>
</body>
</html>