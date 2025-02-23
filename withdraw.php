<?php
include_once("views/Dashboard_Segments.php");
include_once("php/account-manager.php");

//To be used in 1.) withdraw.php 2.) invest.php 3.) admin_of_admins.php
//Select the rates from database to use as 'value' for the input elements
$rates = [];
$br_stmt = $pdo->prepare("SELECT * FROM btc_rate LIMIT ?, ?");
$br_stmt->execute([0, 6]);
$br_data = $br_stmt->fetchAll(PDO::FETCH_OBJ);

foreach($br_data as $b){
    $rates[] = $b->br;
}

    if ($data) {
    //that means.. user is logged in:
        Dashboard_Segments::header();
        
                    if (isset($_POST["withdrawal_amount"])) { 
                        
                            //check if user has enough money in wallet address:   
                            if($current_balance >= $_POST["withdrawal_amount"]) {
                                //place withdraw request:
                                $deposit_stmt = $pdo->prepare("INSERT INTO user_requests(user_id, rq_type, rq_amount,rq_time,rq_wallet_address,rq_payment_method) VALUES(?,?,?,?,?,?)");

                                $deposit_stmt->execute([
                                    $_POST["withdrawer_id"],"Withdraw",$_POST["withdrawal_amount"],date("Y-m-d h:i:s", time()),$_POST["user_wallet_address"],$_POST["wallet_type"]
                                ]);
                    

                                //Mail User:
                                $w_name = $data->real_name;
                                $withd = $_POST["withdrawal_amount"];
                                $walletAddress = $_POST['user_wallet_address'];
                                $walletType = $_POST['wallet_type'];
                                
                                ini_set("display_errors", 1);

                                $message = <<<HTML
                                    <html>
                                    <head>
                                        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo"/>
                                                <link rel="stylesheet" href="https://$site_url_short/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
                    
                                    </head>
                                    <body style ="font-family:Trirong;">
                                        <div style="position:relative">
                                            <img src="https://$site_url_short/static/images/logo-bitfinance.png" style="margin-left:36%;margin-right:36%;width:25%;position:absolute"/>
                                        </div>
                                        <h2 style="color:#00008b;font-family:Arimo;text-align:center">$site_name</h2>
                                            <p  style ="font-family:Trirong;">Hello $w_name, Your Withdrawal Request of \$$withd from your <b>$walletType </b>wallet address:<b> $walletAddress</b> has been injected into the blockchain and is currently awaiting approval by the system.</p>
                                            <p>Do well to check the wallet address you inputed in the request process. Make sure it doesn't contain any errors as this would lead to rejection.</p>
                                            <p>Don't be scared though, you would receive 100% refund of your money.</p>
                                            <p>In fact, the money never really leaves your $site_name's Interest Wallet Address until full approval by the Blockchain.</p>
                                            <p style="margin-bottom:30px">For further enquiries, you can check out our <b><a href="https://$site_url_short/faqs"  style="color:#ff3c00">Frequently asked questions</a></b> page or <b><a href="https://$site_url_short/contact" style="color:#ff3c00">contact us</a></b> directly if our page doesn't answer your questions.</p>
                                        
                                        
                                        <a href="https://$site_url_short/transactions" style="color:#ff3c00;font-size:18px;padding:2%;border-radius:6px;box-shadow:0px 0px 3px #ff3c00;border:2px solid #ff3c00;width:8%;margin-left:30%;margin-right:20%">View Transactions</a>
                                    </body>
                                    </html>
                                HTML;

                                $sender = "admin@$site_url_short";

                                $headers = "From: $sender \r\n";
                                $headers .="Reply-To: $sender \r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $headers .= "Content-type:text/html; charset=UTF-8\r\n";

                                $mail = mail($data->user_email,"Your Withdrawal Request On $site_name",$message, $headers);

                                if($mail){
                                    echo "<br />A Mail has been sent to you";
                                } else {
                                    echo "<br />Sorry, An error occurred. Mail not sent";
                                  }
                                //Mail function ends
?>
                    <div class="main" style="font-size:18px;text-align:center;background-color:#01123c;color:#fff;margin-top:106px;margin-bottom:106px">
                    Your Withdrawal Request has been Placed <i class="fa fa-mark"> and is currently awaiting approval.</i>
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
                            } else{
                                echo "<div class='invalid'>Sorry, Insuffient Funds</div>";
                              }
                    }
?>

 
<div class="dashboard_div">
<form method="post" action="">

<h1 style="padding-left:10px">Place Withdraw Request</h1><hr />

<div class="calculator">
<b style="font-size:19px">Step 1:</b> Choose Your Preferred Wallet:
<br /><br />

<label><input type="radio" name="wallet_type" value="bitcoin" required/> Bitcoin </label><br /><br />
<label><input type="radio" name="wallet_type" value="ethereum" required/> Ethereum</label> <br /><br />
<label><input type="radio" name="wallet_type" value="usdt_trc20" required/> USDT TRC20</label><br /><br />
<label><input type="radio" name="wallet_type" value="bitcoin_cash" required/> Bitcoin Cash</label> <br /><br />

<!-- Show more Payment Methods -->

<span style="padding:6px 9px;color:#fff;background-color:#01123c;border-radius:6px" onclick="show_div('more_payment_methods')">
    View More &nbsp;<i class="fa fa-angle-down"></i>
</span>

<div id="more_payment_methods" style="display:none"><br />

<label><input type="radio" name="wallet_type" value="usdt_erc20" required/> USDT ERC20 </label><br /><br />
<label><input type="radio" name="wallet_type" value="doge" required/> Doge</label> <br /><br />
<label><input type="radio" name="wallet_type" value="bnb_bep2" required/> BNB </label><br /><br />
<label><input type="radio" name="wallet_type" value="TRX" required/> TRX </label>
<br /><br />

</div>

</div>


<div class="calculator">
<hr />

<b style="font-size:19px">Step 2:</b>Enter your wallet address below for verification by the blockchain system.
<br />

<input type = "text" class="investor_input" id = 'user_wallet_address' name = "user_wallet_address" placeholder="your wallet address: "/>
<i class="fa fa-copy" style="margin-left:-33px" onclick="copyText('user_wallet_address')"></i>

<br /><br />
</div>


<!--Enter Amount-->
<div class="calculator">
    <h2>Enter Amount</h2>

    <b style="font-size:19px">Step 3:</b>Specify the amount you would like to withdraw in USD($).
    <br />
    
    <input type = "text" class="investor_input" name="withdrawal_amount" placeholder="usd" required/><span style="margin-left:-39px">USD</span>
    
</div>
<!-- Enter Amount ends-->


<!--Your Balance:-->
<div class="calculator">
<h3>Your Balance:</h3> <hr />

Current Wallet Balance: <b>$<?=$current_balance?></b> 
<br /><br />

    <div style="text-align:center">
        <i style="font-size:14px;">Our System offers a seamless withdrawal policy that allows investors to withdraw both their interest and capital at any time.</i>
    </div>

<?php
    if ($current_balance == 0) {
?>
        <div class="new-dashboard-subheader">Sorry, You do not have any funds to withdraw from</div>
<?php
    }
?>

</div>
<!--Withdraw from ends-->



<!--hiddden inputs-->
<input type="hidden" name = "withdrawer_id" value="<?=$data->user_id?>"/>

<!--hiddden inputs end-->


<br />
<input type="submit" value="Withdraw" class="button" style="margin-left:16px"/>

</form>

</div>


<?php
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