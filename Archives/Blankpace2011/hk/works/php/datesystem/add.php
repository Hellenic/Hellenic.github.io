<?php
	mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
	mysql_select_db("BlankDB") or die("Unable to select the database");
	
	$date = date("d.m.Y H:i");
	$nick = trim(htmlentities($_POST['nickname']));
	$email = trim(htmlentities($_POST['email']));
	$type = $_POST['type'];
	$text = str_replace("\n", "<br />", htmlentities($_POST['text']));
	$errors = '';
 
    if ($nick == '') {
      $errors .= "Name is missing.\n"; }
    elseif (strlen($nick) > 25) {
    	$errors .= "Name is too long. (25)\n";
    }
    
    if ($email == '') {
    		$errors .= "Email is missing.\n";
    }
    else {
    		if (preg_match('/^[a-zA-Z0-9%\-_\.]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z\-]{2,6}$/', $email)==1) {
    			if (strlen($email) > 60) {
    			$errors .= "Email is too long. (60)\n"; }
    		}
    		else $errors .= "$email is not valid email!";
    }
    
    foreach ($type as $typename) {
    		$types .= $typename . ", ";
    }
    
    
    if ($text == '') {
      $errors .= "Text is missing.\n"; }	 

		if ($errors !== '') {
      echo '<p>The following errors have occurred</p>';
      $errors = str_replace("\n", "<br>", $errors);
      echo "<p>$errors</p>";
      }
      else {
					$sql = "INSERT INTO date(nick, email, type, text, date) VALUES('$nick', '$email', '$types', '$text', '$date')";
					$result = mysql_query($sql) or die(mysql_error($sql));
					if ($result) {
						echo "<p>Your message added succesfully!<br>";
						echo "<a href='index.php'>Go back</a></p>";
					}
					else {
						echo "<p>Error occurred, please try again.</p>";
						echo "<a href='index.php'>Go back</a>";
					}
      }

mysql_close();
?>
