<?php

include_once("php/connection.php");

class Index_Segments{
    public static function header($site_name = SITE_NAME_SHORT, $site_url = SITE_URL){
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
            <link rel="stylesheet" href="/static/font-awesome-4.7.0/css/font-awesome.min.css"/>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong|Arimo|Prompt"/>
    
            <link rel="stylesheet" href="/static/themify-icons.css"/>
    
    
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">-->
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            
            <title>$site_name</title>

        </head>
        <body>
            <div class="headers">  
                <div style="margin:-16px 19px 0px 14px">
                    <a href="/" style="color:#2b8eeb"><h3 class="site_name">$site_name</h3></a>
                </div>
            
                <div class="menu-icon">
                    <label for = "menu-box"><i class="fa fa-bars"></i></label>
                </div> 
            </div> 
        
            <a name="#top"></a>

            <!-- Start of Trading View Widget -->
            <div class="trading-view">
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                        "symbols": [{
                                "description": "",
                                "proName": "COINBASE:BTCUSD"
                            },
                            {
                                "description": "",
                                "proName": "COINBASE:ETHUSD"
                            },
                            {
                                "description": "",
                                "proName": "COINBASE:USDTUSD"
                            },
                            {
                                "description": "",
                                "proName": "BITFINEX:XRPUSD"
                            },
                            {
                                "description": "",
                                "proName": "COINBASE:SHIBUSD"
                            },
                            {
                                "description": "",
                                "proName": "NASDAQ:AAPL"
                            },
                            {
                                "description": "",
                                "proName": "NASDAQ:TSLA"
                            },
                            {
                                "description": "",
                                "proName": "NASDAQ:AMZN"
                            },
                            {
                                "description": "",
                                "proName": "FX:EURUSD"
                            },
                            {
                                "description": "",
                                "proName": "FX:GBPUSD"
                            },
                            {
                                "description": "",
                                "proName": "OANDA:EURUSD"
                            }
                        ],
                        "showSymbolLogo": true,
                        "colorTheme": "dark",
                        "isTransparent": true,
                        "displayMode": "adaptive",
                        "locale": "en"
                    }
                </script>
            </div>
            <!-- End of TradingView Widget -->


            <!-- Video and Intro -->
            <div class="video-and-intro">       
                <!-- Video Starts -->         
                <video class="video" width="100%" height="700" autoplay playsinline muted loop>
                    <source src="/static/videos/bg-chc.mp4"  type="video/mp4"> 
                </video>
                <!-- Video ends -->
                
                <!-- intro starts -->
                <div class="intro">
                    <h2>Manage and Grow Funds using $site_name</h2>

                    <div class="text">
                    $site_name Investment development of the digital economy brings forth the newest financial instruments. We focus on investments in the most promising ones - the Digital market. Don't be left behind, get your share of profits!
                    </div>

                    <!-- intro-links starts -->           
                    <div class="intro-links" style="margin-top:24px">
                        <a href="/sign-up">Create Account</a> &nbsp; &nbsp;
                        <a href="/login">Login</a>
                    </div>
                    <!-- intro-links ends -->   
                </div>      
                <!-- intro ends --> 

                <!-- intro-links-big-screen starts -->           
                <div class="intro-links-big-screen">
                    <a href="/sign-up">Create Account</a> &nbsp; &nbsp;
                    <a href="/login">Login</a>
                </div>
                <!-- intro-links-big-screen ends --> 

                
                <!-- Start of Video Trading View Widget -->
                <div class="video-trading-view">
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                        {
                            "symbols": [{
                                    "description": "",
                                    "proName": "COINBASE:BTCUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "COINBASE:ETHUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "COINBASE:USDTUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "BITFINEX:XRPUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "COINBASE:SHIBUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "NASDAQ:AAPL"
                                },
                                {
                                    "description": "",
                                    "proName": "NASDAQ:TSLA"
                                },
                                {
                                    "description": "",
                                    "proName": "NASDAQ:AMZN"
                                },
                                {
                                    "description": "",
                                    "proName": "FX:EURUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "FX:GBPUSD"
                                },
                                {
                                    "description": "",
                                    "proName": "OANDA:EURUSD"
                                }
                            ],
                            "showSymbolLogo": true,
                            "colorTheme": "dark",
                            "isTransparent": true,
                            "displayMode": "adaptive",
                            "locale": "en"
                        }
                    </script>
                </div>
                <!-- End of Video TradingView Widget -->
            </div>
            <!-- Video and Intro ends-->

            <div class="menu-list-div">  
                <input type="checkbox" id="menu-box" class="menu-box"/>
                <ul class="menu-list">
                    
