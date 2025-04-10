<?php
   require $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";
   include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");
   
   use PHPMailer\PHPMailer\PHPMailer;
   $mail = new PHPMailer;
   $mail->isSMTP();
   $mail->SMTPDebug = 0; //set to 0 in runtime and 2 in testing
   $mail->Host = 'smtp.hostinger.com';
   $mail->Port = 587;
   $mail->SMTPAuth = true;
   $mail->Username = "admin@$site_url_short";
   $mail->Password = $email_password;
   $mail->setFrom("admin@$site_url_short", $site_name);
   $mail->addReplyTo("admin@$site_url_short", $site_name);
   $mail->isHTML(true);
   $mail->SMTPKeepAlive = true;
   //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
   //$mail->addAttachment('attachment.txt');
   
    //To send message, do this:
    //$mail->addAddress(htmlentities($_POST["email"]), htmlentities($_POST["name"]));
    //$mail->Subject = "Welcome To $site_name";
    //$mail->Body = $message;
    //$mail1 = $mail->send();
    //check_mail_status($mail1);
    //$mail->clearAddresses();
    
    //or this: ~ 
    /*$mail_xyz = $cm->send_quick_mail($receiver, $subject, $message); 
    check_mail_status($mail_xyz);
    mail->clearAddresses();*/
   
    Class CustomMail extends  PHPMailer {
        public $mail;
        public function inject($obj) {
            $this->mail = $obj;
        }
        
        public function send_quick_mail($receiver, $subject, $message) {
            $this->mail->addAddress($receiver, "");
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            return $this->mail->send();
            // remember to clear after calling this function $mail_xyz->clearAddresses();
        }
    }
    
    $cm = new CustomMail; //to use: just declare: $cm->send_quick_mail($receiver, $subject, $message)
    $cm->inject($mail);
   
ini_set("display_errors", 1);

$username = "";
$realName = "";
$dep_amount ="";
$user_mail ="";
$total_number = "";
$amt_for_each_person = "";
$amt_to_deduct = "";
$with_amt = "";
$bank_name = "";
$acct_num = "";

if($data) {
    $username = $data->username;
    $user_mail = $data->user_email;
    $realName = $data->real_name;
}

if(isset($_POST["deposit_amount"])) {
    $dep_amount = htmlentities($_POST["deposit_amount"]);
}

if(isset($_GET["deposit_amount"])) {
    $dep_amount = htmlentities($_GET["deposit_amount"]);
}

if(isset($_POST["transaction_type"])) { //for bulk transactions
    $amt_for_each_person = htmlentities($_POST["amount_to_pay_each_person"]);
    $total_number = htmlentities($_POST["total_number"]);
    $amt_to_deduct = $amt_for_each_person*$total_number;
}

if(isset($_POST["withdrawal_amount"])) { //for withdrawal
    $with_amt = (int)htmlentities($_POST["withdrawal_amount"]);
    $bank_name = htmlentities($_POST["bank"]);
    $acct_num = htmlentities($_POST["account_number"]);
}

$mail_body_top = <<<HTML
    <html>
        <head>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/><link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
        </head>
        <body style ="font-family:Trirong;padding:18px 9px">
            <div style="margin-bottom:18px">
                <img src="$site_url/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%"/>
            </div>
            <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
HTML;

$mail_body_bottom = "</body></html>";



//Deposit Mails:
$attempted_deposit_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Hello Admin, a user with username: <b>$username</b> and email address: <b>$user_mail</b> is attempting to deposit <b>N$dep_amount</b> in his/her dashboard.
        </p>
    $mail_body_bottom
HTML;

$admin_successful_deposit_message = <<<HTML
    $mail_body_top
        <p>Hello Admin, a user successfully desposited: N$dep_amount.</p>
        <p>Username: <b>$username</b>, Email: <b>$user_mail</b>.</p>
    $mail_body_bottom
HTML;

$user_successful_deposit_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Congratulations, <b>$username</b>, your deposit of <b>N$dep_amount</b> on <b>$site_name</b> was successful. 
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



//Bulk Transfer Mails:
$user_received_deposit_message = <<<HTML
    $mail_body_top
        <p>Hello Sir/Ma, you just received a top up of<b>: N$amt_for_each_person </b> from a haystackpay user with username: <b>$username</b>.</p> 
        
        <p>You can log in now to withdraw your funds, convert to other currencies, invest in the stock market or lock it up with the in-built safe-lock on our site with massive returns on investment.</p>

        <p>To learn more about haystackpay, visit us today on <a href="$site_url" style="font-weight:bold;color:#ff9100">haystackpay.com</a> .</p>
        <p>Connect with us on our various social media platforms and do not forget to share with your friends.</p>
        <p>Thank you.</p>

        <br /><br /><br />

        <div><a href="$site_url/dashboard" style="padding:18px;margin:27px 15px;background-color:#ff9100;color:#fff;border-radius:9px;font-weight:bold"> Visit your dashboard </a></div>

        <br /><br /><br />
    $mail_body_bottom
HTML;


