<?php
$loc = "<a href='index'>Index</a> > <a href='user'>User</a> > Edit";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
		mysql_select_db("BlankDB") or die("Unable to select the database");
		
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
		echo "<h1>User control panel</h1>";
		
		if(isset($_POST['update'])) {
				
				$realname = $_POST['realname'];
				$email = $_POST['email'];
				$homepage = $_POST['homepage'];
				mysql_query("UPDATE usr SET realname='$realname', mail='$email', homepage='$homepage' WHERE username='$user'") or die(mysql_error());
				
				echo "<h2>Your information updated!</h2>";
				echo "<h3>New info:</h3>";
				echo "<p>Real name: $realname <br />Email: $email <br />Homepage: $homepage </p>";
				echo "<p>Click <a href='user'>here</a> to go back.</p>";
				
		mysql_close;
		}
		else {
				$sql = "SELECT * FROM usr WHERE username='$user'";
				$getinfo = mysql_query($sql) or die(mysql_error($sql));
				$rows = mysql_fetch_array($getinfo);
				
				echo "<h2>$user</h2>";
				echo "<h3>Edit information</h3>";
				echo "<form action='useredit' method='post'>";
				echo "<table>";
				echo "<tr><td><label for='username'>Username:</label></td><td><input id='username' type='text' name='username' value='$rows[username]' readonly='readonly' /></td></tr>";
				echo "<tr><td><label for='realname'>Real name:</label></td><td><input id='realname' type='text' name='realname' value='$rows[realname]' maxlength='60' /></td></tr>";
				echo "<tr><td><label for='email'>Email:</label></td><td><input id='email' type='text' name='email' value='$rows[mail]'  maxlength='60'/></td></tr>";
				echo "<tr><td><label for='homepage'>Homepage:</label></td><td><input id='homepage' type='text' name='homepage' value='$rows[homepage]'  maxlength='100'/></td></tr>";
				echo "<tr><td><input type='submit' name='update' value='Update' /></td><td><input type='button' value='Cancel' onClick='history.back()' /></td></tr>";
				echo "</table></form>";
				
		mysql_close();
		}
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
		echo "<h1>User control panel</h1>";
}

?>