                    <li class="x"><label for="menu-box"><i class="fa fa-times"></i></label></li>
                    
                    <li><a href="/">Home</a></li>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/deposit">Invest</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/about-us">About us</a></li>
                    <li><a href="/faqs">Frequently Asked</a></li>
                </ul> 
            </div>  

            <!-- id ajax utilizes this for pop up notices on users' investments -->    
            <div id="invest"></div>



            <!-- Investment Plans and youtube -->
            <!-- Investment Plans -->
            <div class="investment_plans_and_youtube">
                <h1 style="font-family:Prompt">
                    INVESTMENT PLANS
                </h1>
                
                $site_name, experts in the digital economy brings forth the newest financial instruments. We focus on investments in the most promising ones - the Digital market. Dont be left behind, get your share of profits!
    
                <div class="investment_plans_parent">
                    <ul class="investment_plans">
                        <li class="plan_list_header">
                            Basic Plan
                            <div style="font-size:19px">2% Daily for 7 Days</div>   
                        </li>
                        <li class="plan_list_normal">Min Amount: $100</li>
                        <li class="plan_list_normal">Max Amount: $4,999</li>
                        <li class="plan_list_normal">Referal Bonus: 10%</li>
                        <li class="plan_list_normal">Instant Withdrawal</li>
                        <li class="plan_list_bottom"><a href="/sign-up" class="sign_up">Sign Up</a></li>
                    </ul>

                    <ul class="investment_plans">
                        <li class="plan_list_header">
                            Advanced Plan
                            <div style="font-size:19px">2.5% Daily for 7 Days</div>   
                        </li>
                        <li class="plan_list_normal">Min Amount: $5,000</li>
                        <li class="plan_list_normal">Max Amount: $9,999</li>
                        <li class="plan_list_normal">Referal Bonus: 10%</li>
                        <li class="plan_list_normal">Instant Withdrawal</li>
                        <li class="plan_list_bottom"><a href="/sign-up" class="sign_up">Sign Up</a></li>
                    </ul>
        
                    <ul class="investment_plans">
                        <li class="plan_list_header">
                            Premium Plan
                            <div style="font-size:19px">3% Daily for 7 Days</div>   
                        </li>
                        <li class="plan_list_normal">Min Amount: $10,000</li>
                        <li class="plan_list_normal">Max Amount: $19,999</li>
                        <li class="plan_list_normal">Referal Bonus: 10%</li>
                        <li class="plan_list_normal">Instant Withdrawal</li>
                        <li class="plan_list_bottom"><a href="/sign-up" class="sign_up">Sign Up</a></li>
                    </ul>
        
                    <ul class="investment_plans">
                        <li class="plan_list_header">
                            Ultimate Plan
                            <div style="font-size:19px">4% Daily for 7 Days</div>   
                        </li>
                        <li class="plan_list_normal">Min Amount: $20,000</li>
                        <li class="plan_list_normal">Max Amount: Unlimited</li>
                        <li class="plan_list_normal">Referal Bonus: 10%</li>
                        <li class="plan_list_normal">Instant Withdrawal</li>
                        <li class="plan_list_bottom"><a href="/sign-up" class="sign_up">Sign Up</a></li>
                    </ul>
                </div>
                <!-- Investment Plans Ends-->
            <!-- Investment Plans and Youtube Ends.. -->
            </div>

            <div class="about_us">
                <h1 style="color:#2b8eeb">
                    <span style="border-bottom: 1px solid #2b8eeb;padding-bottom:10px">About</span> $site_name
                </h1>

                <div style="margin-top:10px">
                    <h4>About $site_name</h4>
                    Hello. Welcome to $site_name. So glad you’re here.
                    $site_name is an investment company that deals on real estate management, crypto mining, stocks and bonds mining and other agricultural manufacturing. We empower lots of clients around the world, creating a less tasking but reliable stream of income ... Continue
                    
                    <h4>Our Mission</h4>
                    Our mission is to spread the benefits of cryptocurrency trade as wide as we can. We hope to make everyone a beneficiary of our in depth knowledge of cryptocurrency by standing in between to help our investor get the best out of it. You do not need any knowledge of how cryptocurrency works before you can start investing because we are here to trade for you. Relax and let your money work for you.
                    
                    <h4>Our Vision</h4>
                    We hope to through our services grant financial freedom to as much people as we can reach . Our journey has been fruitful so far and we are very optimistic that we will affect more lives positively through our relentless effort in improving our services.
                </div> 

