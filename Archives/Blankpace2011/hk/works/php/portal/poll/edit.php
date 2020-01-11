<p><a href="?p=portal/index">Index</a> > Poll > Edit</p>

<h1>Poll - edit</h1>

<?php
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");

if(isset($_POST['submit'])) {
		$postID = $_POST['postID'];
		$thepost = $_POST['thepost'];
		$thepost = str_replace("\n", "<br />", $thepost);
		$edit = "UPDATE blog SET post='$thepost' WHERE postID = $postID";
		mysql_query($edit) or die(mysql_error($edit));
		
		if ($edit) {
			echo "<p>Your post updated succesfully!</p>";
		}
		else {
			echo "<p>Error occurred, please try again.</p>";
		}
mysql_close;
}
else {
		$postID = $_GET['postID'];
		$getpost = "SELECT * FROM blog WHERE postID = $postID";
		$getpost2 = mysql_query($getpost) or die(mysql_error($getpost));
		$rows = mysql_fetch_array($getpost2);
		$rows = str_replace("<br />", "\n", $rows);
		
		print "<form action='?p=portal/poll/edit' method='post'>";
		print "<input type='hidden' name='postID' value='$postID'>";
		print "Post title:<br /><input type='text' name='title' value='$rows[title]' size='50' readonly='readonly'><br />";
		print "Post:<br /><textarea name='thepost' cols='50' rows='10'>$rows[post]</textarea><br /><br />";
		print "<input type='submit' name='submit' value='Submit'></form>";
mysql_close();
}

?>

<p>
<strong><a href="?p=portal/poll">View poll</a></strong>
</p>
