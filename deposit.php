<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data) {// that means user is logged in:
    
    if(isset($_POST["deposit_amount"])) { //paystack initialization starts
        //Initialize Paystack:
        $dep_amount = (int)htmlentities($_POST["deposit_amount"]);
    
        $url = "https://api.paystack.co/transaction/initialize";
        
        $fields = [
          'email' => $data->user_email,
          'amount' => $dep_amount*100,
          'callback_url' => "$site_url/success.php?deposit_amount=$dep_amount",
          //'callback_url' => "$site_url/success.php?name=$new_order_name&phone=$new_order_phone&qty=$new_order_qty&mail=$customer_mail&product=$product_name",
          'metadata' => ["cancel_action" => "$site_url/failure.php"]
          //'callback_url' => "$site_url/config/webhook.php"
        ];
        
        $fields_string = http_build_query($fields);
        
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Bearer ".$SecretKey,
          "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
    
        $response = json_decode($result, true);
        if ($response['status']) {
            header("Location: " . $response['data']['authorization_url']);
        } else {
            echo "Payment failed, try again.";
        }
    
        //email admin on attempted deposit    
        // implement this someday : $mail_sender->send();
        $mail1 = mail($sender,"A user attempted a deposit of $dep_amount", $attempted_deposit_message, $headers);
        $mail2 = mail("francisokoye48@gmail.com", "A user attempted a deposit of $dep_amount", $attempted_deposit_message, $headers);
    
        check_mail_status($mail1);
        check_mail_status($mail2);
        //Record the transaction:
        //$hstkp_transactions->deposit($data->user_id, $dep_amount, "You made a deposit"); ~ should be on success page
    } //paystack initialization ends

    //display header: ~ still under if($data), placed here to avoid header() already initialised error
    //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title="Deposit - ".SITE_NAME);  
?>

<div style="margin:180px 15px 90px 15px">
    <h2>Add Money</h2>
    <form method="post" action="" style="background-color:#fff;padding:15px 6px;border-radius:9px;border:1px solid #ff9100">
        <input type="number" class="input" name="deposit_amount" placeholder=" N100 - N5,000,000" style="border:1px solid #888;margin:18px 3px;height:42px;width:96%" required/>

        <button type="submit" class="long-action-button" style="background-color:green;color:#fff;width:96%">
            Confirm
        </button>
    </form>
</div>

<?php
    Dashboard_Segments::dashboard_footer(); 
} else { /*end of if($data) for cookie name and pass .. else means user is not logged in*/
    header("location:/login");
} 
?>