                <div style="text-align:center;margin-top:10px">
                    A range of tools to analyze investments are also available, either at portfolio or holding level, including fund fact sheets, price performance and benchmarking charts for each individual holding and value as well as volatility and performance charts for each portfolio of assets.
                </div>


  
                <!-- Youtube Video goes here.. -->
                <h2 style="margin:8% 15px 26px 15px;text-align:center;font-weight:bold;font-size:26px">Presentation Video</h2>      
                
                    $site_name operates in the context of a legal $site_name company and in compliance with $site_name rules and regulations. All operations, hosting and data storage is done within $site_name.

                    <div style="text-align:center;margin:9% 0">
                        <a href="/" style="color:#fff" class="action_button"> Create Account </a>
                    </div>
                    
                    <center>
                    <div class="youtube-video"> 
                       <iframe width="90%" height="50%" style ="max-width:600px;max-height:400px;border-radius:21px" src="https://www.youtube.com/embed/gFLZoSJFoQo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="youtube-video"></iframe> 
                    </div>  
                    </center>
                <!-- Youtube Video ends here.. -->
            </div><!-- About us ends.. --> <br /><br />

            
            
            <div style="background-color:#FAF9F6;color:black">
            <!-- White Background starts.. -->
            <div class ="clients">
                <div class="clients_text">
                    <h3 class ="clients_text_top">
                        3 very simple steps to get started with $site_name
                    </h3>
        
                    <div class ="clients_text_bottom">
                        With over 49 K users, $site_name is the best platform to get started investing on cryptocurrency. It is the easiest platform for beginners to easily get into cryptocurrency.<br /><br />
                    </div>
                </div>
    
                <div class="three-steps-div"><!-- (Located in the right side) -->    
                    <div class="clear">
                        <div class="steps-img">
                            <img src="/static/images/3-steps-01.png"/>
                        </div>
                      
                        <div class="steps-text">
                            <h3>Create Account</h3>
                            Simply open a new account to get started
                        </div>
                    </div>
                    
                    <div class="clear" style="margin:45px 0px">
                        <div class="steps-img">
                            <img src="/static/images/3-steps-02.png"/>
                        </div>
                      
                        <div class="steps-text">
                            <h3>Make Deposit</h3>
                            Make deposit from any of our plans <br />that is convenient for you.
                        </div>
                    </div>
                    
                    <div class="clear">
                        <div class="steps-img">
                            <img src="/static/images/3-steps-03.png"/>
                        </div>
                      
                        <div class="steps-text">
                            <h3>Make Withdrawal</h3>
                            <div>Withdraw to your wallet at your convenient or <br /> reinvest to earn more.</div>
                        </div>
                    </div>
                </div>
            </div>
    
    
            <div class="counter">
                <div class="inner-counter">
                    <h3>72915</h3>
                    Active Users
                </div>
                
                <div class="inner-counter">
                    <h3>4643</h3>
                    Running Days
                </div>
                
                <div class="inner-counter">
                    <h3>72047150</h3>
                    Total Withdrawals
                </div>
                
                <div class="inner-counter">
                    <h3>65614049.44</h3>
                    Total Deposits
                </div>
            </div>
    
            </div><!-- White Background ends.. -->
        

        <div class ="clients">
            <img class ="clients_img" src="/static/images/illustration-1.png"/>

            <div class="clients_text">
                <h3 class ="clients_text_top">
                    Take advantage of proven solutions to achieve cryptocoin success
                </h3>
    
                <div class ="clients_text_bottom">
                    Our roots go back to 2007 - right around the beginning of the revolution that would become known today as Bitcoin. Following the boom of this industry, we quickly began to see some of the common issues that were present when people tried to become involved. We took this need into account along with our own personal ambition to develop an integrated platform that was able to both satisfy the needs of investors and meet their expectations with sufficient returns on their investments. Since then, we have maintained our focus as a company that looks towards the future and transforms the opportunities offered to our valued clients.
                    <br /><br />
                </div>

                               
                <div class="clear">    
                    <div class="illustration-font">
                        <i class="fa fa-briefcase"></i>
                    </div>
                  
                    <div class="illustration-text">
                        <h3>Manage your dashboard</h3>
                        <div>Deposit,transfer and withdraw bitcoin, <br />keep track of them in the one place.</div>
                    </div>
                </div>

                               
                <div class="clear">    
                    <div class="illustration-font">
                        <i class="fa fa-calendar"></i>
                    </div>

                    <div class="illustration-text">
                        <h3>Recurring buys</h3>
                        <div>Invest in digital currency slowly over time by scheduling investments daily, weekly, or monthly.</div>
                    </div>
                </div>
    
