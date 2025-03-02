<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/php/account-manager.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Index_Segments.php");

Index_Segments::header();

$remember_username = "";

if($data){ //data from php/account-manager.php ~ if true, that means user is already logged in.
    header("location:/dashboard");
}

if (isset($_POST["username_or_email"]) && isset($_POST["password"])) {
    $user_id = $_POST["username_or_email"];
    $password = $_POST["password"];

    $remember_username = $_POST["username_or_email"];

    $stmt = $pdo->prepare("SELECT * FROM miners WHERE (username = ? OR user_email = ?) AND `password` = ?");
    $stmt->execute([$user_id, $user_id, $password]);
    
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(count($data)>0){
        setcookie("username_or_email", $_POST["username_or_email"], time()+(24*3600), "/");
        setcookie("password", $_POST["password"], time()+(24*3600), "/");

        //redirect to dashboard
        header("location:/dashboard");
    } else {
?>
    <div class = "invalid">
        invalid username/password combination
    </div>
<?php 
    }
}
?>

<!--HTML:-->
<div class="sign-in-page">
    <div class="new-sign-in-head">
        <div class="fa-user-login"><i class="fa fa-user"></i></div> 
        <div class="new-sign-in-head-caption">Create An Account</div>
    </div>

    <div class="sign-in-box">
        <form method="post" action=""> 
            <div class="flex-div">
                <div class="new-input-div">
                    <input type="text" name="username_or_email" placeholder="Username" value="<?=$remember_username?>" class="new-input" style="margin-bottom:6px"/>    
                    <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
                </div>

                <div class="new-input-div">
                    <input type = "password" name = "password" placeholder = "Password: *****" class="new-input" minlength="8"/><br />
                    <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
                </div>
            </div>

            <div class="sign-in-bottom">
                <button type="submit" class="long-action-button" style="background-color:#ff9100;color:#fff;font-weight:bold;width:100%">Login &nbsp;<i class="fa fa-sign-in"></i></button> <br />
        
                <div style="font-size:15px;text-align;center;margin-top:18px">
                    Forgot Your Password? <b><a href="/reset-password">Recover it now</a></b> <br />
                    Don't have an account? <b><a href="/sign-up">Sign Up</a></b>.<br/>
                </div>
            </div>
        </form>
    </div>
</div>
    
<?php Index_Segments::footer(); ?>