<?php 
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Segments.php");

Segments::header();

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

$ref_stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ?");
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
                }else {
     
                    $stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ? OR user_email = ? LIMIT ?, ?");
                    $stmt->execute([$_POST["username"], $_POST["email"], 0, 1]);
    
                    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                    if(count($data)>0){
                        //--find a way to not repeat yourself again
                        if(isset($_COOKIE["username"])){
                            setcookie("username", $_POST["username"], time()-(24*3600), "/");
                            setcookie("username", $_POST["username"], time()+(24*3600), "/");
                        }else{
                            setcookie("username", $_POST["username"], time()+(24*3600), "/");
                        }
                        if(isset($_COOKIE["password"])){
                            setcookie("password", $_POST["password1"], time()-(24*3600), "/");
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }else {
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }

                        echo "<div class='invalid'> Sorry, username/email is already taken </div>";
                           
                    } else{
                        //input the fields
                         //--find a way to not repeat yourself again
                         if(isset($_COOKIE["username"])){
                            setcookie("username", htmlentities($_POST["username"]), time()-(24*3600), "/");
                            setcookie("username", htmlentities($_POST["username"]), time()+(24*3600), "/");
                        }else{
                            setcookie("username", $_POST["username"], time()+(24*3600), "/");
                        }
                        if(isset($_COOKIE["password"])){
                            setcookie("password", $_POST["password1"], time()-(24*3600), "/");
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }else {
                            setcookie("password", $_POST["password1"], time()+(24*3600), "/");
                        }


                        //conditions are met -- Insert User
                        $p_stmt = $pdo->prepare("INSERT INTO investors(real_name, username, user_email, `password`,referred_by,entry_date) VALUES(?, ?, ?, ?, ?,?)");
                        $p_stmt->execute([$_POST["name"], $_POST['username'],$_POST["email"],$_POST['password1'],$referer,date("Y-m-d h:i:s", time())]);
                        
                        //header("location:/dashboard");
                        //echo "<div class='pop_up' style='display:block'>
                        //  <h3>Sign UP Successful, Kindly <a href='/login' style='color:#ff3c00'>Login</a></h3>
                        //  </div>";
                    
                    
                        //Mail User:
                        $e_name = $_POST["name"];
                        $e_username = $_POST["username"];
                        $e_password = $_POST["password1"];

                        ini_set("display_errors", 1);

                        $message = <<<HTML
                            <html>
                            <head>
                                <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                        <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                        
                            </head>
                            <body style ="font-family:Trirong;">
                                <div style="position:relative">
                                    <img src="https://$site_url_short/static/images/logo-vertextrade.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
                                </div>
                                <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name Investment</h2>
                                    <p  style ="font-family:Trirong;">Hello $e_name, Welcome to $site_name Investment.</p>
                                    <p>As already stated on our site, we're here to <i>Grow your crypto portfolio.</i></p>
                                    <p>The volatility of the crypto market has led to loss of funds for many individuals.</p>
                                    <p><a href="https://$site_url_short/" style="color:#ff3c00">$site_name Investment</a> created this wing loaded with crypto enthusiasts and specialists.</p>
                                    <p>These individuals possess about 90% of accuracy in predicting the viability of crypto currencies.</p>
                                    <p>Together with our techies, they've been able to come up with a powerful algorithm based on blockchain technology which swaps crypto currencies based on its potentials.</p>
                                    <p>So, all you ever have to do is invest in any crypto currency of your choice, sit back and take a glass of wine as you watch your investment yield profits.</p>
                                    <p style="margin-bottom:30px">Yes! It's that simple. The Algo's does all the hardwork for us. So what are you waiting for? Visit your dashboard today or click the button below to <b>Invest</b></p>

                                    <hr />
                                    <b>Below are your login details</b><br />
                                    please, don't share this with anyone
                                    <p><b>Username:</b> $e_username </p>
                                    <p><b>Password:</b> $e_password</p>

                                    <p><small>Kindly disregard this mail if you did not make this sign up and contact: <a href="mailto:admin@$site_url_short" style="color:#ff3c00">admin@$site_url_short</a> for further actions.</small></p>
                                    
                                    <a href="https://$site_url_short/invest" style="color:#ff3c00;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #ff3c00;border:2px solid #ff3c00;width:8%;margin-left:40%;margin-right:30%">invest</a>
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($_POST["email"],"Welcome To $site_name Investment",$message, $headers);
    
                        if($mail){
                            echo "A Welcome Mail has been sent to <b>", $_POST["email"],"</b>. If it doesn't arrive on time, kindly check your spam folder." ;
                        } else {
                            echo "An error occurred, Mail not sent";
                          }




                        //mail  referer:
                        if(isset($_GET["referer"]) || isset($_COOKIE["ref"])) {
                            if(isset($_GET["referer"]))$referer = $_GET["referer"];
                            if(isset($_COOKIE["ref"]))$referer = $_COOKIE["ref"];
                            
                            $ref_stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ?");
                            $ref_stmt->execute([$referer]);
                            $ref_data = $ref_stmt->fetch(PDO::FETCH_OBJ);

                            if($ref_data) {
                                $ref_name = $ref_data->real_name; 
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
                                    <img src="https://$site_url_short/static/images/logo-vertextrade.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
                                </div>
                                <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name Investment</h2>
                                    <p  style ="font-family:Trirong;">Hello $ref_name,<b> $new_user</b> with username <b>$new_username </b> signed up using your referral link.</p>
                                    <p>You would earn 10% of their deposit from now on.</p>
                                    <p>The <b><a href="https://$site_url_short/referred-users"  style="color:#ff3c00">Referred Users</a></b> page of your dashboard contains a list of Users that have signed up with your link while 
                                    the <b><a href="https://$site_url_short/referred-users"  style="color:#ff3c00">Referred Commissions</a></b> page contains your referral earnings.</p>

                                    <p>Do well to encourage your referee(s) to make a deposit and also kindly check the <b><a href="https://$site_url_short/referred-commissions"  style="color:#ff3c00">Referred commissions</a></b> page on your dashboard to view your profits.</p>
                                    <p style="margin-bottom:30px">For further enquiries, you can check out our <b><a href="https://$site_url_short/faqs"  style="color:#ff3c00">Frequently asked questions</a></b> page or <b><a href="https://$site_url_short/contact" style="color:#ff3c00">contact us</a></b> directly if our page doesn't answer your questions.</p>
                                    
                                    
                                    <a href="https://$site_url_short/transactions" style="color:#ff3c00;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #ff3c00;border:2px solid #ff3c00;width:8%;margin-left:30%;margin-right:20%">View Referral Earnings</a>
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($ref_data_user_email,"Your Referee Just Signed Up On $site_name Investment",$message, $headers);

                        if($mail){
                            echo "<br /><br />A Mail has been sent to your referer";
                        } else {
                            echo "Sorry, an error occurred, Mail not sent";
                          }
                        
                        }




                        //mail  Admin:
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
                                    <img src="https://$site_url_short/static/images/logo-vertextrade.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
                                </div>
                                <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name Investment</h2>
                                    <p  style ="font-family:Trirong;">Hello Admin, a new user: <b>$new_user</b> with username: <b>$new_username </b> just signed up in $site_name investment.</p>
                                    
                                    <p>The <b><a href="https://$site_url_short/site-users"  style="color:#ff3c00">Site Users</a></b> page of your admin dashboard contains a list of Users that have signed up on your site, together with the priviledge to take any action you desire on them, such as delete user, view, delete or add transactions, view user's referee, message users, etc.

                                    <br />

                                    <a href="https://$site_url_short/site-users" style="color:#ff3c00;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #ff3c00;border:2px solid #ff3c00;width:8%;margin-left:30%;margin-right:20%">View Site Users</a>
                            </body>
                            </html>
                        HTML;

                        $sender = "admin@$site_url_short";

                        $headers = "From: $sender \r\n";
                        $headers .="Reply-To: $sender \r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                        $mail = mail($sender,"A User Just Signed Up On $site_name Investment",$message, $headers);

                        if($mail){
                            echo "<br /><br />A Mail has been sent to your referer";
                        } else {
                            echo "Sorry, an error occurred, Mail not sent";
                          }



                        header("location:/dashboard"); //--automatically log in
                        //display sign up success pop up:
                        //echo "<div class='pop_up' style='display:block'>
                        //    <h3>Sign UP Successful, Kindly <a href='/login' style='color:#ff3c00'>Login</a></h3>
                        //    </div>";
                    
                    
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

<div class="dashboard_div" style="padding:3px 6px"> <!-- dashboard_div class starts -->

<div class="new-sign-in-head">
    <span class="fa-user-login"><i class="fa fa-user"></i></span> 
    <b style="font-size:21px;color:#01123c">Create An Account</b>
</div>


<div class="sign-in-box">   <!-- sign-in-box class starts -->
    <!--
    <div class="sign-in-welcome">
        Welcome to  <br />
        <b style="color:#57acfc;font-size:16px;">$site_name Investment</b>
        <br /><br />Let's get to know you please.
    </div>
    -->


    <form method="post" action=""> 
        Name & Username:<br />
        <div class="new-input-div">
            <input type="text" placeholder="Name" class="new-input" name="name" value="<?=$remember_name?>" required/>
            <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
        </div>

        <!-- Username:<br />   -->
        <div class="new-input-div">
            <input type="text" placeholder="Username" class="new-input" name="username" value="<?=$remember_username?>" required/>      
            <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
        </div>

        Email:<br/> 
        <div class="new-input-div">
            <input type="text" placeholder="abc@example.com" class="new-input" name="email" value="<?=$remember_email?>" required/>    
            <div class="new-input-fa-icon"> <i class="fa fa-envelope"></i> </div>
        </div>

        Password: <small>(Repeat in next space)</small><br /> 
        <div class="new-input-div">
            <input type = "text" placeholder = "Password: *****" name = "password1" class="new-input" minlength="8" required/>
            <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
        </div>

        <!-- Repeat Password:<br /> -->
        <div class="new-input-div">
            <input type = "text" placeholder = "Repeat Password: *****" name = "password2" class="new-input" minlength="8" required/><br />
            <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
        </div>

       <?php include($_SERVER["DOCUMENT_ROOT"]."/views/captcha.php"); ?>
       
       <br />
        <input type="checkbox" required/><span class="small_letters">I have read and agreed with the terms and conditions</span>
        <br />

        <?php 
            if(!empty($referer)){
        ?>
                Referred By: <span style="color:#2b8eeb;font-weight:bold"><?= $referer ?></span>
        <?php
            }
        ?>
        
        
        <br /><button type="submit" class="long-action-button">Sign Up</i> </button> <br />

        Already have an account? <a href="login" style="font-weight:bold;font-size:18px">Login</a><br />
        Forgot Your Password? <b><a href="/reset-password" style="font-weight:bold;font-size:18px">Recover it</a></b>
    </form>
</div>   <!-- sign-in-box class ends -->
</div>    <!-- dashboard_div class ends -->

<?php
    Segments::footer();
?>