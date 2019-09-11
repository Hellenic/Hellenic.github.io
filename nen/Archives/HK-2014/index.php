<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <meta name="application-name" content="HK" />
        <meta name="description" content="Homepage of Hannu Kärkkäinen" />
        <meta name="keywords" content="hannu, kärkkäinen, homepage, cv" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <base href="" />
        
        <title>HK</title>
        
        <!-- GOOGLE FONTS -->
        <!--
        <link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed:400,500' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Monoton' rel='stylesheet' type='text/css'>
        -->
        <link href='http://fonts.googleapis.com/css?family=Fondamento' rel='stylesheet' type='text/css' />

        <link rel="stylesheet" type="text/css" href="css/base.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/shadowbox.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/shadowbox.js"></script>
        <script type="text/javascript" src="js/page.js"></script>
        <script type="text/javascript" src="js/slider.js"></script>
        <script type="text/javascript" src="js/gallery.js"></script>
        <!--[if lt IE 9]> 
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-26552880-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
	</script>
    </head>
    <body>
        
        <div class="bg-container"></div>
        
        <?php
            require "components/sidebar.html";
        ?>
        <section class="main">
        <?php
            $page = htmlspecialchars($_GET["page"]);
            
            if ($page == "gallery") {
                include "components/gallery.html";
            }
            elseif ($page == "cv") {
                include "components/cv.html";
            }
            elseif ($page == "works") {
                include "components/works.html";
            }
            elseif ($page == "sitemap") {
                include "components/sitemap.html";
            }
            else {
                include "components/home.html";
            }
        ?>
        </section>
        
        <section class="slider bg border-left border-right border-top border-shadow">
            <article>
                
            </article>
        </section>
    
        <section class="gallery bg border-left border-top border-bottom border-shadow">
            <article>
            </article>
        </section>
        
        <div class="ajax-loader"><img src="img/ajax-loader.gif" alt="Loading..." title="Loading..." /></div>
        
    </body>
</html>
