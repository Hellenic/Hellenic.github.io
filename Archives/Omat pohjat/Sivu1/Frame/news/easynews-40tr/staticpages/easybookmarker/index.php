<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$LeftBlock="<span class=menuL><b>BOOK MARKER MENU</b></span><br><br>";
$color="bgcolor=#ffffff"; $color1="bgcolor=#ffffff"; $color2="bgcolor=#F7F8FA";
// ********************************************************************
// ********************** Functions
// ********************************************************************
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=left><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
function puRegistered($Who){Global $Stoitsov;$ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"]){ $ret=1; }if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1){ $ret=2; } return $ret;}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") { switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n"; break; case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break; case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break; case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break; case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break; case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break; case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break; case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
function puHeading($Heading,$BR=1) { if ($BR!=0) $ret="&nbsp;&nbsp;&nbsp;"; $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }
function puMyQuery($Query) { Global $sql, $language; $Res=mysql_query($Query) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query.']."","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
function puMyFetch($Query) { Global $sql, $language; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'].".","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
//function puHackers($Text) { $ret=strip_tags($Text); $ret=escapeshellcmd($ret); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret; }
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
function ExpandFolder($FolderID) { Global $EDP_SELF, $expanded_folders; $ret=""; $Temp2=array(); if (isExpandedFolder($FolderID)) { $Temp=split(",",$expanded_folders); for ($t=0; $t<count($Temp); $t++) { if ($Temp[$t]!=$FolderID) {$ret.=",".$Temp[$t];} } } else { $ret.=$expanded_folders.",".$FolderID; } if (substr($ret,0,1)==",") {$ret=substr($ret,1,strlen($ret));} if (strlen($ret)>0) { $first="&xpanded_folders="; } else { unset($ret); $first="&xpanded_folders="; } return "<a href='".$EDP_SELF.$first.$ret.(!isExpandedFolder($FolderID) ? "#Loc".$FolderID : "" )."' class=normal title='Expand/Collapse Folder'>"; }
function isExpandedFolder($FolderID) { Global $expanded_folders; if ($expanded_folders=="E_ALL" or $FolderID==0) {return TRUE; } $Temp=split(",",$expanded_folders); for ($t=0; $t<count($Temp); $t++) { if ($Temp[$t]==$FolderID) {return TRUE;} }  return false; }
function AllFolders($Act="expand",$class="normal") { global $sql,$expanded_folders, $EDP_SELF; if ($Act=="expand") {  $first="&xpanded_folders=0"; $CatSelects=puMyQuery("SELECT * FROM edp_bmcategory ORDER BY CName;"); while ($CatSelect=mysql_fetch_array($CatSelects)) { $first.=",".$CatSelect["ID"]; }  } else { $first="&xpanded_folders="; } return "<a href='$EDP_SELF$first' class=$class title='".ucfirst($Act)." Folders'>"; }
function to_stamp($Date) { $MDate=split("-",$Date); return mktime(12,00,00,$MDate[1],$MDate[2],$MDate[0]); }
function Export($Parent=0, &$level, &$RH) { Global $sql; $Folders=puMyQuery("SELECT * FROM edp_bmcategory WHERE Parent=$Parent ORDER BY CName;"); if (mysql_num_rows($Folders)==0) {  return ""; } else {  while ($Folder=mysql_fetch_array($Folders)) { $level[$Folder["ID"]]=$level[$Parent]+1; For ($t=0; $t<$level[$Folder["ID"]]*2; $t++) $RH.=" "; $RH.="<DT><H3 FOLDED ADD_DATE=\"1047045444\" DESCRIPTION=\"".$Folder["CDescription"]."\">".$Folder["CName"]."</H3>\n"; $Links=puMyQuery("SELECT * FROM edp_bmlink WHERE Parent=".$Folder["ID"]." ORDER BY LName;"); For ($t=0; $t<$level[$Folder["ID"]]*2; $t++) $RH.=" "; $RH.="<DL><p>\n"; while ($Link=mysql_fetch_array($Links)) { For ($t=0; $t<$level[$Folder["ID"]]*2; $t++) $RH.=" "; $RH.="<DT><A HREF=\"".$Link["LUrl"]."\" ADD_DATE=\"".to_stamp($Link["Date"])."\" LAST_VISIT=\"".to_stamp($Link["Visit"])."\" LAST_MODIFIED=\"".to_stamp($Link["Modify"])."\" DESCRIPTION=\"".$Link["LDescription"]."\" HITS=\"".$Link["Hits"]."\">".$Link["LName"]."</A>\n"; }  Export($Folder["ID"],$level, $RH); For ($t=0; $t<$level[$Folder["ID"]]*2; $t++) $RH.=" "; $RH.="</DL><p>\n"; }  }  }
function ShowFolder($Parent=0, &$level, &$ResultHtml, &$Light) { Global $useradmin, $language, $sql, $Stoitsov,$Easy, $EDP_SELF, $color, $color1, $color2; $Folders=puMyQuery("SELECT * FROM edp_bmcategory WHERE Parent=$Parent ORDER BY CName;"); if (mysql_num_rows($Folders)==0 or !isExpandedFolder($Parent)) {  return ""; } else {  $i=0; while ($Folder=mysql_fetch_array($Folders)) { $i++; $level[$Folder["ID"]]=$level[$Parent]+1; $ResultHtml.="<table   border='0' cellspacing='0' cellpadding='0' width='".$Easy["table_width"]."'> <tr><td  $color valign=top><a name='Loc".$Folder["ID"]."'></a>".puTr($level[$Parent]*10). ($level[$Parent]==1 ? ExpandFolder($Folder["ID"])."<img src='images/".(isExpandedFolder($Folder["ID"]) ? "expanded" : "collapsed" )."_folder.gif' width='32' height='32' alt='' border='0'>" : ExpandFolder($Folder["ID"])."<img src='images/".(isExpandedFolder($Folder["ID"]) ? "minus" : "plus" ).".gif' width='12' height='16' alt='' border='0'>")."</a></td> <td $color width=100% valign=bottom>&nbsp;".ExpandFolder($Folder["ID"])."<b>".$Folder["CName"]."</b></a>".($level[$Parent]==1 ? "<BR>&nbsp;" : " - " )."<i>".$Folder["CDescription"]."</i></td> ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td $color><a href='$EDP_SELF&page=edit_folder&id=".$Folder["ID"]."'><img src='images/folder_dark.gif' width='16' height='16' alt='".$language['Edit folder']."' border='0' ></a><a href='$EDP_SELF&page=add_folder&parent=".$Folder["ID"]."'><img src='images/folder_light.gif' width='16' height='16' alt='".$language['Add folder']."' border='0' ></a><a href='$EDP_SELF&page=add_link&parent=".$Folder["ID"]."'><img src='images/new_link.gif' width='16' height='16' alt='".$language['Add link']."' border='0'></a><br></td>" : "" )."</tr> </table> "; if (isExpandedFolder($Folder["ID"])) { $ResultHtml.=ShowLinks($Folder["ID"],$level[$Parent]*10); } if ($color==$color1) {$color=$color2; } else { $color=$color1; } ShowFolder($Folder["ID"],$level, $ResultHtml, &$Light); } } }
function ShowLinks($Parent=0, $distance) { Global $language, $useradmin, $sql, $Stoitsov,$Easy,$OrderQry, $EDP_SELF, $color, $color1, $color2; $Links=puMyQuery("SELECT * FROM edp_bmlink WHERE Parent=$Parent ORDER BY $OrderQry;"); $num_links=mysql_num_rows($Links); $i=0; $ret.= "<table  border='0' cellspacing='0' cellpadding='0' width='".$Easy["table_width"]."'>"; while ($Link=mysql_fetch_array($Links)) { $i++; if ($color==$color1) {$color=$color2; } else { $color=$color1; } $ret.= " <tr><td  valign=top $color>".puTr($distance).($distance<11 ? puTr(11)."<img src='images/toplink.gif' width='10' height='16' alt='' border='0'>" : "<img src='images/lnk_".($i==$num_links ? "down" : "middle" ).".gif' width='12' height='16' alt='' border='0'><img src='images/link.gif' width='10' height='16' alt='' border='0'>" )."<br></td> <td width=100% $color><a href='$EDP_SELF&follow_link=".$Link["ID"]."' target=\"_new\"   OnMouseover='self.status=\"GoTo: ".$Link["LUrl"]."\"; return true;' OnMouseOut='self.status=\"EasyBookmarker ver.".$Easy["version"]."\"; return true;' class=normal targer=_new>".$Link["LName"]."</a>".( $Link["LDescription"]!='' ? "(<i>{$Link['LDescription']}</i>)" : '')."</td> ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td $color><a href='$EDP_SELF&page=edit_link&id=".$Link["ID"]."&parent=".$Link["Parent"]."'><img src='images/edit_link.gif' width='16' height='16' alt='".$language['Edit link']."' border='0'></a>&nbsp;<a href='$EDP_SELF&action=delete_link&bmID=".$Link["ID"]."'><img src='images/delete_link.gif' width='16' height='16' alt='".$language['Delete link']."' border='0'></a><br></td>" : "" )."</tr> "; }  $ret.="</table>"; return $ret; }
function ShowBrief($What,$HowMany) { Global $sql, $Easy, $EDP_SELF, $color, $color1, $color2; $Links=puMyQuery("SELECT * FROM edp_bmlink ORDER BY $What LIMIT 0,".$HowMany.";"); $ResultHtml="<table   border='0' cellspacing='0' cellpadding='0' width='".$Easy["table_width"]."'>"; $i=0; while ($Link=mysql_fetch_array($Links)) { $i++; if ($color==$color2) {$color=$color1; } else { $color=$color2; } $ResultHtml.="<tr><td valign=top $color>&#149;</td><td $color><a href='$EDP_SELF&follow_link=".$Link["ID"]."' target=\"_new\"  OnMouseover='self.status=\"GoTo: ".$Link["LUrl"]."\"; return true;' OnMouseOut='self.status=\"EasyBookmarker ver.".$Easy["version"]."\"; return true;' class=normal>".$Link["LName"]."</a></td></tr>"; } $ResultHtml.="</table>"; return $ResultHtml; }
if (!session_is_registered("expanded_folders")) { $expanded_folders="0";  session_register("expanded_folders"); $Order=1; session_register("Order"); $Chart=1; session_register("Chart"); }
if (isset($follow_link)) { puMyQuery("UPDATE edp_bmlink SET Hits=Hits+1, Visit='".date("Y-m-d")."' WHERE ID=$follow_link;"); $Link=puMyFetch("SELECT LUrl From edp_bmlink WHERE ID=$follow_link;"); Header("Location: ".$Link["LUrl"]); exit; }
// ********************************************************************
// ************************ Actions
// ********************************************************************
$action_log="$action=='reg_user' or $action=='edit_reg_user'  or $action=='login' or $action=='logout' or $action=='add_user' or action=='edit_user'";
if($action_log) { include_once "../../admin/login.php"; } $useradmin=puRegistered($Stoitsov);
if ($action=="remote") {
    if (isset($Stoitsov["puUsername"])) {  $action="add_link"; $bmLUrl=$url; $bmLName=$name; $bmLDescription=$language['Imported from Quick Add']; $bmParent="0";
    } else {
     $Check=puMyQuery("SELECT * FROM edp_puusers WHERE BINARY puUsername='".puHackers($bmUsername)."' AND BINARY puPassword='".puHackers($bmPassword)."' LIMIT 1;");
     if (mysql_num_rows($Check)!=0 or ( $bmUsername==$puUsername && $bmPassword==$puPassword) ) {
      $Stoitsov=mysql_fetch_array($Check);
      session_register("Stoitsov");
      $useradmin=puRegistered($Stoitsov);
      $action="add_link";  $bmParent="0";
      $bmLUrl=$url; $bmLName=$name; $bmLDescription=$language['Imported from Quick Add']; $bmParent="0";
     } else {
      $Error="<b>".$language['Invalid username or password'].".</b><br>"; $page="remote";
     }
   }
}
if ($action=="add_folder") {
  if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error="<b>".$language['You need to be a registered user in order to add folders'].".</b><br>";
  } else {  unset($Error);
    if (strlen(puHackers($bmCName))<1) $Error="<b>".$language['Folder Name is empty'].".</b><br>";
    if (strlen(puHackers($bmCDescription))<1) $Error.="<b>".$language['Folder Description is empty'].".</b><br>";
    if (isset($Error)) { $page="add_folder"; $parent=$bmParent;
    } else {  puMyQuery("INSERT INTO edp_bmcategory VALUES(null,'".puHackers($bmCName)."','".puHackers($bmCDescription)."','$bmParent');"); }
} }
if ($action=="edit_folder" && $useradmin=2) {
    if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error="<b>".$language['You need to be Administrator in order to edit folders'].".</b><br>";
} else {
		unset($Error);
    if (strlen(puHackers($bmCName))<1) $Error="<b>".$language['Folder Name is empty'].".</b><br>";
    if (strlen(puHackers($bmCDescription))<1) $Error.="<b>".$language['Folder Description is empty'].".</b><br>";
    if (isset($Error)) { $page="edit_folder"; $id=$bmID;
    } else { puMyQuery("UPDATE edp_bmcategory SET Parent='".$bmParent."', CName='".puHackers($bmCName)."', CDescription='".puHackers($bmCDescription)."' WHERE ID=$bmID;"); }
} }
if ($action=="delete_folder" && $useradmin=2) {
  if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error="<b>".$language['You need to be Administrator in order to delete folders'].".</b><br>";
  } else {  puMyQuery("DELETE FROM edp_bmcategory WHERE ID=$bmID;"); }
}
if ($action=="add_link") {
  if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error="<b>".$language['You need to be a registered user in order to add links'].".</b><br>";
  } else { unset($Error);
    if (strlen(puHackers($bmLUrl))<8) $Error="<b>".$language['The link is invalid'].".</b><br>";
    if (strlen(puHackers($bmLName))<1) $Error="<b>".$language['Site Name is empty'].".</b><br>";
    if (strlen(puHackers($bmLDescription))<1) $Error.="<b>".$language['Site Description is empty'].".</b><br>";
    if (isset($Error)) { $page="add_link"; $parent=$bmParent;
   } else { puMyQuery("INSERT INTO edp_bmlink VALUES(null,'".puHackers($bmLUrl)."','".puHackers($bmLName)."','".puHackers($bmLDescription)."','".date("Y-m-d")."','".date("Y-m-d")."','".date("Y-m-d")."',0,'$bmParent');"); }
}}
if ($action=="edit_link" && $useradmin=2) {
  if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error="<b>".$language['You need to be Administrator in order to edit links'].".</b><br>";
  } else { unset($Error);
    if (strlen(puHackers($bmLUrl))<8) $Error="<b>".$language['The link is invalid'].".</b><br>";
    if (strlen(puHackers($bmLName))<1) $Error="<b>".$language['Site Name is empty'].".</b><br>";
    if (strlen(puHackers($bmLDescription))<1) $Error.="<b>".$language['Site Description is empty'].".</b><br>";
    if (isset($Error)) {  $page="add_link"; $parent=$bmParent; $id=$bmID;
  } else { puMyQuery("UPDATE edp_bmlink SET Parent='".$bmParent."', LUrl='".puHackers($bmLUrl)."', LName='".puHackers($bmLName)."', LDescription='".puHackers($bmLDescription)."', Modify='".date("Y-m-d")."', Visit='".date("Y-m-d")."' WHERE ID=$bmID;"); }
}}
if ($action=="delete_link" && $useradmin=2) {
    if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error="<b>".$language['You need to be Administrator in order to delete links'].".</b><br>";
  } else { puMyQuery("DELETE FROM edp_bmlink WHERE ID=$bmID;"); }
}
if ($action=="export") {
    if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error="<b>".$language['You need to be a registered user in order to export bookmarks'].".</b><br>";
  } else {
    $RH="<!DOCTYPE NETSCAPE-Bookmark-file-1>\n<!-- This is an automatically generated file.\nIt will be read and overwritten.\nDo Not Edit! -->\n<TITLE>".$language['Bookmarks']."</TITLE>\n<H1>".$language['Bookmarks']."</H1>\n";
		$RH.="<DL><p>\n";
		Export(0,$level,$RH);
    $Links=puMyQuery("SELECT * FROM edp_bmlink WHERE Parent=0 ORDER BY LName;");
		while ($Link=mysql_fetch_array($Links)) {
    $RH.="<DT><A HREF=\"".$Link["LUrl"]."\" ADD_DATE=\"".to_stamp($Link["Date"])."\" LAST_VISIT=\"".to_stamp($Link["Visit"])."\" LAST_MODIFIED=\"".to_stamp($Link["Modify"])."\" DESCRIPTION=\"".$Link["LDescription"]."\" HITS=\"".$Link["Hits"]."\">".$Link["LName"]."</A>\n"; }
		$RH.="</DL><p>\n";
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=bookmark.htm");
		print $RH;
		exit;
}}
if ($action=="import") {
    if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error="<b>".$language['You need to be a registered user in order to import bookmarks'].".</b><br>";
  } else {
    if ($_FILES['file_name']['type']!="text/html") { $page="import"; $Error="<b>".$language['You can import only valid HTML or TEXT files'].".</b><br>";
    } else {
			$fd = fopen ($_FILES['file_name']['tmp_name'], "r");
			$Level=-1;
			$ParentID=Array();
			$ParentID[0]=0;
      puMyQuery("INSERT INTO edp_bmcategory Values(null,'Imported Links','Imported folder','0');");
      $ParentID[0]=mysql_insert_id();
			while (!feof ($fd)) {
				$buffer = trim(fgets($fd, 4096));
				$buffer=str_replace(chr(10),"",$buffer);
				$buffer=str_replace(chr(13),"",$buffer);
				$buffer=str_replace("<DT>","",$buffer);
				$buffer=str_replace("'","`",$buffer);
				if ($buffer=="<DL><p>") $Level++;
				if ($buffer=="</DL><p>") $Level--;
        if (strlen($buffer)>9 && $Level>=0) {
          if (substr($buffer,1,2)=="H3") {
						$bmCName=strip_tags($buffer);
            puMyQuery("INSERT INTO edp_bmcategory Values(null,'".$bmCName."','Imported folder','".$ParentID[$Level]."');");
						$ParentID[$Level+1]=mysql_insert_id();
          } elseif (substr($buffer,1,6)=="A HREF") {
						$SplitValues=Array("HREF","ADD_DATE","LAST_VISIT","LAST_MODIFIED","DESCRIPTION","HITS");
						$TableValues=Array("bmLUrl","bmDate","bmVisit","bmModify","bmLDescription","bmHits");
						for ($t=0; $t<count($SplitValues); $t++) {
							$Temp1=split($SplitValues[$t]."=\"",$buffer);
							$Temp2=split("\"",$Temp1[1]);
							$var=$TableValues[$t];
							if ($Temp2[0]<0) $Temp2[0]="";
							$$var=$Temp2[0];
            }
            puMyQuery("INSERT INTO edp_bmlink VALUES(null,'".$bmLUrl."','".strip_tags($buffer)."','".$bmLDescription."','".date("Y-m-d",$bmDate)."','".date("Y-m-d",$bmModify)."','".date("Y-m-d",$bmVisit)."',0,'".$ParentID[$Level]."');");
          }  }  }  fclose ($fd);
}  }  }
if ($action=="logout") { session_unregister("Stoitsov"); unset($Stoitsov["puUsername"]); }
if (isset($xpanded_folders)) { $expanded_folders=$xpanded_folders; }
if (isset($setOrder)) { $Order=$setOrder; }
if (isset($setChart)) { $Chart=$setChart; }
switch ($Order) {
	case 2: $OrderQry="Date DESC"; break;
	case 3: $OrderQry="Visit Desc"; break;
	case 4: $OrderQry="Modify Desc"; break;
	case 5: $OrderQry="Hits Desc"; break;
	default: $OrderQry="LName ASC"; break;
}
switch ($Chart) {
  case 2: $ChartHeading=$language['Newest Links']; $ChartQry="Date DESC"; break;
  case 3: $ChartHeading=$language['Last Visited Links']; $ChartQry="Visit Desc"; break;
  case 4: $ChartHeading=$language['Last Modified Links']; $ChartQry="Modify Desc"; break;
  case 5: $ChartHeading=$language['Most Rated (Click-through) Links']; $ChartQry="Hits Desc"; break;
  default: $ChartHeading=$language['Alphabeticaly']; $ChartQry="LName ASC"; break;
}
// ********************************************************************
// **************   EasyBookmarker Screen Creation
// ********************************************************************
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
if (isset($page) && $page=="remote") {
   if (isset($Stoitsov["puUsername"])) { puMyQuery("INSERT INTO edp_bmlink VALUES(null,'".puHackers($url)."','".puHackers($name)."','".$language['Imported from Quick Add']."','".date("Y-m-d")."','".date("Y-m-d")."','".date("Y-m-d")."',0,'$bmParent');");  unset($page);
   } else {
    $ResultHtml="";
    $ResultHtml.=puHeading($language['User authorization'],1).
    "&nbsp;&nbsp;&nbsp;".$language['You need to be registered user in order to add bookmarks'].".<br><br>
    <div align=left>
      <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
      <tr><td colspan=2>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Login']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Login","POST")."
      <tr><td bgcolor=".$Easy["Background"]." align=right><b>".$language['Username'].":</b></td> <td bgcolor=".$Easy["Background"].">".puElement("text","bmUsername",$bmUsername,100)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]." align=right><b>".$language['Password'].":</b></td> <td bgcolor=".$Easy["Background"].">".puElement("password","bmPassword","",100)."</td> </tr>
      <tr> <td colspan=2 align=right>".puElement("submit",$language['Login'],"f_button")."</td> </tr> ". puElement("hidden","action","remote"). puElement("hidden","name",urldecode($name)). puElement("hidden","url",urldecode($url)). puElement()."
		</table><br>".
    $Error ."</div> ";
   }
}
// Start: Main page
if (!isset($page)) { $ResultHtml=""; $level[0]=1; $Light=0;
	ShowFolder(0,$level,$FoldersHtml, &$Light);
        $ResultHtml="<div align=left><table  border='0' cellspacing='0' cellpadding='0' width='".$Easy["table_width"]."'>
        <tr><td><img src='images/topfolder.gif' width='32' height='32' alt='Root folder' border='0'><br></td>
  <td width=100%>&nbsp;".puHeading($language['EasyBookMarker'],0)."</td>
        ".(isset($Stoitsov["puUsername"]) ? "<td $color><a href='$EDP_SELF&page=add_folder&parent=0'><img src='images/folder_light.gif' width='16' height='16' alt='".$language['Add folder']."' border='0'
        ></a><a href='$EDP_SELF&page=add_link&parent=0'><img src='images/new_link.gif' width='16' height='16' alt='".$language['Add link']."' border='0'></a><br></td>" : "" )."</td></tr></table>";
	$ResultHtml.=ShowLinks(0,0);
	$ResultHtml.=$FoldersHtml.
	"</div>";
}
// Start: Chart page
if (isset($page) && $page=="show_links") {
	$ResultHtml="";
	if (!isset($From)) $From=0;
        $TotalLinks=mysql_num_rows(puMyQuery("SELECT ID FROM edp_bmlink;"));
        $Links=puMyQuery("SELECT * FROM edp_bmlink ORDER BY $ChartQry LIMIT $From,".$Easy["links_per_page"].";");
        If ($TotalLinks-$From-$Easy["links_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
        $ResultHtml=puHeading($language['Bookmarks'],1)."&nbsp;&nbsp;&nbsp;<b>".$ChartHeading."</b><div align=left><table  border='0' cellspacing='1' cellpadding='2' width='".$Easy["table_width"]."'>
        <tr><td><span class=".$Easy["Background"].">#</span></td><td><span class=".$Easy["Background"].">".$language['Name/Description']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Added']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Modified']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Visited']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Clicks']."</span></td>
        ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td nowrap><span class=".$Easy["Background"].">".$language['Edit']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Delete']."</span></td>" : "" )."</tr> ";
	$i=$From;
  while ($Link=mysql_fetch_array($Links)) { $i++;
    if ($color==$color1) {$color=$color2; } else { $color=$color1; }
		$ResultHtml.="<tr $color><td valign=top nowrap align=right>".$i.".</td>
    <td valign=top width=100%><a href='$EDP_SELF&follow_link=".$Link["ID"]."' class=normal>".$Link["LName"]."</a> (<i>".$Link["LDescription"]."</i>)</td>
		<td valign=top nowrap>".$Link["Date"]."</td>
		<td valign=top nowrap>".$Link["Modify"]."</td>
		<td valign=top nowrap>".$Link["Visit"]."</td>
    <td valign=top nowrap align=left>".$Link["Hits"]."</td> ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td valign=top $color><a href='$EDP_SELF&page=edit_link&id=".$Link["ID"]."&parent=".$Link["Parent"]."'><img src='images/edit_link.gif' width='16' height='16' alt='".$language['Edit link']."' border='0'> </a></td>
    <td valign=top $color>&nbsp;<a href='$EDP_SELF&action=delete_link&bmID=".$Link["ID"]."'><img src='images/delete_link.gif' width='16' height='16' alt='".$language['Delete link']."' border='0'></a><br></td>" : "" )."</tr>";
	}
	$ResultHtml.="</table>
        <hr size=1 noshade color='".$Easy["LightColor2"]."' width='".$Easy["table_width"]."'>
        <table  border='0' cellspacing='1' cellpadding='2' width='".$Easy["table_width"]."'><tr>
        ".($From!=0 ? "<td><a href='$EDP_SELF&page=show_links&setChart=$Chart&From=".($From-$Easy["links_per_page"])."' class=normal>".$language['Previous page']."</a></td>" : "" )."
        ".($More ? "<td align=right><a href='$EDP_SELF&page=show_links&setChart=$Chart&From=".($From+$Easy["links_per_page"])."' class=normal>".$language['Next page']." ></a></td>" : "" )."
        </tr></table></div>";
}
// Start: Search page
if (isset($page) && $page=="search") { $ResultHtml=""; $bmSearch=puHackers($bmSearch);
	if (!isset($From)) $From=0;
        $TotalLinks=mysql_num_rows(puMyQuery("SELECT ID FROM edp_bmlink WHERE LName like '%".$bmSearch."%' OR LDescription like '%".$bmSearch."%' OR LUrl like '%".$bmSearch."%';"));
        $Links=puMyQuery("SELECT * FROM edp_bmlink WHERE LName like '%".$bmSearch."%' OR LDescription like '%".$bmSearch."%' OR LUrl like '%".$bmSearch."%' ORDER BY Hits Desc LIMIT $From,".$Easy["links_per_page"].";");
        If ($TotalLinks-$From-$Easy["links_per_page"]>0) { $More=TRUE; } else { $More=FALSE; }
        $ResultHtml=puHeading($language['Bookmarks'],1)."&nbsp;&nbsp;&nbsp;<b>".$language['Search for']." \"".$bmSearch."\"</b><div align=left><table  border='0' cellspacing='1' cellpadding='2' width='".$Easy["table_width"]."'>
        <tr><td><span class=".$Easy["Background"].">#</span></td><td><span class=".$Easy["Background"].">".$language['Name/Description']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Added']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Modified']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Visited']."</span></td><td nowrap><span class=".$Easy["Background"].">".$language['Clicks']."</span></td>
        ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td nowrap><span class=".$Easy["Background"].">".$language['Edit']."</span></td><td nowrap><span class=".$Easy["Background"].">Delete</span></td>" : "" )."</tr> ";
	$i=$From;
  while ($Link=mysql_fetch_array($Links)) { $i++;
    if ($color==$color1) {$color=$color2; } else { $color=$color1; }
		$ResultHtml.="<tr $color><td valign=top nowrap align=right>".$i.".</td>
    <td valign=top width=100%><a href='$EDP_SELF&follow_link=".$Link["ID"]."' class=normal>".$Link["LName"]."</a> (<i>".$Link["LDescription"]."</i>)</td>
		<td valign=top nowrap>".$Link["Date"]."</td>
		<td valign=top nowrap>".$Link["Modify"]."</td>
		<td valign=top nowrap>".$Link["Visit"]."</td>
    <td valign=top nowrap align=left>".$Link["Hits"]."</td> ".(isset($Stoitsov["puUsername"]) && $useradmin==2 ? "<td valign=top $color><a href='$EDP_SELF&page=edit_link&id=".$Link["ID"]."&parent=".$Link["Parent"]."'><img src='images/edit_link.gif' width='16' height='16' alt='".$language['Edit link']."' border='0'> </a></td>
    <td valign=top $color>&nbsp;<a href='$EDP_SELF&action=delete_link&bmID=".$Link["ID"]."'><img src='images/delete_link.gif' width='16' height='16' alt='".$language['Delete link']."' border='0'></a><br></td>" : "" )."</tr>";
	}
	$ResultHtml.="</table>
        <hr size=1 noshade color='".$Easy["LightColor2"]."' width='".$Easy["table_width"]."'>
        <table  border='0' cellspacing='1' cellpadding='2' width='".$Easy["table_width"]."'><tr>
        ".($From!=0 ? "<td><a href='$EDP_SELF&page=search&bmSearch=$bmSearch&From=".($From-$Easy["links_per_page"])."' class=normal>".$language['Previous page']."</a></td>" : "" )."
        ".($More ? "<td align=right><a href='$EDP_SELF&page=search&bmSearch=$bmSearch&From=".($From+$Easy["links_per_page"])."' class=normal>".$language['Next page']." </a></td>" : "" )."
	</tr></table></div>";
}
// Start: Export page
if ($page=="export") { $ResultHtml="";
    if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error=$language['You need to be registered user in order to add categories'];
  } else {
  $ResultHtml.= puHeading($language['Export Bookmarks'],2);
  $ResultHtml.= "<ul><p>".$language['This function helps you move your bookmarks from EasyBookmarker to your favorite Browser'].". <br>".$language['Once you downloaded the file, follow these instructions'].":</p>
	<b>M$ Internet Explorer</b>
	<ul>
  <li>".$language['File menu']."</li>
  <li>".$language['Import and Export']."...</li>
  <li>".$language['In the wizard, select Import Favorites']."</li>
  <li>".$language['Choose Import from file or address option']."</li>
  <li>".$language['Select the downloaded file']."</li>
	</ul><br>
	<b>Netscape 6</b>
	<ul>
  <li>".$language['Bookmarks menu']."</li>
  <li>".$language['Manage bookmarks']."</li>
  <li>".$language['File menu']."</li>
  <li>".$language['Import bookmarks']."...</li>
  <li>".$language['Select the downloaded file']."</li>
	</ul>
  <p>".$language['Its that simple'].".</p>
  <p><b>".$language['To download your bookmarks, click the link below'].".</b> <br>".$language['If your download does not start, right-click the link and choose Save as option'].".</p> <a href='$EDP_SELF&action=export' class=normal>".$language['Download now']."</a></ul>";
} }
// Start: import page
if ($page=="import") { $ResultHtml="";
  if (!isset($Stoitsov["puUsername"])) { $page="login"; $Error=$language['You need to be registered user in order to add categories'];
  } else {
  $ResultHtml.= puHeading($language['Import Bookmarks'],2).
  "<ul><p>".$language['This function helps you move your bookmarks from your favorite Browser to the EasyBookmarker'].".</p>
  <p>".$language['Tested & works fine with exported bookmarks from'].":</p>
	<ul>
  <li>M$ Internet Explorer 5 ".$language['and above']."</li>
	<li>Netscape Navigator</li>
	<li>Netscape Communicator</li>
	<li>Netscape 6</li>
  <li>EasyBookmarker 2.0 ".$language['and above']."</li>
	</ul>
  <form action='$EDP_SELF' method=post enctype='multipart/form-data'>
	<input type='hidden' name='MAX_FILE_SIZE' value='".(1024*1024*1024)."'>
  <b>".$language['Choose your local bookmarks file'].":</b><br>
	<input type=file name='file_name' class=f_text><br><br>
  ".puElement("submit",$language['Import'],"f_button").
  puElement("hidden","action","import").
  "</form>".$Error." </ul>";
} }
// Start: Add Folder page
if (isset($page) && $page=="add_folder" && isset($parent)) { $ResultHtml="";
  if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error=$language['You need to be a registered user in order to add categories']; } else { if ($parent!=0) { $UnderCategory=puMyFetch("SELECT * FROM edp_bmcategory WHERE ID=$parent LIMIT 1"); } else { $UnderCategory["CName"]="EasyBookmarker"; }
    $ResultHtml.=puHeading($language['Edit Bookmarks'],1). "&nbsp;&nbsp;&nbsp;<b>".$language['New Folder under']." ".$UnderCategory["CName"]."</b><br><br>
      <div align=left>
        <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
        <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['New Folder Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST")."
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Name'].":</b> [200 Chars max]<br> ".puElement("text","bmCName","",250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Description'].":</b> [255 Chars max]<br> ".puElement("text","bmCDescription","",250)."</td> </tr>
        <tr><td align=right>".puElement("submit",$language['Create'],"f_button")."</td> </tr> ".puElement("hidden","bmParent",$parent).puElement("hidden","action","add_folder").puElement()."
      </table><br>". $Error."</div> ";
  }  }
