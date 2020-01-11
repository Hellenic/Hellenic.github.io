<?php
$loc = "<a href='index'>Index</a> > Register";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
		echo "<h1>Register</h1>";
		
		echo "<p>You are already logged in as ". $user .". ";
		echo "If you are not ". $user .", please <a href='logout'>log out</a> immediately! ";
		echo "Otherwise, click here to go to <a href='user'>user panel</a>.</p>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
		echo "<h1>Register</h1>";
		
		if (isset($_POST['submit'])) {
				mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
				mysql_select_db("BlankDB") or die("Unable to select the database");
				
				$username = trim(htmlentities($_POST['username']));
				$password = trim(htmlentities($_POST['password']));	
				$password2 = trim(htmlentities($_POST['password2']));
				$email = trim(htmlentities($_POST['email']));
				$errors = '';
				
				if (empty($username) || empty($password) || empty($password2) || empty($email))  {
						$errors .= "You must fill in all fields!<br>"; }
				
				$checkname = mysql_query("SELECT username FROM usr WHERE username='$username'");
				if (mysql_num_rows($checkname) !== 0) {
						$errors .= "Name \"$username\" is already in use, please select another.<br>"; }
				
				if ($password !== $password2) {
						$errors .= "Passwords didn't match, try again.<br>"; }
				
				if (preg_match('/^[a-zA-Z0-9%\-_\.]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z\-]{2,6}$/', $email) !== 1) {
						$errors .= "\"$email\" is not valid email!<br>"; }
				
				if ($errors !== '') {
						echo "<h3>Following errors occurred:</h3>";
						echo "<p>$errors</p>"; }
				else {
						mysql_query("INSERT INTO usr(username, password, mail) VALUES('$username', '$password', '$email')");
						echo "<p>Registeration succesfully complete!</p>";
				}
				
				mysql_close();
		}
		else {
?>
		
				<form action='register' method='post'>
				<table>
						<tr><td><label for="name">Username</label></td><td><input id="name" type='text' name='username' size='50' maxlength='20' readonly='readonly' /></td><td>Max. 20 characters</td></tr>
						<tr><td><label for="pass">Password</label></td><td><input id="pass" type='password' name='password' size='50' maxlength='20' readonly='readonly' /></td><td>Max. 20 characters</td></tr>
						<tr><td><label for="pass2">Password again</label></td><td><input id="pass2" type='password' name='password2' size='50' maxlength='20' readonly='readonly' /></td><td></td></tr>
						<tr><td><label for="email">Email</label></td><td><input id="email" type='text' name='email' size='50' maxlength='60' readonly='readonly' /></td><td>Max. 60 characters</td></tr>
						<tr><td><input type='submit' name='submit' value='Register' /></td><td><input type='reset' name='reset' value='Reset' /></td></tr>
						<tr><td>&nbsp;</td><td><b>This is test portal and registering is disabled</b>.</td></tr>
						<tr><td>&nbsp;</td><td>You can <a href="login">log in</a> by using test account</td></tr>
				</table>
				</form>

<?php
		}
}
?>
