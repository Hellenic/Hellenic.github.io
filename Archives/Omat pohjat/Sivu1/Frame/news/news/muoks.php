<?php
/* muoks.php
   News modification system - the news adding thingy
   Tommi Kärkkäinen 2007
 */

function addnews()
{
	if(!isset($_POST['title']))
		die("Please, enter a title");
	if(strstr($_POST['title'], "|"))
		die("Illegal character in title (|)");
	if(strstr($_POST['title'], "\n"))
		die("Illegal characret in title (newline)");

	$time = time();

	//write the index entry
	$index = $time."|".$_POST['title']."\n".file_get_contents("uutiset/index");
	$fp = fopen("uutiset/index", "w");
	fwrite($fp, $index);
	fclose($fp);

	//write the news entry
	$fp = fopen("uutiset/$time", "w");
	fwrite($fp, $_POST['news']);
	fclose($fp);

	echo "done!";
}

session_start();

// the MD5 hash of the password
$passhash = md5("salakala");

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != 1 )
	if(!isset($_POST['password']) || md5($_POST['password']) != $passhash )
	{
	?>
		<html><head><title>Log in, please</title></head>
		<body>
		<h1>Please authenticate</h1>
		<form name="auth" method="POST">
		Password: <input name="password"> <input type="submit" name="s">
		</form>
		</body></html>
	<?php
		die();
	} else {
		$_SESSION['loggedin'] = 1;
	}

// user auth stuff has been taken care of, let's move on!

if(!isset($_GET['mode'])) $mode = "add";
else $mode = $_GET['mode'];

if($mode == "add")
	if(isset($_POST['news']))
		addnews();
	else {
	?>
		<html><head><title>Add news</title></head>
		<body>
		<h1>Add news</h1>
		<form method="POST" action="muoks.php">
		Title: <input name="title"><br>
		News body:<br>
		<textarea name="news">
		</textarea><br>
		<input type="submit" name="s">
		</form></body></html>
	<?php
	}
// that's it, as long as adding is the only desired action for this
?>
