<?php
ini_set("display_errors", '1'); //for testing purposes..

include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");

class Index_Segments{
    public static function header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "", $title=SITE_NAME){
        if (isset($_GET["ref"])) {
            $ref = htmlentities($_GET["ref"]);

            if(isset($_COOKIE["ref"])){
                //delete existing referer cookie
                setcookie("ref", $ref, time()-(24*3600), "/");
            }

            //set new referer cookie:
            setcookie("ref", $ref, time()+(12*3600), "/");
        }

        $css_version = filemtime($_SERVER["DOCUMENT_ROOT"]."/static/style.css");

        echo <<<HTML
        <!doctype html>
        <html lang="en">
        <head>
          
            <link rel="stylesheet" href="/static/style.css?$css_version"/>
            <link rel="icon" type="image/x-icon" href="/static/images/favicon.png"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo|Prompt"/>
            
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                
            <title>$title</title>
              
        </head>
        <body>
            <div class="headers">  
                <div style="margin:-16px 19px 0px 14px">
                    <a href="/"><h3 class="site_name">$site_name</h3></a>
                </div>
            
                <div class="menu-icon">
                    <label for = "menu-box">
                        <i class="fa fa-bars"></i>
                    </label>
                </div> 
            </div> 
        
            <a name="#top"></a>
              
            <div class="menu-list-div">  
                <input type="checkbox" id="menu-box" class="menu-box"/>
                <ul class="menu-list">
                                
                    <li class="x"><label for="menu-box"><i class="fa fa-times"></i></label></li>
                    
                    <!--<li><a href="/about-us">About</a></li>-->
                    <li><a href="/login">Login</a></li>
                    <li><a href="/sign-up">Sign Up</a></li>
                    <li><a href="/how-it-works">How it works</a></li>
                    <li><a href="https://wa.link/94f4vk">Contact us</a></li>
                </ul> 
            </div> 
       HTML;
       }
                
        public static function body($site_name = SITE_NAME_SHORT, $site_url = SITE_URL){
            $site_name_uc = strtoupper($site_name);
            echo <<<HTML
                <div class="haystackpay_intro">
                    <!--<img src="/static/images/logo.png" style="width:120px;height:120px;border-radius:100%"/>-->
                    <br />
                    <h1>Get it done with <span style="color:#ff9100">ease</span>.</h1>
                    <div>Make bulk transfers, receive, send, exchange and manage multiple currencies in one app.</div>

                    <!--
                    <img src="/static/images/horizontal_image1.png" class="" style="margin:12px"/> 
                    <img src="/static/images/horizontal_image2.png" class=""/>
                    -->

                    <a href="/sign-up">
                        <div class="get_started">
                            <div class="get_started_img_div"><img src="/static/images/logo.png" class="get_started_img"/></div>
                            <div>Get Started now &nbsp;<i class="fa fa-arrow-right"></i></div>
                        </div>
                    </a>

                    <div style="margin-bottom:12px">
                        <b>Do you intend to send money to multiple persons from a single account? <br />
                        <span style="color:#888">Enter their email addresses, one on each line:</span></b>
                    </div>
                    
                    <div style="font-size:15px;margin-bottom:-12px">Accepted numbering formats are: 1. , 1) or 1.)</div>
                    <form method = "post" action = "/bulk-transfer">
                        <textarea name="referred_accounts" class="index_textarea" placeholder="Eligible Accounts to Pay: \n  \n1.) abc@example.com \n2) def@example.com \n3. ghi@example.com \n4.) jkl@example.com \n5.) mno@example.com"></textarea>
                        <br /><button class="long-action-button" type = "submit">Disburse Funds <i class="fa fa-money"></i> </button><br /><br />
                    </form>
                </div>
            HTML;
       }

       public static function index_scripts(){
        echo <<<HTML

        <!-- Footer - index_scripts -->
        <script>
            function show_div(vari) {
                if (document.getElementById(vari).style.display == "none") {
                    document.getElementById(vari).style.display = "block";
                } else if (document.getElementById(vari).style.display == "block") {
                    document.getElementById(vari).style.display = "none";
                }
            }
                         
            const collection = document.getElementsByClassName("invalid");
                                 
            for (let i=0; i < collection.length; i++){
                //collection[i].style = "display:none";
                                            
                var innerHT = collection[i].innerHTML;
                            
                var newInnerHT = innerHT + "<span style='float:right;margin:4px 18px'><i class='fa fa-times' onclick='hide_invalid_div()'></i></span>";
                          
                collection[i].innerHTML = newInnerHT;
            }
                           
            function hide_invalid_div() {
                //const collection = document.getElementsByClassName("invalid");
                i = 0;
                for (i=0; i<collection.length; i++){
                    collection[i].style.display = "none";
                }  
            }

            //Implementing multi-line placeholder for textarea html documents
            var textAreas = document.getElementsByTagName('textarea');

            Array.prototype.forEach.call(textAreas, function(elem) {
                elem.placeholder = elem.placeholder.replace(/\\n/g, '\\n');
            });

            function show_bt_input_div(){
                document.getElementById("bt_input_div").style.display = block;
            }

            function close_bt_input_div(){
                document.getElementById("bt_input_div").style.display = none;
            }
        </script>
        HTML;
        }


        public static function footer($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $additional_scripts = ""){ 
            
            $index_scripts = Index_Segments::index_scripts();    

            echo <<<HTML
            <div class="footer">
                <div class="footer_fa_links"> <!-- social media links -->
                    <a href="https://youtube.com/@aguanittoken?si=2UPwkGxROq7WpLAO"><i class="fa fa-youtube-play"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61553828145828"><i class="fa fa-facebook"></i></a>
                    <a href="https://t.me/aguanit"><i class="fa fa-telegram"></i></a>
                    <a href="https://x.com/AguanitToken?t=VwVfUCIOP1xBa9KRrfPHkg&s=09"><i class="fa fa-twitter"></i></a>
                </div>
                         
                <div class="footer_copyright">
                    © 2025 $site_name Token.
                </div>
            </div>
            
            $index_scripts
            $additional_scripts
            <br /><br /><br />
        </body>
        </html>    
    HTML;
    }
}
?>