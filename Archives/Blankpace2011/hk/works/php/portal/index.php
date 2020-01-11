<?php
$loc = "Index >";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='user'>$user</a> - <a href='logout'>Log out</a></span>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='login'>Login</a> or <a href='register'>Register</a>.</span>";
}

?>

<h1>Portal</h1>

		<p>
				This is experimental portal thingy made with PHP.
		</p>
		
		<p>
				<a href="register">Register</a><br />
				<a href="login">Login</a><br />
				<a href="blog/view">Blog</a><br />
				<a href="user">Userpanel</a>
		</p>
