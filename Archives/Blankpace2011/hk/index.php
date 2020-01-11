<<?php ?>?xml version="1.0" encoding="iso-8859-1"?<?php ?>>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="content-language" content="fi" />
  <meta name="robots" content="all" />
  <meta name="author" content="Hannu Kärkkäinen" />
  <meta name="copyright" content="Hannu Kärkkäinen" />
  <meta name="description" content="Personal homepage of Hannu Kärkkäinen" />
  <meta name="keywords" content="hannu kärkkäinen, blankpace, homepage, curriculum vitae, biography, gallery" /> 
	<link rel="stylesheet" type="text/css" href="design/tyyli.css" />
	<script src="design/general.js" type="text/javascript"></script>
  	<title>Homepage of Hannu K&auml;rkk&auml;inen</title>
	</head>
	
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
	
  <body>

		<div id="otsikko">
				 <a href="http://blankpace.net/hk/"><img alt="Homepage of Hannu Kärkkäinen" title="Homepage of Hannu Kärkkäinen Logo" src="design/header.jpg" width="760" height="120" /></a>
		</div>
		
		<div id="navbar">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="about">About</a></li>
				<li><a href="cv">CV</a></li>
				<li><a href="myworks">My works</a></li>
			</ul>
		</div>
		
		<div id="main">
				<!--<div id="ylakuva"><img alt="[ylareuna]" src="http://blankpace.net/hk/design/yla.gif" width="458" height="33" /></div>-->
				
			 	<div id="sisalto">
						<?php
						$p = $_GET['p'];
						if ( !empty($p) && file_exists('./' . $p . '.php') && stristr( $p, '.' ) == False ) 
						{
						   $file = './' . $p . '.php';
						}
						else
						{
						   $file = './main.php';
						}
						include $file;
						?>
				</div>

		</div>
		
		<div id="footer">
				<table><tr>
				<td id="foot-vas">
					&nbsp;
				</td>
				<td id="foot-kesk">
				<a href="sitemap">Sitemap</a> // <a href="http://blankpace.net/temp/">Temp</a> // <a href="links">Links</a>
				</td>
				<td id="foot-oik">
						<a href="http://jigsaw.w3.org/css-validator/check/referer">
						    <img src="design/vcss-blue.png" alt="Valid CSS!" height="31" width="88" />
						</a>
						<a href="http://validator.w3.org/check?uri=referer">
								<img src="design/valid-xhtml10-blue.png" alt="Valid XHTML 1.0 Transitional" height="31" width="88" />
						</a>
				</td>
				</tr></table>
		</div>

</body>
</html>
