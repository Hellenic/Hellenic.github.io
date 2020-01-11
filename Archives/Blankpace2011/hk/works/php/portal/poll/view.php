<p><a href="../index">Index</a> > Poll</p>

<h1>Poll</h1>

<?php
/*
		Table: poll
		
		pollid
		name
		q1txt
		q1
		q2txt
		q2
		q3txt
		q3
*/

// $percent = = round(($responses['total'] / $total) * 100);
/*
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");

$sql = "SELECT * FROM poll WHERE pollid=1";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);


			echo "<table>";
			echo "<tr><td>$rows[name]</td><td></td></tr>";
			echo "<tr><td>$rows[q1txt]</td><td>$rows[q1]</td></tr>";
			echo "<tr><td>$rows[q2txt]</td><td>$rows[q2]</td></tr>";
			echo "<tr><td>$rows[q3txt]</td><td>$rows[q3]</td></tr>";
			echo "</table>";

session_start();
if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$usersql = "SELECT * FROM usr WHERE username='$user'";
		$userresult = mysql_query($usersql) or die(mysql_error($usersql));
		$userrows = mysql_fetch_array($userresult);
			
			if ($userrows[usrlvl] == 3) {
					echo "<p><a href='poll/admin'>Admin page</a></p>";
			}
			
mysql_close();
*/
?>
<p>
[Insert poll here]
</p>

<br />
<br />

