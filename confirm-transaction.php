<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {//user is logged in: -- $data from /php/account-manager.php
    Dashboard_Segments::header();
?>

<?php
    Dashboard_Segments::footer();
} else {//user is not logged in: -- redirect to login page
    if(isset($_POST["transaction_type"])){ // ~ user was trying to make a transaction . . save the user's data in the database

    }
    header("location:/login");
}