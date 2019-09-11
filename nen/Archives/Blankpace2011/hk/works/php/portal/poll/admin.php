<p><a href="?p=portal/index">Index</a> > Poll > Admin</p>

<h1>Poll - admin</h1>

<?php
session_start();
if (isset($_SESSION['user'])) {
		mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
		mysql_select_db("BlankDB") or die("Unable to select the database"); 

		$user = $_SESSION['user'];
		$sql = "SELECT * FROM usr WHERE username='$user'";
		$result = mysql_query($sql) or die(mysql_error($sql));
		$rows = mysql_fetch_array($result);
			
		if ($rows[usrlvl] == 3) {
				echo "<a href='?p=portal/poll/add'>Add</a><br />";
				echo "<a href='?p=portal/poll/edit'>Edit</a><br />";
				echo "<a href='?p=portal/poll/delete'>Delete</a>";
		} else {
				echo "You are not admin";
		}
		mysql_close();
}
else {
		echo "<p>You are not logged in!<br />";
		echo "To log in click <a href='?p=portal/login'>here</a>.</p>";
}

?>

<p>
<strong><a href="?p=portal/poll">View poll</a></strong>
</p>
