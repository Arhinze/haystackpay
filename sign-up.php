<?php 
include_once($_SERVER["DOCUMENT_ROOT"]."/php/account-manager.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Index_Segments.php");

Index_Segments::header();

$referer = "";
$remember_name = "";
$remember_username = "";
$remember_email = "";

if(isset($_GET["referer"])){
    $referer = htmlentities($_GET["referer"]);
} 

if(isset($_COOKIE["ref"])){
    $referer = $_COOKIE["ref"];
}

if(isset($_POST["name"])){
    $remember_name = htmlentities($_POST["name"]);
}

if(isset($_POST["username"])){
    $remember_username = htmlentities($_POST["username"]);
}

if(isset($_POST["email"])){
    $remember_email = htmlentities($_POST["email"]);
}

$ref_stmt = $pdo->prepare("SELECT * FROM haystack_users WHERE username = ?");
$ref_stmt->execute([$referer]);
$ref_data = $ref_stmt->fetch(PDO::FETCH_OBJ);

if(!$ref_data) $referer = "";

if(isset($_POST["user_code"])){
    $usercode = $_POST["user_code"];
    if($usercode == $_POST["code"]){
        //Verify and Input the rest of the user fields
        if($_POST["password1"] == $_POST["password2"]){

            //validate Email
            // if(!filter_input(INPUT_POST, $_POST["email"], FILTER_VALIDATE_EMAIL) === false){
            if(filter_var(trim(htmlentities($_POST["email"])), FILTER_VALIDATE_EMAIL) == true){

                //validate username
                if(preg_match("/[^a-z0-9_]/i", $_POST["username"])){
                    echo '<div class="invalid"><i class="fa fa-warning"></i> Only letters, numbers and _ are accepted for username</div>';
                }else {//~checking if user already exists, so as to return 'user exists' error
                    $stmt = $pdo->prepare("SELECT * FROM haystack_users WHERE username = ? OR user_email = ? LIMIT ?, ?");
                    $stmt->execute([$_POST["username"], $_POST["email"], 0, 1]);
    
                    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                    if(count($data)>0){// ~ that means.. user exists
                        echo "<div class='invalid'>Sorry, username/email is already taken </div>";
                    } else{
                        //input the fields
                         if(isset($_COOKIE["username_or_email"])){
                            //destroy existing one before setting a new one
                            setcookie("username_or_email", htmlentities($_POST["username"]), time()-(24*3600), "/");
                            setcookie("username_or_email", htmlentities($_POST["username"]), time()+(24*3600), "/");
                        }else{
                            //just set new cookie ~ no need to destroy old one since it's not set anyway..
                            setcookie("username_or_email", $_POST["username"], time()+(24*3600), "/");
                        }
                        if(isset($_COOKIE["password"])){
                            //destroy existing one before setting a new one
                            setcookie("password", $_POST["password1"], time()-(24*3600), "/");
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }else {
                            //just set new cookie ~ no need to destroy old one since it's not set anyway..
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }


                        //conditions are met -- Insert User
                        $p_stmt = $pdo->prepare("INSERT INTO haystack_users(real_name, username, user_email, `password`,airdrop_status,twitter_username,avax_wallet_address,aguat_wallet_address,referred_by,entry_date,mining_status,mining_start_time) VALUES(?, ?,?, ?, ?, ?,?,?,?,?,?,?)");

                        $p_stmt->execute([$_POST["name"], $_POST['username'],$_POST["email"],$_POST['password1'],"not_participated"," "," "," ",$referer,date("Y-m-d H:i:s", time()),date("Y-m-d H:i:s", time()),"inactive"]);
                    
                        //Mail User:
                        $e_name = htmlentities($_POST["name"]);
                        $e_username = htmlentities($_POST["username"]);
                        $e_password = htmlentities($_POST["password1"]);

                        ini_set("display_errors", 1);

                        $message = <<<HTML
                            <html>
                            <head>
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                        <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                        
                            </head>
                            <body style ="font-family:Trirong;">
                                <div style="position:relative">
                                    <img src="https://$site_url_short/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/><br /><br /><br />
                                </div>
                                <h2 style="color:$site_color_light;font-family:Arimo;text-align:center">$site_name </h2>

                                    <p  style ="font-family:Trirong;">Dear $e_name, </p>

                                    <p>Welcome to <b>$site_name</b> community!. We're thrilled to have you on board and excited for you as you begin to experience the thrill of modern banking.</p>

                                    <p>We are the best financial system experienced in bulk transfers as well as singular transactions and service payment.</p>

                                    <p>Connect with other $site_name lovers on our various platforms and don’t forget to check out our social media handles for the latest news, updates, and flagship features to enhance your financial experience. If you have any questions or need assistance, our <a href="mailto:support@$site_url_short">support team</a> is always here to help.</p>

                                    <hr />
                                    <b>Below are your login details.</b><br />
                                    Please, don't share this with anyone
                                    <p><b>Username:</b> $e_username </p>
                                    <p><b>Password:</b> $e_password</p>

                                    <p>Best regards,</p>
                                    <p>The $site_name Team</p> 
                                    <p style="color:$site_color_light"><b>$site_url_short</b> | <b>admin@$site_url_short</b></p>
                                    
                                    <p>kindly disregard this mail if you did not make this sign up and contact: admin@aguanit.com  for further actions.</p>
                                    
                                    <p><small>Kindly disregard this mail if you did not make this sign up and contact: <a href="mailto:admin@$site_url_short" style="color:#042c06">admin@$site_url_short</a> for further actions.</small></p>

                                    <br /><br /><br />
                                    
                                    <a href="https://$site_url_short" style="font-size:18px;padding:2% 4%;border-radius:6px;box-shadow:0px 0px 3px #042c06;border:2px solid #042c06;display:flex;justify-content:center;text-align:center;background-color:$site_color_light;font-weight:bold;color:#fff">Send/Receive Money</a>

                                    <br /><br /><br />
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($_POST["email"],"Welcome To $site_name",$message, $headers);
    
                        if($mail){
                            echo "A Welcome Mail has been sent to <b>", $_POST["email"],"</b>. If it doesn't arrive on time, kindly check your spam folder." ;
                        } else {
                            echo "An error occurred, Mail not sent";
                          }




                        //mail  referer:
                        if(isset($_GET["referer"]) || isset($_COOKIE["ref"])) {
                            if(isset($_GET["referer"]))$referer = $_GET["referer"];
                            if(isset($_COOKIE["ref"]))$referer = $_COOKIE["ref"];
                            
                            $ref_stmt = $pdo->prepare("SELECT * FROM haystack_users WHERE username = ?");
                            $ref_stmt->execute([$referer]);
                            $ref_data = $ref_stmt->fetch(PDO::FETCH_OBJ);

                            if($ref_data) {
                                $ref_name = $ref_data->real_name; 
                                $ref_username = $ref_data->username; 
                                $ref_data_user_email = $ref_data->user_email;
                            }
                            $new_user = $_POST["name"];
                            $new_username = $_POST["username"];
                        

                        ini_set("display_errors", 1);

                        $message = <<<HTML
                            <html>
                            <head>
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                        <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                        
                            </head>
                            <body style ="font-family:Trirong;">
                                <div style="position:relative">
                                    <img src="https://$site_url_short/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/><br /><br /><br />
                                </div>
                                <h2 style="color:$site_color_light;font-family:Arimo;text-align:center">$site_name</h2>
                                    <p  style ="font-family:Trirong;">Hi $ref_name,

                                    We’re thrilled to let you know that your referral of $new_user with username: $new_username was successful!.

                                    <!--As a token of our appreciation, we’ve credited your account with 1 &#x24; referral bonus.-->
                                    
                                    Your support means the world to us and we’re grateful you chose to share this beautiful financial service app with others. Keep transacting with us, it gets more fun and easier with each passing day!  
                                        
                                    <p>The <b><a href="https://$site_url_short/referred-users"  style="color:#042c06">Referred Users</a></b> page of your dashboard contains a list of Users you have referred to us. <!--while 
                                    the <b><a href="https://site_url_short/referred-commissions"  style="color:#042c06">Referred Commissions</a></b> page contains your referral earnings.</p>-->

                                    <p>Kindly encourage your referee(s) to enage actively with our services.</p>

                                    <p>Thanks again for being an amazing advocate!</p>  
                                    
                                    <p>Best regards,</p>  
                                    <p>$ref_name</p> 
                                    
                                    <p>Share your unique referral link below <!--and keep the rewards coming:--></p>  
                                    <p><a href="https://$site_url_short/?ref=$ref_username"></a></p>
                                    
                                    <br /><br /><br />
                                    
                                    <a href="https://$site_url_short/referred-users" style="color:#fff;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #042c06;border:2px solid #042c06;display:flex;justify-content:center;text-align:center;background-color:$site_color_light;font-weight:bold">View Referrals</a>

                                    <br /><br /><br /> 
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($ref_data_user_email, "Thank You for Your Referral, $ref_username", $message, $headers);

                        if($mail){
                            echo "<br /><br />A Mail has been sent to your referer";
                        } else {
                            echo "Sorry, an error occurred, Mail not sent";
                          }
                        
                        }




                        //mail  Admin:
                        $new_user = htmlentities($_POST["name"]);
                        $new_username = htmlentities($_POST["username"]);

                        ini_set("display_errors", 1);

                        $message = <<<HTML
                            <html>
                            <head>
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                        <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                        
                            </head>
                            <body style ="font-family:Trirong;">
                                <div style="position:relative">
                                    <img src="https://$site_url_short/static/images/logo_rbg.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/><br /><br /><br />
                                </div>
                                <h2 style="color:$site_color_light;font-family:Arimo;text-align:center">$site_name </h2>
                                    <p  style ="font-family:Trirong;">Hello Admin, a new user: <b>$new_user</b> with username: <b>$new_username </b> just signed up in $site_name.</p>
                                    
                                    <p>The <b><a href="https://$site_url_short/site-users"  style="color:#042c06">Site Users</a></b> page of your admin dashboard contains a list of Users that have signed up on your site, together with the priviledge to take any action you desire on them, such as delete user, view user details, view user's transactions/referee, message users, etc.

                                    <br /><br /><br />

                                    <a href="https://$site_url_short/site-users" style="color:#fff;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #042c06;border:2px solid #042c06;display:flex;justify-content:center;text-align:center;background-color:$site_color_light;font-weight:bold">View Site Users</a>

                                    <br /><br /><br />
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($sender,"A User Just Signed Up On $site_name",$message, $headers);
                        $mail2 = mail("francisokoye48@gmail.com","A User Just Signed Up On $site_name",$message, $headers);

                        if($mail){
                            echo "<br /><br />A Mail has been sent to both the user and referer";
                        } else {
                            echo "Sorry, an error occurred, Mail not sent to both user and referer";
                        }

                        if($mail2){
                            echo "<br /><br />A Mail has been sent to both the user and referer";
                        } else {
                            echo "Sorry, an error occurred, Mail not sent to both user and referer";
                        }

                        //redirect user to dashboard
                        header("location:/dashboard?new-user"); //--automatically log in
                        //display sign up success pop up: ~ on dashboard page
                    }

                }
            } else {
                echo '<div class="invalid"><i class="fa fa-warning"></i> Invalid Email Address</div>';
            }
        } else {
            echo '<div class="invalid"><i class="fa fa-warning"></i> Sorry, passwords do not match</div>';
        }

    }else if(empty($usercode)){
        echo '<div class="invalid"><i class="fa fa-warning"></i> Please Enter the 6 Digit Code</div>';
    } else {
        echo '<div class="invalid"><i class="fa fa-warning"></i> Wrong Captcha</div>';
    }
} else {
    //echo '<div class="invalid"><i class="fa fa-warning"></i> Please Enter the 6 Digit Code</div>';
}
?>

