<?php

				/* LOGIN */
	setCookie("username", "$username", time()+3600, "/", "", 0);
	setCookie("password", "$password", time()+3600, "/", "", 0);

				/* LOGGED IN */
	if (isset($_COOKIE['username'])) {
			echo "You are not logged in as " . $_COOKIE['name']; }

				/* LOGOUT */
	setCookie("username", "$username", time()-60, "/", "", 0);
	setCookie("password", "$password", time()-60, "/", "", 0);

?>
