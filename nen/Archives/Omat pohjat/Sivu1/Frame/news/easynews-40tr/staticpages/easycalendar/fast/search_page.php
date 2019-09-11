<?
  $search=puHackers($search);
  $table="edp_calendar";
  $color="bgcolor=#ffffff"; $color1="bgcolor=#ffffff"; $color2="bgcolor=#e4e4e4";
  if (!isset($From) or $From=="") {$From=0;}
  if (!isset($Order) or $Order=="") {$Order=0;}
  switch ($Order) { case 1  : $QryOrder="t1.y, t1.m, t1.d, t1.uid Desc"; break;
                    default : $QryOrder="t1.y, t1.m, t1.d, t1.uid Desc"; break; }
  $TotalNews=mysql_num_rows(puMyQuery("SELECT t1.IID, t1.uid, t1.y, t1.title, t1.text, t1.uid, t1.pub, t2.ID, t2.puScreenName FROM ".$table." as t1, edp_puusers as t2 WHERE t2.ID=t1.uid AND (t1.IID like '%$search%' OR t1.y like '%$search%' OR t1.m like '%$search%' OR t1.d like '%$search%' OR t1.title like '%$search%' OR t1.text like '%$search%'  OR t2.puScreenName like '%$search%') ORDER BY ".$QryOrder.";"));
  $Newss=puMyQuery("SELECT t1.IID, t1.uid, t1.m, t1.d, t1.y, t1.title, t1.text, t1.pub, TIME_FORMAT(t1.start_time, '%l:%i%p') AS stime, TIME_FORMAT(t1.end_time, '%l:%i%p') AS etime, t2.ID, t2.puScreenName FROM ".$table." as t1, edp_puusers as t2 WHERE t2.ID=t1.uid AND (t1.IID like '%$search%' OR t1.y like '%$search%' OR t1.m like '%$search%' OR t1.d like '%$search%' OR t1.title like '%$search%' OR t1.text like '%$search%'  OR t2.puScreenName like '%$search%') ORDER BY ".$QryOrder."    LIMIT $From, ".$Easy["head_per_page"].";");
  If ($TotalNews-$From-$Easy["head_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
  $str1="";
	while ($News=mysql_fetch_array($Newss)) {
   if($News["pub"]==0 or $useradmin==2 or $Stoitsov["ID"]==$News["uid"]) { $show=true; } else  { $show=false; }
   if($useradmin>0 && $Stoitsov["ID"]==$News["uid"] or $useradmin==2)   { $showed=true; } else  { $showed=false; }
   if($show) {
    if ($color==$color1) {$color=$color2; } else { $color=$color1; }
    if ($News["stime"] != $News["etime"]) {$timestr = strtolower($News["stime"]) . "&nbsp;<br>" . strtolower($News["etime"])."&nbsp;";} else {$timestr = "";}
    if(stripslashes($News["text"])!=="") {$stxt="<br>".stripslashes($News["text"]);} else {$stxt="";}
    $str1.="<TR>
               <TD class=textblue align=right valign=top width='1%' $color nowrap><b>".$News["d"]."-".$News["m"]."-".$News["y"]."</b></TD>
               <TD class=text width='96%'  valign=top $color><b>".stripslashes($News["title"])."</b>".$stxt."<br><span class=textblue>(Posted by ".$News["puScreenName"].")</span>
             ".($showed ? "<a href='$EDP_SELF&page=edit_news&id=".$News["IID"]."'> [<font color=red>Edit</font>]</a><a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$News["IID"]."&month=".$News["m"]."&year=".$News["y"]."','Are you sure, you want to delete the event?');\"> [<font color=red>Delete</font>]</a>" : "" )."
          </TD>
               <TD class=text align=right valign=top width='1%' $color nowrap>".$timestr."</TD>
            <TR>";
   }
  }
  if($str1!==""){
    $ResultHtml=" <div align=center class=textblue><b>".$language['SEARCH results in Calendar for']." '".str_replace("_"," ",str_replace("edp_","",$search))."'<b></div>
            <table  cellSpacing=1 cellPadding=3  border=0><TBODY>
              <TR>
              <TD class=tablehl align=left width='1%'>&nbsp;".$language['Date']."&nbsp;</TD>
              <TD class=tablehl align=left width='1%'>&nbsp;".$language['Event Description']."&nbsp;</TD>
              <TD class=tablehl align=left width='1%'>&nbsp;".$language['Time']."&nbsp;</TD>
              </TR>
              ".$str1."
              <TR><TD></TD><TD><br></TD><TD></TD></TR>
              </TBODY></TABLE>";
 } else {$ResultHtml="<div align=center class=textblue><b>".$language['No SEARCH results found in Calendar for']." '".str_replace("_"," ",str_replace("edp_","",$search))."'<b></div><hr>";}
  $ResultHtml.="<table  border='0' cellspacing='1' cellpadding='2'><tr>
   ".($From!=0 ? "<td><a href='$EDP_SELF&table=".$table."&page=".$page."&From=".($From-$Easy["head_per_page"])."&Order=".$Order."'><img src='images/prev.gif' width='89' height='14' alt='Jump backward' border='0'></a><br><br></td>" : "" )."
   ".($More ? "<td align=right><a href='$EDP_SELF&table=".$table."&page=".$page."&From=".($From+$Easy["head_per_page"])."&Order=".$Order."'><img src='images/next.gif' width='68' height='14' alt='Jump forward' border='0'></a><br><br></td>" : "" )."
	</tr></table>";
?>
