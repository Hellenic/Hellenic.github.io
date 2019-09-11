<?php
mysql_connect("localhost", "Hellenic", "h3ll3n1c") or die("Unable to connect to database");
mysql_select_db("BlankDB") or die("Unable to select the database"); 

$sql = "SELECT * FROM downloads WHERE Filename='RaidGenerator-php.zip'";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);
$rgphp = $rows['Count'];

$sql = "SELECT * FROM downloads WHERE Filename='RaidGenerator-lua.zip'";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);
$rglua = $rows['Count'];

$sql = "SELECT * FROM downloads WHERE Filename='ProShaman.zip'";
$result = mysql_query($sql) or die(mysql_error($sql));
$rows = mysql_fetch_array($result);
$proshaman = $rows['Count'];

mysql_close();
?>

<h1>Misc</h1>

<h2>Raid group generator</h2>
<p>
	Generates raid groups (10 members) from JSON member list.
</p>
<p>
<a href="raidGen.php">Generator</a><br />
<a href="members.json">Member source</a><br />
<a href="download.php?name=RaidGenerator-php.zip">Download PHP version</a> Downloads: <?php echo $rgphp ?><br />
<a href="download.php?name=RaidGenerator-lua.zip">Download Lua WoW addon version</a> Downloads: <?php echo $rglua ?>
</p>

<h2>World of Warcraft Shaman addon</h2>
<p>
	Simplistic addon for Shamans that shows information about current shield and maelstrom weapon. 
	Also displays when you interrupt enemy spell, ground spell with Grounding Totem or Purge enemy buffs. 
	Notifies also if weapons buffs are missing when entering combat.<br />
	<a href="download.php?name=ProShaman.zip">Download addon</a> Downloads: <?php echo $proshaman ?>
</p>
<p>
	<img src="shot.jpg" alt="ProShaman picture" width="290" height="90" />
</p>


<br />
<br />
<br />