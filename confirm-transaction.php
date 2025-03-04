<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {//user is logged in: -- $data from /php/account-manager.php
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title=SITE_NAME." - Confirm Transaction");
?>

<div style="margin:180px 15px 90px 15px">
    <!-- This is going off soon -->
    <!--
    <div style="text-align:center">
        <p>Sorry, we're still working on this project.</p>
        <p style="margin-top:18px">We believe this little tour has been able to give you an idea of what the project is all about</p>
        <p style="margin-top:18px">For further enquiries, kindly <b><a href="https://wa.link/hgzcrj" style="color:#ff9100">click here <i class="fa fa-whatsapp"></i></a></b> to contact the software developer, or call on: <b>+2348106961530</b>.</p>
    </div>
    -->
    <!--End of: This is going off soon -->


    <?php 
        if(isset($_POST["transaction_type"])) {
            $amt_to_deduct = htmlentities($_POST["amount_to_pay_each_person"])*htmlentities($_POST["total_number"]);
            $hstkp_transactions->withdraw($amt_to_deduct);
        }
    ?>
</div>

<?php
    Dashboard_Segments::footer();
} else {//user is not logged in: -- redirect to login page
    if(isset($_POST["transaction_type"])){ // ~ user was trying to make a transaction . . save the user's data in the database

    }
    header("location:/login");
}