// Start: Edit Folder page
if (isset($page) && $page=="edit_folder" && isset($id) && $useradmin==2) { $ResultHtml="";
    if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error=$language['You need to be registered user in order to edit the folders'];
  } else {
    $EditFolder=puMyFetch("SELECT * FROM edp_bmcategory WHERE ID=$id LIMIT 1");
    $isEmpty=mysql_num_rows(puMyQuery("SELECT * FROM edp_bmlink Where Parent=".$EditFolder["ID"].";"))+
    mysql_num_rows(puMyQuery("SELECT * FROM edp_bmcategory Where Parent=".$EditFolder["ID"].";"));
    $CatSelects=puMyQuery("SELECT * FROM edp_bmcategory Where ID<>$id ORDER BY BINARY CName;");
		$Under=$Categories[0]="EasyBookmarker";
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["ID"]]=$CatSelect["CName"];
      if ($CatSelect["Parent"]==$EditFolder["ID"]) $Under=$CatSelect["CName"]; }
    $ResultHtml.= puHeading($language['Edit Bookmarks'],1). "&nbsp;&nbsp;&nbsp;<b>".$language['Edit Folder under']." ".$Under."</b><br><br>
      <div align=left>
        <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
        <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Folder information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST")."
        <tr><td bgcolor=".$Easy["Background"]." nowrap><b>".$language['Move folder under'].":</b> ".$language['[no change - no move]']."<br> ".puElement("select","bmParent",$Categories,$EditFolder["Parent"],250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Name'].":</b> [200 Chars max]<br> ".puElement("text","bmCName",$EditFolder["CName"],250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Description'].":</b> [255 Chars max]<br> ".puElement("text","bmCDescription",$EditFolder["CDescription"],250)."</td> </tr>
        <tr> <td align=right>".puElement("submit",$language['Change'],"f_button")."</td> </tr> ".
        puElement("hidden","action","edit_folder"). puElement("hidden","parent",$EditFolder["Parent"]). puElement("hidden","bmID",$EditFolder["ID"]).puElement()."
      </table><br>". $Error.
      ($isEmpty==0 ? "<a href='$EDP_SELF&action=delete_folder&bmID=$id' class=normal>".$language['You may delete this folder. It is empty'].".</a>" : "You can not delete this folder. It is not empty." )
      ."</div> ";
  }  }
