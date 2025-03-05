<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/php/account-manager.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/config/paystack.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Index_Segments.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Transactions.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Mail.php");

class Dashboard_Segments extends Index_Segments{
    public static function header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "",$title=SITE_NAME){
        $main_header = Index_Segments::main_header();
        $css_version = filemtime($_SERVER["DOCUMENT_ROOT"]."/static/style.css");


    echo <<<HTML
    <!doctype html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="/static/style.css?$css_version"/>
        <link rel="icon" type="image/x-icon" href="/static/images/favicon.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <title>$site_name</title>        
    </head>
    <body>

    <div class="body">
        $main_header

        <div class="hi_user"> 
            <!-- Google Translate div --> 
            <!--<div class="clear"><div id="google_translate_element" style="position:fixed;float:left;left:13px;top:59px;background-color:#fff;border-radius:4px;padding:0px 3px"></div></div>-->
            
            <!-- Hi user --> 
            
            <span style="float:right;background-color:#fdfff5;color:#000;border-radius:6px;margin:3px;font-size:12px;padding:1px 0 6px 9px;margin-right:12px">
                
                Hi $Hi_user

                <i style="background-color:#ff9100;color:#fff; border-radius:6px;padding:6px 8px;text-align:center;margin:6px 9px 0px 6px;" class="fa fa-user"></i> 
            </span>
        </div>
    
        <a name="#top"></a>

        <input type="checkbox" id="menu-box" class="menu-box"/>

        <ul class="menu-list"> 
            
            <li class="x"><label for="menu-box"><i class="fa fa-times"></i></label></li>
            
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/deposit">Add Money</a></li>
            <li><a href="$site_url#bulk_tr">Bulk Transfer </a></li>
            <li><a href="/withdraw">Withdraw </a></li>

            <!--
            <li class="clear" style="padding-bottom:16px">
                <label for="hidden-menu-item">
                    <span style="float:left">Transfers</span> <i class="fa fa-angle-down" style="float:right"></i> 
                </label>
            </li>

            <input type="checkbox" style="display:none" id="hidden-menu-item" class="hidden-menu-item"/>
            <div class="hidden-menu-div">
                <a href="$site_url/single-transfer" style="color:#fff">Singular Transfers</a><br />
                <a href="$site_url/bulk-transfer" style="color:#fff">Bulk Transfers</a>
            </div>
            -->

            <li class="clear" style="padding-bottom:16px">
                <label for="hidden-menu-item">
                    <span style="float:left">Referrals</span> <i class="fa fa-angle-down" style="float:right"></i> 
                </label>
            </li>

            <input type="checkbox" style="display:none" id="hidden-menu-item" class="hidden-menu-item"/>
            <div class="hidden-menu-div">
                <a href="$site_url/dashboard#referral_link" style="color:#fff">Referred Users</a><br />
                <!--<a href="$site_url/referred-users/#referral_link" style="color:#fff">Referred Users</a><br />-->
                <!--<a href="$site_url/referred-commissions">Referred Commissions</a>-->
            </div>
            
            <li><a href="/settings">Settings</a></li>
            <li><a href="/reset-password">Reset Password</a></li>

            <li><a href="/logout.php" style="color:#fff;font-weight:bold;background-color:red;padding:6px;border-radius:12px">Log out</a></li>
        </ul>     
HTML;
    }


    public static function dashboard_body_top() {
        echo <<<HTML
            <div class="dashboard_form" style="display:flex;justify-content:center">
                <div class="dashboard_top_section">
                    <div class="dashboard_top_div"><i class="fa fa-arrow-circle-down"></i></div>
                    <div class="dashboard_top_text">Deposit</div>
                </div>
                <div class="dashboard_top_section">
                    <div class="dashboard_top_div"><i class="fa fa-bank"></i></div>
                    <div class="dashboard_top_text">Withdraw to bank</div>
                </div>
                <div class="dashboard_top_section" onclick="show_div('coming_soon')">
                    <div class="dashboard_top_div"><i class="fa fa-exchange"></i></div>
                    <div class="dashboard_top_text">Convert</div>
                </div>
            </div>
            
            <!-- displayed when user clicks on 'convert' . this is going off soon -->
            <span id="coming_soon" style="display:none">
                <span style='float:right;position:absolute;top:9px;right:9px'><i class='fa fa-times' onclick="show_div('coming_soon')"></i></span>
            </span>
        HTML;
    }



    public static function dashboard_scripts($site_name = SITE_NAME_SHORT, $site_url = SITE_URL){

        //Index_Segments::index_scripts();

        echo <<<HTML
        <!-- Footer - dashboard_script -->
        <script>
                         
            const pop_up_collection = document.getElementsByClassName("pop_up");
                                 
            for (let i=0; i < pop_up_collection.length; i++){
                //pop_up_collection[i].style = "display:none";
                                            
                var innerHT = pop_up_collection[i].innerHTML;
                            
                var newInnerHT = innerHT + "<span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_up()'></i></span>";
                          
                pop_up_collection[i].innerHTML = newInnerHT;
            }
                           
            function close_pop_up() {
                //const pop_up_collection = document.getElementsByClassName("pop_up");
                i = 0;
                               
                for (i=0; i<pop_up_collection.length; i++){
                    pop_up_collection[i].style.display = "none";
                }  
            } 

            function copyText(link_text_id){
                x = document.getElementById(link_text_id);
                x.select();
                x.setSelectionRange(0, 99999);
        
                document.execCommand('copy');
                //alert("copied text: " + x.value);
                document.getElementById("alert_text_copied").innerHTML = "<div class='pop_up'>copied text: <b><br />" + x.value + "</b> <span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_up()'></i></span><div/>";
            }
        </script>

        <script>
            /*function pop_up(txt){
                document.getElementById("pop_up").innerHTML = "<div class='pop_up'>"+txt+"<span style='float:right;position:absolute;top:6px;right:6px'><i class='fa fa-times' onclick='close_pop_upx()'></i></span></div>";
            }

            function close_pop_upx(){
                document.getElementById("pop_up").style.display = "none";
            }*/

            function show_div(vari) {
                if (document.getElementById(vari).style == "display:none") {
                    document.getElementById(vari).style = "display:block";
                } else if (document.getElementById(vari).style == "display:block") {
                    document.getElementById(vari).style = "display:none";
                } else {
                    document.getElementById(vari).style = "display:block";
                }
            }
        </script>

    <noscript> 
        Java script is disabled. Site won't work well. please enable Javascript.
    </noscript>
HTML;
    }

    public static function dashboard_footer(){
        Index_Segments::footer($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $additional_scripts = Dashboard_Segments::dashboard_scripts());
    }
}