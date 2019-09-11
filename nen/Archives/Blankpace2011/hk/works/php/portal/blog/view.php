<?php
$loc = "<a href='../index'>Index</a> > Blog";

mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");
$sql = "SELECT * FROM blog ORDER BY postID DESC";
$result = mysql_query($sql) or die(mysql_error($sql));

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$usersql = "SELECT * FROM usr WHERE username='$user'";
		$userresult = mysql_query($usersql) or die(mysql_error($usersql));
		$userrows = mysql_fetch_array($userresult);
		
		echo "<span class='smalltext'>$loc |-----| Logged in: <a href='../user'>$user</a> - <a href='../logout'>Log out</a></span>";
		echo "<h1>Blog</h1>";
}
else {
		echo "<span class='smalltext'>$loc |-----| Hello guest, <a href='../login'>Login</a> or <a href='../register'>Register</a>.</span>";
		echo "<h1>Blog</h1>";
}
	
while($rows = mysql_fetch_array($result)) {
?>

<div class="blog">
		<div class="postdate">Posted on <?php echo $rows["postdate"]; ?></div>
		<div class="title"><?php echo $rows["title"]; ?></div>
		<div class="post"><?php echo $rows["post"]; ?></div>
		<div class="posttime">
				Posted by Hellenic @ <?php echo $rows["posttime"];
				if ($userrows[usrlvl] == 3) {
					echo " <a href='blog/edit&postID=$rows[postID]'>Edit</a> //"; 
					echo " <a href='blog/delete&postID=$rows[postID]'>Delete</a>";
				}
				?>
		</div>
</div>
<br /><hr />
<br />

<?php
}
mysql_close();
?>
