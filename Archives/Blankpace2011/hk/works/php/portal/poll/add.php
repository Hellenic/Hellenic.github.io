<p><a href="?p=portal/index">Index</a> > Poll > Add</p>

<h1>Poll - add new</h1>

<?php
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
<strong><a href="?p=portal/poll">View poll</a></strong>
</p>