// Start: Add Link page
if (isset($page) && $page=="add_link" && isset($parent)) { $ResultHtml="";
    if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error=$language['You need to be a registered user in order to add links'];
  } else {
    if ($parent!=0) { $UnderCategory=puMyFetch("SELECT * FROM edp_bmcategory WHERE ID=$parent LIMIT 1"); } else { $UnderCategory["CName"]="EasyBookmarker"; }
    $ResultHtml.= puHeading($language['Edit Bookmarks'],1).
    "&nbsp;&nbsp;&nbsp;<b>".$language['New Link under']." ".$UnderCategory["CName"]."</b><br><br>
      <div align=left>
        <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
        <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['New Link Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Link","POST")."
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Link'].":</b> [255 Chars max]<br> ".puElement("text","bmLUrl","http://",250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Name'].":</b> [200 Chars max]<br> ".puElement("text","bmLName","",250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Description'].":</b><br> ".puElement("text","bmLDescription","",250)."</td> </tr>
        <tr><td align=right>".puElement("submit",$language['Add'],"f_button")."</td> </tr> ".puElement("hidden","bmParent",$parent). puElement("hidden","action","add_link").puElement()."
      </table><br>". $Error ."</div> ";
}  }
// Start: Edit Link page
if (isset($page) && $page=="edit_link" && isset($id) && isset($parent) && $useradmin==2) { $ResultHtml="";
  if (!isset($Stoitsov["puUsername"])) {  $page="login"; $Error=$language['You need to be a registered user in order to edit the links'];
  } else {
    if ($parent!=0) { $UnderCategory=puMyFetch("SELECT * FROM edp_bmcategory WHERE ID=$parent LIMIT 1"); } else { $UnderCategory["CName"]="EasyBookmarker"; }
    $EditLink=puMyFetch("SELECT * FROM edp_bmlink WHERE ID=$id LIMIT 1");
    $CatSelects=puMyQuery("SELECT * FROM edp_bmcategory ORDER BY BINARY CName;");
		$Categories[0]="EasyBookmarker";
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
      $Categories[$CatSelect["ID"]]=$CatSelect["CName"]; }
    $ResultHtml.= puHeading($language['Edit Bookmarks'],1). "&nbsp;&nbsp;&nbsp;<b>".$language['Edit Link under']." ".$UnderCategory["CName"]."</b><br><br>
      <div align=left>
        <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
        <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Link Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Link","POST")."
        <tr><td bgcolor=".$Easy["Background"]." nowrap><b>".$language['Move Link under'].":</b> ".$language['[no change - no move]']."<br> ".puElement("select","bmParent",$Categories,$parent,250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Link'].":</b> [255 Chars max]<br> ".puElement("text","bmLUrl",$EditLink["LUrl"],250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Name'].":</b> [200 Chars max]<br> ".puElement("text","bmLName",$EditLink["LName"],250)."</td> </tr>
        <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Description'].":</b><br> ".puElement("text","bmLDescription",$EditLink["LDescription"],250)."</td> </tr>
        <tr><td align=right>".puElement("submit",$language['Change'],"f_button")."</td> </tr> ".puElement("hidden","action","edit_link"). puElement("hidden","parent",$parent). puElement("hidden","bmID",$EditLink["ID"]).puElement()."
      </table><br>". $Error."<a href='$EDP_SELF&action=delete_link&bmID=$id' class=normal>You may delete this link.</a>"
      ."</div> ";
}  }
// Start: Quick Add
if (isset($page) && $page=="quick_add") { $ResultHtml="";
    $ResultHtml.=puHeading($language['Quick Add'],1).
    "&nbsp;&nbsp;&nbsp;<b>".$language['Add your favorite links on the fly'].".</b><br><ul>
    <p>".$language['There is a powerful function in EasyBookmarker called QuickAdd'].". <br>".$language['You may add the page you are currently browsing with your favorite browser by clicking on a link in its Favorites (Netscape Bookmarks)'].". <br>".$language['To achieve that, you must'].":</p>
		<b>M$ Internet Explorer</b><ul>
    <li>".$language['Right click the following link'].": <a href=\"javascript:document.location = 'http://".$HTTP_HOST.$_SERVER['PHP_SELF']."?BookMarker=1&page=remote&name=' + escape(document.title) + '&url=' + escape(document.location)\" onClick=\"javascript:alert('".$language['You must drag this link to your browsers toolbar or add it to your favorites'].".'); return false\" class=normal>".$language['MyEasyBookmarker - QuickAdd']."</a>;</li>
    <li>".$language['Choose Add to Favorites... from the pop-up menu'].";</li>
    <li>".$language['Whenever you deside to add a page to the EasyBookmarker, simply click on MyEasyBookmarker - QuickAdd located in your Favorites menu'].".</li>
		</ul><br>
		<b>Netscape</b><ul>
    <li>".$language['Right click the following link'].": <a href=\"javascript:document.location = 'http://".$HTTP_HOST.$EDP_SELF."&BookMarker=1&action=page&name=' + escape(document.title) + '&url=' + escape(document.location)\" onClick=\"javascript:alert('You must drag this link to your browser\'s toolbar or add it to your favorites.'); return false\" class=normal>".$language['MyEasyBookmarker - QuickAdd']."</a>;</li>
    <li>".$language['Choose File Bookmark for Link... from the pop-up menu'].";</li>
    <li>".$language['Whenever you deside to add a page to the EasyBookmarker, simply click on MyEasyBookmarker - QuickAdd located in your Bookmarks menu'].".</li>
    </ul><p>".$language['Hope you like it']."!</p></ul> ";
}
$ResultH.="";
$ResultH.="<table  border='0' cellspacing='0' cellpadding='0' width='100%'>
	<tr>
    <td nowrap>&nbsp;".(isset($Stoitsov["puUsername"]) ? "&nbsp;&nbsp;<img src='images/edit_link.gif' width='16' height='16' alt='' border='0'><br>" : "" )."</td>
    <td nowrap>&nbsp;".(isset($Stoitsov["puUsername"]) ? "<b>".$language['Bookmarks'].": </b><a href='$EDP_SELF&page=import' class=normal>".$language['Import']."</a>/<a href='$EDP_SELF&page=export' class=normal>".$language['Export']."</a>" : "" )."</td>
    <td nowrap>".AllFolders("expand")."<img src='images/folder_dark.gif' width='16' height='16' alt='".$language['Expand All']."' border='0' hspace=4></a></td>
    <td nowrap>".AllFolders("expand")."".$language['Expand All']."</a></td>
    <td nowrap>".AllFolders("collapse")."<img src='images/folder_light.gif' width='16' height='16' alt='".$language['Collapse All']."' border='0' hspace=4></a></td>
    <td nowrap>".AllFolders("collapse")."".$language['Collapse All']."</a></td>
    <td nowrap><a href='$EDP_SELF&page=quick_add' class=normal><img src='images/new_link.gif' width='16' height='16' alt='' border='0' hspace=2></a><br></td>
    <td width=100%><a href='$EDP_SELF&page=quick_add' class=normal>".$language['Quick Add']."</a>".puTr()."<br></td>
  </tr>".puElement()."
  <tr><td width='100%' colspan='11'>".puTr(1,3)."<br></td> </tr>
  <tr><td width='100%' bgcolor='".$Easy[$PageSection]."' colspan='11'>".puTr(1,1)."<br></td></tr>
