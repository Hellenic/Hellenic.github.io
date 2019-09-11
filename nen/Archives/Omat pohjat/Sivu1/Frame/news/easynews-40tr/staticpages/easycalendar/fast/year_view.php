<?
  $ArrowLv = ArrowLY($m, $y); $ArrowRv = ArrowRY($m, $y);
  $ResultHtml= "<form name='ToYear'>".yearDown1($y)."<input  type='button' class='strong' value='".$language['Go']."' onClick='javascript:submitYear()'></form>
   <table  border='0' cellspacing='0' cellpadding='0' align=center>
   <tr><td class=textblue valign=top align=center colspan=9><b>".$ArrowLv."&nbsp;".$y."&nbsp;".$ArrowRv."</b><br><br></td></tr>";
   for($jm=1; $jm < 13; $jm++) {
   Calendar($useradmin, $jm, $y, $d, $str, $str1, $str1);
   $strm[$jm]=$str;
   if($jm==1 or $jm==3 or $jm==5 or $jm==7 or $jm==9 or $jm==11) $ResultHtml.= "<tr>";
      $ResultHtml.= "
      <td valign='top' width='15'>".puTr(15,1)."</td>
      <td valign='top' align='center'  width='1%'>
       <table  cellpadding='0' cellspacing='0' border='0'>
       <tr><td valign='top'  class='textblue' align=center><a href=\"$EDP_SELF&month=".$jm."&year=".$y."\"><b>".$language['months'][$jm-1]."</b></a></td></tr>
       <tr><td class='blue' valign='bottom'>".$strm[$jm]."</td></tr>
       <tr><td align='center'><br /></td></tr>
       </table>
      </td>
      <td valign=top width='15'>".puTr(15,1)."</td>";
    if($jm==2 or $jm==4 or $jm==6 or $jm==8 or $jm==10 or $jm==12) $ResultHtml.= "</tr>";
  }
$ResultHtml.= "</table>";
?>
