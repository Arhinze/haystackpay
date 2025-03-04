<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Transactions.php");

if($data) {
    if(isset($_POST["transaction_type"])) {
        $amt_to_deduct = htmlentities($_POST["amount_to_pay_each_person"])*htmlentities($_POST["total_number"]);
        $mails_to_disburse_to = htmlentities($_POST["valid_emails"]);
        $hstkp_transactions->withdraw($data->user_id, $amt_to_deduct, $mails_to_disburse_to);
    }

    header("Location: /dashboard?new_transaction=".$hstkp_transactions->get_last_tr_id($data->user_id));
    Dashboard_Segments::footer();
} else {
    header("location:/login");
}
?>