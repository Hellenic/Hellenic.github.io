<?
$title = $HTTP_POST_VARS['title']; $Error="";
if (strlen($title)<1) {$Error="&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>".$language['ERROR'].":</it> ".$language['noTitle']."</font>";}
if ($Error!=="") {$page="edit_news";} else {
  $title = addslashes($HTTP_POST_VARS['title']);
  $uid = $HTTP_POST_VARS['uid']; $pub = $HTTP_POST_VARS['pub'];
	$text = addslashes($HTTP_POST_VARS['text']);
	$month = $HTTP_POST_VARS['month'];
	$day = $HTTP_POST_VARS['day'];
	$year = $HTTP_POST_VARS['year'];
	$shour = $HTTP_POST_VARS['start_hour'];
	$sminute = $HTTP_POST_VARS['start_min'];
	$s_ampm = $HTTP_POST_VARS['start_am_pm'];
	$ehour = $HTTP_POST_VARS['end_hour'];
	$eminute = $HTTP_POST_VARS['end_min'];
	$e_ampm = $HTTP_POST_VARS['end_am_pm'];
	if ($s_ampm == 1) { $shour = $shour + 12; }
	if ($e_ampm == 1) { $ehour = $ehour + 12; }
  $starttime = "$shour:$sminute:00"; $endtime = "$ehour:$eminute:00";
  if ($id!=="") {
    $sql = "UPDATE edp_calendar SET uid=$uid, m=$month, d=$day, y=$year, start_time='$starttime', end_time='$endtime', title='$title', text='$text', pub='$pub' WHERE IID=$id";
	} else {
    $sql = "INSERT INTO edp_calendar  VALUES(null, '$uid', '$month', '$day', '$year', '$starttime', '$endtime', '$title', '$text', '$pub')";
	}
  mysql_query($sql) or Die (puError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$sql</PRE>"));
}
?>
