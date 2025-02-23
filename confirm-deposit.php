<?php
include_once("views/Dashboard_Segments.php");
include_once("php/account-manager.php");


//To be used in 1.) withdraw.php 2.) invest.php 3.) admin_of_admins.php
//Select the wallet address from database to use as 'value' for the input elements
$rates = [];
$br_stmt = $pdo->prepare("SELECT * FROM btc_rate LIMIT ?, ?");
$br_stmt->execute([0, 6]);
$br_data = $br_stmt->fetchAll(PDO::FETCH_OBJ);

foreach($br_data as $b){
    $rates[] = $b->br;
}

    if($data){
        //that means the person is logged in:
        Dashboard_Segments::header();
        
        if(isset($_POST["confirm-deposit"])){
                //insert deposit proper
                $deposit_stmt = $pdo->prepare("INSERT INTO user_requests(user_id, rq_type, rq_amount,rq_time, rq_img,rq_payment_method) VALUES(?,?,?,?,?,?)");

                $deposit_stmt->execute([$data->user_id,"Deposit",htmlentities($_POST["requested-amount"]),date("Y-m-d h:i:s", time()),htmlentities($_POST["reference-id"]),htmlentities($_POST["wallet-type"])]);
  
                //Mail User:
                $i_name = $data->real_name;
                $dep = $_POST["requested-amount"];
                ini_set("display_errors", 1);

                $message = <<<HTML
                    <html>
                    <head>
                        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                
                    </head>
                    <body style ="font-family:Trirong;">
                        <div style="position:relative">
                            <img src="https://$site_url_short/static/images/logo-vertextrade.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
                        </div>
                        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name Investment</h2>
                            <p  style ="font-family:Trirong;">Hello $i_name, Your <b>Investment</b> of $dep has been injected into the blockchain and is currently awaiting approval by the system.</p>
                            <p>Do well to check the Transaction page on your dashboard from time to time to view your profits.</p>
                            <p style="margin-bottom:30px">For further enquiries, you can check out our <b><a href="https://$site_url_short/faqs"  style="color:#ff3c00">Frequently asked questions</a></b> page or <b><a href="https://$site_url_short/contact" style="color:#ff3c00">contact us</a></b> directly if our page doesn't answer your questions.</p>
                            
                            
                            <a href="https://static/images/logo-vertextrade.png/transactions" style="color:#ff3c00;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #ff3c00;border:2px solid #ff3c00;width:8%;margin-left:30%;margin-right:20%">View Transactions</a>
                    </body>
                    </html>
                HTML;

                $sender = "admin@$site_url_short";

                $headers = "From: $sender \r\n";
                $headers .="Reply-To: $sender \r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                $mail = mail($data->user_email,"Your Deposit On $site_name Investment",$message, $headers);

                if($mail){
                    echo "<br />A Mail has been sent to you";
                } else {
                    echo "Sorry, an error occurred, Mail not sent";
                  } 
?>


                <div class="main" style="font-size:18px;text-align:center;background-color:#01123c;color:#fff;margin-top:106px;margin-bottom:106px">
                    Your Deposit Request has been Placed <i class="fa fa-mark"> and is currently awaiting approval.</i>
                    <br /><br /><br />
                    <center>
                    <a href="/dashboard" class="action_button" style="background-color:#2b8eeb;color:#fff;border:1px solid #fff;border-radius:4px">
                        Dashboard
                        &nbsp;
                        <i class="fa fa-angle-right"></i>
                        <i class="fa fa-angle-right"></i>
                    </a>
        
                    <a href="/transactions" class="action_button" style="background-color:#01123c;color:#fff;border:1px solid #fff;border-radius:4px">
                        Transactions
                        &nbsp;
                        <i class="fa fa-angle-right"></i>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    </center>
                    <br />
                </div>

<?php
            } // end of if (isset ($_POST["confirm-deposit"]))

            if (isset($_POST["checkout-deposit"])) {

                $wallets = [
                    "bitcoin"=>"bc1q830mj60852y30l822w0vf07uwzxg8lkhtk67tc",
                    "ethereum"=>"0xcBf1b2daA5D941F469456d52F74144d93E901713",
                    "bitcoin_cash"=>"qrhpyhrsaqx5vxh64qw52qw6sfy60arclghumjlq0u",
                    "usdt_trc20"=>"TDBPyG6wWUFmhyjnjp1EoMxmfpq1NqMFgo",
                    "doge"=>"D6i3p3ZVqKYuS1tFZQKnQ4Z9WuFSkdHWMN",
                    "bnb_bep2"=>"bnb1ln7hkcd3aglph0my5sm330w2tnt7ph733c4mx7",
                    "usdt_erc20"=>"0xcBf1b2daA5D941F469456d52F74144d93E901713",
                    "TRX"=>"TDBPyG6wWUFmhyjnjp1EoMxmfpq1NqMFgo",
                ];

                $profits = [
                    "basic"=>"2",
                    "advanced"=>"2.5",
                    "premium"=>"3",
                    "ultimate"=>"4"
                ];

                $user_wallet_choice = htmlentities($_POST["type-of-wallet"]);
                $user_plan = htmlentities($_POST["plan"]);
?>


<div class="dashboard_div">
    <div class="new-dashboard-head">Please Confirm your Deposit</div>

    <!--Bitcoin Address starts -->
    <div class="new-dashboard">
        Please send your payments to the following <?=ucfirst($user_wallet_choice)?> wallet address:
        <br />
        <b><?=$wallets[$user_wallet_choice]?></b>
    </div>
    <!--Bitcoin Address ends -->
       
    <!--Plan starts -->
    <div class="new-dashboard">
        <div class="new-dashboard-left">
            <b>Plan</b>
        </div>

        <div class="new-dashboard-right">
            Basic Plan
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            <b>Profit</b>
        </div>

        <div class="new-dashboard-right">
            <?=$profits[$user_plan]?>% daily for 7 days.
        </div>
    </div>


    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Principal Return:
        </div>

        <div class="new-dashboard-right">
            Yes
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Principal Withdraw:	
        </div>

        <div class="new-dashboard-right">
            Not available
        </div>
    </div>   	
   


    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Credit Amount:	
        </div>

        <div class="new-dashboard-right">
            <?=htmlentities($_POST["amount"])?>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
             Deposit Fee:	
        </div>

        <div class="new-dashboard-right">
            0.00% + $0.00 (min. $0.00 max. $0.00)
        </div>
    </div>   	
   

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Debit Amount:
        </div>

        <div class="new-dashboard-right">
            <?=htmlentities($_POST["amount"])?>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Debit Amount:
        </div>	
	
        <div class="new-dashboard-right">
            <?=htmlentities($_POST["amount"])?>
        </div>
    </div>   	


    <!--Form for transaction reference id begins -->
    <form method="post" action="" style="width:60%;margin-left:12px">
        <div>
            <h4>Required:</h4>
            Transaction ID
            <input type="text" placeholder="Enter transaction ID" name="reference-id" class="input" style="margin:0"/>
            <input type="hidden" name="wallet-type" value="<?=$user_wallet_choice?>"/>
            <input type="hidden" name="requested-amount" value="<?=htmlentities($_POST["amount"])?>"/>
            <input type="hidden" name="confirm-deposit" value="yes"/>
        </div> 
        
        <div class="">
            <!-- "Submit" Button -->
            <input type="submit" value="Confirm Deposit" style="border:0px;background-color:#2b8eeb;border-radius:6px;color:#fff;font-size:16px;padding:8px;margin:20px 0 16px 4px"/>  
        </div>  
    </form> 
    <!--Form for transaction reference id ends -->
    
</div>


<?php
    }

    Dashboard_Segments::footer();
    } else {
        header("location:/login");
    }

?>  

<script>
    function calculate(input_id1){
        currency_array = ["btc","eth","usdt","pm"];
        if(document.getElementById(input_id1).placeholder == "usd"){
            for(i of currency_array.keys()){
                x = document.getElementById(currency_array[i]);
                rate = x.name;
                x.value = (document.getElementById(input_id1).value)/rate ; 
            }     
        } else {
            currency = document.getElementById(input_id1);
            for(j of currency_array.keys()){
                y = document.getElementById(currency_array[j]);
                rate = (currency.value)*(currency.name);
                y.value = (rate/(y.name)); 
            }   
            document.getElementById('usd').value = (currency.value)*(currency.name); 
        }
    }

    function show_div(vari) {
        if (document.getElementById(vari).style.display == "none") {
            document.getElementById(vari).style.display = "block";
        } else if (document.getElementById(vari).style.display == "block") {
            document.getElementById(vari).style.display = "none";
        }
    }
</script>