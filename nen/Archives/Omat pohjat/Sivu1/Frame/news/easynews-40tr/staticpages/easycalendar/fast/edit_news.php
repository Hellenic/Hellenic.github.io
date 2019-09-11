<?
  $id = $HTTP_GET_VARS['id']; $uid = $Stoitsov["ID"];
  if ($id=="") {
    $d = $HTTP_GET_VARS['day']; $m = $HTTP_GET_VARS['month']; $y = $HTTP_GET_VARS['year'];
    $pubs=0; $text = $title = "";
    $shour = $sminute = 0; $ehour = $eminute = 0;
    $headerstr = $language['addheader'];
    $buttonstr = $language['addbutton'];
    $pgtitle = $language['addeventtitle'];
	} else {
    $sql = "SELECT * FROM edp_calendar WHERE IID = $id";
    $result = mysql_query($sql) or Die (puError($language['ERROR'],$language['Invalid DataBase Query']."<br>.","<PRE>".$language['The query is'].":<br>$sql</PRE>"));
		$row = mysql_fetch_assoc($result);
    $pubs=$row["pub"];
    $headerstr = $language['editheader'];
    $buttonstr = $language['editbutton'];
    $pgtitle = $language['editeventtitle'];
    $title = stripslashes($row["title"]);
    $text = stripslashes($row["text"]);
    $m = $row["m"]; $d = $row["d"]; $y = $row["y"];
    $starttime = split(":", $row["start_time"]);
    $shour = $starttime[0]; $sminute = $starttime[1];
    if ($shour > 12) {$shour = ($shour - 12);$spm = true;}
    $endtime = split(":", $row["end_time"]);
    $ehour = $endtime[0]; $eminute = $endtime[1];
    if ($ehour > 12) {$ehour = ($ehour - 12); $epm = true;}
  }
  Calendar($useradmin, $m, $y, $d, $str, $str1,  $str2);
  $ResultHtml.= "
    <table ><tr>
    <td align=left valign=top width=40%>
    <table  border=0 cellspacing=7 cellpadding=0><span class='textblue'><b>".$headerstr."<br>".$Error."</b></span><br>
     <form action='".$EDP_SELF."&action=add_news&day=".$d."&month=".$m."&year=".$y."&id=".$id."' method='post' name='addedit'>
     <input type='hidden' name='uid' value='".$uid."'><input type='hidden' name='day' value='".$d."'>
			<tr>
        <td nowrap valign='top' align='right' nowrap><span class='textblue'><b>".$language["datetext"]."</b></span></td>
        <td>".monthDown1($m, $language["months"])."&nbsp;".dayDown1($d)."&nbsp;".yearDown1($y)."</td>
			</tr>
			<tr>
        <td nowrap valign='top' align='right' nowrap>
        <span class='textblue'><b>".$language["title"]."</b></span></td>
        <td><input type='text' name='title' size='29' value='".$title."' maxlength='50'></td>
			</tr>
			<tr>
        <td nowrap valign='top' align='right' nowrap>
        <span class='textblue'><b>".$language["text"]."</b></span></td>
        <td><textarea cols=22 rows=6 name='text'>".$text."</textarea></td>
			</tr>
			<tr>
        <td nowrap valign='top' align='right' nowrap><span class='textblue'><b>".$language["starttime"]."</b></span></td>
        <td>".hourDown1($shour, "start")."<b>:</b>".minDown1($sminute, "start").amPmDown1($spm, 'start')."</td>
			</tr>
			<tr>
        <td nowrap valign='top' align='right' nowrap><span class='textblue'><b>".$language["endtime"]."</b></span></td>
        <td>".hourDown1($ehour, "end")."<b>:</b>".minDown1($eminute, "end").amPmDown1($epm, "end")."</td>
			</tr>
			<tr>
        <td nowrap valign='top' align='right' nowrap><span class='textblue'><b>".$language['Public'].":</b></span></td>
        <td>
         <select name='pub'><option value='0' ".($pubs==0 ? "selected" : "")." >".$language['Public']."</option><option value='1' ".($pubs==1 ? "selected" : "")." >".$language['Private']."</option></select>&nbsp;
         <input type='submit' class='strong'  name='addedit' value='".$buttonstr."'>&nbsp;<input type='button' class='strong' value='".$language['cancel']."' onClick=\"javascript:self.top.location.href='".$EDP_SELF."&day=".$d."&month=".$m."&year=".$y."';\">
        </td>
        </tr>
      </td>
			</tr>
     </form>
     </table>
     </td>
     <td valign=top >
     ".$str1."
     </td>
     </tr></table><hr><br>
";
?>
