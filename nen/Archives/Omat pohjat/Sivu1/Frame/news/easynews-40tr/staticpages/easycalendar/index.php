<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
        ******************************************** software.stoitsov.com  */
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$atopic=str_replace("_"," ",str_replace("edp_","",$FREET[$PageSection]));
$colorblue=$Easy[$PageSection];
// ********************************************************************
// Call theme function template output index
// ********************************************************************
include_once  "../../themes/".$ThemeName."/indexf.php";
// ********************************************************************
// ************************ Functions
// ********************************************************************
?>
<?
function yearDown($year){echo "<select name='year'>";$z = 3; for($i=1;$i < 8; $i++) {if ($z == 0) {echo "  <option value='" . ($year - $z) . "' selected>" . ($year - $z) . "</option>";} else {echo "  <option value='" . ($year - $z) . "'>" . ($year - $z) . "</option>";}$z--;}echo "</select>";}
function yearDown1($year){$ret="<select name='year'>";$z = 3; for($i=1;$i < 8; $i++) {if ($z == 0) {$ret.="  <option value='" . ($year - $z) . "' selected>" . ($year - $z) . "</option>";} else {$ret.="  <option value='" . ($year - $z) . "'>" . ($year - $z) . "</option>";}$z--;}$ret.="</select>";return $ret;}
function monthDown($month, $montharray){echo "<select name='month'>";for($i=0;$i < 12; $i++) {if ($i != ($month - 1)) {echo "  <option value='" . ($i + 1) . "'>$montharray[$i]</option>";} else {echo "  <option value='" . ($i + 1) . "' selected>$montharray[$i]</option>";}}echo "</select>";}
function monthDown1($month, $montharray){$ret="<select name='month'>";for($i=0;$i < 12; $i++) {if ($i != ($month - 1)) {$ret.= "  <option value='" . ($i + 1) . "'>$montharray[$i]</option>";} else {$ret.= "  <option value='" . ($i + 1) . "' selected>$montharray[$i]</option>";}}$ret.= "</select>";return $ret;}
function dayDown($day){echo "<select name='day'>";for($i=1;$i <= 31; $i++) {if ($i == $day) {echo "<option value='$i' selected>$i</option>";} else {echo "  <option value='$i'>$i</option>";}}echo "</select>";}
function dayDown1($day){$ret="<select  name='day'>";for($i=1;$i <= 31; $i++) {if ($i == $day) {$ret.="<option  value='$i' selected>$i</option>";} else {$ret.="  <option value='$i'>$i</option>";}}$ret.="</select>"; return $ret;}
function hourDown($hour, $namepre){echo "<select name='" . $namepre . "_hour'>";for($i=0;$i <= 12; $i++) {if ($i == $hour) {echo "  <option value='$i' selected>$i</option>";} else {echo "  <option value='$i'>$i</option>";}}echo "</select>";}
function hourDown1($hour, $namepre){$ret="<select name='" . $namepre . "_hour'>";for($i=0;$i <= 12; $i++) {if ($i == $hour) {$ret.="  <option value='$i' selected>$i</option>";} else {$ret.="  <option value='$i'>$i</option>";}}$ret.="</select>";return $ret;}
function minDown($min, $namepre){echo "<select name='" . $namepre . "_min'>";for($i=0;$i <= 55; $i+=5) {if ($i < 10) { $disp = "0" . $i; } else { $disp = $i; }if ($i == $min) {echo "  <option value='$i' selected>$disp</option>";} else {echo " <option value='$i'>$disp</option>";}}echo "</select>";}
function minDown1($min, $namepre){$ret="<select name='" . $namepre . "_min'>";for($i=0;$i <= 55; $i+=5) {if ($i < 10) { $disp = "0" . $i; } else { $disp = $i; }if ($i == $min) {$ret.="  <option value='$i' selected>$disp</option>";} else {$ret.=" <option value='$i'>$disp</option>";}}$ret.="</select>"; return $ret;}
function amPmDown($pm, $namepre){if ($pm) { $pm = " selected"; } else { $am = " selected"; }echo "<select name='" . $namepre . "_am_pm'>";echo "  <option value='0'$am>am</option>";echo "  <option value='1'$pm>pm</option>";echo "</select>";}
function amPmDown1($pm, $namepre){if ($pm) { $pm = " selected"; } else { $am = " selected"; }$ret="<select name='" . $namepre . "_am_pm'>";$ret.="  <option value='0'$am>am</option>";$ret.="  <option value='1'$pm>pm</option>";$ret.="</select>";return $ret;}
function ArrowL($m, $y, $d){Global  $EDP_SELF;$nextyear = ($m != 12) ? $y : $y + 1;$prevyear = ($m != 1) ? $y : $y - 1;$prevmonth = ($m == 1) ? 12 : $m - 1;$nextmonth = ($m == 12) ? 1 : $m + 1;$s = "<a href='$EDP_SELF&day=" . $d . "&month=" . $prevmonth . "&year=" . $prevyear . "'>";$s .= "<img src='images/leftArrow.gif' border='0'></a> ";return $s;}
function ArrowR($m, $y, $d){Global  $EDP_SELF;$nextyear = ($m != 12) ? $y : $y + 1;$prevyear = ($m != 1) ? $y : $y - 1;$prevmonth = ($m == 1) ? 12 : $m - 1;$nextmonth = ($m == 12) ? 1 : $m + 1;$s = "<a href='$EDP_SELF&day=" . $d . "&month=" . $nextmonth . "&year=" . $nextyear . "'>";$s .= "<img src='images/rightArrow.gif' border='0'></a>";return $s;}
function ArrowLY($m, $y){Global  $EDP_SELF;$nextyear = $y + 1;$prevyear = $y - 1;$s = "<a href='$EDP_SELF&page=yearview&month=" . $month . "&year=" . $prevyear . "'>";$s .= "<img src='images/leftArrow.gif' border='0'></a> ";return $s;}
function ArrowRY($m, $y){Global  $EDP_SELF;$nextyear = $y + 1;$prevyear = $y - 1;$s = "<a href='$EDP_SELF&page=yearview&month=" . $month . "&year=" . $nextyear . "'>";$s .= "<img src='images/rightArrow.gif' border='0'></a>";return $s;}
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><span style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></span></td></tr></table><br>";}
// function puHackers($Text) {$ret=strip_tags($Text); $ret=escapeshellcmd($ret); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret;}
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function puHeading($Heading,$BR=1) {$ret=""; $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret.""; }
function puMyQuery($Query) { Global $sql; $Res=mysql_query($Query) or Die (puError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$Query</PRE>If the problem persists, contact the system administrator."));return $Res; }
function puMyFetch($Query) {Global $sql; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$Query</PRE>If the problem persists, contact the system administrator.")); return $Res;}
function puRegistered($Who) {Global $Stoitsov; $ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"])$ret=1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1) $ret=2; return $ret;}
function puShowAuthor($ID) {Global $Easy,$sql; $Author=puMyFetch("SELECT puScreenName, puMail FROM edp_puusers WHERE ID=$ID LIMIT 1;"); if (!$Easy["Contact"]) { return "<i>".$Author["puScreenName"]."</i>"; } else {return "<a href='mailto:".$Author["puMail"]."'><i>".$Author["puScreenName"]."</i></a>";}}
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") { switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n"; break; case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break; case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break; case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break; case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break; case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break; case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break; case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
// ********************************************************************
// ************************ Function Calendar
// ********************************************************************
function Calendar($useradmin1, $month, $year, $dday, &$str, &$str1, &$str2){
  global $language, $EDP_SELF, $Easy, $Stoitsov;
  $color="bgcolor=#ffffff"; $color1="bgcolor=#ffffff"; $color2="bgcolor=#eeeeee";
  $result = mysql_query("SELECT IID, uid, d, title, text, pub,  TIME_FORMAT(start_time, '%l:%i%p') AS stime, TIME_FORMAT(end_time, '%l:%i%p') AS etime, edp_puusers.ID, edp_puusers.puScreenName, edp_puusers.puMail FROM  edp_calendar LEFT JOIN edp_puusers ON (edp_calendar.uid=edp_puusers.ID) WHERE m = $month AND y = $year ORDER BY start_time, IID") or die(mysql_error());
  $str = ""; $str1=""; $str2="";
  $str.= "<table  cellpadding='1' cellspacing='1' border='0'><tr><td class='days_header'>w#</td><td>".puTr(1,1)."</td>";
  foreach($language['abrvdays'] as $day) {$str.= "<td class='days_header'align=center>$day</td>";}
  $str.= "</tr>";
	while($row = mysql_fetch_assoc($result)) {
    $event[$row["d"]]["pub"][]          = $row["pub"];
    $event[$row["d"]]["puMail"][]       = $row["puMail"];
    $event[$row["d"]]["puScreenName"][] = $row["puScreenName"];
    $event[$row["d"]]["uid"][]          = $row["uid"];
    $event[$row["d"]]["id"][]           = $row["IID"];
    $event[$row["d"]]["title"][]        = stripslashes($row["title"]);
    if(stripslashes($row["text"])!=="") {$event[$row["d"]]["text"][]  = "<br>".stripslashes($row["text"]);} else {$event[$row["d"]]["text"][]  =""; }
    if ($row["stime"] != $row["etime"]) {$timestr = strtolower($row["stime"]) . "&nbsp;<br>" . strtolower($row["etime"])."&nbsp;";;} else {$timestr = "";}$event[$row["d"]]["timestr"][] = $timestr;}
    $days = 31-((($month-(($month<8)?1:0))%2)+(($month==2)?((!($year%((!($year%100))?400:4)))?1:2):0));
    $weekpos = date("w",mktime(0,0,0,$month,1,$year)); $day = ($weekpos == 0) ? 1 : 0;
    $d = date(j); $m = date(n); $y = date(Y);
    $wkk=0;
    if($month!=1){
      for($i=1;$i < $month; $i++) {
       $wkk = $wkk + 31-((($i-(($i<8)?1:0))%2)+(($i==2)?((!($year%((!($year%100))?400:4)))?1:2):0));
	}}
    while($day <= $days ) {
     $week=intval(($wkk+$day)/7+0.5)+1;
     $str .="<tr>";
     for($i=0;$i < 7; $i++) {
       $titles = count($event[$day]["title"]);
       if ($titles!==0) {$bb="<b>"; $be="</b>";} else {$bb=""; $be="";  }
       if($i==0) {$str.="<td class='week_cell' align=right valign=top  ><a href='$EDP_SELF&id=&page=weekview&day=".$day."&month=".$month."&year=".$year."&week=".$week."'>".($week<10 ? "&nbsp;".$week : $week)."</td><td>".puTr(1,1)."</a></td>"; }
       if($day > 0 && $day <= $days) {
         if (($day == $d) && ($month == $m) && ($year == $y)) {
            if ($useradmin1>0) {
               $str .= "<td class='today_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a><br><a href='$EDP_SELF&id=&page=edit_news&day=".$day."&month=".$month."&year=".$year."'><img src='images/bell.gif' alt=\"".$language['Add Event']."\" border='0' ></a></td>";
            } else {
               $str .= "<td class='today_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."<br><img src='images/bell.gif' alt=\"".$language['Add Event']."\" border='0' ></a></td>";
            }
         } else {
            if ($useradmin1>0) {
              $str .= "<td class='day_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a><br><a href='$EDP_SELF&id=&page=edit_news&day=".$day."&month=".$month."&year=".$year."'><img src='images/bell.gif'  alt=\"".$language['Add Event']."\"  border='0' ></td>";
            } else {
              $str .= "<td class='day_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."<br><img src='images/bell.gif' alt=\"".$language['Add Event']."\" border='0' ></a></td>";
            }
         }
         if($event[$day]["title"][0]) {
           for($j=0; $j < $titles; $j++) {
               if($event[$day]["pub"][$j]==0 or $useradmin1==2 or $Stoitsov["ID"]==$event[$day]["uid"][$j]) { $show=true; } else  { $show=false; }
               if($useradmin1>0 && $Stoitsov["ID"]==$event[$day]["uid"][$j] or $useradmin1==2) { $showed=true; } else  { $showed=false; }
               if($show) {
                 if ($color==$color1) {$color=$color2; } else { $color=$color1; }
                 if($dday==$day) {$str2.="<TR><TD class=text width='99%'  valign=top $color><b>".$event[$day]["title"][$j]."</b>".$event[$day]["text"][$j]."<br><span class=textblue>".$language['Postaed by']."<a href='mailto:".$event[$day]["puMail"][$j]."'>".$event[$day]["puScreenName"][$j]."</a></span>".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$event[$day]["id"][$j] ."'> [<font color=#B13433>".$language['Edit']."</font>]</a><a href='#' onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$event[$day]["id"][$j]."&month=".$month."&year=".$year."','".$language['Are you sure, you want to delete the event?']."');\"> [<font color=#B13433>".$language['Delete']."</font>]</a>" : "")."</TD><TD class=text align=right valign=top width='1%' $color nowrap>".$event[$day]["timestr"][$j]."</TD><TR>";}
                 if($j==0) {
                   $str1.="<TR><TD class=textblue align=right valign=top width='1%' $color nowrap><b>".$day."-".$month."-".$year."</b></TD><TD class=text width='96%'  valign=top $color><b>".$event[$day]["title"][$j]."</b>".$event[$day]["text"][$j]."<br><span class=textblue>".$language['Posted by']." <a href='mailto:".$event[$day]["puMail"][$j]."'>".$event[$day]["puScreenName"][$j]."</a></span>".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$event[$day]["id"][$j] ."'> [<font color=#B13433>".$language['Edit']."</font>]</a><a href='#' onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$event[$day]["id"][$j]."&month=".$month."&year=".$year."','".$language['Are you sure, you want to delete the event?']."');\"> [<font color=#B13433>".$language['Delete']."</font>]</a>" : "")."</TD><TD class=text align=right valign=top width='1%' $color nowrap>".$event[$day]["timestr"][$j]."</TD><TR>";
                 } else {
                     $str1.="<TR><TD class=textblue align=right valign=top width='1%' $color nowrap> </TD><TD class=text width='96%'  valign=top $color><b>".$event[$day]["title"][$j]."</b>".$event[$day]["text"][$j]."<br><span class=textblue>".$language['Posted by']." <a href='mailto:".$event[$day]["puMail"][$j]."'>".$event[$day]["puScreenName"][$j]."</a>".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$event[$day]["id"][$j] ."'> [<font color=#B13433>".$language['Edit']."</font>]</a><a href='#' onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$event[$day]["id"][$j]."&month=".$month."&year=".$year."','".$language['Are you sure, you want to delete the event?']."');\"> [<font color=#B13433>".$language['Delete']."</font>]</a>" : "")."</TD><TD class=text align=right valign=top width='1%' $color nowrap>".$event[$day]["timestr"][$j]."</TD><TR>";
                 }
               }
           }
         }
         $day++;
       } elseif($day == 0)  {
          $str .= " <td class='empty_day_cell' valign='top'>&nbsp;</td>";
          $weekpos--;
          if ($weekpos == 0) {$day++;}
         } else {
          $str .= " <td class='empty_day_cell' valign='top'>&nbsp;</td>";
       }
     } // for
     $str .= "</tr>";
    } // while
    $str.= "</table>";
    if($str2!==""){
     $str2=" <span align=center class=textblue><b>".$language['Events for']." ".$dday."-".$month."-".$year."</b></span>
             <table  cellSpacing=1 cellPadding=3 width='100%' border=0><TBODY>
               <TR><TD class=tablehl align=left width='99%'>&nbsp;".$language['Event Description']."&nbsp;</TD><TD class=tablehl align=left width='1%'>&nbsp;".$language['Time']."&nbsp;</TD></TR>
               ".$str2."
               <TR><TD><br></TD><TD></TD></TR>
            </TBODY></TABLE>";
   } else {$str2="<span align=center class=textblue><b>".$language['No events for']." ".$dday."-".$month."-".$year."</b></span>";}
    if($str1!==""){
     $str1=" <span align=center class=textblue><b>".$language['Events for the month']."</b></span>
             <table  cellSpacing=1 cellPadding=3 width='100%' border=0><TBODY>
               <TR><TD class=tablehl align=left width='1%'>&nbsp;".$language['Date']."&nbsp;</TD><TD class=tablehl align=left width='1%'>&nbsp;".$language['Event Description']."&nbsp;</TD><TD class=tablehl align=left width='1%'>&nbsp;".$language['Time']."&nbsp;</TD></TR>
               ".$str1."
               <TR><TD></TD><TD><br></TD><TD></TD></TR>
            </TBODY></TABLE>";
   } else {$str1="<span align=center class=textblue><b>".$language['No events for the month']."</b></span>";}
}
// ********************************************************************
// ************************ Actions
// ********************************************************************
  $LeftBlock="<span class=menuL><b>".strtoupper($atopic)." ".$language['MENU']."</b></span>";
  $action_log="$action=='edit_reg_user'  or $action=='reg_user'  or $action=='login' or $action=='logout' or $action=='add_user'  or action=='edit_user'";
  if($action_log) { include_once "../../admin/login.php";} $useradmin=puRegistered($Stoitsov);
  if ($action=="add_news" &&  $useradmin>0) {include_once "fast/add_news.php";}
// ********************************************************************
// **************   EasyCalendar Screen Creation
// ********************************************************************
// if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
// if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
// if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
if (isset($page) && $page=="search" )                     {include_once "fast/search_page.php";}
if (isset($page) && $page=="inspanidual" )                 {if(isset($read)) {$ResultHtml="";$News=puMyFetch("SELECT * FROM $table WHERE ID=$read;");$ResultHtml.=NewsOut($News,-500);$ResultHtml.="<a href='$EDP_SELF&table=".$table."&From=$From&Order=$Order&search=$search'><img src='images/back.gif' width='38' height='14' alt='Jump backward' border='0'></a></td>";}}
if (isset($page) && $page=="edit_news" && $useradmin>0)   {include_once "fast/edit_news.php";}
$month = $HTTP_GET_VARS['month']; $year = $HTTP_GET_VARS['year']; $week = $HTTP_GET_VARS['week'];
$m = (!$month) ? date("n") : $month; $y = (!$year) ? date("Y") : $year; $d = (!$day) ? date("j") : $day;
if ($action=="delete"   && $useradmin>0 ) {puMyQuery("DELETE FROM edp_calendar WHERE IID=$id;");}
if (isset($page) && $page=="day_view")                    {include_once "fast/day_view.php";}
if (isset($page) && $page=="yearview") {
// ********************************************************************
// Start: Year View Page
// ********************************************************************
include_once "fast/year_view.php";
} else if(isset($page) && $page=="weekview")  {
// ********************************************************************
// Start: Year View Page
// ********************************************************************
include_once "fast/week_view.php";
} else {
// ********************************************************************
// Start: Main Page
// ********************************************************************
  $ArrowLv = ArrowL($m, $y, 1); $ArrowRv = ArrowR($m, $y, 1);
  Calendar($useradmin, $m, $y, $d, $str, $str1, $str2);
  $ResulViewDay= $str2."<br>";
  $ResultHtml.= "
   <table >
      <tr>
      <td valign=top align=left width=10>&nbsp;</td>
      <td valign=top align=left width=200>
       <table  cellpadding='0' cellspacing='0' border='0' align='left' >
       <tr><td  valign=middle align=left >".$ArrowLv."</td><td valign=bottom  class=textblue align=center><b>".$language['months'][$m-1]."&nbsp;".$y."</b></td><td valign=middle align=right>".$ArrowRv."</td><br></tr>
       <tr><td class='blue' valign=top colspan=3>".$str."</td></tr>
       <tr><td align='center' colspan=3><form name='monthYear'>
        ".monthDown1($m, $language['months']).yearDown1($y)."<input  type='button' class='strong'  value='".$language['Go']."' onClick='javascript:submitMonthYear()'></form></td></tr>
       <tr><td align='center' colspan=3><br></td></tr>
       <tr><td align='center' colspan=3>".$ResulViewDay."</td></tr>
       </table>
      </td>
      <td valign=top align=left width=1%>&nbsp;</td>
      <td valign=top align=left >".$str1."</td>
      <td valign=top align=left width=1%>&nbsp;</td>
      </tr>
   </table>
   ";
}
// ********************************************************************
// ********************** BuildmenuL
// ********************************************************************
$Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>".$language['Users (Login)']."</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".ucwords($Stoitsov["puScreenName"])." ".$language['(Logout)']."</a>" );
if ($useradmin==2) {
  $Adminmenu="<br><span  class=menuL><b>".$language['Admin menu']."</b></span><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>".$language['Add User']."</a><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>".$language['Manage Users']."</a><br>
  <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easycalendar/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>".$language['Edit Page']."</a><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easycalendar/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>".$language['Site Config']."</a>";
} elseif ($useradmin<1) {
  $Adminmenu.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=register&do=reg_user' class=menuL>".$language['Please Register']."</a>";
}
$user=$Easy["user"];
if ($user == 1) {
$user=$language['Currently there is'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['User Online'];
} else {
$user=$language['Currently there are'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['Users Online'];
}
// <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='".$EDP_SELF."&page=day_view&month=".$m."&year=".$y."&day=".$d."' class=menuL>".$language['Day View']."</a><br>
$pumenuL="<br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='".$EDP_SELF."&month=".date("n")."&year=".date("Y")."' class=menuL>".$language['Today']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='".$EDP_SELF."&month=".$m."&year=".$y."' class=menuL>".$language['Month View']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='".$EDP_SELF."&page=yearview&month=".$m."&year=".$y."' class=menuL>".$language['Year View']."</a><br>
".puElement("form",$EDP_SELF,"SEARCH","GET")."<br>
<span class=menuL><b>".$language['Search in Calendar']."</b></span>
".puElement("text","search",$search,100).puElement("hidden","page","search").puElement("hidden","PageSection",$PageSection).puElement("submit",$language['Go']).puElement();
$pumenuLA.="<br><br><a href='http://myio.net/software/products/description.php?software=EasyCalendar' target=_stoitsov><img src='images/EasyCalendarLogo_big.gif' height='90' width='105'  alt='EasyCalendar!' border='0'></a><br><br> ";
$LeftBlock.=$pumenuL.$pumenuLA;
// pageconfig and site config
if (isset($page) && $page=="config" && $useradmin==2) { include_once "../../admin/config_page.php"; } // end: Config Page
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
// ********************************************************************
// ********************** Left Center Right Blocks
// ********************************************************************
// Center Blocks $ResultHtml
// dynamic $LeftBlock
$LeftBlockArray[0]=$LeftBlock;
$menuL="menuL"; $menuLlink="invert";
if($LeftBlockData[0]!==".php") {
for ($i=0; $i<count($LeftBlockData); $i++) {include "../../admin/Blocks/".$LeftBlockData[$i]; $LeftBlockArray[$i+1]=$Block; }
}
// dynamic $RightBlock
if(Count($TOC)>0) {$RightBlock="<span class=menuR><b>On this page</b></span><br>";
for ($t=1; $t<Count($TOC)+1; $t++) {$RightBlock.=$TOC[$t]."<BR>";} $RightBlockArray[0]=$RightBlock."<br>"; $j=0;} else {$j=-1;}
$menuL="menuR"; $menuLlink="menuR";
if($RightBlockData[0]!==".php") {
for ($i=0; $i<count($RightBlockData); $i++) {include "../../admin/Blocks/".$RightBlockData[$i]; $j++; $RightBlockArray[$j]=$Block;}}
// ********************************************************************
// Call theme template output index
// ********************************************************************
include_once  "../../themes/".$ThemeName."/index.php";
?>
