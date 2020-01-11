<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
// NB! no translation finished for this file
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$LeftBlock="<span class=menuL ALIGN=CENTER><b>GALLERY MENU</b><br><br>";
error_reporting(0);
if (!session_is_registered("gaOrder")) { $gaOrder=0; session_register("gaOrder"); }
if (isset($setgaOrder)) $gaOrder=$setgaOrder;
switch ($gaOrder) {
	case 1: $QryOrder="Description"; break;
	case 2: $QryOrder="FileSize Desc"; break;
	default: $QryOrder="Date Asc"; break;
}
// ********************************************************************
// ************************ Functions
// ********************************************************************
function gaGetByID($Table,$Field,$ID) { Global $sql; $Result=mysql_query("SELECT ".$Field." FROM ".$Table." WHERE ID='".$ID."';"); if (mysql_num_rows($Result)==0) { return "WOW"; } else { $Ret=mysql_fetch_array($Result); return $Ret[$Field]; } }
function gaMakeThumb($original_file,$new_file) { global $Easy; $W=$H=120; $im = @imagecreatefromjpeg ($original_file); $size = GetImageSize ($original_file); $H1=$size[1]/($size[0]/$W); $W1=$size[0]/($size[1]/$H); if ($H1<$W1) { $H1=120; $dH=0; $dW=($W1-120)/2; } if ($H1>$W1) { $W1=120; $dW=0; $dH=($H1-120)/2; } if ($Easy["gd_version"]==2) { $im2 = @ImageCreateTrueColor ($W,$H); imagecopyresampled ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); } else { $im2 = @ImageCreate ($W,$H); imagecopyresized ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); } $black = ImageColorAllocate ($im2, 0, 0, 0); imagerectangle($im2,0,0,$W-1,$H-1,$black); ImageJpeg($im2,$new_file); }
function gaResize($original_file,$new_file) { global $Easy; if (!isset($Easy["upload_resizeX"]) or $Easy["upload_resizeX"]==0) return FALSE; $im = @imagecreatefromjpeg ($original_file); $size = GetImageSize ($original_file); $RequestedW=$Easy["upload_resizeX"]; $RequestedH=$Easy["upload_resizeY"]; $RealH=$size[1]; $RealW=$size[0]; if ($RealW<$RequestedW && $RealH<$RequestedH) return FALSE; if ($RealW>=$RealH) { $NewW=$RequestedW; $NewH=Round($RealH*(100/$RealW*$NewW)/100,0); } else { $NewH=$RequestedH; $NewW=Round($RealW*(100/$RealH*$NewH)/100,0); } if ($Easy["gd_version"]==2) { $im2 = @ImageCreateTrueColor ($NewW,$NewH); imagecopyresampled ($im2, $im, 0, 0, 0, 0, $NewW, $NewH,$RealW,$RealH); } else { $im2 = @ImageCreate ($NewW,$NewH); imagecopyresized ($im2, $im, 0, 0, 0, 0, $NewW, $NewH,$RealW,$RealH); } $black = ImageColorAllocate ($im2, 0, 0, 0); imagerectangle($im2,0,0,$NewW-1,$NewH-1,$black); ImageJpeg($im2,$new_file); return TRUE; }
function gaShowPicture($pic) { global $Easy;  if ($pic["PictureFile"]!="") {  $tmbl=split("/",$pic["PictureFile"]); if (!file_exists($Easy["media_folder"]."/".$tmbl[0]."/thumb_".$tmbl[1])) { gaMakeThumb($Easy["media_folder"]."/".$pic["PictureFile"],$Easy["media_folder"]."/".$tmbl[0]."/thumb_".$tmbl[1]); } return "<img src='".$Easy["media_folder"]."/".str_replace("/","/thumb_",$pic["PictureFile"])."' width='120' height='120' alt='".$pic["Description"]."' border='0'>"; } else { return "<img src='images/nopic.gif' width='120' height='120' alt='No picture available' border='0'>"; } }
function getDirList ($dirName) { $d = dir($dirName); while($entry = $d->read()) { if ($entry != "." && $entry != "..") { if (is_dir($dirName."/".$entry)) { $ret[$entry]=$entry; } } } $d->close(); return $ret; }
function getFileList ($dirName) { $d = dir($dirName); while($entry = $d->read()) { if ($entry != "." && $entry != "..") { if (!is_dir($dirName."/".$entry)) { if (substr($entry,0,6)!="thumb_") $ret[$entry]=$entry; } } } $d->close(); return $ret; }
function GoDelete($file) { $delete = @unlink($file); if (@file_exists($file)) { $filesys = eregi_replace("/","\\",$file); $delete = @system("del $filesys"); if (@file_exists($file)) { $delete = @chmod ($file, 0775); $delete = @unlink($file); $delete = @system("del $filesys"); } else { return TRUE; } }  else { return TRUE; } if (@file_exists($file)) { return FALSE; } else { return TRUE; } }
function puRegistered($Who){Global $Stoitsov; $ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"]){ $ret=1; }if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1){ $ret=2; } return $ret;}
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default")
{ switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n"; break;
                      case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break;
                      case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break;
                      case "file" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='file'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break;
                      case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break;
                      case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break;
                      case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break;
                      case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break;
                      case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break;
                      case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break;
                      case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break;
                      case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
function puHeading($Heading,$BR=1) { $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }
function puMyQuery($Query) { Global $sql, $language; $Res=mysql_query($Query) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query.']."","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
function puMyFetch($Query) { Global $sql, $language; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'].".","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
// function puHackers($Text) { $ret=strip_tags($Text); $ret=escapeshellcmd($ret); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret; }
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
// ********************************************************************
// ************************ Actions
// ********************************************************************
$action_log="$action=='reg_user' or $action=='edit_reg_user'  or $action=='login' or $action=='logout' or $action=='add_user' or action=='edit_user'";
if($action_log) { include_once "../../admin/login.php";} $useradmin=puRegistered($Stoitsov);
if ($action=="add_category") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($gaDisplayName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>"; if (isset($Error)) { $page="new"; $what="category"; } else { puMyQuery("INSERT INTO edp_gacategories VALUES(null,'".puHackers($gaDisplayName)."','');"); } } }
if ($action=="update_category") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($gaDisplayName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>"; if (isset($Error)) { $page="modify"; $what="category"; } else { puMyQuery("UPDATE edp_gacategories SET DisplayName='".puHackers($gaDisplayName)."' WHERE ID=$catid;"); } } }
if ($action=="set_category_picture") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { puMyQuery("UPDATE edp_gacategories SET PictureFile='".puHackers($pic)."' WHERE ID=$catid;"); } }
if ($action=="delete_category" && isset($catid)) { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { puMyQuery("DELETE FROM edp_gacategories WHERE ID=$catid;"); } }
if ($action=="add_folder") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($gaFolderName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>"; if (strlen(puHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>"; if (isset($Error)) { $page="new"; $what="folder"; $catid=$gaGrand; } else { $HDD_Name=str_replace(" ","_",strtolower(puHackers($gaFolderName))); if (mkdir ($Easy["media_folder"]."/".$HDD_Name, 0755)) { chmod ($Easy["media_folder"]."/".$HDD_Name,0777); puMyQuery("INSERT INTO edp_gamediafolders VALUES(null,'".$HDD_Name."','".puHackers($gaFolderName)."','".puHackers($gaDescription)."','0','','".$gaGrand."');"); $page="category"; $catid=$gaGrand; } } } }
if ($action=="update_folder") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($gaFolderName))<4) $Error.="<b>Name is invalid. Min 4 chars.</b><br>"; if (strlen(puHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>"; if (isset($Error)) { $page="modify"; $what="folder"; } else { puMyQuery("UPDATE edp_gamediafolders SET FolderName='".puHackers($gaFolderName)."', Description='".puHackers($gaDescription)."', Grand='".$gaGrand."' WHERE ID=$folid;"); $page="category"; $catid=$gaGrand; } } }
if ($action=="set_folder_picture") { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { puMyQuery("UPDATE edp_gamediafolders SET PictureFile='".puHackers($pic)."' WHERE ID=$folid;"); $page="category"; $catid=gaGetByID("edp_gamediafolders","Grand",$folid); } }
if ($action=="delete_folder" && isset($folid)) { if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else { if (GoDelete($Easy["media_folder"]."/".gaGetByID("edp_gamediafolders","Folder",$folid))) { $page="category"; $catid=gaGetByID("edp_gamediafolders","Grand",$folid); puMyQuery("DELETE FROM edp_gamediafolders WHERE ID=$folid;"); } } }
if ($action=="upload") {
  if (puRegistered($Stoitsov)<0) {
		$page="login";
    $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>";
  } else {
      if (!$Easy["demo_mode"]) { // mario again if (!$Easy["demo_mode"])   instead of if ($Easy["demo_mode"])
			$page="upload"; $folid=$gaFolder;
      $Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b>
              <br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
		} else {
        if (!isset($Easy["upload_fields"])) $Easy["upload_fields"]=10;
        for ($uploaded=0; $uploaded < $Easy["upload_fields"]; $uploaded++) {
				$fname="files".$uploaded;
				$itype=split("/",$_FILES[$fname]['type']);
				if ($_FILES[$fname]['size']!=0 && $itype[0]=="image" && ($itype[1]=="jpeg" OR $itype[1]=="pjpeg")) {
					$isize=getimagesize($_FILES[$fname]['tmp_name']);
					$dimensions=$isize[0]."x".$isize[1]." px";
           $MediaHDD=gaGetByID("edp_gamediafolders","Folder",$gaFolder);
           if (!gaResize($_FILES[$fname]['tmp_name'],$Easy["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])) {
           if (move_uploaded_file($_FILES[$fname]['tmp_name'], $Easy["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])) {
           puMyQuery("DELETE FROM edp_gapictures WHERE PictureFile='".$MediaHDD."/".$_FILES[$fname]['name']."';");
           puMyQuery("Insert Into edp_gapictures Values(null,'".$_FILES[$fname]['name']."','$dimensions','".Round($_FILES[$fname]['size']/1024,2)."','".$MediaHDD."/".$_FILES[$fname]['name']."','$gaFolder','".Date("Y-m-d")."');");
           if (file_exists($Easy["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name'])) {
           GoDelete($Easy["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name']);
    } } } else {
          $isize=getimagesize($Easy["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name']);
          $dimensions=$isize[0]."x".$isize[1]." px";
          $filesize=Round(filesize($Easy["media_folder"]."/".$MediaHDD."/".$_FILES[$fname]['name'])/1024,2);
          puMyQuery("DELETE FROM edp_gapictures WHERE PictureFile='".$MediaHDD."/".$_FILES[$fname]['name']."';");
          puMyQuery("Insert Into edp_gapictures Values(null,'".$_FILES[$fname]['name']."','$dimensions','".$filesize."','".$MediaHDD."/".$_FILES[$fname]['name']."','$gaFolder','".Date("Y-m-d")."');");
          if (file_exists($Easy["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name'])) {
          GoDelete($Easy["media_folder"]."/".$MediaHDD."/thumb_".$_FILES[$fname]['name']);
    } } } else { if ($itype[1]!="octet-stream") $Error="<br><font color=red><b>EasyGallery is working only with JPEG (.jpg) images!</b></font><br>"; } }
      if (isset($turn)) { $page="folder"; $folid=$gaFolder; $catid=gaGetByID("edp_gamediafolders","Grand",$folid); } else { $page="upload"; $folid=$gaFolder; }
    } } }
if ($action=="pictures" && isset($pics)) {
  if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>";
  } else { if (isset($delete)) { if (!$Easy["demo_mode"]) { // mario again if (!$Easy["demo_mode"])   instead of if ($Easy["demo_mode"])
				$page="folder";
				$Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b><br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
			} else {
				foreach ($pics as $pic) {
        $Picture=puMyFetch("SELECT PictureFile FROM edp_gapictures WHERE ID=$pic;");
        if (GoDelete($Easy["media_folder"]."/".$Picture["PictureFile"])) {
         GoDelete($Easy["media_folder"]."/".str_replace("/","/thumb_",$Picture["PictureFile"]));
         puMyQuery("DELETE FROM edp_gapictures WHERE ID=$pic;");
         puMyQuery("UPDATE edp_gacategories SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
         puMyQuery("UPDATE edp_gamediafolders SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
          } }
				$page="folder";
      } }
    if (isset($move)) {
      $NewFolder=gaGetByID("edp_gamediafolders","Folder",$gaFolder);
			foreach ($pics as $pic) {
        $Picture=puMyFetch("SELECT PictureFile FROM edp_gapictures WHERE ID=$pic;");
				$NewFile=split("/",$Picture["PictureFile"]);
        if (rename($Easy["media_folder"]."/".$Picture["PictureFile"],$Easy["media_folder"]."/".$NewFolder."/".$NewFile[1])) {
        GoDelete($Easy["media_folder"]."/".str_replace("/","/thumb_",$Picture["PictureFile"]));
        puMyQuery("UPDATE edp_gapictures SET PictureFile='".$NewFolder."/".$NewFile[1]."', Folder='".$gaFolder."' WHERE ID=$pic;");
        puMyQuery("UPDATE edp_gacategories SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
        puMyQuery("UPDATE edp_gamediafolders SET PictureFile='' WHERE PictureFile='".$Picture["PictureFile"]."';");
        } }
			$page="folder";
    } } }
if ($action=="update_picture") {
  if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>";
  } else { unset($Error);
      if (strlen(puHackers($gaDescription))<4) $Error.="<b>Description is invalid. Min 4 chars.</b><br>";
      if (isset($Error)) { $page="modify"; $what="picture";
      } else { puMyQuery("UPDATE edp_gapictures SET Date='".puHackers($gaDate)."', Description='".puHackers($gaDescription)."' WHERE ID=$picid;"); $page="folder";  }
} }
if ($action=="reindex") { //Mario  $Easy["demo_mode"] is FALSE and I have put if (!$Easy["demo_mode"]) instead of if ($Easy["demo_mode"]) and works but why?
  if (puRegistered($Stoitsov)<0) { $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>";
  } else { if (!$Easy["demo_mode"]) { $page="folder"; $catid=$gaGrand; $folid=$FolderID; $Error="<br><b><font color=red>EasyGallery is running in DEMO mode. You can not UPLOAD or DELETE Files.</font></b><br><font color=green>Install EasyGallery on your server and set DEMO MODE to FALSE!</font><br>";
      } else {
        $isExFolder=puMyQuery("SELECT ID, Folder FROM edp_gamediafolders WHERE Folder='$gaDir';");
        if (mysql_num_rows($isExFolder)!=0) {
					$Temp=mysql_fetch_array($isExFolder);
          $FolderID=$Temp["ID"];
          puMyQuery("UPDATE edp_gamediafolders SET Grand='".$gaGrand."' WHERE ID=$FolderID;");
        } else {
          puMyQuery("INSERT INTO edp_gamediafolders VALUES(null,'".$gaDir."','".puHackers($gaFolderName)."','".puHackers($gaDescription)."','0','','".$gaGrand."');");
					$FolderID=mysql_insert_id();
				}
        $Files=getFileList($Easy["media_folder"]."/".$gaDir);
				foreach ($Files as $File) {
         gaResize($Easy["media_folder"]."/".$gaDir."/".$File,$Easy["media_folder"]."/".$gaDir."/".$File);
         $isize=getimagesize($Easy["media_folder"]."/".$gaDir."/".$File);
         $dimensions=$isize[0]."x".$isize[1]." px";
         $filesize=Round(filesize($Easy["media_folder"]."/".$gaDir."/".$File)/1024,2);
         $isExPicture=puMyQuery("SELECT ID FROM edp_gapictures WHERE PictureFile='".$gaDir."/".$File."';");
          if (mysql_num_rows($isExPicture)!=0) { puMyQuery("UPDATE edp_gapictures SET PictureSize='$dimensions', FileSize='".$filesize."', Folder='$FolderID' WHERE PictureFile='".$gaDir."/".$File."';");
          } else { puMyQuery("INSERT INTO edp_gapictures VALUES(null,'".$File."','$dimensions','".$filesize."','".$gaDir."/".$File."','$FolderID','".Date("Y-m-d")."');"); } }
        $DBPics=puMyQuery("SELECT ID, PictureFile FROM edp_gapictures WHERE Folder=$FolderID;");
				while ($DBPic=mysql_fetch_array($DBPics)) {
        if (!file_exists($Easy["media_folder"]."/".$DBPic["PictureFile"])) {
          GoDelete($Easy["media_folder"]."/".str_replace("/","/thumb_",$DBPic["PictureFile"]));
          puMyQuery("DELETE FROM edp_gapictures WHERE ID=".$DBPic["ID"].";");
        } }
				$page="folder"; $catid=$gaGrand; $folid=$FolderID;
    } } }
// ********************************************************************
// **************   EasyGallery Screen Creation
// ********************************************************************
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
// Start: New
if (isset($page) && $page=="new" && isset($what)) {
  if ($what=="category" ) {
    $ResultHtml=puHeading("Add New Category",1)."Use categories to organize your Media Folders<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Category Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Category","POST")."
    <tr><td bgcolor=".$Easy["Background"]."><b>Name:</b> Max 255 chars<br> ".puElement("text","gaDisplayName","",150)."</td> </tr>
    <tr><td align=right>".puElement("submit","Create","f_button")."</td> </tr>". puElement("hidden","action","add_category").puElement()."
    </table> ".$Error."</div>";
  }
  if ($what=="folder" ) { $CatSelects=puMyQuery("SELECT * FROM edp_gacategories ORDER BY DisplayName;"); while ($CatSelect=mysql_fetch_array($CatSelects)) { $Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"]; }
    $ResultHtml=puHeading("Add New Folder",1)."Use folders as a picture containers<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Folder Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST").
   "<tr><td bgcolor=".$Easy["Background"]."><b>Create under:</b><br> ".puElement("select","gaGrand",$Categories,$catid,150)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Name:</b> Max 255 chars<br> ".puElement("text","gaFolderName","",150)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Description:</b><br> ".puElement("text","gaDescription","",300)."</td> </tr>
    <tr> <td align=right>".puElement("submit","Create","f_button")."</td> </tr>". puElement("hidden","action","add_folder").puElement()." </table>
    ".$Error."</div>";
  } }
// Start: Modify
if (isset($page) && $page=="modify" && isset($what)) {
  if ($what=="category" && isset($catid)) {
     $Edit=puMyFetch("SELECT * FROM edp_gacategories WHERE ID=$catid;");
    $ResultHtml=puHeading("Edit Category",1)."Use categories to organize your Media Folders<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Category Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Login","POST")."
    <tr><td bgcolor=".$Easy["Background"]."><b>Name:</b> Max 255 chars<br> ".puElement("text","gaDisplayName",$Edit["DisplayName"],150)."</td> </tr>
    <tr> <td align=right>".puElement("submit","Create","f_button")."</td> </tr>". puElement("hidden","catid",$catid).puElement("hidden","action","update_category").puElement()."
    </table> ".$Error."</div>";
  }
  if ($what=="folder" ) { $Edit=puMyFetch("SELECT * FROM edp_gamediafolders WHERE ID=$folid;"); $CatSelects=puMyQuery("SELECT * FROM edp_gacategories ORDER BY DisplayName;"); while ($CatSelect=mysql_fetch_array($CatSelects)) { $Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"]; }
    $ResultHtml=puHeading("Edit Folder",1)."Use folders as a picture containers<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Folder Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST").
   "<tr><td bgcolor=".$Easy["Background"]."><b>Move under:</b><br> ".puElement("select","gaGrand",$Categories,$Edit["Grand"],150)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Name:</b> Max 255 chars<br> ".puElement("text","gaFolderName",$Edit["FolderName"],150)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Description:</b><br> ".puElement("text","gaDescription",$Edit["Description"],300)."</td> </tr>
    <tr> <td align=right>".puElement("submit","Update","f_button")."</td> </tr>". puElement("hidden","folid",$folid).puElement("hidden","action","update_folder").puElement()."
    </table> ".$Error."</div>";
  }
  if ($what=="picture" && isset($picid)) {
    $Edit=puMyFetch("SELECT * FROM edp_gapictures WHERE ID=$picid;");
    $ResultHtml=puHeading("Edit Picture",1)."Your pictures on the net<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Picture Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Login","POST")."
    <tr><td align=center bgcolor=".$Easy["LightColor1"].">".gaShowPicture($Edit)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Description:</b><br> ".puElement("text","gaDescription",$Edit["Description"],150)."</td> </tr>
    <tr><td bgcolor=".$Easy["Background"]."><b>Date:</b><br> ".puElement("text","gaDate",$Edit["Date"],150)."</td> </tr>
    <tr> <td align=right>".puElement("submit","Update","f_button")."</td> </tr>". puElement("hidden","catid",$catid).puElement("hidden","folid",$folid).puElement("hidden","picid",$picid).puElement("hidden","action","update_picture").puElement()."
    </table> ".$Error."</div>";
  }
}
// Start: Choose Picture
if (isset($page) && $page=="choosefront" && isset($for)) {
  if ($for=="category" && isset($catid)) {
     $ResultHtml=puHeading("\"".gaGetByID("edp_gacategories","DisplayName",$catid)."\" Category",1).
		"Click on a picture to become Category Cover<br><br>";
		if (!isset($from)) $from=0;
     $TotalPictures=mysql_num_rows(puMyQuery("SELECT * FROM edp_gamediafolders as t1, edp_gapictures as t2 WHERE t1.Grand=$catid AND t2.Folder=t1.ID;"));
     $Choices=puMyQuery("SELECT * FROM edp_gamediafolders as t1, edp_gapictures as t2 WHERE t1.Grand=$catid AND t2.Folder=t1.ID LIMIT $from,".$Easy["pics_per_page"].";");
		while ($Choose=mysql_fetch_array($Choices)) {
     $ResultHtml.="<a href='$EDP_SELF&action=set_category_picture&pic=".$Choose["PictureFile"]."&catid=$catid'>".gaShowPicture($Choose)."</a> ";
    }
		$ResultHtml.= "<br><br><div align=center>";
     if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=choosefront&for=category&catid=$catid&from=".($from-$Easy["pics_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
     if ($TotalPictures>$from+$Easy["pics_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=choosefront&for=category&catid=$catid&folid=$folid&from=".($from+$Easy["pics_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
		$ResultHtml.= "</div>";
  }
  if ($for=="folder" && isset($folid)) {
     $ResultHtml=puHeading("\"".gaGetByID("edp_gamediafolders","FolderName",$folid)."\" Media Folder",1). "Click on a picture to become Media Folder Cover<br><br>";
		if (!isset($from)) $from=0;
    $TotalPictures=mysql_num_rows(puMyQuery("SELECT * FROM edp_gapictures WHERE Folder=$folid;"));
    $Choices=puMyQuery("SELECT * FROM edp_gapictures WHERE Folder=$folid LIMIT $from,".$Easy["pics_per_page"].";");
		while ($Choose=mysql_fetch_array($Choices)) {
    $ResultHtml.="<a href='$EDP_SELF&action=set_folder_picture&pic=".$Choose["PictureFile"]."&folid=$folid'>".gaShowPicture($Choose)."</a> ";
    }
		$ResultHtml.= "<br><br><div align=center>";
    if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=choosefront&for=folder&folid=$folid&from=".($from-$Easy["pics_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
    if ($TotalPictures>$from+$Easy["pics_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=choosefront&for=folder&folid=$folid&folid=$folid&from=".($from+$Easy["pics_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
		$ResultHtml.= "</div>";
  }
}
// Start: Upload

if (isset($page) && $page=="upload") {
    $CatSelects=puMyQuery("SELECT t1.ID as FID, t1.FolderName, t2.DisplayName FROM edp_gamediafolders as t1, edp_gacategories as t2 WHERE t2.ID=t1.Grand ORDER BY t2.DisplayName, t1.FolderName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
    $Categories[$CatSelect["FID"]]=$CatSelect["DisplayName"]." > ".$CatSelect["FolderName"];
    }
    if (!isset($Easy["upload_fields"])) $Easy["upload_fields"]=10;
    $ResultHtml=puHeading("Upload pictures",1)."Your pictures on the net<br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
    <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Upload Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Upload","POST","enctype='multipart/form-data'").
   "<tr><td bgcolor=".$Easy["Background"]."><b>Upload under:</b><br> ".puElement("select","gaFolder",$Categories,$folid,300)."</td> </tr>";
    for ($pics=0; $pics<$Easy["upload_fields"]; $pics++) {
      $ResultHtml.= "<tr> <td bgcolor=".$Easy["Background"]." align=right><b>".($pics+1).".</b> ".puElement("file","files".$pics,"",280)."</td>
		</tr>";
    }
    $ResultHtml.="<tr><td bgcolor=".$Easy["Background"]." align=center> ".puElement("checkbox","turn","yes")." After upload go to the upload folder</td> </tr>
    <tr> <td align=right>".puElement("submit","Upload","f_button")."</td> </tr>". puElement("hidden","MAX_FILE_SIZE",(1024*1024*1024)).puElement("hidden","action","upload").puElement()."
		</table>
		".$Error."<br>* <b>Note</b>: Upload speed depends on your Internet connection speed.<br>You may need to wait for a while after pressing the Upload button.<br><i>You <b>do not</b> need to fill all fields.</i></div>";
}
// Start: Reindex
if (isset($page) && $page=="reindex") { $CatSelects=puMyQuery("SELECT * FROM edp_gacategories ORDER BY DisplayName;"); while ($CatSelect=mysql_fetch_array($CatSelects)) { $Categories[$CatSelect["ID"]]=$CatSelect["DisplayName"]; }
  $Dirs=getDirList($Easy["media_folder"]."/");
  $ResultHtml=puHeading("Reindex",1)."Searches for new pictures, uploaded via FTP<br><br>
	<div align=center>
  <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
  <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: Reindex Information</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST").
 "<tr><td bgcolor=".$Easy["Background"]."><b>Found Directories:</b><br> ".puElement("select","gaDir",$Dirs,"",150)."</td> </tr>
  <tr><td bgcolor=".$Easy["Background"]."><b>Move under:</b><br> ".puElement("select","gaGrand",$Categories,$Edit["Grand"],150)."</td> </tr>
  <tr><td bgcolor=".$Easy["Background"]."><b>Name:</b> Max 255 chars<br> ".puElement("text","gaFolderName",$Edit["FolderName"],150)."</td> </tr>
  <tr><td bgcolor=".$Easy["Background"]."><b>Description:</b><br> ".puElement("text","gaDescription",$Edit["Description"],300)."</td> </tr>
  <tr><td align=right>".puElement("submit","Start","f_button")."</td> </tr>". puElement("hidden","action","reindex").puElement()."
	</table><div align=center>This is a slow procedure. You may wait for a while - depending on picture sizes.</div>
  ".$Error."</div>";
}
// Start: Folders View
if (isset($page) && $page=="category" && isset($catid)) {
  $ResultHtml=puHeading(gaGetByID("edp_gacategories","DisplayName",$catid)." Folders",1). "<b>Navigation </b><img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF' class=normal>Categories</a>
  <img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'>".gaGetByID("edp_gacategories","DisplayName",$catid)." Folders<br><br>";
	if (!isset($from)) $from=0;
  $TotalFolders=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gamediafolders WHERE Grand=$catid;"));
  $Folders=puMyQuery("SELECT * FROM edp_gamediafolders WHERE Grand=$catid ORDER BY FolderName LIMIT $from,".$Easy["cats_per_page"].";");
  $ResultHtml.= "<br><table  border=0 cellspacing=3 align=center>";
	$i=0;
	while ($Folder=mysql_fetch_array($Folders)) {
    $i++; if ($i==1) { $ResultHtml.="<tr>";  }
    $ResultHtml.= "<td align=center width=130 valign=top ><a href='$EDP_SELF&page=folder&catid=$catid&folid=".$Folder["ID"]."' class=normal> ".gaShowPicture($Folder)."</a><br>";
    if (puRegistered($Stoitsov)==2) { $toDelete=0;
     $toDelete=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gapictures WHERE Folder=".$Folder["ID"].";"));
     $ResultHtml.="<a href='$EDP_SELF&page=choosefront&for=folder&folid=".$Folder["ID"]."'><img src='images/picture.gif' width='60' height='14' alt='Select Picture for this Folder' border='0'></a>".
     "<a href='$EDP_SELF&page=modify&what=folder&folid=".$Folder["ID"]."'><img src='images/modify.gif' width='60' height='14' alt='Modify this Folder' border='0'></a><br>".
     ($toDelete!=0 ? "" : "<a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete_folder&folid=".$Folder["ID"]."','Are you sure you want to delete?');\"><img src='images/delete.gif' width='60' height='14' alt='Delete this Folder' border='0'></a><br>" )." ";
    }
    $ResultHtml.="<a href='$EDP_SELF&page=folder&catid=$catid&folid=".$Folder["ID"]."' class=normal><b>".$Folder["FolderName"]."</b><br><i>".$Folder["Description"]."</i></a></td>";
    if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
  }
  if ($i!=0) { for ($m=$i; $m<4; $m++) {$ResultHtml.= "<td>&nbsp;</td>";}  $ResultHtml.= "</tr>"; }
  $ResultHtml.= "<tr><td colspan=4 align=center><br>";
        if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=category&catid=$catid&from=".($from-$Easy["cats_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
        if ($TotalFolders>$from+$Easy["cats_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=category&catid=$catid&from=".($from+$Easy["cats_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
  $ResultHtml.= "</td></tr></table>".$Error;
}
// Start: Pictures View
if (isset($page) && $page=="folder" && isset($catid) && isset($folid) ) {
        $ResultHtml=puHeading(gaGetByID("edp_gamediafolders","FolderName",$folid)." Pictures",1).
        "<b>Navigation </b><img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF' class=normal>Categories</a>
        <img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=category&catid=$catid' class=normal>".gaGetByID("edp_gacategories","DisplayName",$catid)."</a>
        <img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'>".gaGetByID("edp_gamediafolders","FolderName",$folid)." Pictures
	<br><br>";
	if (!isset($from)) $from=0;
        $TotalPictures=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gapictures WHERE Folder=$folid;"));
        $Pictures=puMyQuery("SELECT * FROM edp_gapictures WHERE Folder=$folid ORDER BY ".$QryOrder." LIMIT $from,".$Easy["pics_per_page"].";");
  $ResultHtml.= "<br><table  border=0 cellspacing=3 align=center>";
  if (puRegistered($Stoitsov)==2) {
        $ResultHtml.=puElement("form",$EDP_SELF,"POST");
        $CatSelects=puMyQuery("SELECT t1.ID as FID, t1.FolderName, t2.DisplayName FROM edp_gamediafolders as t1, edp_gacategories as t2 WHERE t2.ID=t1.Grand ORDER BY t2.DisplayName, t1.FolderName;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$Categories[$CatSelect["FID"]]=$CatSelect["DisplayName"]." > ".$CatSelect["FolderName"];
    }
  }
	$i=0;
  while ($Picture=mysql_fetch_array($Pictures)) { $i++;
    if ($i==1) $ResultHtml.="<tr>";
		$picSize=split("x",substr($Picture["PictureSize"],0,strlen($Picture["PictureSize"])-3));
		$picW=$picSize[0]; $picH=$picSize[1];
    $ResultHtml.= "<td align=center width=130 valign=top><a href='#' OnClick=\"javascript:PicWindow('$EDP_SELF&picture=".$Picture["ID"]."',$picW,$picH);\" class=normal> ".gaShowPicture($Picture)."</a><br>";
    if (puRegistered($Stoitsov)==2) {
    $ResultHtml.="<a href='$EDP_SELF&page=modify&what=picture&picid=".$Picture["ID"]."&catid=$catid&folid=$folid'><img src='images/modify.gif' width='60' height='14' alt='Modify this Picture' border='0' align=left hspace=5></a> <input type=checkbox name=pics[] value=".$Picture["ID"].">Select<br>";
		}
    $ResultHtml.="<a href='#' OnClick=\"javascript:PicWindow('$EDP_SELF&picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>".
		$Picture["Description"]."<br>".$Picture["PictureSize"]."<br>".$Picture["FileSize"]."kb ".$Picture["Date"]."</a></td>";
		if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
  }
  if ($i!=0) { for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>"; $ResultHtml.= "</tr>"; }
  if (puRegistered($Stoitsov)==2) {
	$ResultHtml.= "<tr>
    <td colspan=2 align=center bgcolor='".$Easy["LightColor1"]."'>".puElement("select","gaFolder",$Categories,$folid,200)." <input type=submit name=move value='Move' class=f_text></td>
    <td colspan=2 align=center bgcolor='".$Easy["LightColor1"]."'><input type=submit name=delete value='Delete' class=f_text></td>".
    puElement("hidden","catid",$catid).puElement("hidden","folid",$folid).
    puElement("hidden","action","pictures").puElement()."</tr>";
	}
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
        if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=folder&catid=$catid&folid=$folid&from=".($from-$Easy["pics_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
        if ($TotalPictures>$from+$Easy["pics_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=folder&catid=$catid&folid=$folid&from=".($from+$Easy["pics_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// Start: Search View
if (isset($page) && $page=="search" && isset($search)) {
  $search=puHackers($search);
  $ResultHtml=puHeading("Search Results",1).
	"Searched for: <b>$search</b><br><br>";
	if (!isset($from)) $from=0;
        $TotalPictures=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gapictures WHERE Description like '%".$search."%';"));
        $Pictures=puMyQuery("SELECT * FROM edp_gapictures WHERE Description like '%".$search."%' ORDER BY ".$QryOrder." LIMIT $from,".$Easy["pics_per_page"].";");
  $ResultHtml.= "<br><table  border=0 cellspacing=3 align=center>";
	$i=0;
  while ($Picture=mysql_fetch_array($Pictures)) { $i++;
    if ($i==1) $ResultHtml.="<tr>";
		$picSize=split("x",substr($Picture["PictureSize"],0,strlen($Picture["PictureSize"])-3));
		$picW=$picSize[0]; $picH=$picSize[1];
    $ResultHtml.= "<td align=center width=130 valign=top><a href='#' OnClick=\"javascript:PicWindow('$EDP_SELF&picture=".$Picture["ID"]."',$picW,$picH);\" class=normal> ".gaShowPicture($Picture)."</a><br>";
    $ResultHtml.="<a href='#' OnClick=\"javascript:PicWindow('$EDP_SELF&picture=".$Picture["ID"]."',$picW,$picH);\" class=normal>".
		$Picture["Description"]."<br>".$Picture["PictureSize"]."<br>".$Picture["FileSize"]."kb ".$Picture["Date"]."</a></td>";
		if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
  }
  if ($i!=0) { for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>"; $ResultHtml.= "</tr>"; }
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
  if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=search&search=$search&from=".($from-$Easy["pics_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
  if ($TotalPictures>$from+$Easy["pics_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=search&search=$search&from=".($from+$Easy["pics_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// Start: Main Page (Categories View)
if (strlen($ResultHtml)==0) {
  $ResultHtml=puHeading("Available Categories",1). "<b>Navigation: </b><img src='images/menu_itema.gif' width='9' height='8' alt='' border='0'>Categories<br><br>";
	if (!isset($from)) $from=0;
  $TotalCategories=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gacategories;"));
  $Categories=puMyQuery("SELECT * FROM edp_gacategories ORDER BY DisplayName LIMIT $from,".$Easy["cats_per_page"].";");
  $ResultHtml.= "<br><table  border=0 cellspacing=3 align=center>";
	$i=0;
  while ($Category=mysql_fetch_array($Categories)) { $i++;
   if ($i==1) $ResultHtml.="<tr>";
   $ResultHtml.= "<td align=center width=130 valign=top><a href='$EDP_SELF&page=category&catid=".$Category["ID"]."' class=normal> ".gaShowPicture($Category)."</а><br>";
   if (puRegistered($Stoitsov)==2) { $toDelete=0;
    $toDelete=mysql_num_rows(puMyQuery("SELECT ID FROM edp_gamediafolders WHERE Grand=".$Category["ID"].";"));
    $ResultHtml.="<a href='$EDP_SELF&page=choosefront&for=category&catid=".$Category["ID"]."'><img src='images/picture.gif' width='60' height='14' alt='Select Picture for this Category' border='0'></a>".
    "<a href='$EDP_SELF&page=modify&what=category&catid=".$Category["ID"]."'><img src='images/modify.gif' width='60' height='14' alt='Modify this Category' border='0'></a><br>".
    ($toDelete!=0 ? "" : "<a href=\"#\" onClick=\"javascript:YesNo('$EDP_SELF&action=delete_category&catid=".$Category["ID"]."','Are you sure you want to delete?');\"><img src='images/delete.gif' width='60' height='14' alt='Delete this Category' border='0'></a><br>" )." ";
    }
    $ResultHtml.="<a href='$EDP_SELF&page=category&catid=".$Category["ID"]."' class=normal>".$Category["DisplayName"]."</a></td>";
    if ($i==4) { $ResultHtml.= "</tr>"; $i=0; }
}
  if ($i!=0) { for ($m=$i; $m<4; $m++) $ResultHtml.= "<td>&nbsp;</td>"; $ResultHtml.= "</tr>"; }
	$ResultHtml.= "<tr><td colspan=4 align=center><br>";
   if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&from=".($from-$Easy["cats_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='Previous Page' border='0'></a>";
   if ($TotalCategories>$from+$Easy["cats_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&from=".($from+$Easy["cats_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='Next Page' border='0' hspace=4></a>";
	$ResultHtml.= "</td></tr></table>".$Error;
}
// ********************************************************************
// ********************** BuildmenuL
// ********************************************************************
$Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>Users (Login)</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".ucwords($Stoitsov["puScreenName"])." (Logout)</a>" );
if (puRegistered($Stoitsov)==2) {
  $Adminmenu="<br><span class=menuL><b>Admin menu</b></span><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>Add user</a><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>Manage users</a><br>
        <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=new&what=category' class=invert>New Category</a><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=new&what=folder&catid=$catid' class=invert>New Folder</a><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=upload&catid=$catid&folid=$folid' class=invert>Upload new pictures</a><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=reindex&catid=$catid&folid=$folid' class=invert>Reindex FTP uploads</a>
        <br>
        <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easygallery/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>Edit Page</a><br>
        <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easygallery/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>Site Config</a>";
} elseif (puRegistered($Stoitsov)<1) {
  $Adminmenu.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=register&do=reg_user' class=menuL>Please register</a>";
}
$user=$Easy["user"];
if ($user == 1) {
$user="Currently there is:<br>&nbsp;<font color=red><b>".$user."</font></b> User Online";
} else {
$user="Currently there are:<br>&nbsp;<font color=red><b>".$user."</font></b> Users Online";
}
$gamenuL="<b>Categories & Folders</b><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF' class=invert>Available Categories</a><br>";
$Categories=puMyQuery("SELECT * FROM edp_gacategories ORDER BY DisplayName;");
	while ($Category=mysql_fetch_array($Categories)) {
    $gamenuL.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=category&catid=".$Category["ID"]."' class=invert><b>".$Category["DisplayName"]."</b></a><br>\n";
    if (isset($catid) && $catid==$Category["ID"]) { $Folders=puMyQuery("SELECT * FROM edp_gamediafolders WHERE Grand=$catid ORDER BY FolderName;");
    while ($Folder=mysql_fetch_array($Folders)) { $gamenuL.=puTr(9,8)."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=folder&catid=".$Category["ID"]."&folid=".$Folder["ID"]."' class=invert>".$Folder["FolderName"]."</a><br>\n"; }
    }
  }
$gamenuL.="
<br><b>Picture`s order</b><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=$page&catid=$catid&folid=$folid&From=$From&setgaOrder=0' class=invert>By Date</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=$page&catid=$catid&folid=$folid&&From=$From&setgaOrder=1' class=invert>By Description</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=$page&catid=$catid&folid=$folid&&From=$From&setgaOrder=2' class=invert>By Size</a><br><br>
".puElement("form",$EDP_SELF,"SEARCH","GET")."
<b>Search for</b><br> ".puElement("text","search",$search,100).puElement("hidden","page","search").puElement("submit","Go").puElement();
if (isset($picture)) {
    $Picture=puMyFetch("SELECT * FROM edp_gapictures WHERE ID=$picture;");
    $size=getimagesize($Easy["media_folder"]."/".$Picture["PictureFile"]);
    echo "<table  border=0 cellspacing=0 cellpadding=0 width=100% height=96%><tr><td align=center>".
    "<table  border=0 cellspacing=1 cellpadding=2 width=1 bgcolor=".$Easy[$PageSection].">\n".
    "<tr><td colspan=3 bgcolor=".$Easy[$PageSection]."><font color=".$Easy["LightColor1"]."><b>Picture \"".$Picture["Description"]."\"</b></font></td></tr>".
    "<tr><td colspan=3 bgcolor=".$Easy["LightColor1"]."><a href='javascript:window.close();'>
    <img src=\"".$Easy["media_folder"]."/".$Picture["PictureFile"]."\" ".$size[3]." alt=\"".$Picture["FileSize"]." kb\" border=\"0\"></a><br></td></tr>".
    "<tr><td colspan=3 align=center><font color=".$Easy["LightColor1"]."><b>".$Picture["Description"]."</b></font></td></tr>\n".
    "<tr><td bgcolor=".$Easy["LightColor1"]." align=center>".$Picture["Date"]."</td><td bgcolor=".$Easy["LightColor1"]." align=center>".$Picture["PictureSize"]."</td><td bgcolor=".$Easy["LightColor1"]." align=center>".$Picture["FileSize"]." kb</td></tr>".
    "<tr><td colspan=3 bgcolor=".$Easy["LightColor1"]." align=center><a href='javascript:window.close();' class=normal>Close Picture</a></td></tr>\n";
    "</table></td></tr></table>";
	echo "</body></html>";
	exit;
}
$LeftBlock.=$gamenuL;
$LeftBlock.="<br><br><div><a href='http://myio.net/software/products/description.php?software=EasyGallery' target=_stoitsov><img src='images/EasyGalleryLogo_big.gif' height='90' width='105'  alt='EasyGallery!' border='0'></a></div><br>";
// ********************************************************************
// ********************** Left Center Right Blocks
// ********************************************************************
// Center Blocks $ResultHtml
//$ResultH.=$ResultHtml."<br>"; $ResultHtml=""; $ResultHtml=$ResultH;
// pageconfig and site config
if (isset($page) && $page=="config" && $useradmin==2) { include_once "../../admin/config_page.php"; } // end: Config Page
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
// Call theme template output index
include_once  "../../themes/".$ThemeName."/index.php";
?>
