<?php
	mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
	mysql_select_db("BlankDB") or die("Unable to select the database"); 

	$fname = $_GET['name'];
	
	$checksql = "SELECT * FROM downloads WHERE Filename='$fname'";
	$checkrow = mysql_query($checksql) or die(mysql_error($checksql));

	
	if (mysql_num_rows($checkrow) == 0)
	{
		$inssql = "INSERT INTO downloads(Filename, Count) VALUES('$fname', '1')";
		$insresult = mysql_query($inssql) or die(mysql_error($inssql));
		if ($insresult)
		{
				echo "<p>Downloading your file... $fname</p>";
				echo "<a href='javascript:history.go(-1)'>Go back</a>";
				start_download($fname);
		}
		else
		{
				echo "<p>Error occurred, please try again.</p>";
		}
	}
	else
	{
		$addsql = "UPDATE downloads SET Count=(Count+1) WHERE Filename='$fname'";
		$addresult = mysql_query($addsql) or die(mysql_error($addsql));
		if ($addresult)
		{
				echo "<p>Downloading your file... $fname</p>";
				echo "<a href='javascript:history.go(-1)'>Go back</a>";
				start_download($fname);
		}
		else 
		{
				echo "<p>Error occurred, please try again.</p>";
		}
	}

	function start_download($file)
	{
		if (file_exists($file))
		{
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		    exit;
		}
	}

mysql_close();
?>
