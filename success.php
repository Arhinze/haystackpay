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
    
    <div style="margin:180px 12px 75px 12px">
        <div class="message">
            <h1>Deposit Successful</h1>
            <p>Thank you for banking with us! Your transaction was successful.</p>
            <p>You will receive an email confirmation shortly.</p>
            <p style="font-weight:bold"><a href="/dashboard">Return to Dashboard</a></p>
        </div>
    </div>

    <?php
        // $_GET variables:
        $ps_trx_ref = htmlentities($_GET["trxref"]);
        $ps_att_ref = htmlentities($_GET["refx"]);
        $dep_amount = htmlentities($_GET["deposit_amount"]);

        //Check if transaction is a valid transaction before depositing . .
        $tr_attempt_check_stmt = $pdo->prepare("SELECT * FROM tr_attempts WHERE user_id = ? AND ps_attempt_refx = ? LIMIT ?, ?");
        $tr_attempt_check_stmt->execute([$data->user_id, $ps_att_ref, 0, 1]);
        $tr_attempt_data =  $tr_attempt_check_stmt->fetch(PDO::FETCH_OBJ);

        if ($tr_attempt_data) { // ~ transaction is a valid transaction
            //Insert deposit transaction . .
            //$hstkp_transactions->deposit($data->user_id, $dep_amount, "You made a deposit");
            $new_tr_stmt = $pdo->prepare("INSERT INTO transactions(user_id, tr_type, tr_amount, tr_time, ps_trxref, ps_attempt_refx) VALUES (?, ?, ?, ?, ?, ?)");
            $new_tr_stmt->execute([$data->user_id, "inflow", $dep_amount, date("Y-m-d H:i:s", time()), $ps_trx_ref, $ps_att_ref]);

            //Delete the transaction to avoid a repeat
            $delete_tr_att_stmt = $pdo->prepare("DELETE FROM tr_attempts WHERE ps_attempt_refx = ?");
            $delete_tr_att_stmt->execute([$ps_att_ref]);

            //mail admin
            $mail1 = mail($sender, "A user deposited a sum of N$dep_amount", $admin_successful_deposit_message, $headers);
            $mail2 = mail("francisokoye48@gmail.com", "A user deposited a sum of N$dep_amount", $admin_successful_deposit_message, $headers);
    
            //mail user
            $mail3 = mail($user_mail, "Inflow ~ your deposit of N$dep_amount was successful", $user_successful_deposit_message, $headers);
    
            check_mail_status($mail1);
            check_mail_status($mail2);
            check_mail_status($mail3);
        } else {
            echo "<div class='invalid' style='background-color:green;color:#fff'>Please proceed to the dashboard</div>";
        }

    Dashboard_Segments::footer();
} else { //if user is not logged in . .
    header("location: /login");
}
?>