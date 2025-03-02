<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {//user is logged in: -- $data from /php/account-manager.php
    Dashboard_Segments::header();
?>

<div style="margin:150px 15px;">
    <!-- This is going off soon -->
    <div style="text-align:center">
        <p>Sorry, we're still working on this project.</p>
        <p>We believe this little tour has been able to give you the whole idea of what the project is all about</p>
        <p>For further enquiries, kindly <b><a href="https://wa.link/hgzcrj" style="color:#ff9100">click here <i class="fa fa-whatsapp"></i></a></b> to contact the software developer, or call on: <b>+2348106961530</b>.</p>
    </div>
    <!--End of: This is going off soon -->
</div>

<?php
    Dashboard_Segments::footer();
} else {//user is not logged in: -- redirect to login page
    if(isset($_POST["transaction_type"])){ // ~ user was trying to make a transaction . . save the user's data in the database

    }
    header("location:/login");
}