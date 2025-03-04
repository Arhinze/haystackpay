<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/views/Dashboard_Segments.php");

if($data){// that means user is logged in:
    //display header:
    //Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "");
    Dashboard_Segments::header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = $data->username,$title="Deposit - ".SITE_NAME);  
?>


<div style="margin:180px 15px 90px 15px">
    <form method="post" action="" style="background-color:#fff;padding:15px 6px;border-radius:9px">
        <input type="number" class="input" placeholder="N100 - N5,000,000" style="border:0;border-bottom:1px solid #fff;margin:18px 3px;padding:12px"/>
    </form>
</div>

<?php
    Dashboard_Segments::dashboard_footer(); 
} else { /*end of if($data) for cookie name and pass .. else means user is not logged in*/
    header("location:/login");
} 
?>