$new_user_received_deposit_message = <<<HTML
    $mail_body_top
        <p>Hello Sir/Ma, you just received a top up of <b>:N$amt_for_each_person </b> from a haystackpay user with username: <b>$username</b>.</p> 
        <p>Your account is new on $site_name, so you would have to reset the generated default password to your new password on <a href="$site_url/reset-password" style="font-weight:bold;color:#fff;background-color:#ff9100;padding:1.5px;border-radius:3px">$site_url/reset-password</a> to continue.</p>

        <p>You can log in afterwards to withdraw your funds, convert to other currencies, invest in the stock market or lock it up with the in-built safe-lock on our site with massive returns on investment.</p>

        <p>To learn more about haystackpay, visit us today on <a href="$site_url" style="font-weight:bold;color:#ff9100">haystackpay.com</a> .</p>
        <p>Connect with us on our various social media platforms and do not forget to share with your friends.</p>
        <p>Thank you.</p>

        <br /><br /><br />

        <div><a href="$site_url/reset-password" style="padding:18px;margin:27px 15px;background-color:#ff9100;color:#fff;border-radius:9px;font-weight:bold"> Reset Password </a></div>

        <br /><br /><br />
    $mail_body_bottom
HTML;

$bulk_transferer_message = <<<HTML
    $mail_body_top
        <p>Hello Sir/Ma, </p>
        
        <p>Congratulations, your transfer of <b>N$amt_to_deduct</b> to <b>$total_number</b> user(s) was successful</p>
        <p>These <b>$total_number</b> users have received a sum of <b>N$amt_for_each_person</b> each.</p>
        <p>Your dashboard page contains a receipt for this transaction - showing the email addresses involved.</p>

        <p>Thank you so much for your continuous support as we look forward to working more with you.</p>
        <p>Kindly keep in touch with us on our various social media platforms.</p>
        
        <p><b>PS:</b></p>
        
        <p>We've sent your beneficiaries an email notification, but in case they don't receive it, you can ask them to visit the reset password page <a href="$site_url/reset-password">$site_url/reset-password</a> and log in after re-setting to a new password.</p>

        <br /><br /><br />
    
        <div><a href="$site_url/dashboard" style="padding:18px;margin:27px 15px;background-color:#ff9100;color:#fff;border-radius:9px;font-weight:bold"> Visit your dashboard </a></div>
    
        <br /><br /><br />
    $mail_body_bottom
HTML;

$admin_user_received_deposit_message = <<<HTML
    $mail_body_top
        <p>Hello Admin, a user with username: <b>$username</b> just made a bulk transfer of <b>:N $amt_to_deduct</b> to $total_number users.</p>

        <br /><br /><br />

        <div><a href="$site_url/site-users" style="padding:18px;margin:27px 15px;background-color:#ff9100;color:#fff;border-radius:9px;font-weight:bold"> Visit control panel </a></div>

        <br /><br /><br />
    $mail_body_bottom
HTML;



//Withdrawal Mails:
$user_attempt_withdrawal_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Hello <b>$username</b>, 
        </p>
        <p>
            We noticed your recent attempt to withdraw a sum of : <b>N$with_amt</b>. We regret to inform you that we are not yet done with this feature.
        </p>
        <p>
            <p>Nevertheless, the admin has been notified of your intention.</p> 
            <p>Kindly reply this message with "Proceed", if you would still like to proceed with this transaction, and we will have our agent send it to your account manually.</p>
        </p>
        <p>Thank you for your continuous support.</p>

        <br /><br /><br />


        <!--<div><a href="https://haystackpay.com/dashboard" style="padding:18px;margin:27px 15px;background-color:#ff9100;color:#fff;border-radius:9px;font-weight:bold"> Visit your dashboard </a></div>-->

        <br /><br /><br />

    $mail_body_bottom
HTML;

$admin_user_attempt_withdrawal_message = <<<HTML
    $mail_body_top
        <p  style ="font-family:Trirong;">
            Hello Admin, a user with username: <b>$username</b> and email address: <b>$user_mail</b> is attempting to withdraw <b>N$with_amt</b> from his/her dashboard.
        </p>
        <p>
            <h3>Bank Details:</h3>
            <div><b>Name: </b>$realName</div>
            <div><b>Bank: </b>$bank_name</div>
            <div><b>Account No: </b>$acct_num</div>
        </p>
    $mail_body_bottom
HTML;


//headers
$sender = "admin@$site_url_short";

$headers = "From: $site_name <$sender>\r\n";
$headers .="Reply-To: $sender \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html; charset=UTF-8\r\n";

//tester function:
function check_mail_status($mail_xyz) {
    if (!$mail_xyz) {
        echo "<br /><br /><br /><br /> <span style='color:red; margin-left:15px'><br /> <b>Mail not sent. <br />  Mailer Error: ".$mail_xyz->ErrorInfo."  </b> </span>";
    } else {//$err_msg = error_get_last()["message"];
        //$mail_xyz->clearAddresses();
        //echo "<br /><br /><br /><br /> <span style='color:green'> <br /> <b> Mail sent successfully </b><br /> </span>";
    }
}