<p class="smalltext"><a href="index">Index</a> > Logout</p>

<h1>Goodbye, come again</h1>

<?php

	session_start();
	unset($_SESSION['user']);
	session_destroy();
	
	echo "<p>You are now logged out.</p>";
	echo "<p>To log back in click <a href='login'>here</a><br />";
	echo "or go back to the main <a href='http://blankpace.net/hk/works/php/main'>page</a>.</p>";

?>
