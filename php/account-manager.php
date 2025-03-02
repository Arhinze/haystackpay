<?php
ini_set("session.use_only_cookies", 1);
include_once("/home/u590828029/domains/aguanit.com/public_html/php/connection.php");

$data = false;

if((isset($_COOKIE["username_or_email"])) && ((isset($_COOKIE["password"])))){
    $user_id = $_COOKIE["username_or_email"];
    $password = $_COOKIE["password"];

    $stmt = $pdo->prepare("SELECT * FROM miners WHERE (username = ? OR user_email = ?) AND `password` = ?");
    $stmt->execute([$user_id, $user_id, $password]);
    
    $data = $stmt->fetch(PDO::FETCH_OBJ);
}

// then call 'if data(){ ... }' for all necessary dashboard related page.


//Updating status to 'inactive' and adding the balance for all miners after 48 hours:
$gen_stmt = $pdo->prepare("SELECT * FROM miners WHERE mining_status = ? LIMIT ?, ?");
$gen_stmt->execute(["active", 0, 500]);
$gen_data = $gen_stmt->fetchAll(PDO::FETCH_OBJ);

foreach($gen_data as $gd) {
    if (strtotime($gd->mining_start_time) <= (time() - (48*60*60))) {
        $gen_updt = $pdo->prepare("UPDATE miners SET mining_status = ?, total_amount_mined = ? WHERE user_id = ?");
        $gen_updt->execute(["inactive",$gd->total_amount_mined + 1.00224, $gd->user_id]);
    }
}