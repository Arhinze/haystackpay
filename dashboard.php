<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data){// that means user is logged in:
    // ~ check if user made a new transaction:
    if(isset($_GET["new_transaction"])) {
        $trans_id = (int)htmlentities($_GET["new_transaction"]);
        if ((time() - strtotime($hstkp_transactions->tr_time($trans_id))) < (1*60)){//if transaction is not more than 1 min old
            echo "<div class='pop_up'>Transaction successful. <span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_up()'></i></span></div>";
        } else { //to avoid excessive access to mysql database ~ I don't know if this is necessary though
            header("location:/dashboard");
        }
    }
     
    //display header:
    //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title=SITE_NAME." - Dashboard");  
?>

<div style="margin:180px 15px 90px 15px">
    <!-- This is going off soon -->
    <!--
    <div style="text-align:center">
        <p>Sorry, we're still working on this project.</p>
        <p>We believe this little tour has been able to give you an idea of what the project is all about</p>
        <p>For further enquiries, kindly <b><a href="https://wa.link/hgzcrj" style="color:#ff9100">click here <i class="fa fa-whatsapp"></i></a></b> to contact the software developer, or call on: <b>+2348106961530</b>.</p>
    </div>
    -->
    <!--End of: This is going off soon -->

    <div class="dashboard">
        <h2>Your Transactions:</h2><hr />
        <?php
            $no = 0;
            $all_trs_by_this_user = $hstkp_transactions->all_trs($data->user_id);
            
            echo "<div style='margin:27px 9px'>";
            if(count($all_trs_by_this_user) > 0) {
                foreach ($all_trs_by_this_user as $all_h_tr) {
                    $no += 1;
                    $tr_color = ($all_h_tr->tr_type == "inflow") ? "green" : "red";
        ?>
                    <div style="color:<?=$tr_color?>;font-size:15px;margin-bottom:9px" onclick="show_div('tr_desc_div<?=$no?>')">
                        <i class='fa fa-circle'></i> &nbsp; <?=$all_h_tr->tr_type?> - N<?=$all_h_tr->tr_amount?> - <?=$all_h_tr->tr_time?> <i class='fa fa-angle-down'></i>
                    </div>
    
                    <div id="tr_desc_div<?=$no?>" style="display:none;font-size:12px;margin:9px;background-color:#fff;padding:12px;9px;border-radius:9px;border:1px solid #ff9100;box-shadow:0 0 6px 0 #888 inset"><?=$all_h_tr->tr_from?></div>
        <?php
                }
            } else {
                echo "<i class='color:#888'> - All Your Transactions will appear here - </i>";
            }
        ?>
            </div>
            <hr />
        <div style="margin-top:21px"><b>Current Balance: </b><?=$hstkp_transactions->current_balance($data->user_id)?></div>
    </div>

    <!-- Referral Link section starts -->
    <div style="padding:12px">
        <h3 style="color:<?=$site_color_alt?>">Your Referral Link</h3>
            
        <input style="height:33px;border:1px solid #ff9100;
            border-right:30px solid #ff9100;width:80%;
            border-radius:6px;margin-top:8px" id='referral_link'
            value="https://<?=$site_url_short?>/?ref=<?=$data->username?>"/>
            
            <i style="margin-left:-29px;color:#fff" class="fa fa-copy" onclick="copyText('referral_link')"></i>
            <div id="alert_text_copied"></div>

        <a name="referral_link" id="referral_link"></a>
        <br /> 
    </div>
    <!-- Referral Link section ends -->
</div>

<?php
    Dashboard_Segments::dashboard_footer(); 
} else { /*end of if($data) for cookie name and pass .. else means user is not logged in*/
    header("location:/login");
} 
?>