<div class="sign-in-page"> <!-- sign-in-page class starts -->
    <div class="new-sign-in-head" style="display:flex">
        <div class="fa-user-login"><i class="fa fa-user"></i></div> 
        <div class="new-sign-in-head-caption">Create An Account</div>
    </div>
    
    
    <div class="sign-in-box"><!-- sign-in-box class starts -->
        <form method="post" action=""> 
            <div class="sign-in-box-headers">Name & Username:</div>
            <div class="new-input-div">
                <input type="text" placeholder="Name" class="new-input" name="name" value="<?=$remember_name?>" required/>
                <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
            </div>
    
            <!-- Username:<br />   -->
            <div class="new-input-div">
                <input type="text" placeholder="Username" class="new-input" name="username" value="<?=$remember_username?>" required/>      
                <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
            </div>
    
            <div class="sign-in-box-headers">Email:</div> 
            <div class="new-input-div">
                <input type="text" placeholder="abc@example.com" class="new-input" name="email" value="<?=$remember_email?>" required/>    
                <div class="new-input-fa-icon"> <i class="fa fa-envelope"></i> </div>
            </div>
    
            <div class="sign-in-box-headers">Password: <small>(Repeat in next space)</small></div> 
            <div class="new-input-div">
                <input type = "text" placeholder = "Password: *****" name = "password1" class="new-input" minlength="8" required/>
                <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
            </div>
    
            <!-- Repeat Password:<br /> -->
            <div class="new-input-div">
                <input type = "text" placeholder = "Repeat Password: *****" name = "password2" class="new-input" minlength="8" required/><br />
                <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
            </div>
    
            <!-- code(captcha) -->
            <?php include($_SERVER["DOCUMENT_ROOT"]."/views/captcha.php"); ?>
           
            <br />
            <input type="checkbox" required/><span class="small_letters">I have read and agreed with the terms and conditions</span>
            <br />
            <!-- end of code(captcha) -->

            <?php 
                if(!empty($referer)){
            ?>
                    Referred By: <span style="color:<?=$site_color_light?>;font-weight:bold"><?=$referer?></span>
            <?php
                }
            ?>

            <br /><button type="submit" class="long-action-button" style="background-color:#ff9100">Join <?=$site_name?> &nbsp; <i class="fa fa-sign-in"></i></button> <br />
    
            <div style="margin-top:15px;font-size:15px">
                Already have an account? <a href="login" style="font-weight:bold;font-size:18px;color:#ff9100">Login</a><br />
                Forgot Your Password? <b><a href="/reset-password" style="font-weight:bold;font-size:18px;color:#ff9100">Recover it</a></b>
            </div>
        </form>
    </div>   <!-- sign-in-box class ends -->

    <?php include($_SERVER["DOCUMENT_ROOT"]."/views/where_to_get_wa.php"); ?>

</div> <!-- sign-in-page class ends -->

<?php
    Index_Segments::footer();
?>