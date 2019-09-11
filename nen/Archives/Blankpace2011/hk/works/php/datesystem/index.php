<h1>Simple dating system</h1>

<strong>Add a message</strong>

<form action="add.php" method="post">
    <table class="dating">
        <tr><td id="wtd1"><label for="nickname">Nickname</label></td><td id="wtd2"><input id="nickname" type="text" size="40" name="nickname" maxlength="25" /></td></tr>
        <tr><td><label for="email">E-mail</label></td><td><input id="email" type="text" size="40" name="email" maxlength="60" /></td></tr>
        <tr><td><label>Type of company:</label></td>
                      <td><input type="checkbox" name="type[]" value="friend" />Friendship
                          <input type="checkbox" name="type[]" value="correspondence" />Correspondence
                          <input type="checkbox" name="type[]" value="adventure" />Adventure
                          <input type="checkbox" name="type[]" value="long-term" />Long-term</td></tr>
        <tr><td><label for="text">Text:</label></td><td><textarea id="text" name="text" cols="60" rows="6"></textarea></td></tr>
        <tr><td></td><td><input type="submit" value="Submit" /> <input type="reset" value="Reset" /></td></tr>
    </table> 
</form>

<strong>Messages</strong>

<?php		 					 					 					 					
		
		mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
		mysql_select_db("BlankDB") or die("Unable to select the database");
		
		$sql = "SELECT * FROM date ORDER BY ID DESC";
		$result = mysql_query($sql) or die(mysql_error($sql));
		
		while($rows = mysql_fetch_array($result)) {
?>
		
		<table class="dating">
		<tr><td class="td1">Number</td>
				<td class="td2"><?php echo $rows["ID"]; ?></td>
		</tr>
		<tr><td class="td1">Nickname</td>
				<td class="td2"><?php echo $rows["nick"]; ?></td>
		</tr>
		<tr><td class="td1">E-mail</td>
				<td class="td2"><?php echo $rows["email"]; ?></td>
		</tr>
		<tr><td class="td1">Type</td>
				<td class="td2"><?php echo $rows["type"]; ?></td>
		</tr>
		<tr><td class="td1">Text</td>
				<td class="td2"><?php echo $rows["text"]; ?></td>
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
