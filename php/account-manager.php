<?php

if((isset($_COOKIE["username"])) && ((isset($_COOKIE["password"])))){
    $username = $_COOKIE["username"];
    $password = $_COOKIE["password"];

    $stmt = $pdo->prepare("SELECT * FROM investors WHERE username = ? AND `password` = ?");
    $stmt->execute([$username, $password]);
    
    $data = $stmt->fetch(PDO::FETCH_OBJ);
        //check if user has enough money in deposit wallet address:
        $cstmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ?");
        $cstmt->execute([$data->user_id]);
        $cdata = $cstmt->fetchAll(PDO::FETCH_OBJ);
    
        $active_deposit = 0;
        $gross_deposit = 0;
        $gross_interest = 0;
        $referral = 0;
        $total_withdraw = 0;
    
        $current_balance = 0;
        $current_balance_status = False;
        
        if(count($cdata)>0){
            foreach($cdata as $c){    
                if($c->tr_type == "Deposit"){
                    if ((strtotime($c->tr_time) + (7*24*60*60)) > time()) {
                        //that means user has active deposit currenrly receiving profits
                        $active_deposit += $c->tr_amount;
                        $current_balance += $c->profit - $c->tr_amount;

                        $current_balance_status = True;
                    }
    
                    //$gross_deposit += $c->tr_amount;
                    
                    $gross_interest += $c->profit;
    
                } else if($c->tr_type == "referral"){ 
    
                    $referral += $c->tr_amount;
    
                } else if($c->tr_type == "Withdraw"){ 
    
                    $total_withdraw += $c->tr_amount;
    
                }      
            }
            /*
            if($c->tr_type == "Deposit" && (strtotime($c->tr_time) + (7*24*60*60)) > time()) {
                $current_balance = ($gross_interest + $referral) - $total_withdraw;
            }
            */

            if ($current_balance_status == False) {
                $current_balance = ($gross_interest + $referral) - $total_withdraw;
            } else {
                /* 
                putting this would introduce the minus(-) sign problem when user withdraws after 7 days and invests again
                */
                //$current_balance -= $total_withdraw;

                /*Now, if user has an active deposit, just show his profits:*/
                $cstmt2 = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? AND tr_type = ? ORDER BY tr_id DESC LIMIT ?, ?");
                $cstmt2->execute([$data->user_id, "Deposit", 0, 1]);
                $cdata2 = $cstmt2->fetch(PDO::FETCH_OBJ);

                $current_balance = $cdata2->profit - $cdata2->tr_amount;

                //To still allow admins simulate withdrawal:
                if ($current_balance >= $total_withdraw) {
                    $current_balance -= $total_withdraw;
                }
            }
            //$current_balance = ($gross_interest + $referral) - $total_withdraw;
        }
    } else {
        header("location:/login");
    }