<?php
$loc = "<a href='index'>Index</a> > <a href='user'>User</a> > Recover"

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
}
?>

<h1>Recover password</h1>

<p>Lost your password?</p>

<p>Well that's just too bad.</p>
