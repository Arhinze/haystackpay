<?php

//Managing all the transactions made by users on haystackpay
class Transactions {
    private $pdo;

    public function inject($obj){
        $this->pdo = $obj;
    }

    private function tr_alert($message){
        echo "<div class='invalid' style='background-color:green'>".$message."</div>";
    }

    public function deposit($user_id,$amt,$from){
        $dep_stmt = $this->pdo->prepare("INSERT INTO transactions(tr_id, user_id, tr_type, tr_amount, tr_time, tr_from) VALUES (?,?,?,?,?,?)");
        $dep_stmt->execute([null, $user_id, "inflow", $amt, date("Y-m-d H:i:s",time(), $from)]);

        return $this->tr_alert("Deposit made successfully"); 
    }

    public function withdraw($user_id,$amt,$description){
        $wit_stmt = $this->pdo->prepare("INSERT INTO transactions(tr_id, user_id, tr_type, tr_amount, tr_time, tr_from) VALUES (?,?,?,?,?,?)");
        $wit_stmt->execute([null, $user_id, "outflow", $amt, date("Y-m-d H:i:s",time()), $description]);

        return $this->tr_alert("Withdrawal made successfully"); 
    }

    public function current_balance($user_id) {
        //inflow:
        $cb_in_stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE user_id = ? AND tr_type = ? LIMIT ?, ?");
        $cb_in_data = $cb_in_stmt->execute([$data->user_id, "inflow", 0, 1000]);

        $total_cb_in = 0;
        foreach($cb_in_data as $cb_in) {
            $total_cb_in += $cb_in;
        }

        //outflow:
        $cb_out_stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE user_id = ? AND tr_type = ? LIMIT ?, ?");
        $cb_out_data = $cb_out_stmt->execute([$data->user_id, "outflow", 0, 1000]);

        $total_cb_out = 0;
        foreach($cb_out_data as $cb_out) {
            $total_cb_out += $cb_out;
        }

        //current balance:
        $current_balance = $total_cb_in - $total_cb_out;
        return $current_balance;
    }
}

$hstkp_transactions = new Transactions;
$hstkp_transactions->inject($pdo);