<?php
$loc = "<a href='http://blankpace.net/test/php/?p=portal/index'>Index</a> > Blog > Edit";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='?p=portal/user'>$user</a> - <a href='?p=portal/logout'>Log out</a></span>";
		echo "<h1>Blog - edit</h1>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='?p=portal/login'>Login</a> or <a href='?p=portal/register'>Register</a>.</span>";
		echo "<h1>Blog - edit</h1>";
}

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
}
else {
		session_start();
		if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$usersql = "SELECT * FROM usr WHERE username='$user'";
				$userresult = mysql_query($usersql) or die(mysql_error($usersql));
				$userrows = mysql_fetch_array($userresult);
		
				if ($userrows[usrlvl] == 3) {
						$postID = $_GET['postID'];
						$getpost = "SELECT * FROM blog WHERE postID = $postID";
						$getpost2 = mysql_query($getpost) or die(mysql_error($getpost));
						$rows = mysql_fetch_array($getpost2);
						$rows = str_replace("<br />", "\n", $rows);
						
						print "<form action='?p=portal/blog/edit' method='post'>";
						print "<input type='hidden' name='postID' value='$postID'>";
						print "Post title:<br /><input type='text' name='title' value='$rows[title]' size='50' readonly='readonly'><br />";
						print "Post:<br /><textarea name='thepost' cols='50' rows='10'>$rows[post]</textarea><br /><br />";
						print "<input type='submit' name='submit' value='Submit'></form>";
				} else {
						echo "You do not have administrator privileges<br />";
						echo "Click <a href='http://blankpace.net/test/php/?p=portal/user'>here</a> to go back.";
				}
		
		}
		else {
			echo "<p>You are not logged in!<br />";
			echo "To log in click <a href='http://blankpace.net/test/php/?p=portal/user'>here</a>.</p>";
		}
}
mysql_close();
?>

<p>
<strong><a href="?p=portal/blog">Read blog</a></strong>
</p>