                <div class="clear">    
                    <div class="illustration-font">
                        <i class="fa fa-lock"></i>
                    </div>
                  
                    <div class="illustration-text">
                        <h3>Vault protection</h3>
                        <div>For added security, activate your 2FA as soon as you sign up.</div>
                    </div>
                </div>

            </div>
        </div>


        <div style="overflow-x:auto"><!-- .auto overflow style starts-->
        <div class="clients-new-parent"> <!-- parent div starts-->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-2.png"/>
            <div class="clients_text-new">
                <h3 class ="clients_text_top-new">
                    Why are so many people investing in cryptocurrencies like Bitcoin on $site_name?
                </h3>
    
                <div class ="clients_text_bottom-new">
                    We believe that decentralised cryptocurrencies like Bitcoin and Ethereum will revolutionise the way the world views and uses money. We are part of pioneering a new financial system being built in real time, and we believe that this new global system will accelerate humanity for generations to come. As early innovators in this industry, we feel it’s our duty to bring this knowledge and excitement to the world.
                    <br /><br />
                </div>
            </div>
        </div>


        <!-- Clients 2 -->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-3.png"/>
            <div class="clients_text-new">
                <h3 class ="clients_text_top-new">
                    $site_name offer Card to investors on VIP plan
                </h3>
    
                <div class ="clients_text_bottom-new">
                    The partnership aims to fill a gap in the traditional financial system that has left many without access to essential banking products. According to a 2017 survey by the FDIC, 25 percent of U.S. households are unbanked or underbanked, while global numbers have reached a staggering 1.7 billion, according to data released by the World Bank. Through BlockCard, $site_name investors can have a virtual card issued to them while a physical card is mailed to them. The card has a minimum of $1000 balance needed. It can be used at over 45 million merchants and ATMs – anywhere in the world where major credit cards are accepted.  
                    <br /><br />
                </div>
            </div>
        </div>

        <!-- Clients 3 -->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-4.png"/>
            <div class="clients_text-new">
    
                <div class ="clients_text_bottom-new">
                    Modern day agriculture won't be realistic without some of the most expensive machineries put in place for it. Agriculture is the future of industrial raw material and the world food supply. $site_name being a diversified and forward thinking investment company, has ventured into this sector of investment... Today, $site_name channels it's resources into it's various farms spread across the globe in order to generate daily profit for it's investors and secure the future of global food supply
                <br /><br />
                </div>
            </div>
        </div>


        <!-- Clients 4-->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-5.png"/>
            <div class="clients_text-new">
                <div class ="clients_text_bottom-new">
                    For many years we have been working conscientiously and with the most diverse technologies and means. We have constantly successfully completed our projects.
                    We believe that the full benefits and potential of cannabis as a medical therapy are within our reach only through supply chain transparency, an engaged and active network of cannabis users, and data that is consistently available and verifiable for medical surveys and for developing and establishing therapies and life-prolonging solutions and treatments on blockchain technology. Our vision is one in which cannabis medical research gets the support it needs and deserves.
                    <br /><br />
                </div>
            </div>
        </div>


        <!-- Clients 5-->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-6.png"/>
            <div class="clients_text-new">
                <div class ="clients_text_bottom-new">
                    Forex trading covers about 5trillion dollars daily by just the act of trading foreign currencies and precious assets. It comes with a lot of strategies . $site_name has successfully secured 0.04% of the daily forex revenue by effective use of Technical and fundamental Analysis, Fibonacci etC. This serves as a high way of generating a lot of revenue for investors.
                    <br /><br />
                </div>
            </div>
        </div>


        <!-- Clients 6-->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-7.png"/>
            <div class="clients_text-new">
                <div class ="clients_text_bottom-new">
                    Bitcoin mining is the process of creating new bitcoin by solving a computational puzzle. Bitcoin mining is necessary to maintain the ledger of transaction upon which bitcoin is based. Miners have become very sophisticated over the last few years... $site_name have through the years been part of the bitcoin mining sector. $site_name having a pool of professional crypto miners uses complex machinery to speed up mining process
                    <br /><br />
                </div>
            </div>
        </div>


        <!-- Clients 7-->
        <div class ="clients-new">
            <img class ="clients_img-new" src="/static/images/illustration-8.png"/>
            <div class="clients_text-new">
                <div class ="clients_text_bottom-new">
                    Real estate is a $217 trillion-dollar market making up almost 60% of all global wealth. It's the largest source of wealth, yet it is illiquid for 99% of the world today. In the past, you only had access to real estate if you were rich or had rich friends–meaning that most people weren't able to benefit from the passive income and capital appreciation it provides.. Today, $site_name cut out the expensive middle man and provide access for investors, by investing in shares of real estate using crypto currencies. 
                    <br /><br />
                </div>
            </div>
        </div>