</table>
<div align=left>
<b>Order:</b>
<a href='$EDP_SELF&setOrder=1' class=normal>".($Order==1 ? "<b>".$language['A-Z']."</b>":"".$language['A-Z']."")."</a>,
<a href='$EDP_SELF&setOrder=2' class=normal>".($Order==2 ? "<b>".$language['New']."</b>":"".$language['New']."")."</a>,
<a href='$EDP_SELF&setOrder=3' class=normal>".($Order==3 ? "<b>".$language['Visited']."</b>":"".$language['Visited']."")."</a>,
<a href='$EDP_SELF&setOrder=4' class=normal>".($Order==4 ? "<b>".$language['Modified']."</b>":"".$language['Modified']."")."</a>,
<a href='$EDP_SELF&setOrder=5' class=normal>".($Order==5 ? "<b>".$language['Used']."</b>":"".$language['Used']."")."</a> | <b>".$language['List'].":</b>
<a href='$EDP_SELF&page=show_links&setChart=1' class=normal>".($Chart==1 ? "<b>".$language['A-Z']."</b>":"".$language['A-Z']."")."</a>,
<a href='$EDP_SELF&page=show_links&setChart=2' class=normal>".($Chart==2 ? "<b>".$language['New']."</b>":"".$language['New']."")."</a>,
<a href='$EDP_SELF&page=show_links&setChart=3' class=normal>".($Chart==3 ? "<b>".$language['Visited']."</b>":"".$language['Visited']."")."</a>,
<a href='$EDP_SELF&page=show_links&setChart=4' class=normal>".($Chart==4 ? "<b>".$language['Modified']."</b>":"".$language['Modified']."")."</a>,
<a href='$EDP_SELF&page=show_links&setChart=5' class=normal>".($Chart==5 ? "<b>".$language['Used']."</b>":"".$language['Used']."")."</a>
&nbsp;&nbsp;</div><br>";
if (!isset($page) && !isset($Stoitsov["puUsername"])) {
        $ResultH0="<div align=left><table  border=0 width=100%><tr> <td></td>
        <td width=70% valign=top >".$ResultHtml."</td>
        <td width=30% valign=top nowrap>".puHeading($language['Last 30']." <br> ".$language['visited links'],0).ShowBrief("Visit",30)."</td></tr></table></div>";
} else { $ResultH0=$ResultHtml; }
$LeftBlock.="<span class=menuL>
 <table  border='0' cellspacing='0' cellpadding='0' width='100%'>
