<?php
$loc = "<a href='http://blankpace.net/test/php/?p=portal/index'>Index</a> > Blog > Delete";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='?p=portal/user'>$user</a> - <a href='?p=portal/logout'>Log out</a></span>";
		echo "<h1>Blog - delete</h1>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='?p=portal/login'>Login</a> or <a href='?p=portal/register'>Register</a>.</span>";
		echo "<h1>Blog - delete</h1>";
}

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
						print "<form action='?p=portal/blog/delete' method='post'>";
						print "Are you sure you want to delete this message? <br />";
						print "<input type='hidden' name='postID' value='$postID'>";
						print "<input type='submit' name='submit' value='Delete'></form>";
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
