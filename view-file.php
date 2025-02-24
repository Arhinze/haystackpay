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
            if(!isset($_POST["managers_accounts"])){
                $i=0;
                foreach($all_active_accounts as $all_act_acct) {
                    $i++;
                    echo $i, ".) ", $all_act_acct, "<br />";
                }
            } else {
                var_dump($_POST); echo "<br />";
                echo $_POST["managers_accounts"];
                $managers_rentals = json_decode($_POST["managers_accounts"]);
                echo "Managers Rentals: "; print_r($managers_rentals);
                foreach($all_active_accounts as $all_act_acct) {
                    if(in_array($all_act_acct, $managers_rentals)) {
                        echo "<b>$all_act_acct</b> <i class='fa fa-check-o'></i>";
                    } else {
                        echo $all_act_acct;
                    }
                }
            echo "<br /><br /><b>Managers Total Active Referrals:</b> ", count($managers_rentals);
            }
            echo "<br /><b>Total active accounts for the week:</b> ", count($all_active_accounts);
        ?>
        </div>
    </div>
</body>
</html>