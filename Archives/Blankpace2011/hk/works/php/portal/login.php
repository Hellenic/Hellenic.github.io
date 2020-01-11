<?php
$loc = "<a href='index'>Index</a> > Login";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
		echo "<h1>Login</h1>";

		echo "<p>You are already logged in as ". $user .". ";
		echo "If you are not ". $user .", please <a href='logout'>log out</a> immediately! ";
		echo "Otherwise, click here to go to <a href='user'>user panel</a>.</p>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
		echo "<h1>Login</h1>";
		
		if (isset($_POST['submit'])) {
				mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
				mysql_select_db("BlankDB") or die("Unable to select the database");
				
				$username = trim(htmlentities($_POST['username']));
				$password = trim(htmlentities($_POST['password']));	
				$sql = "SELECT * FROM usr WHERE username='$username'";
				$result = mysql_query($sql) or die(mysql_error($sql));
				$rows = mysql_fetch_array($result);		 		
				
				if (empty($username) || empty($password)) {
						echo "<p>You must fill in both fields!</p>";
				}
				else {
						if ($username == $rows['username']) {
								if ($password == $rows['password']) {
										if ($sql) {
												session_start();
												header("Cache-control: private");
												$_SESSION['user'] = $_POST['username'];
												header("location: user");
										}
										else {
												echo "<p>Error occurred, please try again.</p>";
										}
								}
								else {
										echo "<p>Wrong password.</p>";
								}
						}
						else {
								echo "<p>Username not found.</p>";
						}
				}
				mysql_close();
		}
		else {
		?>
				<form action='login' method='post'>
				<table>
						<tr><td>Test username: </td><td>tester</td></tr>
						<tr><td>Test password: </td><td>testpass</td></tr>
						<tr><td><label for="name">Username</label></td><td><input id="name" type='text' name='username' size='50' maxlength='20' /></td></tr>
						<tr><td><label for="pass">Password</label></td><td><input id="pass" type='password' name='password' size='50' maxlength='20' /></td></tr>
						<tr><td><input type='submit' name='submit' value='Login' /></td><td>&nbsp;</td></tr>
						<tr><td><a href='register'>Register</a></td><td><a href='recover'>Forgot your password?</a></td></tr>
				</table>
				</form>		
<?php
		}
}
?>
