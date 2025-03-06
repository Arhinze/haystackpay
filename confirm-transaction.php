<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {//that means user is logged in:
    if(isset($_POST["transaction_type"])) {
        
        $amt_for_each_person = htmlentities($_POST["amount_to_pay_each_person"]);
        $total_number = htmlentities($_POST["total_number"]);
        $amt_to_deduct = $amt_for_each_person*$total_number;

        //echo "<h1>$amt_to_deduct</h1>";

        if(((int)$amt_to_deduct) <= $hstkp_transactions->current_balance($data->user_id)) { //user has enough money and can carry out this transaction
        $mails_to_disburse_to = htmlentities($_POST["valid_emails"]);
        $hstkp_transactions->withdraw($data->user_id, $amt_to_deduct, $mails_to_disburse_to);

        //disburse funds to all emails
        $all_valid_emails = explode("#", $mails_to_disburse_to);
        foreach($all_valid_emails as $ave) {
            if(!empty($ave)) {//so as not to insert empty string
                if ($hstkp_transactions->user_exists($ave)) {
                    $hstkp_transactions->deposit($hstkp_transactions->user_exists($ave)->user_id, $amt_for_each_person, "Received from: ".$data->username); 

                    /// - mail() $ave ~ replacing soon with a cron job that sends emails
                    $mail_user = mail($ave, "You received a top up of N$amt_for_each_person", $user_received_deposit_message, $headers);
                    check_mail_status($mail_user);
                } else {
                    $p_stmt = $pdo->prepare("INSERT INTO haystack_users(real_name, username, user_email, `password`,airdrop_status,twitter_username,avax_wallet_address,aguat_wallet_address,referred_by,entry_date,mining_status,mining_start_time) VALUES(?, ?,?, ?, ?, ?,?,?,?,?,?,?)");
    
                    $p_stmt->execute(["Dummy Real Name", $ave, $ave, "123pc","not_participated"," "," "," ",$data->username,date("Y-m-d H:i:s", time()),date("Y-m-d H:i:s", time()),"inactive"]);
    
                    if ($hstkp_transactions->user_exists($ave)) {//now user exists if previously does not exist . .
                        $hstkp_transactions->deposit($hstkp_transactions->user_exists($ave)->user_id, $amt_for_each_person, "Received from: ".$data->username); 

                        // - mail() $ave ~ replacing soon with a cron job that sends emails
                        $mail_user_new = mail($ave, "You received a top up of N$amt_for_each_person", $new_user_received_deposit_message, $headers);
                        check_mail_status($mail_user_new);
                    }
                }
            } //end of if(!empty($ave))
        }

        //message user that his bulk transfer has been made:
        $mail_bulk_transferer = mail($data->user_email, "Your Transfer of N$amt_to_deduct to $total_number user(s) was successful", $bulk_transferer_message, $headers);
        check_mail_status($mail_bulk_transferer);

        //message admin that a bulk transfer has been made:
        $mail_admin = mail($sender, "A user sent a total of N$amt_to_deduct to $total_number users", $admin_user_received_deposit_message, $headers);
        check_mail_status($mail_admin);
    } else {// ~ user does not have enough money for this transaction 
        header("Location: /bulk-transfer?error_msg=sorry, insufficient funds");   
    }

    // ~ (stmts that passed through the if statement. that's stmts called when user's current > $request ) also pass through here
    header("Location: /dashboard?new_transaction=".$hstkp_transactions->get_last_tr_id($data->user_id));
    Dashboard_Segments::footer();
    } 
} else {
    header("location:/login");
}