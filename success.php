<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

    if($data) { //$data variable from php/account-manager.php
        // that means user is logged in:
        //display header
        Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username, $title="Deposit Successful");
?>
 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 20px;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 600px;
        }
    </style>
    
    <div style="margin:105px 12px">
        <div class="message">
            <h1>Deposit Successful</h1>
            <p>Thank you for banking with us! Your transaction was successful.</p>
            <p>You will receive an email confirmation shortly.</p>
            <p style="font-weight:bold"><a href="/dashboard">Return to Dashboard</a></p>
        </div>
    </div>

    <?php
        //Insert deposit transaction . .

        //mail admin
        $mail1 = mail($sender, "A user deposited a sum of N$dep_amount", $admin_successful_deposit_message, $headers);
        $mail1 = mail("francisokoye48@gmail.com", "A user deposited a sum of N$dep_amount", $admin_successful_deposit_message, $headers);

        //mail user
        $mail2 = mail($customer_mail, "Inflow ~ your deposit of N$dep_amount was successful", $user_successful_deposit_message, $headers);
    ?>

<?php
    Dashboard_Segments::footer();
} else { //if user is not logged in . .
    header("location: /login");
}
?>