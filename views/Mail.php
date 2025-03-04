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
      
$attempted_deposit_message = <<<HTML
    <html><head><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/><link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/></head>
    <body style ="font-family:Trirong;">
        <div style="position:relative">
            <img src="$site_url/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
        </div>
        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
            <p  style ="font-family:Trirong;">
                Hello Sir, a user with username: $username attempted to deposit N$dep_amount in his dashboard.
            </p>
    </body>
    </html>
HTML;








//mail  Admin, Sales-Rep:
//$new_order_name = $_GET["name"];
//$new_order_phone = $_GET["phone"];
//$new_order_qty = $_GET["qty"]; 
//$product_name = $_GET["product"];
//$customer_mail = $_GET["mail"];

$new_order_name = "";
$new_order_phone = "";
$new_order_qty = ""; 
$product_name = '';
$customer_mail = "";

$admin_successful_deposit_message = <<<HTML
    <html>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
        <link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
    </head>
    <body style ="font-family:Trirong;">
        <div style="position:relative">
            <img src="$site_url/static/images/logo.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
        </div>
        
        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
            <p  style ="font-family:Trirong;">
            
            Hello Sir/Ma, you just received a new Paid order for $product_name from: 
            <b>$new_order_name</b> with the phone Number: <b>$new_order_phone</b>. 
            </p>
            
            <p>
                <h3>Paid Order details:</h3>
                <div>
                    <b>Name:</b> $new_order_name
                </div> <br />
                
                <div>
                    <b>Phone Number:</b> $new_order_phone
                </div> <br />
                     
                <div>
                    <b>Quantity:</b> $new_order_qty
                </div> <br />
                
                <div>
                    <b>Message:</b> 
                    <p>Kindly find message in the previous mail sent on attempted payment</p>
                </div>
            </p>
    </body>
    </html>
HTML;


$user_successful_deposit_message = <<<HTML
    <html>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
        <link rel="stylesheet" href="$site_url/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
    </head>
    <body style ="font-family:Trirong;">
        <div style="position:relative">
            <img src="$site_url/static/images/logo.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
        </div>
        
        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
            <p  style ="font-family:Trirong;">
            
            Thank You, <b>$new_order_name</b> for your order of $product_name from: <b>$site_name</b>. 
            </p>
            
            <p>
                <div>
                    One of our sales representatives would get in touch with you soon, and you would receive your order in 2 to 3 working days or less.
                </div> <br />
                
                <div>
                    Kindly feel free to send us a mail or call any of the numbers on our website page if you're in need of further clarifications.
                </div> <br />
                     
                <div>
                    Thanks a lot once more sir/ma.
                </div> <br />
            </p>
    </body>
    </html>
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