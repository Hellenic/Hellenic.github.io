<?php
$loc = "<a href='index'>Index</a> > Admin";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
		mysql_select_db("BlankDB") or die("Unable to select the database");
		
		$sql = "SELECT * FROM usr WHERE username='$user'";
		$result = mysql_query($sql) or die(mysql_error($sql));
		$rows = mysql_fetch_array($result);
		
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
		echo "<h1>Admin panel</h1>";
		
		if ($rows[usrlvl] == 3) {
				echo "<h2>Hello Administrator, " . $user . "!</h2>";
				echo "<h3>Information</h3>";
				echo "<table>";
				echo "<tr><td>Username:</td><td>$rows[username]</td></tr>";
				echo "<tr><td>Real name:</td><td>$rows[realname]</td></tr>";
				echo "<tr><td>Mail:</td><td>$rows[mail]</td></tr>";
				echo "<tr><td>Homepage:</td><td>$rows[homepage]</td></tr>";
				echo "<tr><td><a href='useredit'>Edit info</a></td><td><a href='logout'>Log out</a></td></tr></table>";
				
				echo "<br /><hr /><br />";
				
				//echo "<a href='poll'>Poll</a><br />";
				//echo "<a href='poll/add'>Poll - Add</a><br />";
				//echo "<a href='poll/edit'>Poll - Edit</a><br />";
				//echo "<a href='poll/delete'>Poll - Delete</a><br />";
				echo "<a href='blog/view'>Blog</a><br />";
				echo "<a href='blog/edit'>Blog - Edit</a><br />";
				echo "<a href='blog/write'>Blog - Write</a><br />";
				echo "<a href='blog/delete'>Blog - Delete</a><br />";
		}
		else {
				echo "You do not have administrator privileges<br />";
				echo "Click <a href='user'>here</a> to go back.";
		}
		mysql_close();
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
		echo "<h1>Admin panel</h1>";
		
		echo "<p>You are not logged in!<br />";
		echo "To log in click <a href='login'>here</a>.</p>";
}
?>
