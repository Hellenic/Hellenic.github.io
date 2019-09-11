<p><a href="?p=portal/index">Index</a> > Poll > Delete</p>

<h1>Poll - delete</h1>

<?php
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");

if(isset($_POST['submit'])) {
		$postID = $_POST['postID'];	
		$del = "DELETE FROM blog WHERE postID = $postID";
		mysql_query($del) or die(mysql_error($del));
		
		if ($del) {
			echo "<p>Your post deleted succesfully!</p>";
		}
		else {
			echo "<p>Error occurred, please try again.</p>";
		}
mysql_close;
}
else {
		$postID = $_GET['postID'];
		print "<form action='?p=portal/poll/delete' method='post'>";
		print "Are you sure you want to delete this message? <br />";
		print "<input type='hidden' name='postID' value='$postID'>";
		print "<input type='submit' name='submit' value='Delete'></form>";
mysql_close();
}

?>

<p>
<strong><a href="?p=portal/poll">View poll</a></strong>
</p>
