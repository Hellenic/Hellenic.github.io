<h1>Guestbook</h1>

<p><strong>Write to guestbook</strong></p>

<form method="post" action="add">
			<table id="guestbook">
			<tr><td id="wtd1"><label for="name">Name</label></td>
					<td id="wtd2"><input id="name" name="name" type="text" size="50" maxlength="40" /></td>
			</tr>
			<tr><td><label for="email">E-mail (optional)</label></td>
					<td><input id="email" name="email" type="text" size="50" maxlength="60" /></td>
			</tr>
			<tr><td><label for="comment">Comment</label></td>
					<td><textarea id="comment" name="comment" cols="50" rows="5"></textarea></td>
			</tr>
			<tr><td></td><td><img alt="" src="captcha.php" width="150" height="70" /><span class="smalltext"> Code is case sensitive</span></td></tr>
			<tr><td><label for="code">Input code</label></td><td><input id="code" type="text" name="captcha_code" size="20" maxlength="5" /></td></tr>
			<tr><td>&nbsp;</td>
					<td><input type="submit" value="Submit" /> <input type="reset" value="Reset" /></td>
			</tr>
			</table>	
</form>
<p class="smalltext">
Comment max length is 300 chars. Max row length is 50 chars.<br />
Code is not allowed. No advertisement, thank you.<br />
</p>
<hr />


<p><strong>Read guestbook</strong></p>

<?php

mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database");

$sql = "SELECT * FROM blankbook ORDER BY ID DESC";
$result = mysql_query($sql) or die(mysql_error($sql));

while($rows = mysql_fetch_array($result)) {
?>

<table class="padding">
<tr><td class="td1">Name</td>
		<td class="td2"><?php echo $rows["name"]; ?></td>
</tr>
<tr><td class="td1">E-mail</td>
		<td class="td2"><?php echo $rows["email"]; ?></td>
</tr>
<tr><td class="td1">Comment</td>
		<td class="td2"><?php echo $rows["comment"]; ?></td>
</tr>
<tr><td class="td1">Date</td>
		<td class="td2"><?php echo $rows["date"]; ?></td>
</tr>
</table>
<br />

<?php
}
mysql_close();
?>
