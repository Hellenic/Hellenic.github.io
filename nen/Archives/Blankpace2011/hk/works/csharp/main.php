<?php
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database"); 

$sql = "SELECT * FROM downloads WHERE Filename='Alarmer.zip'";
$result = mysql_query($sql) or die(mysql_error($sql));

$rows = mysql_fetch_array($result);

mysql_close();
?>

<h1>C#</h1>
	<p>
	Little projects I've made with C#. Programs need at least .NET Framework installed.
	</p>
	
	<h2>Alarmer</h2>
	<p>
	Simple alarmer. Input the time and press start and the countdown will begin.
	When time reaches 0, alarm sound will play and the timer stops.
	</p>
	
	<p>
	<a href="download.php?name=Alarmer.zip">
	<img src="alarmer.jpg" alt="Alarmer" title="Alarmer screenshot" width="306" height="186" />
	</a>
	<br />
	Downloads: <?php echo $rows['Count'] ?>
	<br /><br />	
	<a href="download.php?name=Alarmer.zip">Download</a>
	</p>

<br />
<br />
<br />
			
			

