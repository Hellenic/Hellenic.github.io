<?
  $search=puHackers($search);
  if(!isset($table)) $table="edp_pupublish";
  $ResultHtml=puHeading($language['Search in']." ".str_replace("_"," ",str_replace("edp_","",$table)),0)."<br><b>".$language['Search for']." ".str_replace("_"," ",str_replace("edp_","",$search))."</b><br><br>";
  if (!isset($From) or $From=="") {$From=0;}
  if (!isset($Order) or $Order=="") {$Order=0;}
  switch ($Order) { case 1  : $QryOrder="t1.puHeading Asc"; break;
                    default : $QryOrder="t1.puDate Desc, t1.ID Desc"; break; }
  $TotalNews=mysql_num_rows(puMyQuery("SELECT t1.ID, t1.puHeading, t1.puUserID, t1.puDate, t1.puTopic, t2.puScreenName FROM ".$table." as t1, edp_puusers as t2 WHERE t2.ID=t1.puUserID AND (t1.puHeading like '%$search%' OR t1.puBody like '%$search%' OR t1.puTopic like '%$search%'  OR t2.puScreenName like '%$search%') ORDER BY ".$QryOrder.";"));
  if ($TotalNews==0) $ResultHtml.="<p>".$language['No results found'].".</p>";
  $Newss=puMyQuery("SELECT t1.ID, t1.puHeading, t1.puUserID, t1.puDate, t1.puTopic, t2.puScreenName FROM ".$table." as t1, edp_puusers as t2 WHERE t2.ID=t1.puUserID AND (t1.puHeading like '%$search%' OR t1.puBody like '%$search%' OR t1.puTopic like '%$search%'  OR t2.puScreenName like '%$search%') ORDER BY ".$QryOrder." LIMIT $From, ".$Easy["head_per_page"].";");
  If ($TotalNews-$From-$Easy["head_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
	while ($News=mysql_fetch_array($Newss)) {
  $ResultHtml.="<a href='$EDP_SELF&table=".$table."&page=individual&fage=$page&read=".$News["ID"]."&From=$From&Order=$Order&search=$search'>
  <b>".$News["puHeading"]."</b></a><br><b>".$language['Topic'].":</b> ".str_replace("_"," ",str_replace("edp_","",$News["puTopic"]))."<b> ".$language['Author'].":</b> ".puShowAuthor($News["puUserID"])." <b> ".$language['Publish date'].": </b> ".$News["puDate"]."<br><br>\n\n";
  }
  $ResultHtml.="<table  border='0' cellspacing='1' cellpadding='2'><tr>
   ".($From!=0 ? "<td><a href='$EDP_SELF&table=".$table."&page=".$page."&From=".($From-$Easy["head_per_page"])."&Order=".$Order."'><img src='images/prev.gif' width='89' height='14' alt='".$language['Jump backward']."' border='0'></a></td>" : "" )."
   ".($More ? "<td align=right><a href='$EDP_SELF&table=".$table."&page=".$page."&From=".($From+$Easy["head_per_page"])."&Order=".$Order."'><img src='images/next.gif' width='68' height='14' alt='".$language['Jump forward']."' border='0'></a></td>" : "" )."
	</tr></table>";
?>
