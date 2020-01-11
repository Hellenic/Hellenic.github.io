<?php
/* index.php
   news display system
   Tommi Kärkkäinen 2007
 */
?>

<html><head><title>Newssisysteemi niiq! xD</title></head>
<body>
<?php
function list_news()
{
	echo "<h1>Uutisia!</h1>";
	echo "<p><ul>\n";
	$fp = fopen("uutiset/index", "r");
	while ($line = fgets($fp))
	{
		$parts = explode("|", $line);
		echo "<li>".date("j.n.y H:i", $parts[0]).":<a href=\"?n=".$parts[0]."\">".$parts[1]."</a></li>\n";
	}
	fclose ($fp);
	echo "</ul></p>";
}

function display_news()
{
	$id = $_GET['n'];
	if(!is_int(intval($id)))
		return 0;
	if(!file_exists("uutiset/$id"))
		return 0;

	//get the title
	$title="";
	$fp = fopen("uutiset/index", "r");
	while ( $line = fgets($fp))
	{
		$parts = explode( "|", $line);
		if($parts[0] == $id)
		{
			$title = $parts[1];
			break;
		}
	}
	fclose($fp);
	if($title == "")
		return 0;

	echo "<h1>$title</h1>";
	$cont = file_get_contents("uutiset/$id");
	echo "<p>";
	$cont = str_replace("\r\n\r\n", "</p><p>", $cont);
	$cont = str_replace("\r\n", "<br>", $cont);
	$cont = str_replace("\n\n", "</p><p>", $cont);
	$cont = str_replace("\n", "<br>", $cont);
	echo $cont;
	echo "</p>";
	return 1;
}

$success = 0;
if(isset($_GET['n']))
{
	$success = display_news();
	if($success)
		die();
}

list_news();
	
?>

</body>
</html>