".puElement("form",$EDP_SELF,"Search","POST")."
  <tr><td nowrap class=menuL><b>".$language['Search for'].":</b><br></td></tr>
  <tr><td nowrap class=menuL>".puElement("text","bmSearch","",100)."".puElement("submit",$language['Go'],"f_button")."<br></td> ".puElement("hidden","page","search").puElement()."</tr>
  <tr><td nowrap>".AllFolders("expand","invert")."<br><img src='images/folder_dark.gif' width='16' height='16' alt='Expand All' border='0' hspace=4 ></a> ".AllFolders("expand","invert")."".$language['Expand All']."</a></td> </tr>
  <tr><td nowrap>".AllFolders("collapse","invert")."<img src='images/folder_light.gif' width='16' height='16' alt='Collapse All' border='0' hspace=4></a> ".AllFolders("collapse","invert")."".$language['Collapse All']."</a></td> </tr>
  <tr><td nowrap class=menuL><a href='$EDP_SELF&page=quick_add' class=invert ><img src='images/new_link.gif' width='16' height='16' alt='' border='0' hspace=2></a> <a href='$EDP_SELF&page=quick_add' class=invert >&nbsp;".$language['Quick Add']."</a>".puTr()."<br></td> </tr>". puElement()."</tr>
  <tr><td width='100%' colspan='11'>".puTr(1,3)."<br></td> </tr>
 </table>";
                                                                                                                $Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>".$language['Users (Login)']."</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".ucwords($Stoitsov["puScreenName"])." ".$language['(Logout)']."</a>" );
