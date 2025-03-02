<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

    if($data){
        // that means user is logged in:

        //cookie variables:
        $form_user_id = $_COOKIE["username_or_email"];
        $form_password = $_COOKIE["password"];

        //~check if user is new so as to welcome user:
        if(isset($_GET["new-user"])){
            $user_status = htmlentities($_GET["new-user"]);
            if ((time() - strtotime($data->entry_date)) < (1*60)){//if user is not more than 1 min old
                echo "<div class='pop_up'>Sign up successful. Welcome to $site_name, <b>$data->username</b>. <span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_up()'></i></span></div>";
            } else { //to avoid excessive access to mysql database ~ I don't know if this is necessary though
                header("location:/dashboard");
            }
        }
     
        //display header:
        Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $site_mining_page_url = SITE_MINING_PAGE_URL, $Hi_user = $data->username);
        
?>

<div style="margin-top:150px">
    <!-- This is going off soon -->
    <div style="text-align:center">
        <p>Sorry, we're still working on this project.</p>
        <p>We believe this little tour has been able to give you the whole idea of what the project is all about</p>
        <p>For further enquiries, kindly <b><a href="https://wa.me/+2348106961530">click here <i class="fa fa-whatsapp"></i></a></b> to contact the software developer, or call on: +2348106961530.</p>
    </div>
    <!--End of: This is going off soon -->

    <!-- Referral Link section starts -->
    <div style="padding:12px">
        <h3 style="color:#fff">Your Referral Link</h3>
            
        <input style="height:33px;border:1px solid #0bee3ccc;
            border-right:30px solid #0bee3ccc;width:80%;
            border-radius:6px;margin-top:8px" id='referral_link'
            value="https://<?=$site_url_short?>/?ref=<?=$data->username?>"/>
            
            <i style="margin-left:-29px" class="fa fa-copy" onclick="copyText('referral_link')"></i>
            <div id="alert_text_copied"></div>
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