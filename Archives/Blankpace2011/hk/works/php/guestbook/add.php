<h1>Guestbook - add</h1>

<?php
	mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
	mysql_select_db("BlankDB") or die("Unable to select the database");
	
	session_start();
	$date = date("d.m.Y H:i");
	$name = htmlentities($_POST['name']);
	$email = htmlentities($_POST['email']);
	$comment = str_replace("\n", "<br />", htmlentities($_POST['comment']));
	$code = htmlentities($_POST['captcha_code']);
	$errors = '';
 
    if ($name == '') {
      $errors .= "Name is missing.\n"; }
    elseif (strlen($name) > 40) {
    	$errors .= "Name is too long. (40)\n";
    }
    
    
    if (!empty($email)) {
    	 if (preg_match('/^[a-zA-Z0-9%\-_\.]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z\-]{2,6}$/', $email)==1) {
    	 		if (strlen($email) > 60) {
    	 		$errors .= "Email is too long. (60)\n"; }
    	 }
    	 else $errors .= "$email is not valid email!\n";
    }
    
    
    if ($comment == '') {
      $errors .= "Comment is missing.\n"; }	 
    elseif (strlen($comment) > 300) {
    	$errors .= "Comment is too long. (300)\n";
    }
		$linebr = explode("<br />", $comment);
		$lines = count($linebr);
		if ($lines > 15) {
			$errors .= "Comment max line number is 15.\n";
		}
		foreach ($linebr as $linelen) {
				$word = explode(" ", $linelen);
				foreach ($word as $words) {
				    if (strlen($words) > 51) {
				    		$errors .= "Comment has a too long word.\n";
				    }
		    }
    }
    
		if (!isset($_SESSION['captcha_code'])) {
    		$errors .= "Error loading captcha, please try again.\n";
    }
    elseif ($code == '') {
    		$errors .= "Security code is missing\n";
    } else {
        if(md5($code) !== $_SESSION['captcha_code']) {
            $errors .= "Security code was NOT correct.\n";
        }
    }

		if ($errors !== '') {
      echo '<p>The following errors have occurred</p>';
      $errors = str_replace("\n", "<br />", $errors);
      echo "<p>$errors</p>";
      }
      else {
					$sql = "INSERT INTO blankbook(name, email, comment, date) VALUES('$name', '$email', '$comment', '$date')";
					$result = mysql_query($sql) or die(mysql_error($sql));
					if ($result) {
						echo "<p>Your message added succesfully!</p>";
					}
					else {
						echo "<p>Error occurred, please try again.</p>";
					}
      }

mysql_close();
?>

	<script type="text/javascript">
			setTimeout("window.location='view'",3000);
	</script>

<p>
<strong><a href="view">Guestbook</a></strong>
</p>
