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
        //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
        Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title=SITE_NAME." - Dashboard");
        
        
?>

<div style="margin:180px 15px 90px 15px">
    <!-- This is going off soon -->
    <div style="text-align:center">
        <p>Sorry, we're still working on this project.</p>
        <p>We believe this little tour has been able to give you an idea of what the project is all about</p>
        <p>For further enquiries, kindly <b><a href="https://wa.link/hgzcrj" style="color:#ff9100">click here <i class="fa fa-whatsapp"></i></a></b> to contact the software developer, or call on: <b>+2348106961530</b>.</p>
    </div>
    <!--End of: This is going off soon -->

    <!-- Referral Link section starts -->
    <div style="padding:12px">
        <h3 style="color:<?=$site_color_alt?>">Your Referral Link</h3>
            
        <input style="height:33px;border:1px solid #ff9100;
            border-right:30px solid #ff9100;width:80%;
            border-radius:6px;margin-top:8px" id='referral_link'
            value="https://<?=$site_url_short?>/?ref=<?=$data->username?>"/>
            
            <i style="margin-left:-29px;color:#fff" class="fa fa-copy" onclick="copyText('referral_link')"></i>
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