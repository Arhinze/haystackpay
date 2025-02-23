<?php
//auto-invest starts

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Transactions.php");

//$ss = $pdo->prepare("SELECT * FROM transactions WHERE tr_type = ?  AND tr_amount >= ? AND tr_time > ? LIMIT ?, ?");
//$ss->execute(["Deposit", 100, (time()-10*24*60*60), 0, 300]);

$ss = $pdo->prepare("SELECT * FROM transactions WHERE tr_type = ? AND tr_amount >= ? ORDER BY tr_id DESC LIMIT ?, ?");
$ss->execute(["Deposit", 100, 0, 300]);

$all_data = $ss->fetchAll(PDO::FETCH_OBJ);

/*
if (count($all_data) > 0) {
    echo "<h1 style='margin-top:48px'> All Data working</h1>", count($all_data);
} else {
    echo "<h1 style='margin-top:48px'> All Data not not working</h1>";
}
*/

foreach($all_data as $d){
    
    if(((strtotime($d->tr_time) + ((1 + $transactions->num_of_days($d->tr_amount))*24*60*60)) > time()) && ((time() - (24*60*60)) > strtotime($d->last_profit_time))){
        $a = $transactions->rate($d->tr_amount);

        $up_stmt = $pdo->prepare("UPDATE transactions SET last_profit_time = ?, profit = ? WHERE tr_id = ?");
        $up_stmt->execute([date("Y-m-d H:i:s", time()), ($d->profit + ($a/100 * $d->tr_amount)), $d->tr_id]);
    }
}
//auto-invest ends
?>