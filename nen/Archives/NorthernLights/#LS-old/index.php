<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="content-language" content="en" />
  <meta name="robots" content="all" />
  <meta name="author" content="Hannu Kärkkäinen" />
  <meta name="copyright" content="Hannu Kärkkäinen" />
  <meta name="description" content="Northern Lights - Final Fantasy XI Linkshell of Cerberus" />
  <meta name="keywords" content="northern lights, northern, lights, ffxi,
							final fantasy, linkshell, cerberus, mmorpg" />
  <link rel="stylesheet" type="text/css" href="design/layout.css" />
  <title>Northern Lights Linkshell</title>
  </head>

<body>

	<div id="header">
			 <a href="index.php"><img alt="Northern Lights banner" src="design/banner.jpg" width="728" height="90" /></a>
	</div>
	
	
		<div id="left">
		<table class="linkit">
		<tr><th>Menu</th></tr>
		<tr><td>Home</td></tr>
		<tr><td><a href="about.php">About</a></td></tr>
		<tr><td><a href="members.php">Members</a></td></tr>
		<tr><td><a href="forum/" target="_blank">Forums</a></td></tr>
		<tr><td><a href="rules.php">Rules</a></td></tr>
		</table>
		</div>
	
	
	<div id="main">
	<div id="mid">

		
		<br />
		
		<?php
		$p = $_GET['p'];
		if ( !empty($p) && file_exists('./news/' . $p . '.php') && stristr( $p, '.' ) == False ) 
		{
		   $file = './news/' . $p . '.php';
		}
		else
		{
		   $file = './news/current.php';
		}
		include $file;
		?>

	</div>
	</div>
	
	
	<div id="right">
	<br />
	</div>


	<div id="footer">
			&copy; <a href="mailto:hellenic@blankpace.net">Hellenic</a> - Logo by Zeroi
	</div>
	
</body>
</html>
