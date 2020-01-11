<?php
$loc = "<a href='?p=portal/index'>Index</a> > Blog > Write";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='?p=portal/user'>$user</a> - <a href='?p=portal/logout'>Log out</a></span>";
		echo "<h1>Blog - write</h1>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='?p=portal/login'>Login</a> or <a href='?p=portal/register'>Register</a>.</span>";
		echo "<h1>Blog - write</h1>";
}
echo "<p><strong>Write to blog</strong></p>";

mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$usersql = "SELECT * FROM usr WHERE username='$user'";
		$userresult = mysql_query($usersql) or die(mysql_error($usersql));
		$userrows = mysql_fetch_array($userresult);

		if ($userrows[usrlvl] == 3) {
?>

<form method="post" action="?p=blog/add">
			<table class="blog">
			<tr><td class="wri1">Title</td>
					<td class="wri2"><input name="title" type="text" size="50" maxlength="100"/></td>
			</tr>
			<tr><td class="wri1">Post</td>
					<td class="wri2"><textarea name="post" cols="50" rows="10"></textarea></td>
			</tr>
			<tr><td class="wri1">&nbsp;</td>
					<td class="wri2"><input type="submit" value="Submit" /> <input type="reset" value="Reset" /></td>
			</tr>
			</table>
</form>

<?php

		} else {
				echo "You do not have administrator privileges<br />";
				echo "Click <a href='?p=portal/user'>here</a> to go back.";
		}

}
else {
	echo "<p>You are not logged in!<br />";
	echo "To log in click <a href='?p=portal/login'>here</a>.</p>";
}
?>
