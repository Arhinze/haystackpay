<?php

ini_set("display_errors", 1);
$username = "";
//$deposit_amount ="";
if($data) {
    $username = $data->username;
}
      
$attempted_deposit_order = <<<HTML
    <html><head><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/><link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/></head>
    <body style ="font-family:Trirong;">
        <div style="position:relative">
            <img src="$site_url/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
        </div>
        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
            <p  style ="font-family:Trirong;">
                Hello Sir, a user with username: $username attempted to deposit N$deposit_amount in his dashboard.
            </p>
    </body>
    </html>
HTML;

$sender = "admin@$site_url_short";

$headers = "From: $sender \r\n";
$headers .="Reply-To: $sender \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html; charset=UTF-8\r\n";


//if($mail && $mail2 && $mail3 && $mail4){
//    echo "<br /> <span style='color:#e93609; margin-left:15px'> <b>Thank you, Your order has been successfully received, kindly await a call from our  Sales Representative</b> </span>";
//} else {
//    echo "<span style='color:red'> <b>Sorry, an error occurred, Order not sent</b> </span>";
//}

function check_mail_status($mail) {
    if ($mail) {
        echo "<br /> <span style='color:#e93609; margin-left:15px'> <b>Mail Sent Successfully</b> </span>";
    } else {
        echo "<span style='color:red'> <b>Sorry, an error occurred, Mail not sent</b> </span>";
    }
}