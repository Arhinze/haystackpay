<?php

ini_set("session.use_only_cookies", 1);
include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Segments.php");

Segments::header();
?>

<?php

$remember_username = "";

if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
    $username = $_COOKIE["username"];
    $password = $_COOKIE["password"];

    $stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ? AND `password` = ?");
    $stmt->execute([$username, $password]);
    
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(count($data)>0){
        header("location:/dashboard");
    }
} 



if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $remember_username = $_POST["username"];

    $stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ? AND `password` = ?");
    $stmt->execute([$username, $password]);
    
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    if(count($data)>0){
        setcookie("username", $_POST["username"], time()+(24*3600), "/");
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
        <span class="fa-user-login"><i class="fa fa-user"></i></span> Login to Account
    </div>

    <div class="sign-in-box">
        <form method="post" action="/login"> 
            <div class="flex-div">
                <div class="new-input-div">
                    <input type="text" name="username" placeholder="Username" value="<?=$remember_username?>" class="new-input" style="margin-bottom:6px"/>    
                    <div class="new-input-fa-icon"> <i class="fa fa-user"></i> </div>
                </div>

                <div class="new-input-div">
                    <input type = "password" name = "password" placeholder = "Password: *****" class="new-input" minlength="8"/><br />
                    <div class="new-input-fa-icon"> <i class="fa fa-key"></i> </div>
                </div>
            </div>

            <div class="sign-in-bottom">
                <button type="submit" class="long-action-button">Login </button> <br />
        
                <div style="font-size:12px;text-align;center;margin-top:21px">
                    Forgot Your Password? <b><a href="/reset-password" style="font-weight:bold;">Recover it now</a></b> <br />
                    Don't have an account? <b><a href="sign-up" style="font-weight:bold;">Sign Up</a></b>.<br/>
                </div>
            </div>
        </form>
    </div>
</div>
    
<?php Segments::footer(); ?>