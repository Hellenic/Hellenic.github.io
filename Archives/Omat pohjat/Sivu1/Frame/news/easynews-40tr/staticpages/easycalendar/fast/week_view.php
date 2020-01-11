<?
// ********************************************************************
// ************************ Function Calendar
// ********************************************************************
function WeekViewF($useradmin1, $month, $year, $dday, $wweek, &$str, &$str1){
  global $language, $EDP_SELF, $Easy, $Stoitsov;
  $color="bgcolor=#ffffff"; $color1="bgcolor=#ffffff"; $color2="bgcolor=#eeeeee";
  $result = mysql_query("SELECT IID, uid, d, title, text, pub,  TIME_FORMAT(start_time, '%l:%i%p') AS stime, TIME_FORMAT(end_time, '%l:%i%p') AS etime, edp_puusers.ID, edp_puusers.puScreenName, edp_puusers.puMail FROM  edp_calendar LEFT JOIN edp_puusers ON (edp_calendar.uid=edp_puusers.ID) WHERE m = $month AND y = $year ORDER BY start_time, IID") or die(mysql_error());
  $str1="";
  $str = "<table  cellpadding='1' cellspacing='1' border='0'><tr><td class='days_header'>w#</td><td>".puTr(1,1)."</td>";
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
    $wkk=0; if($month!=1){
    for($i=1;$i < $month; $i++) {
    $wkk = $wkk + 31-((($i-(($i<8)?1:0))%2)+(($i==2)?((!($year%((!($year%100))?400:4)))?1:2):0));
    } }
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
    $d = date(j); $m = date(n); $y = date(Y); // if($dday=="") {$dday=$d;}
    $wkk=0;
    if($month!=1){
      for($i=1;$i < $month; $i++) {
       $wkk = $wkk + 31-((($i-(($i<8)?1:0))%2)+(($i==2)?((!($year%((!($year%100))?400:4)))?1:2):0));
    }}
    while($day <= $days ) {
     $week=intval(($wkk+$day)/7+0.5)+1;
     if($week==$wweek) {$str .="<tr>"; }
     for($i=0;$i < 7; $i++) {
       if($week==$wweek) {
        if($i==0) {$str.="<td class='week_cell' align=right valign=top  ><a href='$EDP_SELF&id=&page=weekview&day=".$day."&month=".$month."&year=".$year."&week=".$week."'>".($week<10 ? "&nbsp;".$week : $week)."</td><td>".puTr(1,1)."</a></td>"; }
        $titles = count($event[$day]["title"]);
        if ($titles!==0) {$bb="<b>"; $be="</b>";} else {$bb=""; $be="";  }
       }
       if($day > 0 && $day <= $days) {
        if($week==$wweek) {
         if (($day == $d) && ($month == $m) && ($year == $y)) {
            if ($useradmin1>0) {
               $str .= "<td class='today_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a><br><a href='$EDP_SELF&id=&page=edit_news&day=".$day."&month=".$month."&year=".$year."'><img src='images/bell.gif' alt=\"Add Event\" border='0' ></a></td>";
            } else {
               $str .= "<td class='today_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a></td>";
            }
         } else {
            if ($useradmin1>0) {
              $str .= "<td class='day_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a><br><a href='$EDP_SELF&id=&page=edit_news&day=".$day."&month=".$month."&year=".$year."'><img src='images/bell.gif'  alt=\"Add Event\"  border='0' ></td>";
            } else {
              $str .= "<td class='day_cell' valign='top'><a href='$EDP_SELF&id=&day=".$day."&month=".$month."&year=".$year."'>".$bb.$day.$be."</a></td>";
            }
         }
         if($event[$day]["title"][0]) {
           for($j=0; $j < $titles; $j++) {
               if($event[$day]["pub"][$j]==0 or $useradmin1==2 or $Stoitsov["ID"]==$event[$day]["uid"][$j]) { $show=true; } else  { $show=false; }
               if($useradmin1>0 && $Stoitsov["ID"]==$event[$day]["uid"][$j] or $useradmin1==2) { $showed=true; } else  { $showed=false; }
               if($show) {
                 if ($color==$color1) {$color=$color2; } else { $color=$color1; }
                   if($j==0) {
                     $str1.="<TR><TD class=textblue align=right valign=top width='1%' $color nowrap><b>".$day."-".$month."-".$year."</b></TD><TD class=text width='96%'  valign=top $color><b>".$event[$day]["title"][$j]."</b>".$event[$day]["text"][$j]."<br><span class=textblue>".$language['Posted by']." <a href='mailto:".$event[$day]["puMail"][$j]."'>".$event[$day]["puScreenName"][$j]."</a></span>".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$event[$day]["id"][$j] ."'> [<font color=#B13433>".$language['Edit']."</font>]</a><a href='#' onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$event[$day]["id"][$j]."&month=".$month."&year=".$year."','".$language['Are you sure, you want to delete the event?']."');\"> [<font color=#B13433>".$language['Delete']."</font>]</a>" : "")."</TD><TD class=text align=right valign=top width='1%' $color nowrap>".$event[$day]["timestr"][$j]."</TD><TR>";
                   } else {
                     $str1.="<TR><TD class=textblue align=right valign=top width='1%' $color nowrap> </TD><TD class=text width='96%'  valign=top $color><b>".$event[$day]["title"][$j]."</b>".$event[$day]["text"][$j]."<br><span class=textblue>".$language['Posted by']." <a href='mailto:".$event[$day]["puMail"][$j]."'>".$event[$day]["puScreenName"][$j]."</a>".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$event[$day]["id"][$j] ."'> [<font color=#B13433>".$language['Edit']."</font>]</a><a href='#' onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$event[$day]["id"][$j]."&month=".$month."&year=".$year."','".$language['Are you sure, you want to delete the event?']."');\"> [<font color=#B13433>".$language['Delete']."</font>]</a>" : "")."</TD><TD class=text align=right valign=top width='1%' $color nowrap>".$event[$day]["timestr"][$j]."</TD><TR>";
                   }
               }
           }
         }
         }
         $day++;
       } elseif($day == 0)  {
	   if($week==$wweek) {$str .= " <td class='empty_day_cell' valign='top'>&nbsp;</td>";}
          $weekpos--;
          if ($weekpos == 0) {$day++;}
         } else {
		 if($week==$wweek) {$str .= " <td class='empty_day_cell' valign='top'>&nbsp;</td>";}
       }
     } // for
     if($week==$wweek) {$str .= "</tr>";}
    } // while
    $str.= "</table>";
    if($str1!==""){
     $str1=" <div align=center class=textblue><b>".$language['Events for the week']."</b></div>
             <table  cellSpacing=1 cellPadding=3 width='100%' border=0><TBODY>
               <TR>
               <TD class=tablehl align=left width='1%'>&nbsp;".$language['Date']."&nbsp;</TD>
               <TD class=tablehl align=left width='1%'>&nbsp;".$language['Event Description']."&nbsp;</TD>
               <TD class=tablehl align=left width='1%'>&nbsp;".$language['Time']."&nbsp;</TD>
               </TR>
               ".$str1."
               <TR>
               <TD></TD>
               <TD><br></TD>
               <TD></TD>
               </TR>
            </TBODY></TABLE>";
   } else {$str1="<div align=center class=textblue><b>".$language['No events for the week']."</b></div>";}
}
  WeekViewF($useradmin, $m, $y, $d, $week, $strw, $strw1);
  $ArrowLv = ArrowL($m, $y, 1); $ArrowRv = ArrowR($m, $y, 1);
  Calendar($useradmin, $m, $y, $d, $str, $str1, $str2);
  $ResultHtml.= "
   <table  border='0' cellspacing='0' cellpadding='0'>
      <tr>
      <td valign=top align=left width=10>&nbsp;</td>
      <td valign=top align=left width=190>
       <table  cellpadding='0' cellspacing='0' border='0' align='left' >
       <tr><td  valign=bottom align=left></td><td valign=bottom  class=textblue align=center><b>".$language['Week #']."".$week." of ".$y."</b></td><td align=right></td></tr>
       <tr><td class='blue' valign=top colspan=30>".$strw."</td></tr>
       <tr><td valign=top colspan=3><br></td></tr>
       <tr><td  valign=bottom align=left>".$ArrowLv."</td><td valign=bottom  class=textblue align=center><b>".$language['months'][$m-1]."&nbsp;".$y."</b></td><td align=right>".$ArrowRv."</td></tr>
       <tr><td  class='blue'  valign=top colspan=3>".$str."</td></tr>
       <tr><td align='center' colspan=3><form name='monthYear'>
        ".monthDown1($m, $language['months']).yearDown1($y)."<input  type='button' class='strong'  value='".$language['Go']."' onClick='javascript:submitMonthYear()'></form></td></tr>
       <tr><td align='center' colspan=3><br></td></tr>
       <tr><td align='center' colspan=3>".$ResulViewDay."</td></tr>
       </table>
      </td>
      <td valign=top align=left width=1%>&nbsp;</td>
      <td valign=top align=left >".$strw1."</td>
      <td valign=top align=left width=1%>&nbsp;</td>
      </tr>
   </table>
   ";
?>