        </div> <!-- parent div ends-->
        </div> <!-- .auto overflow ends-->



        <!-- Start of TV live Trading view -->
        <h2 style="text-align:center;margin-top:28px">Live Trade View</h2>

        <div class="trading-view-tv">
            <div id="tradingview_4eea6" style="height: 500px;"></div>

            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
                new TradingView.widget({
                    "autosize": true,
                    "symbol": "NASDAQ:AAPL",
                    "interval": "5",
                    "timezone": "Etc/UTC",
                    "theme": "dark",
                    "style": "1",
                    "locale": "en",
                    "toolbar_bg": "#f1f3f6",
                    "enable_publishing": false,
                    "allow_symbol_change": true,
                    "container_id": "tradingview_4eea6"
                });

            </script>
        </div>
        <!-- End of TV live Trading view -->



        <!-- Open Account -->
        <div class="flex-div" style="text-align:center">    
            <div style="width:100%">
                <h2>Open account for free and start trading!</h2>
                <div>
                    $site_name offers institutions and professionals <br /> the ability toinvest a variety of digital currencies like Bitcoin, <br />Ethereum, and more on a regulated U.S. based exchange.
                </div>
            </div>
            
            <div style="width:100%"><br />
                <a href="/" style="color:#fff" class="action_button"> Create Account Now</a>
            </div>
        </div>
        <!-- End of Open Account -->



        <!-- Google Translate divs -->    
        <div class="clear">
            <div id="google_translate_element" style="position:fixed;left:8px;bottom:36px;background-color:#01123c;border-radius:4px;padding:3px 6px;border:1px solid #fff"></div>
        </div>
        <!-- End of Google Translate divs -->

        


    
        <!-- //public static function footer(){} -->

        <!-- Footer -->

        <!--Move to top with this-->

        <div style="position:fixed;bottom:125px;right:42px;z-index:5;text-align:center;background-color:#2b8eeb;padding:6px 2px 6px 2px;border-radius:4px;line-height:7px;width:30px;">
            <a href="#top" style="font-size:18px;color:#fff">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>

        <div class="pre_footer">
            <div class="pre_footer_text_top" style="text-align:center">
    
                <span style="font-size:21px;font-weight:bold;text-align:center;color:#2b8eeb">$site_name</span> 
                <br /><br />

                <span>Our leadership team reflects our belief in strong governance, with diverse backgrounds, expertise and ways of thinking. Together, this group enables us to build a multidimensional Investment strategy.</span>
            </div>

            <div class="clear" style="width:100%">   
                <ul style="list-style-type:none;float:left;width:48%;padding-left:3px">
                <h4>USEFUL LINKS</h4>
                    <li>Home</li>
                    <li>About Us</li>
                    <li>Question Guide</li>
                    <li>Log in</li>
                    <li>Sign up</li>
                    <li>Contact us</li>
                </ul>

                <ul style="list-style-type:none;float:right;width:48%;padding-left:3px">
                <h4>GET IN TOUCH</h4>
                    <li>Borg Olivier Street, 1807 Sliema, Central Region, Malta</li>
                </ul>
            </div>
        </div>

        <div class="footer" style="background-color:#03010f">
            <div style="float:left;padding:10px 10px 10px 4%">
                &copy; 2022 $site_name. All rights reserved.
            </div>

            <div style="float:right;padding:10px 4% 10px 10px">
                Contact Us &nbsp; &nbsp; Terms & Conditions
            </div>
        </div>
    HTML;
    }
}

?>

<script>
function ajax_invest(){
    obj = new XMLHttpRequest;
    obj.onreadystatechange = function(){
        if(obj.readyState == 4){
            document.getElementById("invest").innerHTML = obj.responseText;
        }
    }

    obj.open("GET","/ajax_invest.php");
    obj.send(null);
    }  
    
    setTimeout(ajax_invest, 3000);
    setInterval(ajax_invest, 15000);
</script>

        <!-- Google Translate scripts -->

<script type="text/javascript">
    function googleTranslateElementInit() {
         new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.VERTICAL}, 'google_translate_element');
    }
</script>
        
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        
<!-- End of Google Translate scripts -->

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '6756ba3017b86e57bbfef5c8a3b39f9f3a38f4ae';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
<!--End of smartsupp Script-->

</body>
</html>