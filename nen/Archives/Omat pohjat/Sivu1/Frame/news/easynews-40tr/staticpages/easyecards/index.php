<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$LeftBlock="<span class=menuL ALIGN=CENTER><b>".$language['E-CARDS MENU']."</b><br><br>";
error_reporting(0); $Num_Steps=5;
// ********************************************************************
// ********************** Functions
// ********************************************************************
function puMakeThumb($original_file,$new_file) { global $Easy; $W=$H=100; $im = @imagecreatefromjpeg ($original_file); $size = GetImageSize ($original_file); $H1=$size[1]/($size[0]/$W); $W1=$size[0]/($size[1]/$H); if ($H1<$W1) { $H1=$H; $dH=0; $dW=($W1-$W)/2; } if ($H1>$W1) { $W1=$W; $dW=0; $dH=($H1-$H)/2; } if ($Easy["gd_version"]==2) { $im2 = @ImageCreateTrueColor ($W,$H); imagecopyresampled ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); } else { $im2 = @ImageCreate ($W,$H); imagecopyresized ($im2, $im, 0-$dW, 0-$dH, 0, 0, $W1, $H1,$size[0],$size[1]); } $black = ImageColorAllocate ($im2, 0, 0, 0); imagerectangle($im2,0,0,$W-1,$H-1,$black); ImageJpeg($im2,$new_file); }
function puShowPicture($pic) { global $Easy;  $tmbl=split("/",$pic); if (!file_exists("./".$tmbl[1]."/".$tmbl[2]."/thumb_".$tmbl[3])) { puMakeThumb($pic,"./".$tmbl[1]."/".$tmbl[2]."/thumb_".$tmbl[3]); } return "<img src='./".$tmbl[1]."/".$tmbl[2]."/thumb_".$tmbl[3]."' width='100' height='100' alt='Choose picture' border='0'>"; }
function pugetFileCount ($dirName) { $d = dir($dirName); $ret=0; while($entry = $d->read()) { if ($entry != "." && $entry != "..") { if (!is_dir($dirName."/".$entry)) { if (substr($entry,0,6)!="thumb_") $ret++; } } } $d->close(); return $ret; }
function pugetDirList ($dirName) { $d = dir($dirName); while($entry = $d->read()) { if ($entry != "." && $entry != "..") { if (is_dir($dirName."/".$entry)) { $ret[$entry]=ucwords($entry)." (".pugetFileCount($dirName."/".$entry).")"; } } } $d->close(); asort($ret); return $ret; }
function pugetFileList ($dirName) { $d = dir($dirName); $i=-1; while($entry = $d->read()) { if ($entry != "." && $entry != "..") { if (!is_dir($dirName."/".$entry)) { if (substr($entry,0,6)!="thumb_") { $i++; $ret[$i]=$dirName."/".$entry; } } }   } $d->close(); return $ret; }
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
function puRegistered($Who){Global $Stoitsov;$ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"]){ $ret=1; }if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1){ $ret=2; } return $ret;}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") { switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional." >\n"; break; case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break; case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text' ".$Class.$ID." name='".$Name."' value='".$Value."' ".$Width.$Aditional.">\n"; break; case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break; case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break; case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break; case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break; case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break; case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
function puHeading($Heading,$BR=1) { if ($BR!=0) $ret="&nbsp;&nbsp;&nbsp;"; $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }
function puMyQuery($Query) { Global $sql, $language; $Res=mysql_query($Query) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query.']."","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
function puMyFetch($Query) { Global $sql, $language; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'].".","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
// function puHackers($Text) { $ret=strip_tags($Text); $ret=escapeshellcmd($ret); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret; }
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
// ********************************************************************
// ************************ Actions
// ********************************************************************
$action_log="$action=='reg_user' or $action=='edit_reg_user'  or $action=='login' or $action=='logout' or $action=='add_user' or action=='edit_user'";
if($action_log) { include_once "../../admin/login.php";} $useradmin=puRegistered($Stoitsov);
// ********************************************************************
// **************   EasyCards Screen Creation
// ********************************************************************
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
if (isset($setPreview)) { $step=4; }
if ($step==5) {
  $sid=md5(uniqid (rand())); $addr="http://".$HTTP_HOST.$EDP_SELF."&show=pickup&sid=".$sid;
  $message="\n".$language['Dear']." $RecipientName,\n\n$SenderName ($SenderMail) ".$language['has sent you a Greeting card']."!\n".$language['You may pick it up here'].":\n\n$addr\n\n".$language['You can also send greetings from our site']."! ".$language['Check it out - it is free'].".\n\n------------------------------------\n".$language['Date'].": ".date("d.m.Y")."\n\n";
  mail($RecipientMail, $RecipientName.", ".$SenderName." ".$language['has sent you a Greeting card']."!", $message,$language['From'].": ".$SenderName."\n".$language['Reply-To:']." ".$SenderMail."\n".$language['X-Mailer: Easy E-Cards (software.stoitsov.com)']);
  puMyQuery("INSERT INTO edp_cacards VALUES(null,'$RecipientName','$SenderName','$FirstLine','$Text','$LastLine','$Music','$TextFont','$TextColor','$BackColor','$sid','".date("Y-m-d")."','".$dir."/".$pic.".jpg','$type');");
  $isExist=puMyQuery("SELECT ID FROM edp_catop WHERE Picture='".$dir."/".$pic.".jpg' LIMIT 1;");
  if (mysql_num_rows($isExist)!=0) { puMyQuery("UPDATE edp_catop SET Hits=Hits+1 WHERE Picture='".$dir."/".$pic.".jpg';");
  } else { puMyQuery("INSERT INTO edp_catop VALUES (null,'".$dir."','$type','".$dir."/".$pic.".jpg',1);"); }
}
// Wizard Heading (Same for all pages)
if (isset($step) && $step>0 && $step<=$Num_Steps) { $Steps=Array('',$language['Select a picture for your greeting card'],$language['Greeting card sender & recipient'],$language['Greetings text'],$language['Decorate your Greeting card'],$language['Send confirmation']); $ResultHtml=puHeading($language['E-card creation wizard'],1)." ".$language['Step']." ".$step." ".$language['of']." ".$Num_Steps.": ".$Steps[$step]."<br><br>"; }
// Wizard Step 1: Choose picture
if (isset($step) && $step==1) {
  $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Step']." 1</b>";
	if (!isset($from)) $from=0;
  $Pictures=pugetFileList(($type==1 ? "./horiz/" : "./vert/" ).$dir);
  if (($from+$Easy["pics_per_page"])>count($Pictures)) { $to=count($Pictures); } else { $to=$from+$Easy["pics_per_page"]; }
	$ResultHtml.="<div align=center>";
  for ($t=$from; $t<$to; $t++) { $Temp=split("/",$Pictures[$t]); $Pic=substr($Temp[3],0,strlen($Temp[3])-4); $ResultHtml.="<a href='$EDP_SELF&step=2&dir=$dir&type=$type&pic=".$Pic."'>".puShowPicture($Pictures[$t])."</a> "; }
	$ResultHtml.="<br><br>
        ".($from!=0 ? "<a href='$EDP_SELF&step=1&dir=$dir&type=$type&from=".($from-$Easy["pics_per_page"])."'><img src='images/prev.gif' width='89' height='14' alt='".$language['Jump backward']."' border='0'></a> " : "" )."
        ".($to<count($Pictures) ? "<a href='$EDP_SELF&step=1&dir=$dir&type=$type&from=".($from+$Easy["pics_per_page"])."'><img src='images/next.gif' width='68' height='14' alt='".$language['Jump forward']."' border='0'></a>" : "" )."
	</div>";
}
// Wizard Step 2: Sender & recipient
if (isset($step) && $step==2) { $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a> <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=1&dir=$dir&type=$type' class=normal>".$language['Step']." 1</a> <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Step']." 2</b>";
  $ResultHtml.="<table  border=0> ".puElement("form",$EDP_SELF)."
  <tr>
    <td><b>".$language['Your name'].":</b><br>".puElement("text","SenderName",$SenderName,200)."</td>
    <td><b>".$language['Your e-mail'].":</b><br>".puElement("text","SenderMail",$SenderMail,200)."</td>
  </tr>
  <tr>
    <td><b>".$language['Recipients name'].":</b><br>".puElement("text","RecipientName",$RecipientName,200)."</td>
    <td><b>".$language['Recipients e-mail'].":</b><br>".puElement("text","RecipientMail",$RecipientMail,200)."</td>
  </tr>
  <tr>
    <td colspan=2 align=right>".puElement("submit",$language['Next'])."</td>
  </tr>".
  puElement("hidden","dir",$dir).puElement("hidden","type",$type).puElement("hidden","step",3).puElement("hidden","pic",$pic).puElement()."</table>";
}
// Wizard Step 3: The Text
if (isset($step) && $step==3) {
  $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=1&dir=$dir&type=$type' class=normal>".$language['Step']." 1</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=2&dir=$dir&type=$type&pic=$pic&SenderName=$SenderName&SenderMail=$SenderMail&RecipientName=$RecipientName&RecipientMail=$RecipientMail' class=normal>".$language['Step']." 2</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Step']." 3</b>";
  $size = GetImageSize ("./".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg");
  $ResultHtml.="<table  border=0 cellspacing=0 cellpadding=2  bgcolor='".$Easy["LightColor1"]."'>".puElement("form",$EDP_SELF)."
  <tr bgcolor='".$Easy[$PageSection]."'>
  <td>&nbsp;&nbsp;".puHeading("<font color='".$Easy["LightColor2"]."'>".$language['Greeting card']."</font>",1)."&nbsp;&nbsp;<font color='".$Easy["LightColor2"]."'>".$language['From']." <b>$SenderName</b></font></td>
  <td align=right><a href='http://myio.net/software' target=_stoitsov><img src='images/stoitsov2.gif' width='150' height='27' alt='".$language['Delivered by Stoitsov.com']."' border='0'></a></td> </tr>";
if ($type==1) {
  $ResultHtml.="
   <tr><td align=center colspan=2><br><img src='".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br><br></td> </tr>
   <tr> <td colspan=2 align=center><br><b>".$language['First Line'].":</b> (".$language['ex. Dear John Doe'].")<br>".puElement("text","FirstLine",$FirstLine,400)."</td> </tr>
   <tr> <td colspan=2 align=center><br><b>".$language['Greetings text'].":</b> (".$language['Hit enter for a new line'].")<br>".puElement("textarea","Text",$Text,400,5)."</td> </tr>
   <tr> <td colspan=2 align=center><br><b>".$language['Last Line'].":</b> (".$language['ex. Best Wishes'].")<br>".puElement("text","LastLine",$LastLine,400)."<br><br></td> </tr>";
  } else {
  $ResultHtml.="<tr>
      <td align=center><br><img src='".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br /><br></td>
      <td align=center><br><b>".$language['First Line'].":</b> (".$language['ex. Dear John Doe'].")<br>".puElement("text","FirstLine",$FirstLine,250)."<br>
      <br><b>".$language['Greetings text'].":</b> (".$language['Hit enter for a new line'].")<br>".puElement("textarea","Text",$Text,250,15)."<br>
      <br><b>".$language['Last Line'].":</b> (".$language['ex. Best Wishes'].")<br>".puElement("text","LastLine",$LastLine,250)."<br><br></td>
  </tr>";
	}
  $ResultHtml.="<tr> <td align=right colspan=2  bgcolor='".$Easy[$PageSection]."'>".puElement("submit",$language['Next'])."</td> </tr>".
  puElement("hidden","dir",$dir).puElement("hidden","type",$type).puElement("hidden","step",4).puElement("hidden","pic",$pic).
  puElement("hidden","SenderName",$SenderName).puElement("hidden","SenderMail",$SenderMail).puElement("hidden","RecipientName",$RecipientName).puElement("hidden","RecipientMail",$RecipientMail).puElement()
	."</table>";
}
// Wizard Step 4: Decoration
if (isset($step) && $step==4) {
  $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=1&dir=$dir&type=$type' class=normal>".$language['Step']." 1</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=2&dir=$dir&type=$type&pic=$pic&SenderName=$SenderName&SenderMail=$SenderMail&RecipientName=$RecipientName&RecipientMail=$RecipientMail' class=normal>".$language['Step']." 2</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=3&dir=$dir&type=$type&pic=$pic&SenderName=$SenderName&SenderMail=$SenderMail&RecipientName=$RecipientName&RecipientMail=$RecipientMail&FirstLine=$FirstLine&Text=$Text&LastLine=$LastLine' class=normal>".$language['Step']." 3</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Step']." 4</b>";
  $size = GetImageSize ("./".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg");
  $ResultHtml.="<table  border=0 cellspacing=0 cellpadding=2 bgcolor='$BackColor'>".puElement("form",$EDP_SELF)."
  <tr bgcolor='".$Easy[$PageSection]."'>
  <td>&nbsp;&nbsp;".puHeading("<font color='".$Easy["LightColor2"]."'>".$language['Greeting card']."</font>",1)."&nbsp;&nbsp;<font color='".$Easy["LightColor2"]."'>".$language['From']." <b>$SenderName</b></font></td>
  <td align=right><a href='http://myio.net/software' target=_stoitsov><img src='images/stoitsov2.gif' width='150' height='27' alt='".$language['Delivered by Stoitsov.com']."' border='0'></a></td> </tr>";
  if ($type==1) {
  $ResultHtml.="
    <tr> <td align=center colspan=2><br><img src='".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br><br></td> </tr>
    <tr> <td colspan=2><br><UL><b><i><font face='$TextFont' color='$TextColor'>$FirstLine</font></i></b> <p><font face='$TextFont' color='$TextColor'>".nl2br($Text)."</font></p> <i><font face='$TextFont' color='$TextColor'>$LastLine</i></font><br><br> <b><font face='$TextFont' color='$TextColor'>$SenderName</b></font></UL></td> </tr>";
  } else {
    $ResultHtml.="
    <tr>
			<td align=center><img src='".($type==1 ? "./horiz/" : "./vert/" ).$dir."/".$pic.".jpg' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br></td>
			<td><UL><b><i><font face='$TextFont' color='$TextColor'>$FirstLine</font></i></b>
			<p><font face='$TextFont' color='$TextColor'>".nl2br($Text)."</font></p>
			<i><font face='$TextFont' color='$TextColor'>$LastLine</i></font><br><br>
      <b><font face='$TextFont' color='$TextColor'>$SenderName</b></font></UL></td>
		</tr>";
	}
  $ResultHtml.="<tr> <td align=right colspan=2  bgcolor='".$Easy[$PageSection]."'>".puElement("submit",$language['Send card'])."</td> </tr>".
  puElement("hidden","dir",$dir).puElement("hidden","type",$type).puElement("hidden","step",5).puElement("hidden","pic",$pic).
  puElement("hidden","SenderName",$SenderName).puElement("hidden","SenderMail",$SenderMail).puElement("hidden","RecipientName",$RecipientName).puElement("hidden","RecipientMail",$RecipientMail).
  puElement("hidden","FirstLine",$FirstLine).puElement("hidden","Text",$Text).puElement("hidden","LastLine",$LastLine).
  puElement("hidden","TextColor",$TextColor).puElement("hidden","TextFont",$TextFont).puElement("hidden","BackColor",$BackColor).puElement("hidden","Music",$Music).
  puElement()
	."</table><EMBED SRC='$Music' HEIGHT='0' WIDTH='0' AUTOSTART='true' LOOP='true'><BGSOUND SRC='$Music' LOOP='INFINITE'>";
}
// Wizard Step 5: Send confirmation
if (isset($step) && $step==5) {
 $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a>
 <img src='images/bullet.gif' width='9' height='8' alt='' border='0'>".$language['Step']." 1
 <img src='images/bullet.gif' width='9' height='8' alt='' border='0'>".$language['Step']." 2
 <img src='images/bullet.gif' width='9' height='8' alt='' border='0'>".$language['Step']." 3
 <img src='images/bullet.gif' width='9' height='8' alt='' border='0'>".$language['Step']." 4
 <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Step']." 5</b>";
 $ResultHtml.="<b>".$language['Congratulations']."!</b>
 <p>".$language['Greeting card from you']." (<b>$SenderName</b>) ".$language['has been sent successfully to your friend']." (<b>$RecipientName</b>).</p>
 <p>".$language['Thanks for using']." <b><i>".$language['Easy E-Cards system']."</i></b>!</p>
 <p>".$language['If you wish to send another Greeting card']." - <a href='$EDP_SELF' class=normal>".$language['click here']."</a>.</p>";
}
// Pick up card
if (isset($sid) && $show=="pickup") {
  $SiteNavigation="<a href='$EDP_SELF' class=normal>&nbsp;".$language['Home']."</a>
  <img src='images/bullet.gif' width='9' height='8' alt='' border='0'><b>".$language['Greeting Card']."</b>";
  $Cards=puMyQuery("SELECT * FROM edp_cacards WHERE sid='$sid';");
  if (mysql_num_rows($Cards)!=0) { $Card=puMyFetch("SELECT * FROM edp_cacards WHERE sid='$sid';");
		$size = GetImageSize ("./".($Card["PType"]==1 ? "./horiz/" : "./vert/" ).$Card["Picture"]);
    $ResultHtml.="<table  border=0 cellspacing=0 cellpadding=2  bgcolor='$BackColor'>
    <tr bgcolor='".$Easy[$PageSection]."'>
    <td>&nbsp;&nbsp;".puHeading("<font color='".$Easy["LightColor2"]."'>".$language['Greeting card']."</font>",1)."&nbsp;&nbsp;<font color='".$Easy["LightColor2"]."'>".$language['From']." <b>".$Card["SenderName"]."</b></font></td>
    <td align=right><a href='http://myio.net/software' target=_stoitsov><img src='images/stoitsov2.gif' width='150' height='27' alt='".$language['Delivered by Stoitsov.com']."' border='0'></a></td> </tr>";
    if ($Card["PType"]==1) {
      $ResultHtml.="
       <tr> <td align=center colspan=2><img src='".($Card["PType"]==1 ? "./horiz/" : "./vert/" ).$Card["Picture"]."' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br></td> </tr>
       <tr>
				<td colspan=2><br><UL><b><i><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["FirstLine"]."</font></i></b>
				<p><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".nl2br($Card["MText"])."</font></p>
				<i><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["LastLine"]."</i></font><br><br>
				<b><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["RecipientName"]."</b></font></UL></td>
       </tr>";
    } else {
			$ResultHtml.="<tr>
				<td align=center><img src='".($Card["PType"]==1 ? "./horiz/" : "./vert/" ).$Card["Picture"]."' width='".$size[0]."' height='".$size[1]."' alt='' border='0'><br></td>
				<td><br><UL><b><i><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["FirstLine"]."</font></i></b>
				<p><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".nl2br($Card["MText"])."</font></p>
				<i><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["LastLine"]."</i></font><br><br>
				<b><font face='".$Card["TextFont"]."' color='".$Card["TextColor"]."'>".$Card["RecipientName"]."</b></font></UL></td>
			</tr>";
		}
    $ResultHtml.="<tr><td align=right colspan=2  bgcolor='".$Easy[$PageSection]."'><font color='".$Easy["LightColor2"]."'><b>".$language['Date'].": ".$Card["Date"]."</b></font>&nbsp;</td> </tr>
		</table><EMBED SRC='".$Card["Music"]."' HEIGHT='0' WIDTH='0' AUTOSTART='true' LOOP='true'><BGSOUND SRC='".$Card["Music"]."' LOOP='INFINITE'>";
  }
}
// Start: Main Page
if (strlen($ResultHtml)==0) {
   $SiteNavigation="<b>&nbsp;".$language['Home']."</b>";
   $ResultHtml=puHeading($language['Welcome'],1)." ".$language['Easy E-Cards']." <br><br>
   <p>".$language['You may start creating your greeting card by selecting a card type and picture category from the menu at your left'].". ".$language['Or you may choose from the top-sent pictures from below'].".</p>";
  $TopPics=puMyQuery("SELECT * FROM edp_catop ORDER BY Hits Desc LIMIT ".$Easy["pics_per_page"].";");
   while ($TopPic=mysql_fetch_array($TopPics)) {
		$Temp=split("/","//".$TopPic["Picture"]);
		$Pic=substr($Temp[3],0,strlen($Temp[3])-4);
    $ResultHtml.="<a href='$EDP_SELF&step=2&dir=".$TopPic["Dir"]."&type=".$TopPic["PType"]."&pic=".$Pic."'>".puShowPicture(($TopPic["PType"]==1 ? "./horiz/" : "./vert/" ).$TopPic["Picture"])."</a> ";
  }
}
// ********************************************************************
// ********************** BuildmenuL
// ********************************************************************
// Card pickup
if (isset($sid)) { $camenuL="<span class=menuL>".$language['Information']."</span><br> <font color='#B5B5B5'>".$language['You may send your own Greeting card by']." <a href='$EDP_SELF' class=menuL>".$language['clicking here']."</a>! ".$language['It is free'].".</font>"; }
// Main page, Step 1 menu
if ($step<2 && !isset($sid)) {
  $camenuL="<span class=menuL>".$language['Horizontal images']."</span><br>";
  $HorDir=pugetDirList("./horiz");
  while (list($dirc,$Head)=each($HorDir)) { $camenuL.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=1&dir=$dirc&type=1' class=menuL>".($dir==$dirc && $type==1 ? "<b>$Head</b>" : $Head )."</a><br>"; }
  $camenuL.="<br><span class=menuL>".$language['Vertical images']."</span><br>";
  $VerDir=pugetDirList("./vert");
  while (list($dirc,$Head)=each($VerDir)) { $camenuL.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&step=1&dir=$dirc&type=2' class=menuL>".($dir==$dirc && $type==2 ? "<b>$Head</b>" : $Head )."</a><br>"; }
}
// Step 2 menu
if ($step==2) { $camenuL="<span class=menuL>".$language['Information']."</span><br> <font color='#B5B5B5'>".$language['Please fill in the correct e-mail addresses or your card will never reach the recipient it is directed to'].".</font>"; }
// Step 3 menu
if ($step==3) { $camenuL="<span class=menuL>".$language['Information']."</span><br> <font color='#B5B5B5'>".$language['Please try to avoid typing text larger than the text box or your greeting card may become ugly as its layout changes'].".</font>"; }
// Step 4 menu
if ($step==4) {
 $camenuL="<span class=menuL><b>".$language['Decorate options']."</span></b><br>".puElement("form",$EDP_SELF,"thisform")."
 <font color='#B5B5B5'>
 ".$language['Greetings text color'].":<br>
 <select name=\"TextColor\" class=f_text style='width:100px;'>
 <option style=\"color:black; background-color: #DEE3E7\" value=\"black\" ".($TextColor=="black" ? "selected" : "" ).">Black</option>\n<option style=\"color:darkred; background-color: #DEE3E7\" value=\"darkred\" ".($TextColor=="darkred" ? "selected" : "" ).">Dark Red</option>\n<option style=\"color:red; background-color: #DEE3E7\" value=\"red\" ".($TextColor=="red" ? "selected" : "" ).">Red</option>
 <option style=\"color:orange; background-color: #DEE3E7\" value=\"orange\" ".($TextColor=="orange" ? "selected" : "" ).">Orange</option>\n<option style=\"color:brown; background-color: #DEE3E7\" value=\"brown\" ".($TextColor=="brown" ? "selected" : "" ).">Brown</option>\n<option style=\"color:yellow; background-color: #DEE3E7\" value=\"yellow\" ".($TextColor=="yellow" ? "selected" : "" ).">Yellow</option>
 <option style=\"color:green; background-color: #DEE3E7\" value=\"green\" ".($TextColor=="green" ? "selected" : "" ).">Green</option>\n<option style=\"color:olive; background-color: #DEE3E7\" value=\"olive\" ".($TextColor=="olive" ? "selected" : "" ).">Olive</option>\n<option style=\"color:cyan; background-color: #DEE3E7\" value=\"cyan\" ".($TextColor=="cyan" ? "selected" : "" ).">Cyan</option>
 <option style=\"color:blue; background-color: #DEE3E7\" value=\"blue\" ".($TextColor=="blue" ? "selected" : "" ).">Blue</option>\n<option style=\"color:darkblue; background-color: #DEE3E7\" value=\"darkblue\" ".($TextColor=="darkblue" ? "selected" : "" ).">Dark Blue</option>\n<option style=\"color:indigo; background-color: #DEE3E7\" value=\"indigo\" ".($TextColor=="indigo" ? "selected" : "" ).">Indigo</option>
 <option style=\"color:violet; background-color: #DEE3E7\" value=\"violet\" ".($TextColor=="violet" ? "selected" : "" ).">Violet</option>\n<option style=\"color:white; background-color: #DEE3E7\" value=\"white\" ".($TextColor=="white" ? "selected" : "" ).">White</option>
 </select><br>
 ".$language['Greetings text font'].":<br>
 <select zise=12 name=\"TextFont\" class=f_text  style='width:100px;'>
 <OPTION VALUE=\"Arial\" ".($TextFont=="Arial" ? "selected" : "" )."> Arial</OPTION>
 <OPTION VALUE=\"Arial Black\" ".($TextFont=="Arial Black" ? "selected" : "" )."> Arial Black</OPTION>
 <OPTION VALUE=\"Brush Script MT\" ".($TextFont=="BrushScript MT" ? "selected" : "" )."> Brush Script MT</OPTION>
 <OPTION VALUE=\"Comic Sans MS\" ".($TextFont=="Comic Sans MS" ? "selected" : "" ).">Comic Sans</OPTION>
 <OPTION VALUE=\"Comic Sans MS\" ".($TextFont=="Comic Sans MS" ? "selected" : "" )."> Comic Sans MS</OPTION>
 <OPTION VALUE=\"Courier\" ".($TextFont=="Courier" ? "selected" : "" )."> Courier</OPTION>
 <OPTION VALUE=\"Courier New\" ".($TextFont=="Courier New" ? "selected" : "" )."> Courier New</OPTION>
 <OPTION VALUE=\"Garamond\" ".($TextFont=="Garamond" ? "selected" : "" )."> Garamond</OPTION>
 <OPTION VALUE=\"Georgia\" ".($TextFont=="Georgia" ? "selected" : "" )."> Georgia</OPTION>
 <OPTION VALUE=\"Impact\" ".($TextFont=="Impact" ? "selected" : "" )."> Impact</OPTION>
 <OPTION VALUE=\"Lucida Handwriting\" ".($TextFont=="Lucida Handwriting" ? "selected" : "" )."> Lucida Handwriting</OPTION>
 <OPTION VALUE=\"MS Sans Serif\" ".($TextFont=="MS Sans Serif" ? "selected" : "" )."> MS Sans Serif</OPTION>
 <OPTION VALUE=\"MS Serif\" ".($TextFont=="MS Serif" ? "selected" : "" )."> MS Serif</OPTION>
 <OPTION VALUE=\"News Gothic MT\" ".($TextFont=="News Gothic MT" ? "selected" : "" )."> News Gothic MT</OPTION>
 <OPTION VALUE=\"Palatino\" ".($TextFont=="Palatino" ? "selected" : "" )."> Palatino</OPTION>
 <OPTION VALUE=\"Times New Roman\" ".($TextFont=="Times New Roman" ? "selected" : "" )."> Times New Roman</OPTION>
 <OPTION VALUE=\"Verdana\" ".($TextFont=="Verdana" ? "selected" : "" )."> Verdana</OPTION></SELECT><br>
 ".$language['Background color']."<br>
 <select name=\"BackColor\" class=f_text style='width:100px;'>
 <option style=\"color:black; background-color: #DEE3E7\" value=\"white\" ".($BackColor=="white" ? "selected" : "" ).">White</option>\n
 <option style=\"color:black; background-color: #DEE3E7\" value=\"black\" ".($BackColor=="black" ? "selected" : "" ).">Black</option>\n<option style=\"color:darkred; background-color: #DEE3E7\" value=\"darkred\" ".($BackColor=="darkred" ? "selected" : "" ).">Dark Red</option>\n<option style=\"color:red; background-color: #DEE3E7\" value=\"red\" ".($BackColor=="red" ? "selected" : "" ).">Red</option>
 <option style=\"color:orange; background-color: #DEE3E7\" value=\"orange\" ".($BackColor=="orange" ? "selected" : "" ).">Orange</option>\n<option style=\"color:brown; background-color: #DEE3E7\" value=\"brown\" ".($BackColor=="brown" ? "selected" : "" ).">Brown</option>\n<option style=\"color:yellow; background-color: #DEE3E7\" value=\"yellow\" ".($BackColor=="yellow" ? "selected" : "" ).">Yellow</option>
 <option style=\"color:green; background-color: #DEE3E7\" value=\"green\" ".($BackColor=="green" ? "selected" : "" ).">Green</option>\n<option style=\"color:olive; background-color: #DEE3E7\" value=\"olive\" ".($BackColor=="olive" ? "selected" : "" ).">Olive</option>\n<option style=\"color:cyan; background-color: #DEE3E7\" value=\"cyan\" ".($BackColor=="cyan" ? "selected" : "" ).">Cyan</option>
 <option style=\"color:blue; background-color: #DEE3E7\" value=\"blue\" ".($BackColor=="blue" ? "selected" : "" ).">Blue</option>\n<option style=\"color:darkblue; background-color: #DEE3E7\" value=\"darkblue\" ".($BackColor=="darkblue" ? "selected" : "" ).">Dark Blue</option>\n<option style=\"color:indigo; background-color: #DEE3E7\" value=\"indigo\" ".($BackColor=="indigo" ? "selected" : "" ).">Indigo</option>
 <option style=\"color:violet; background-color: #DEE3E7\" value=\"violet\" ".($BackColor=="violet" ? "selected" : "" ).">Violet</option>
 </select><br>
 ".$language['Music']."<br>
 <SELECT NAME=\"Music\" class=f_text style='width:100px;'>";
 $MusicFiles=pugetFileList("./music");
 while (list($dirc,$Head)=each($MusicFiles)) {$camenuL.="<option value='$Head' ".($Music==$Head ? "selected" : "" ).">".ucwords(str_replace("_"," ",str_replace(".mid","",str_replace("./music/","",$Head))))."</option>"; }
 $camenuL.="</select><br> <br>
 ".puElement("submit",$language["Preview"]).
  puElement("hidden","dir",$dir).puElement("hidden","type",$type).puElement("hidden","step",4).puElement("hidden","pic",$pic).
  puElement("hidden","SenderName",$SenderName).puElement("hidden","SenderMail",$SenderMail).puElement("hidden","RecipientName",$RecipientName).puElement("hidden","RecipientMail",$RecipientMail).
  puElement("hidden","FirstLine",$FirstLine).puElement("hidden","Text",$Text).puElement("hidden","LastLine",$LastLine).puElement("hidden","setPreview","Preview").puElement()."
 </font>";
}
$camenuL.="<br>";
$ResultH="<div align='center'>
<table  border=0  cellspacing=0 cellpadding=0 bgcolor='#B5B5B5'>
<tr><td width=100% background='images/top3.gif' valign=top align=right><font color='".$Easy["LightColor1"]."'><b><i>".$language['Navigation'].": </i></b></font>".$SiteNavigation."&nbsp;&nbsp;</td>
</tr></table>";
$LeftBlock.=$camenuL;
$Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>".$language['Users (Login)']."</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".$Stoitsov["puScreenName"]." ".$language['(Logout)']."</a>" );
if ($useradmin==2) {
 $Adminmenu="<br><span class=menuL><b>".$language['Admin menu']."</b></span><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>".$language['Add User']."</a><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>".$language['Manage Users']."</a><br>
 <br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easyecards/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>".$language['Edit Page']."</a><br>
 <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easyecards/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>".$language['Site Config']."</a>
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
$LeftBlock.="<br><div align=center><a href='http://myio.net/software/products/description.php?software=EasyPublish' target=_stoitsov><img src='images/EasyE-CardsLogo_big.gif' height='90' width='105'  alt='Easy-E-Cards' border='0'></a> </div><br><br>";
// ********************************************************************
// ********************** Left Center Right Blocks
// ********************************************************************
// Center Blocks $ResultHtml
$ResultH.=$ResultHtml."<br></div>"; $ResultHtml=""; $ResultHtml=$ResultH;
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
