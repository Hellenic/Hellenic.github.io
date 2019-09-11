<?php
$loc = "<a href='?p=portal/index'>Index</a> > Blog > Write > Add";

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

	mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
	mysql_select_db("BlankDB") or die("Unable to select the database");
	
	$postdate = date("l, d. F Y");
	$posttime = date("H:i");
	$title = htmlentities($_POST['title']);
	$post = str_replace("\n", "<br />", $_POST['post']);
	$errors = '';
    
    if ($title == '') {
      $errors .= "Title is missing.\n"; }
    elseif (strlen($name) > 100) {
    	$errors .= "Name is too long. (100)\n";
    }
    if ($post == '') {
      $errors .= "Post is missing.\n"; }	 

		if ($errors !== '') {
      echo '<p>The following errors have occurred</p>';
      $errors = str_replace("\n", "<br>", $errors);
      echo "<p>$errors</p>";
      }
      else {
					$sql = "INSERT INTO blog(title, post, postdate, posttime) VALUES('$title', '$post', '$postdate', '$posttime')";
					$result = mysql_query($sql) or die(mysql_error($sql));
					if ($result) {
						echo "<p>Your post added succesfully!</p>";
					}
					else {
						echo "<p>Error occurred, please try again.</p>";
					}
      }

mysql_close();
?>

<p>
<strong><a href="?p=portal/blog">Read blog</a></strong>
</p>
