<?
function NewsOut($News,$short) {
Global $Stoitsov, $FREED, $PageSection, $page, $Easy, $EDP_SELF, $table, $edp_relative_path, $language, $newsa, $inewsa;
$news_topic="<font color='gray'>".$language['Topic'].":</font><b><font color='#5b80b2'> ".str_replace("_"," ",str_replace("edp_","",$News["puTopic"]))."</font></b>";
$news_head=$News["puHeading"];
$news_author=puShowAuthor($News["puUserID"]);
$news_date=$News["puDate"];
$news_more="";
if($short>=0) {
 $news_body=BBCode2HTML(substr($News["puBody"],0,$short));
 if(strlen($news_body)>=$short-1) { $news_body.=" ..."; $news_more=" <a href='$EDP_SELF&page=individual&table=".$News["puTopic"]."&read=".$News["ID"]."'>".$language['Read More']." ...</a> "; }
} else {
 $news_body=BBCode2HTML($News["puBody"]);
}
$inewsa=$inewsa+1;
if($page=="individual" & $inewsa>1) {$inewsa=1; }
$news_all= "
<table width='100%' cellpadding='0' cellspacing='0'>
  <tr><td align='left' valign='bottom'  bgcolor='#E9FBEB'><h1>&nbsp;".$news_head."</h1></td></tr>
  <tr align='left'><td bgcolor='#FBFBFB'><br />".$news_body."</p><p>".$news_more."</p></ul></tr>
  <tr align='center'><td bgcolor='#E5FDBF' >
  <div class=\"edit\">".$news_topic."<font color='gray'>&nbsp;&nbsp;".$language['Contributed by'].":</font><b> ".$news_author."</b><font color='gray'>&nbsp;&nbsp;(".$news_date.")</font></dvi>
</td>
</tr>";
if ((puRegistered($Stoitsov)==2 or $Stoitsov["ID"]==$News["puUserID"])) {
 $news_all.=  "<tr><td align=\"center\"> ";
 if($FREED[$PageSection]=="dynamicpages") {
  $news_all.=  "[<a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."&home=1'>".$language['Edit-Move-Add to Home']."</a> | <a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."&home=0'>".$language['Edit-Move']."</a> |  <a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$News["ID"]."','".$language['Are you sure, you want to delete?']."');\">".$language['Delete']."</a> ]";
 } else {
  if($page!="individual") {$news_all.=  "<br>[<a href='$EDP_SELF&page=edit_news&id=".$News["ID"]."'>".$language['Edit-Move']."</a> | <a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete&id=".$News["ID"]."','".$language['Are you sure, you want to remove from Home?']."');\">".$language['Remove from Home']."</a>]"; }
 }
$news_all.="</td></tr>";
}
$news_all.="</table><br><br>";
$newsa[$inewsa]=$news_all;
return $news_all="";
}
?>