if ($useradmin==2) {
 $Adminmenu="<br><span class=menuL><b>".$language['Admin menu']."</b></span><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>".$language['Add User']."</a><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>".$language['Manage Users']."</a><br>
 <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=import' class=menuL>".$language['Import']."</a><span class=menuL>/</span><a href='$EDP_SELF&page=export' class=menuL>".$language['Export']."</a><br>
 <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../easybookmarker/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>".$language['Edit Page']."</a><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../easybookmarker/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>".$language['Site Config']."</a>
";
} elseif ($useradmin<1) {
  $Adminmenu.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=register&do=reg_user' class=menuL>".$language['Please register']."</a>";
}
$user=$Easy["user"];
if ($user == 1) {
$user=$language['Currently there is'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['User Online'];
} else {
$user=$language['Currently there are'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['Users Online'];
}
$LeftBlock.="<br><a href='http://myio.net/software/products/description.php?software=EasyBookmarker' target=_stoitsov><img src='images/EasyBookmarkerLogo_big.gif' height='90' width='105'  alt='EasyBookMarker!' border='0'></a><br><br></span>";

// ********************************************************************
// ********************** Left Center Right Blocks
// ********************************************************************
// Center Blocks $ResultHtml
$ResultH.=$ResultH0; $ResultHtml=""; $ResultHtml=$ResultH."<br><br>";
// pageconfig and site config
if (isset($page) && $page=="config" && $useradmin==2) {include_once "../../admin/config_page.php"; } // end: Config Page
// dynamic $LeftBlock
$LeftBlockArray[0]=$LeftBlock;
$menuL="menuL"; $menuLlink="invert";
if($LeftBlockData[0]!==".php") {
for ($i=0; $i<count($LeftBlockData); $i++) {include "../../admin/Blocks/".$LeftBlockData[$i]; $LeftBlockArray[$i+1]=$Block; }
}
// dynamic $RightBlock
$menuL="menuR"; $menuLlink="menuR";
if($RightBlockData[0]==".php") {$RightBlock=""; } else {
  for ($i=0; $i<count($RightBlockData); $i++) {include "../../admin/Blocks/".$RightBlockData[$i]; $RightBlockArray[$i]=$Block;}
}
// ********************************************************************
// Call theme template output index
// ********************************************************************
include_once  "../../themes/".$ThemeName."/index.php";
?>
