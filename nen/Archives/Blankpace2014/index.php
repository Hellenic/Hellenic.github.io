<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <meta name="application-name" content="The Blankpace.net" />
        <meta name="description" content="The Blankpace.net" />
        <meta name="keywords" content="blankpace, hk, cardeon" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <base href="" />
        
        <title>The Blankpace.net</title>
        
        <!-- GOOGLE FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Fondamento' rel='stylesheet' type='text/css' />

        <link rel="stylesheet" type="text/css" href="css/base.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/index.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld" />
        <script type="text/javascript" src="js/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="js/base.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
        <!--[if lt IE 9]> 
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="//cdn.webglstats.com/stat.js" defer="defer" async="async"></script>
        
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
        <?php
            require "components/sidebar.html";
        
            require "components/content.html";
        ?>
    </body>
</html>
