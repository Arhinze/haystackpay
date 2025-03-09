<?php
   require 'vendor/autoload.php';
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
   
   $receiver = "francisarinze999@gmail.com";
   $mail->addAddress($receiver, 'Arinze');
   $mail->Subject = "Checking if PHPMailer work";
   $mail->Body = "Final Test: <br /><br /><br /> <b>This is just a plain text message body to check if PHPMailer is working . .</b><br /><br />It seems to be working . . Thank you Lord";
   $mail_xyz = $mail->send();
   check_mail_status($mail_xyz);
   
   //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
   //$mail->addAttachment('attachment.txt');
   
   function check_mail_status($mail_xyz) {
        if (!$mail_xyz) {
            echo "<b style='color:red'>Mailer Error: " . $mail_xyz->ErrorInfo."</b>";
        } else {
            //echo 'Mail sent successfully.';
        }
   }
?>