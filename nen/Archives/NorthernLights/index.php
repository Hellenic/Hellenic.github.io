<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="content-language" content="fi" />
  <meta name="robots" content="all" />
  <meta name="author" content="Hannu Kärkkäinen" />
  <meta name="copyright" content="Hannu Kärkkäinen" />
  <meta name="description" content="Northern Lights - Final Fantasy XI Linkshell of Cerberus" />
  <meta name="keywords" content="northern lights linkshell, northern, lights, linkshell, gmt, ffxi,
							final fantasy, cerberus, mmorpg" />
	<link rel="shortcut icon" href="design/icon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="design/style.css" />
  <title>Northern Lights Linkshell</title>
</head>

<body>

		<div id="otsikko">
				 <a href="index.php"><img alt="header" title="Northern Lights" src="design/header.jpg" width="760" height="150" /></a>
		</div>
		
		<div id="navbar">
			<ul>
				<li><a href="?p=main">Home</a></li>
				<li><a href="?p=about">About</a></li>
				<li><a href="forum/" target="_blank">Forums</a></li>
				<li><a href="?p=rules">Rules</a></li>
				<li><a href="?p=links">Links</a></li>
			</ul>
		</div>
		
		<div id="main">
				<div id="ylakuva"><img alt="ylareuna" src="design/yla.gif" width="458" height="33" /></div>
				
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
		
				<div id="alakuva"><img alt="alareuna" src="design/ala.gif" width="458" height="33" /></div>
		</div>
		
		<div id="footer">
				<img id="alavas" alt="alareuna" src="design/alavas.jpg" width="32" height="47" />
				<img id="alaoik" alt="alareuna" src="design/alaoik.jpg" width="32" height="47" />
				&copy; Northern Lights Linkshell &copy; // <a href="../temp/">Temp</a>
		</div>

</body>
</html>
