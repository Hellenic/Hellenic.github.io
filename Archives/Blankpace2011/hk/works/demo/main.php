<?php
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database"); 

$sql = "SELECT * FROM downloads WHERE Filename='Chelonia.zip'";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);
$demo = $rows['Count'];

$sql = "SELECT * FROM downloads WHERE Filename='Chelonia.avi'";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);
$video = $rows['Count'];

mysql_close();
?>

<h1>Demos</h1>

<div class="center">
	
	<img alt="Chelonia demo" src="chelonia.jpg" width=664"" height="250" />
	
	<p>
		Chelonia is a short demo I made to learn more about programming. Code is written on C++. 
		Graphics are rendered with <a href="http://www.ogre3d.org/">OGRE</a> and music is played with <a href="http://www.ambiera.com/irrklang/">irrKlang</a>.
	</p>
	<p>
		<a href="http://www.youtube.com/watch?v=fkjkpl1v8ks">Watch on YouTube</a><br />
		<a href="download.php?name=Chelonia.zip">Download demo</a> - Downloaded <?php echo $demo ?> times<br />
		<a href="download.php?name=Chelonia.avi">Download demo video</a>  - Downloaded <?php echo $video ?> times
	</p>
	
	<br />
	
</div>

<br />
<br />
<br />