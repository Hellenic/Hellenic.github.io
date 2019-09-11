<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
        ******************************************** software.stoitsov.com  */
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$atopic=str_replace("_"," ",str_replace("edp_","",$FREET[$PageSection]));
// ********************************************************************
// ************************ Functions
// ********************************************************************
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
// function puHackers($Text) {$ret=strip_tags($Text); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret;}
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function puHeading($Heading,$BR=1) {$ret=""; $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }
function puMyQuery($Query) { Global $sql, $language; $Res=mysql_query($Query) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'],"<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator']."."));return $Res; }
function puMyFetch($Query) {Global $sql, $language; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'],"<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res;}
function puRegistered($Who) {Global $Stoitsov; $ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"])$ret=1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1) $ret=2; return $ret;}
function puShowAuthor($ID) {Global $Easy,$sql; $Author=puMyFetch("SELECT puScreenName, puMail FROM edp_puusers WHERE ID=$ID LIMIT 1;"); if (!$Easy["Contact"]) { return "<i>".$Author["puScreenName"]."</i>"; } else {return "<a href='mailto:".$Author["puMail"]."'><i>".$Author["puScreenName"]."</i></a>";}}
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") { switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n"; break; case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break; case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break; case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break; case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break; case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break; case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break; case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
function BBCode2HTML($Text) {$Text=strip_tags($Text);$TextArray=split("\n",$Text);$Text="";foreach ($TextArray as $Line) {$patterns = array(); $replacements = array();$patterns[0]="#\[img\](.*?)\[/img\]#si"; $replacements[0]="<img src=\"\\1\" alt=\"\\1\"border=\"0\" align=left hspace=10 vspace=5>";$patterns[1]="#\[url\]([a-z]+?://){1}(.*?)\[/url\]#si"; $replacements[1]="<a href=\"http://\\2\" target=\"_blank\">\\2</a>";$patterns[2]="#\[url\](.*?)\[/url\]#si"; $replacements[2]="<a href=\"http://\\1\" target=\"_blank\">\\1</a>";$patterns[3]="#\[url=([a-z]+?://){1}(.*?)\](.*?)\[/url\]#si"; $replacements[3]="<a href=\"http://\\2\" target=\"_blank\">\\3</a>";$patterns[4]="#\[url=(.*?)\](.*?)\[/url\]#si"; $replacements[4]="<a href=\"http://\\1\" target=\"_blank\">\\2</a>";$patterns[5]="/\[color=(\#[0-9A-F]{6}|[a-z]+)\]/si"; $replacements[5]="<font color=\"\\1\">";$patterns[6]="#\[/color\]#si"; $replacements[6]="</font>";$patterns[7]="/\[size=([\-\+]?[1-2]?[0-9])\]/si"; $replacements[7]="<span style=\"font-size: \\1px; line-height: normal\">";$patterns[8]="#\[/size\]#si"; $replacements[8]="</span>";$Line = preg_replace($patterns, $replacements, $Line);$Line=str_replace("[ul","<ul",$Line);$Line=str_replace("[/ul","</ul",$Line);$Line=str_replace("[b","<b",$Line);$Line=str_replace("[/b","</b",$Line);$Line=str_replace("[i","<i",$Line);$Line=str_replace("[/i","</i",$Line);$Line=str_replace("[u","<u",$Line);$Line=str_replace("[/u","</u",$Line);$Line=str_replace("[p","<p class=news",$Line);$Line=str_replace("[/p","</p",$Line);$Line=str_replace("[h1","<br><span class=h2s",$Line);$Line=str_replace("[/h1]","</span><br>",$Line);$Line=str_replace("[h2","<br><span class=h3s",$Line);$Line=str_replace("[/h2]","</span><br>",$Line);$Line=str_replace("]",">",$Line);$Line=str_replace("'","`",$Line);$Text.=$Line;}return $Text;}
// ********************************************************************
// ************************ Actions
// ********************************************************************
$action_log="$action=='reg_user' or $action=='edit_reg_user'  or $action=='login' or $action=='logout' or $action=='add_user' or $action=='edit_user'";
if ($action_log)          {include_once "../../admin/login.php";} $useradmin=puRegistered($Stoitsov);
// if ($action=="edit_news") {if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else {if (isset($Preview)) { $page="edit_news"; } else { unset($Error);if (strlen(puHackers($puHeading))<1) $Error.="<b>".$language['Heading is invalid. Min 4 character'].".</b><br>";if (strlen($message)<4)   $Error.="<b>".$language['Body is invalid. Min 4 chars'].".</b><br>";if (strlen(puHackers($puDate))!=10)  $Error.="<b>".$language['Date is invalid. Date format: YYYY-MM-DD'].".</b><br>";if (isset($Error)) { $page="edit_news"; } else {$aaa=puMyFetch("SELECT puTopic FROM edp_pupublish WHERE ID=$id"); $oldTopic=$aaa["puTopic"];if($oldTopic==$newTopic){puMyQuery("UPDATE ".puHackers($newTopic)." SET puHeading='".puHackers($puHeading)."', puBody='".$message."', puDate='".puHackers($puDate)."', puUserID='".puHackers($puUserID)."', puTopic='".puHackers($newTopic)."' WHERE ID='".$puTopicID."'");} else {puMyQuery("DELETE FROM ".puHackers($oldTopic)." Where ID='$puTopicID'");puMyQuery("INSERT INTO ".puHackers($newTopic)." VALUES(null,'".puHackers($puHeading)."','".$message."','".puHackers($puDate)."','".puHackers($puUserID)."','".puHackers($newTopic)."');");$puTopicID=mysql_insert_id();}puMyQuery("UPDATE edp_pupublish SET puHeading='".puHackers($puHeading)."', puBody='".$message."', puDate='".puHackers($puDate)."', puUserID='".puHackers($puUserID)."', puTopic='".puHackers($newTopic)."', puTopicID='".puHackers($puTopicID)."' WHERE ID=$id;");} } } }
if ($action=="edit_news") {if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else {if (isset($Preview)) { $page="edit_news"; } else { unset($Error);if (strlen(puHackers($puHeading))<1) $Error.="<b>".$language['Heading is invalid. Min 4 character'].".</b><br>";if (strlen($message)<4)   $Error.="<b>".$language['Body is invalid. Min 4 chars'].".</b><br>";if (strlen(puHackers($puDate))!=10)  $Error.="<b>".$language['Date is invalid. Date format: YYYY-MM-DD'].".</b><br>";if (isset($Error)) { $page="edit_news"; } else {$aaa=puMyFetch("SELECT puTopic FROM edp_pupublish WHERE ID=$id"); $oldTopic=$aaa["puTopic"];if($oldTopic==$newTopic){puMyQuery("UPDATE ".puHackers($newTopic)." SET puHeading='".puHackers($puHeading)."', puBody='".puHackers($message)."', puDate='".puHackers($puDate)."', puUserID='".puHackers($puUserID)."', puTopic='".puHackers($newTopic)."' WHERE ID='".$puTopicID."'");} else {puMyQuery("DELETE FROM ".puHackers($oldTopic)." Where ID='$puTopicID'");puMyQuery("INSERT INTO ".puHackers($newTopic)." VALUES(null,'".puHackers($puHeading)."','".puHackers($message)."','".puHackers($puDate)."','".puHackers($puUserID)."','".puHackers($newTopic)."');");$puTopicID=mysql_insert_id();}puMyQuery("UPDATE edp_pupublish SET puHeading='".puHackers($puHeading)."', puBody='".puHackers($message)."', puDate='".puHackers($puDate)."', puUserID='".puHackers($puUserID)."', puTopic='".puHackers($newTopic)."', puTopicID='".puHackers($puTopicID)."' WHERE ID=$id;");} } } }
if ($action=="delete")    {if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else {puMyQuery("DELETE FROM edp_pupublish WHERE ID=$id;");} }
// ********************************************************************
// **************   EasyPublish Screen Creation
// ********************************************************************
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
// if (isset($page) && $page=="add_news" && $useradmin>0)    {include_once "fast/addnews_page.php";}
if (isset($page) && $page=="edit_news" && isset($id) && $useradmin>0) {include_once "fast/editnews_page.php";}

$LeftBlock="<span class=menuL><b>".strtoupper($atopic)." ".$language['MENU']."</b></span>";
// ********************************************************************
// Start: Main Page
// ********************************************************************
if (strlen($ResultHtml)==0  or $page=="config") {
  $ResultHtml="<b>".strtoupper($atopic)."</b><br><br>";
  if (!isset($From) or $From=="") {$From=0;}
  if (!isset($Order) or $Order=="") {$Order=0;}
	switch ($Order) {
		case 1	: $QryOrder="puHeading Asc"; break;
		default	: $QryOrder="puDate Desc, ID Desc"; break;
	}
   $TotalNews=mysql_num_rows(puMyQuery("SELECT ID FROM edp_pupublish;"));
   if($TotalNews==0) $ResultHtml.="<b>No active news</b>";
   $Newss=puMyQuery("SELECT * FROM edp_pupublish ORDER BY ".$QryOrder." LIMIT $From, ".$Easy["news_per_page"].";");
   If ($TotalNews-$From-$Easy["news_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
	$toc=0;
  while ($News=mysql_fetch_array($Newss)) { $toc++;
    $TOC[$toc]="<a href='$EDP_SELF&From=".$From."&Order=$Order#toc".$toc."' class=menuR>".$News["puHeading"]."</a>";
    $News["puTopic"]="edp_pupublish";
    $ResultHtml.="<a name='toc".$toc."'></a>".NewsOut($News,500);
  }
  $ResultHtml.="<table  border='0' cellspacing='1' cellpadding='2'><tr>
        ".($From!=0 ? "<td><a href='$EDP_SELF&From=".($From-$Easy["news_per_page"])."&Order=$Order'><img src='images/prev.gif' width='89' height='14' alt='".$language['Jump backward']."' border='0'></a></td>" : "" )."
        ".($More ? "<td align=right><a href='$EDP_SELF&From=".($From+$Easy["news_per_page"])."&Order=$Order'><img src='images/next.gif' width='68' height='14' alt='".$language['Jump forward']."' border='0'></a></td>" : "" )."
	</tr></table>";
}
// ********************************************************************
// Start Topics page
// ********************************************************************
if (isset($page) && $page=="topics" ) {
  $ResultHtml=puHeading($language['Available Topics'],2)."<UL>";
  $result = puMyQuery("SELECT  dpFREET, ID FROM edp_pconfig WHERE dpFREED='dynamicpages'");
  while(list($aaa,$aaasec) = mysql_fetch_array($result)) {
  $aaasec=$FREEIS[$aaasec];
  $aaalink=puHackers(str_replace("_"," ",str_replace("edp_","",$aaa)));
  $TotalNews=mysql_num_rows(puMyQuery("SELECT ID FROM $aaa;"));
  $ResultHtml.="<li><a href='"."../../dynamicpages/index.php?PageSection=".$aaasec."'><b>".$aaalink."</b> (".$language['Publications']." : ".$TotalNews.")</a></li>";
  }
  $ResultHtml.="</UL>";
}
// ********************************************************************
// Start Contents page
// ********************************************************************
if (isset($page) && $page=="contents" ) {
  $ResultHtml=puHeading($Easy["Articles"]." ".$language['Contents by Topics'],2);
  if (!isset($From) or $From=="" or $From<0) {$From=0;}
  if (!isset($Order) or $Order=="") {$Order=0;}
	switch ($Order) {
		case 1	: $QryOrder="puHeading Asc"; break;
		default	: $QryOrder="puDate Desc, ID Desc"; break;
	}
  $result = mysql_query("SELECT dpFREET FROM edp_pconfig WHERE dpFREED='dynamicpages'");
  while(list($aaa) = mysql_fetch_row($result)) {
  $TotalNews=mysql_num_rows(puMyQuery("SELECT ID FROM $aaa;"));
  if($TotalNews==0 && $From==0) { $ResultHtml.="<br><b>".$language['No active contents in topic'].": ".str_replace("_"," ",str_replace("edp_","",$aaa))."</b><br></b>"; }
  $Newss=puMyQuery("SELECT ID, puHeading, puUserID, puDate, puTopic FROM $aaa ORDER BY ".$QryOrder." LIMIT $From, ".$Easy["head_per_page"].";");
     $i=0;
     while ($News=mysql_fetch_array($Newss)) {
      if($i==0) { $ResultHtml.="<br><br><b>".$language['Contents in the topic'].": ".str_replace("_"," ",str_replace("edp_","",$News["puTopic"]))."</b> (".$language['out of']." ".$TotalNews." ".$language['Publications'].")<br><UL>"; $i++;}
      $ResultHtml.="<li><a href='$EDP_SELF&page=individual&table=".$News["puTopic"]."&read=".$News["ID"]."&From=$From&Order=$Order'><b>".$News["puHeading"]."</b></a><br>
      ".$language['Topic'].": ".str_replace("_"," ",str_replace("edp_","",$News["puTopic"]))." | ".$language['Author'].":  ".puShowAuthor($News["puUserID"])." | ".$language['Publish date'].": ".$News["puDate"]."\n\n</li>";
     }
  $ResultHtml.="</UL>";
  If ($TotalNews > $From && $From!==0)             { $Less=TRUE; } else { $Less=FALSE; }
  If ($TotalNews > $From+$Easy["head_per_page"]  ) { $More=TRUE; } else { $More=FALSE; }
  $ResultHtml.="<table  border='0' cellspacing='1' cellpadding='2'><tr>
        ".($Less     ? "<td align=left ><a href='$EDP_SELF&page=$page&From=".($From-$Easy["head_per_page"])."&Order=$Order'><img src='images/prev.gif' width='89' height='14' alt='".$language['Jump backward']."' border='0'></a></td>" : "" )."
        ".($More     ? "<td align=right><a href='$EDP_SELF&page=$page&From=".($From+$Easy["head_per_page"])."&Order=$Order'><img src='images/next.gif' width='68' height='14' alt='".$language['Jump forward']."' border='0'></a></td>" : "" )."</tr></table>";
  }
}
// ********************************************************************
// Start Authors page
// ********************************************************************
if (isset($page) && $page=="authors" ) {
  $ResultHtml=puHeading($Easy["Articles"]." ".$language['Authors by Topics'],2);
  if (!isset($From) or $From=="") {$From=0;}
  if (!isset($Order) or $Order=="") {$Order=0;}
	switch ($Order) {
		case 1	: $QryOrder="puHeading Asc"; break;
		default	: $QryOrder="puDate Desc, ID Desc"; break;
	}
  $result = mysql_query("SELECT dpFREET FROM edp_pconfig WHERE dpFREED='dynamicpages'");
  while(list($aaa) = mysql_fetch_row($result)) {
   $TotalAuthors=mysql_num_rows(puMyQuery("SELECT ID FROM edp_puusers;"));
   $Authors=puMyQuery("SELECT ID , puScreenName FROM edp_puusers ORDER BY puScreenName LIMIT $From, ".$Easy["head_per_page"].";");
   $ResultHtml.="<br><br><b>".$language['Authors in the topic'].": ".str_replace("_"," ",str_replace("edp_","",$aaa))."</b><br>";
   If ($TotalAuthors-$From-$Easy["head_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
   while ($Author=mysql_fetch_array($Authors)) {
    $NewsForAuthor=mysql_num_rows(puMyQuery("SELECT ID FROM $aaa WHERE puUserID=".$Author["ID"].";"));
    $ResultHtml.="<a href='$EDP_SELF&page=search&table=".$aaa."&search=".$Author["puScreenName"]."'><b>".$Author["puScreenName"]."</b></a>
    (".$language['Publications'].": ".$NewsForAuthor.")<br>\n\n";
   }
   $ResultHtml.="<table  border='0' cellspacing='1' cellpadding='2'><tr>
   ".($From!=0 ? "<td><a href='$EDP_SELF&page=$page&From=".($From-$Easy["head_per_page"])."&Order=$Order'><img src='images/prev.gif' width='89' height='14' alt='".$language['Jump backward']."' border='0'></a></td>" : "" )."
   ".($More ? "<td align=right><a href='$EDP_SELF&page=$page&From=".($From+$Easy["head_per_page"])."&Order=$Order'><img src='images/next.gif' width='68' height='14' alt='".$language['Jump forward']."' border='0'></a></td>" : "" )."
   </tr></table>";
  }
}
if (isset($page) && $page=="search" )     {include_once "fast/search_page.php";}
if (isset($page) && $page=="individual" ) {
 if(isset($read)) {
  $ResultHtml="<b>".strtoupper($FREET[$PageSection])."</b><br><br>";
  $News=puMyFetch("SELECT * FROM $table WHERE ID=$read;");
  $ResultHtml.=NewsOut($News,-500);
  $ResultHtml.="<a href='$EDP_SELF&table=".$table."&From=$From&Order=$Order&search=$search'><img src='images/back.gif' width='38' height='14' alt='".$language['Jump backward']."' border='0'></a>";
 }
}
// ********************************************************************
// ********************** BuildmenuL
// ********************************************************************
$Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>".$language['Users (Login)']."</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".$Stoitsov["puScreenName"]." ".$language['(Logout)']."</a>" );
if ($useradmin==2) {
  $Adminmenu="<br><span  class=menuL><b>".$language['Admin menu']."</b></span><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>".$language['Add User']."</a><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>".$language['Manage Users']."</a><br>
  <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easypublish/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>".$language['Edit Page']."</a><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href=\"#\" onClick=\"javascript:YesNo('"."../../dynamicpages/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=page_add','".$language['Are you sure, you want to add a new page?']."');\" class=menuL>".$language['Add Page']."</a><br>
  <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easypublish/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>".$language['Site Config']."</a>";
} elseif ($useradmin<1) {
  $Adminmenu.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=register&do=reg_user' class=menuL>".$language['Please register']."</a>";
}
$user=$Easy["user"];
if ($user == 1) {
$user=$language['Currently there is'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['User Online']."";
} else {
$user=$language['Currently there are'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['Users Online']."";
}
$pumenuL="<br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF' class=menuL>".$language['Front']." ".$Easy["Articles"]."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=topics' class=menuL>".$language['Topics']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=contents' class=menuL>".$language['Contents']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=authors' class=menuL>".$language['Authors list']."</a>
<br><span class=menuL><b>".$Easy["Articles"]." ".$language['order']."</b></span><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=$page&From=$From&Order=0' class=menuL>".$language['By Date']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=$page&From=$From&Order=1' class=menuL>".$language['By Title']."</a><br><br>
".puElement("form",$EDP_SELF,"SEARCH","GET")."
<span class=menuL><b>".$language['Search in Front']." ".$Easy["Articles"]."</b></span><br>
".puElement("text","search",$search,100).puElement("hidden","page","search").puElement("hidden","PageSection",$PageSection).puElement("submit",$language['Go']).puElement();
$pumenuLA.="<br><br><a href='http://myio.net/software/products/description.php?software=EasyPublish' target=_stoitsov><img src='images/EasyPublishLogo_big.gif' height='90' width='105'  alt='EasyPublish!' border='0'></a><br><br>";
$LeftBlock.=$pumenuL.$pumenuLA;
// pageconfig and site config
if (isset($page) && $page=="config" && $useradmin==2) { include_once "../../admin/config_page.php"; }
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
