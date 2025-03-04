<?php

ini_set("display_errors", 1);
$username = "";
$dep_amount ="";
$user_mail ="";
if($data) {
    $username = $data->username;
    $user_mail = $data->user_email;
}

if(isset($_POST["deposit_amount"])) {
    $dep_amount = htmlentities($_POST["deposit_amount"]);
}

$mail_body_top = <<<HTML
    <html>
        <head>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/><link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
        </head>
        <body style ="font-family:Trirong;">
            <div style="position:relative">
                <img src="$site_url/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
            </div>
            <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
HTML;

$mail_body_bottom = "</body></html>";

$attempted_deposit_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Hello Sir, a user with username: <b>$username</b> and email address: <b>$user_mail</b> is attempting to deposit <b>N$dep_amount</b> in his/her dashboard.
        </p>
    $mail_body_bottom
HTML;

$admin_successful_deposit_message = <<<HTML
    $mail_body_top
        <p>Hello Sir/Ma, A user successfully desposited: $dep_amount.</p>
        <p>Username: <b>$username</b>, Email: <b>$user_mail</b>.</p>
    $mail_body_bottom
HTML;

$user_successful_deposit_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Congratulations, <b>$username</b>your deposit of <b>$dep_amount</b> on <b>$site_name</b> was successful. 
        </p>
        <p>
            <div>
                Thank you for banking with us. Do well to keep in tough with us as we revolutionize the banking system and banking experience.
            </div> <br />
            <div>
                Kindly feel free to send us a mail or call any of the numbers on our website page if you're in need of any clarifications and keep in touch with us on our various social media platforms.
            </div> <br />
            <div>
                Thanks a lot once more sir/ma.
            </div> <br />
        </p>
    $mail_body_bottom
HTML;

$sender = "admin@$site_url_short";

$headers = "From: $sender \r\n";
$headers .="Reply-To: $sender \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html; charset=UTF-8\r\n";

function check_mail_status($mail) {
    if ($mail) {
        echo "<br /> <span style='color:#e93609; margin-left:15px'> <b>Mail Sent Successfully</b> </span>";
    } else {
        echo "<span style='color:red'> <b>Sorry, an error occurred, Mail not sent</b> </span>";
    }
}