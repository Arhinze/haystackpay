<?php
ini_set("display_errors", '1'); //for testing purposes..

include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");

class Index_Segments{
    public static function main_header($site_name = SITE_NAME_SHORT) {
        echo <<<HTML
            <div class="headers" style="display:flex;padding:6px 3px"> <!-- start of .headers --> 
                <div style="float:left;margin-top:-5px"><img src="/static/images/logo_rbg.png" class="site_name_logo"/></div>
                <div style="float:left;margin-top:-5px">
                    <h3 class="site_name"><a href="/">HAYSTACK<span style="color:#ff9100">PAY</span><!--$site_name--></a></h3>
                </div>
            
                <div class="menu-icon" style="position:fixed;right:15px;top:15px">
                    <label for = "menu-box">
                        <i class="fa fa-bars"></i>
                    </label>
                </div> 
            </div> <a name="#top"></a> <!-- end of .headers --> 
        HTML;
    }
    
    public static function header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $Hi_user = "", $title=SITE_NAME){
        
        $main_header = Index_Segments::main_header();
        $css_version = filemtime($_SERVER["DOCUMENT_ROOT"]."/static/style.css");

        if (isset($_GET["ref"])) {
            $ref = htmlentities($_GET["ref"]);

            if(isset($_COOKIE["ref"])){
                //delete existing referer cookie
                setcookie("ref", $ref, time()-(24*3600), "/");
            }

            //set new referer cookie:
            setcookie("ref", $ref, time()+(12*3600), "/");
        }

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
            $main_header
            <div class="menu-list-div">  
                <input type="checkbox" id="menu-box" class="menu-box"/>
                <ul class="menu-list">
                                
                    <li class="x"><label for="menu-box"><i class="fa fa-times"></i></label></li>
                    
                    <!--<li><a href="/about-us">About</a></li>-->
                    <li><a href="/login">Login</a></li>
                    <li><a href="/sign-up">Sign Up</a></li>
                    <li><a href="$site_url#bulk_tr">Bulk Transfer </a></li>
                    <!--<li><a href="/how-it-works">How it works</a></li>-->
                    <li><a href="https://wa.link/hgzcrj">Contact us</a></li>
                </ul> 
            </div> 
       HTML;
       }
                
        public static function body($site_name = SITE_NAME_SHORT, $site_url = SITE_URL){
            $site_name_uc = strtoupper($site_name);
            echo <<<HTML
                <div class="haystackpay_intro">
                    <video style="opacity:0.5" width="100%" height="auto" autoplay playsinline muted loop>
                        <source src="/static/videos/haystackpay_intro.mp4"  type="video/mp4"> 
                    </video>
                    <!--
                    <div class="site_images_div">
                        <img src="/static/images/logo_rbg.png" class="site_images"/>
                    </div> 
                    -->
                    
                    <br />
                    <h1>Get it done with <span style="color:#ff9100">ease</span>.</h1>
                    <div>Speak, Type or Snap to pay. Make a transfer to multiple people at once. Receive AI powered financial analysis of your spending habit - all in one app.</div>

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

                    <div style="margin:24px 0">
                        <div style="font-size:24px"><b>Speak</b>, <b>Type</b> or <b>Snap</b> to pay:</div>
                        <div style="display:flex;justify-content:space-between">
                            <div class="features_images_div">
                                <div class="features_images" onclick="show_div('start_speaking_div')"><img src="/static/images/speak.png"/></div>
                                <div class="features_images_bottom_text">listening. . .</div>
                            </div>
                            <div class="features_images_div">
                                <div class="features_images" onclick="show_div('start_typing_div')"><img src="/static/images/type.png"/></div>
                                <div class="features_images_bottom_text">tell me what to do. .</div>
                            </div>
                            <div class="features_images_div">
                                <div class="features_images" onclick="show_div('start_snapping_div')"><img src="/static/images/snap.png"/></div>
                                <div class="features_images_bottom_text">Take a picture of anyone's account details</div>
                            </div>
                        </div>
                    </div>

                    <!-- Speech -->
                    <div style="display:none;position:fixed;top:15%;left:10%;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:80%;width:70%;text-align:center" id="start_speaking_div">
                        <div style="text-align:left;margin:12px"><b onclick="show_div('start_speaking_div')"><i class="fa fa-times" style="color:#2b8eeb"></i></b></div>
                        <div class="features_images_div" style="width:100%;margin:25% 3%">
                            <label for="speak_button"><div class="features_images"><img src="/static/images/speak.png" style="width:60%;height:auto"/></div></label>
                            <div class="features_images_bottom_text">Tap the icon to speak</div>

                            <div><b id="transcript" style="font-size:12px"></b></div>
                            <button id="speak_button" style="display:none"></button>
                        </div>
                    </div>

                    <div id="proceed_after_speech"></div>

                    <!-- Typing -->
                    <div style="display:none;position:fixed;top:15%;left:10%;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:80%;width:70%;text-align:center" id="start_typing_div">
                        <div style="text-align:left;margin:12px"><b onclick="show_div('start_typing_div')"><i class="fa fa-times" style="color:#2b8eeb"></i></b></div>

                        <div style="margin-top:30px">
                            <input class="payment_input" id="ai_text_input" type="text" placeholder="try: 'send 3000 to bestie'"/>
                            <button class="payment_button" onclick="typing_output()"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                    
                    <div id="proceed_after_typing"></div>

                    <!-- Snap/Pictures -->
                    <div style="display:none;position:fixed;top:15%;left:10%;background-color:#fff;border-radius:6px;border:1px solid #2b8eeb;height:80%;width:70%;text-align:center" id="start_snapping_div">
                        <div style="text-align:left;margin:12px"><b onclick="show_div('start_snapping_div')"><i class="fa fa-times" style="color:#2b8eeb"></i></b></div>
                        <div class="features_images_div" style="width:100%;margin:25% 3%">
                            <label for="speak_button"><div class="features_images"><img src="/static/images/snap.png" style="width:60%;height:auto"/></div></label>
                            <div class="features_images_bottom_text">Take a picture of any account details to send money to that account.</div>

                            
                            <form method="post" action = "" enctype="multipart/form-data"> 
                                <label for="snap_button"><div style="width:80%" class="button" style="display:block"> <i class="fa fa-image"></i> Upload a picture/screenshot from your device containing account details.</div></label>

                                <input type="file" onchange="snapping_output()" style="display:none" id="snap_button"/>
                            </form>
                        </div>
                    </div>

                    <div style="margin:18px 0">
                        <div style="font-size:24px;"><b>Pay via email/phone Number</b></div>
                        <div style="font-size:15px">No need to ask for their account details, Once you have their email or phone number, you can make a transfer to them.</div>

                        <div style="background-color: #acd1f3ff;border-radius:9px;padding:9px 6px;margin-top:12px">
                            <div style="font-weight:bold"><span onclick="reveal_email_ps()" style="color:#000" id="rps_email_text">Email</span>/<span onclick="reveal_phone_ps()"  style="color:#888" id="rps_phone_text">Phone Number</span></div>
                            <div id="pay_via_email" style="display:block">
                                <input class="payment_input" placeholder="Enter an email address"/>
                                <button class="payment_button"><i class="fa fa-arrow-right"></i></button>
                            </div>
    
                            <div id="pay_via_phone" style="display:none">
                                <input class="payment_input" placeholder="Enter a phone Number"/>
                                <button class="payment_button"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="bulk_tr" style="margin:15px 0"><a id="bulk_tr" name="bulk_tr"></a><!-- start of .bulk_tr -->
                        <div style="margin-bottom:12px">
                            <b>Do you intend to send money to multiple persons from a single account? <br />
                            <span style="color:#888">Enter their Email addresse(s)/Phone Number(s), one on each line:</span></b>
                        </div>
                    
                        <div style="font-size:15px;margin-bottom:-12px">Accepted numbering formats are: 1. , 1) or 1.)</div>
                        <form method = "post" action = "/bulk-transfer">
                            <textarea name="referred_accounts" class="index_textarea" placeholder="Eligible Accounts to Pay: \n  \n1.) abc@example.com \n2) def@example.com \n3. ghi@example.com \n4.) jkl@example.com \n5.) mno@example.com" required></textarea>
                            <br /><button class="long-action-button" type = "submit">Disburse Funds <i class="fa fa-money"></i> </button><br /><br />
                        </form>
                    </div><!-- end of .bulk_tr -->
                </div>

                <div class="site_images_div">
                    <img src="/static/images/haystackpay_banner.png" class="site_images"/>
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

            function reveal_email_ps(){
                document.getElementById("pay_via_email").style.display = "block";
                document.getElementById("pay_via_phone").style.display = "none";
                document.getElementById("rps_email_text").style.color = "#000";
                document.getElementById("rps_phone_text").style.color = "#888";
            }

            function reveal_phone_ps(){
                document.getElementById("pay_via_email").style.display = "none";
                document.getElementById("pay_via_phone").style.display = "block";
                document.getElementById("rps_email_text").style.color = "#888";
                document.getElementById("rps_phone_text").style.color = "#000";
            }
                         
            const collection = document.getElementsByClassName("invalid");
                                 
            for (let i=0; i < collection.length; i++){
                //collection[i].style = "display:none";
                                            
                var innerHT = collection[i].innerHTML;
                            
                var newInnerHT = innerHT + "<span style='float:right;margin:4px 18px'><i class='fa fa-times' onclick='hide_invalid_div()'></i></span>";
                          
                collection[i].innerHTML = newInnerHT;
            }



            //AI speech to text:
            let recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = "en-US";
            recognition.continuous = false;
            
            document.getElementById("speak_button").onclick = () => recognition.start();
            
            recognition.onresult = function(event) {
                let text = event.results[0][0].transcript;
                document.getElementById("transcript").textContent = text;
            
                // Send recognized text to PHP
                /*fetch("ai.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: "message=" + encodeURIComponent(text)
                })
                .then(res => res.json())
                .then(data => {
                    console.log(res);
                    alert("AI Response: " + res);
                });*/

                obj = new XMLHttpRequest;
                obj.onreadystatechange = function(){
                    if(obj.readyState == 4){
                        if (document.getElementById("proceed_after_speech")){
                            document.getElementById("proceed_after_speech").innerHTML = obj.responseText;
                        }
                    }
                }         

                console.log(text);
                obj.open("GET","/ajax/ai.php?message="+text);
                obj.send(null);
            };


            //AI text understanding:
            function typing_output() {
                ai_text=document.getElementById("ai_text_input").value;
                obj = new XMLHttpRequest;
                obj.onreadystatechange = function(){
                    if(obj.readyState == 4){
                        if (document.getElementById("proceed_after_text")){
                            document.getElementById("proceed_after_text").innerHTML = obj.responseText;
                        }
                    }
                }         
    
                console.log("AI typing text: " + ai_text);
                obj.open("GET","/ajax/ai.php?message="+ai_text);
                obj.send(null);
            }

            //Snap(Image) understanding:
            function snapping_output(){
                ai_text="send 5000 to Francis";
                obj = new XMLHttpRequest;
                obj.onreadystatechange = function(){
                    if(obj.readyState == 4){
                        if (document.getElementById("proceed_after_text")){
                            document.getElementById("proceed_after_text").innerHTML = obj.responseText;
                        }
                    }
                }         
    
                console.log("AI typing text: " + ai_text);
                obj.open("GET","/ajax/ai.php?message="+ai_text);
                obj.send(null);
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
                document.getElementById("bt_input_div").style.display = "block";
            }
        
            function close_bt_input_div(){
                document.getElementById("bt_input_div").style.display = "none";
            }
    
            function calculate_total(){
                total_num = document.getElementById("total_number").value;
                amt_for_each = document.getElementById("amount_to_pay_each_person").value;
                total_amount = Number(total_num) * Number(amt_for_each);
    
                document.getElementById("total_to_transfer_text").innerHTML = "<div style='margin:12px 3px'>Total cost of transaction: <b><i class='fa fa-naira'></i>N "+total_amount.toString()+"</b></div>";

                obj = new XMLHttpRequest;
                obj.onreadystatechange = function(){
                    if(obj.readyState == 4){
                        if (document.getElementById("current_balance_text")){
                            document.getElementById("current_balance_text").innerHTML = obj.responseText;
                        }
                    }
                }
        
                obj.open("GET","/ajax/ajax_cb.php?total_="+total_amount);
                obj.send(null);

                //disable button and allow only when total_amount < current balance and amt_for_each > 100
                button_status = document.getElementById("proceed_to_pay_button");
                current_balance_text = document.getElementById("current_balance_text");
                if((Number((current_balance_text.innerHTML).replace("N", "")) >= total_amount) & (amt_for_each >= 10)) {
                    button_status.style="background-color:#333131";
                    button_status.disabled = false;
                } else {
                    button_status.style="background-color:#888";
                    button_status.disabled = true;
                }

                //turn current balance text green or red depending on if it's > or < than total_amount
                if(Number((current_balance_text.innerHTML).replace("N", "")) >= total_amount) {
                    current_balance_text.style="color:green";
                } else {
                    current_balance_text.style="color:red";
                }
            }

        </script>
        HTML;
        }


        public static function footer($site_name = SITE_NAME_SHORT, $site_url = SITE_URL, $additional_scripts = ""){ 
            
            $index_scripts = Index_Segments::index_scripts();    

            echo <<<HTML
            <div class="footer">
                <div class="footer_fa_links"> <!-- social media links -->
                    <a href="https://youtube.com/"><i class="fa fa-youtube-play"></i></a>
                    <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                    <a href="https://wa.link/hgzcrj" style="color:green"><i class="fa fa-whatsapp"></i></a>
                    <a href="https://t.me/"><i class="fa fa-telegram"></i></a>
                    <a href="https://x.com/arhinze"><i class="fa fa-twitter"></i></a>
                </div>
                         
                <div class="footer_copyright">
                    © 2025 $site_name
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