<?
function NewsOut($News,$short) {
 Global $Stoitsov, $FREED,  $FREET,$PageSection, $page, $Easy, $EDP_SELF, $table, $language, $newsa, $inewsa;
 $news_topic=$language['Topic'].": ".ucwords(str_replace("_"," ",str_replace("edp_","",$FREET["$PageSection"])));
 $news_head=$News["puHeading"]; $news_author=puShowAuthor($News["puUserID"]); $news_date=$News["puDate"]; $news_more="";
 if($short>=0) {
  $news_body=BBCode2HTML(substr($News["puBody"],0,$short));
  if(strlen($news_body)>=$short-1) { $news_body.=" ..."; $news_more=" <a href='$EDP_SELF&page=individual&table=".$News["puTopic"]."&read=".$News["ID"]."'><br>&laquo;Read More&raquo;</a>"; }
  } else { $news_body=BBCode2HTML($News["puBody"]);}
  $inewsa=$inewsa+1;
 if($page=="individual" & $inewsa>1) {$inewsa=1; }
 $news_all= "
 <table cellpadding='2' cellspacing='0'>
  <tr>
    <td align='left' valign='bottom' id='tdgray'><div id='h2odashed'><font  face='Verdana, Arial, Helvetica, sans-serif'  size='+1'>".$news_head."&nbsp;</font></div></td>
  </tr>
  <tr>
    <td  id='tdgray'><font face='Courier New, Courier, mono' size='3'>".$news_body."".$news_more."</font>
  </tr>
  <tr>
    <td align='center'><font color='#006699'  size='1' face='Verdana, Arial, Helvetica, sans-serif'>".$news_topic."&nbsp;&nbsp;by: ".$news_author."&nbsp;(".$news_date.")&nbsp;</font><br/ ><br/ ></td>
  </tr>
  ";
  if ((puRegistered($Stoitsov)==2 or $Stoitsov["ID"]==$News["puUserID"])) {
   $news_all.=  "<tr><td align=\"center\" > ";
   if($FREED[$PageSection]=="dynamicpages") {
     $news_all.=  "[<a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."&home=1'>".$language['Edit-Move-Add to Home']."</a> | <a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."&home=0'>".$language['Edit-Move']."</a> |  <a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$News["ID"]."','".$language['Are you sure, you want to delete?']."');\">".$language['Delete']."</a> ]";
   } else {
     if($page!="individual") {$news_all.=  "<br>[<a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."'>".$language['Edit-Move']."</a> | <a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$News["ID"]."','".$language['Are you sure, you want to remove from Home?']."');\">".$language['Remove from Home']."</a>]"; }
   }
   $news_all.="<br /></td></tr>";
  }
 $news_all.="</table><br />"; $newsa[$inewsa]=$news_all; return $news_all="";
}
?>
