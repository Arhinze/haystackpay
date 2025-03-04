<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Transactions.php");

if($data) {//that means user is logged in:
    if(isset($_POST["transaction_type"])) {
        $amt_for_each_person = htmlentities($_POST["amount_to_pay_each_person"]);
        $amt_to_deduct = $amt_for_each_person*htmlentities($_POST["total_number"]);
        $mails_to_disburse_to = htmlentities($_POST["valid_emails"]);
        $hstkp_transactions->withdraw($data->user_id, $amt_to_deduct, $mails_to_disburse_to);

        //disburse funds to all emails
        $all_valid_emails = json_decode($mails_to_disburse_to);
        foreach($all_valid_emails as $ave) {
            if (user_exists($ave)) {
                $hstkp_transactions->deposit($ave->user_id, $amt_for_each_person, "Received from: ".$data->username); 
                // - mail() $ave
            } else {
                $p_stmt = $pdo->prepare("INSERT INTO haystack_users(real_name, username, user_email, `password`,airdrop_status,twitter_username,avax_wallet_address,aguat_wallet_address,referred_by,entry_date,mining_status,mining_start_time) VALUES(?, ?,?, ?, ?, ?,?,?,?,?,?,?)");

                $p_stmt->execute(["Dummy Real Name", "dummy_user_name", $ave, "123pc","not_participated"," "," "," ",$data->username,date("Y-m-d H:i:s", time()),date("Y-m-d H:i:s", time()),"inactive"]);

                if (user_exists($ave)) {//now user exists if previously does not exist . .
                    $hstkp_transactions->deposit($ave->user_id, $amt_for_each_person, "Received from: ".$data->username); 
                    // - mail() $ave
                }
            }
        }
    }

    //header("Location: /dashboard?new_transaction=".$hstkp_transactions->get_last_tr_id($data->user_id));
    Dashboard_Segments::footer();
} else {
    header("location:/login");
}
?>