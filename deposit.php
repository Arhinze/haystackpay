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

    if($data){
        //that means the person is logged in:
        Dashboard_Segments::header();
        
        if(isset($_POST["deposit"])){
            //send mail to user -- moved to confirm-deposit page
        }
?>

<form method="post" action="/confirm-deposit">
<div class="dashboard_div">
    <div class="new-dashboard-head">Deposit</div>
       
    <!--Plan starts -->
    <div class="new-dashoard">
        <div class="new-dashboard-subhead">  
            <label><input type="radio" name="plan" value="basic" required/> Basic Plan</label>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Plan
        </div>

        <div class="new-dashboard-right">
            Spent Amount ($) &nbsp; &nbsp; &nbsp;	Daily Profit (%)
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Basic Plan
        </div>

        <div class="new-dashboard-right">
            $100.00 - $4999.00	&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; 2.00
        </div>
    </div>
    <!--Plan ends -->
        

    <!--Plan starts -->
    <div class="new-dashoard">
        <div class="new-dashboard-subhead">  
            <label><input type="radio" name="plan" value="advanced" required/> Advanced Plan</label>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Plan
        </div>

        <div class="new-dashboard-right">
            Spent Amount ($) &nbsp; &nbsp; &nbsp;	Daily Profit (%)
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Advanced Plan
        </div>

        <div class="new-dashboard-right">
            $5000.00 - $9999.00	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.50
        </div>
    </div>   	
    <!--Plan ends -->
    
        

    <!--Plan starts -->
    <div class="new-dashoard">
        <div class="new-dashboard-subhead">  
            <label><input type="radio" name="plan" value="premium" required/> Premium Plan</label>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Plan
        </div>

        <div class="new-dashboard-right">
            Spent Amount ($) &nbsp; &nbsp; &nbsp;	Daily Profit (%)
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Premium Plan
        </div>

        <div class="new-dashboard-right">
            $10000.00 - $19999.00 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3.00
        </div>
    </div>   	
    <!--Plan ends -->
    
   

    <!--Plan starts -->
    <div class="new-dashoard">
        <div class="new-dashboard-subhead">  
            <label><input type="radio" name="plan" value="ultimate" required/> Ultimate Plan</label>
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Plan
        </div>

        <div class="new-dashboard-right">
            Spent Amount ($) &nbsp; &nbsp; &nbsp;	Daily Profit (%)
        </div>
    </div>

    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Ultimate Plan
        </div>

        <div class="new-dashboard-right">
            $20000.00 and more &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4.00
        </div>
    </div>   	
    <!--Plan ends -->

    <!--Account Balance -->
    <div class="new-dashboard">
        <div class="new-dashboard-left">
            Your account balance ($):
        </div>

        <div class="new-dashboard-right">
            <?=$current_balance ?>
        </div>
    </div>
    <!--Account Balance Ends-->   	

    <!--Amount to spend -->
    <div class="new-dashboard" style="border-bottom:1px solid #525050;padding-bottom:48px">
        <div class="new-dashboard-left">
            $Amount to Spend ($):
        </div>

        <div class="new-dashboard-right">
            <input type="number" value="100.00" name="amount" class="input" style="margin:0"  required/>
        </div>
    </div>   	
    <!--End of Amount to spend -->


    <!--Choose Wallet Address -->
    <div class="dashboard_div" style="margin-top:12%"> 
        <div class="new-dashboard">
            <label><input type="radio" value="bitcoin" name="type-of-wallet" required/> Spend funds from Bitcoin</label>
        </div>
        <div class="new-dashboard">
            <label><input type="radio" value="ethereum" name="type-of-wallet" required/> Spend funds from Ethereum</label>
        </div>
        <div class="new-dashboard">
            <label><input type="radio" value="bitcoin_cash" name="type-of-wallet" required/> Spend funds from Bitcoin Cash</label>
        </div>
        <div class="new-dashboard">
            <label><input type="radio" value="usdt_trc20" name="type-of-wallet" required/> Spend funds from USDT(TRC20)</label>
        </div>
        <div class="new-dashboard">
            <label><input type="radio" value="doge" name="type-of-wallet" required/> Spend funds from Doge</label>
        </div>
    
        <div class="new-dashboard">
            <label><input type="radio" value="bnb_bep2" name="type-of-wallet" required/> Spend funds from BNB</label>
        </div>
            
        <div class="new-dashboard">
            <label><input type="radio" value="usdt_erc20" name="type-of-wallet" required/> Spend funds from USDT(ERC20)</label>
        </div>
            
        <div class="new-dashboard">
            <label><input type="radio" value="TRX" name="type-of-wallet" required/> Spend funds from TRX</label>
        </div>
    </div>
    <!--Choose Wallet Address Ends -->

    <input type="hidden" name="checkout-deposit" value="yes"/>
        
    <!--"Submit" Button-->
    <input type="submit" value="Place Deposit" style="border:0px;background-color:#2b8eeb;border-radius:6px;color:#fff;font-size:16px;padding:8px;margin:-16px 0 16px 16px"/>
         
</div>

</form>
 
<!-- Reference number-->
<!--
<div class="calculator">
    <h2>Reference Number</h2><hr/>
    <p><b style="font-size:19px">Step 4:</b> Send the Transaction Reference Number as Proof of Payment:</p>
    
    <input type="text" name="payment_proof" style="background-color:#fff;border-radius:6px;color:#01123c;border:1px solid #2b8eeb;width:70%;height:24px" placeholder="Enter Transaction Reference Number"/><br />
    
    <input type="hidden" name = "depositer_id" value="<?=$data->user_id?>"/>
    <input type="hidden" name="request_type" value="Deposit"/>
    
    <br />
    <input type="submit" value="Place Deposit" style="border:0px;background-color:#2b8eeb;border-radius:6px;color:#fff;font-size:16px;padding:8px"/>
</div>
-->


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