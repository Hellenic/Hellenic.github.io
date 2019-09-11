<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
session_start(); $edp_relative_path="../../"; include_once "../../admin/config.php";
$EDP_SELF=$_SERVER['PHP_SELF']."?PageSection=".$PageSection;
$LeftBlock.="<span class=menuL><b>CLASSIFIIELDS MENU</b></span><br><br>";
$clWidth="100%"; error_reporting  (E_ERROR | E_PARSE);
// Private Functions
function clBlockAds() { global $Easy; $PowerBlock[0]="<a href='http://myio.net/software/products/easybookmarker/' class=normal target=_ads>Get your bookmarks optimized in a very few steps!<br><br>Get your site<br><img src='../../images/banners/powerbookmarker90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a><br><br>"; $PowerBlock[1]="<a href='http://myio.net/software/products/easygallery/' class=normal target=_ads>Get your photoes on-line instantly!<br><br>Get your site<br><img src='../../images/banners/powergallery90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a><br><br>"; $PowerBlock[2]="<a href='http://myio.net/software/products/easyclassifields/' class=normal target=_ads>Get your Yahoo-style portal for free!<br><br>Get your site<br><img src='../../images/banners/powerclassifields90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a><br><br>"; $PowerBlock[3]="<a href='http://myio.net/software/products/easye-cards/' class=normal target=_ads>Offer e-cards on-line for free!<br><br>Get your site<br><img src='../../images/banners/powere-cards90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a><br><br>"; $PowerBlock[4]="<a href='http://myio.net/software/products/easypublish/' class=normal target=_ads>Want own news on your site?<br><br>Get your site<br><img src='../../images/banners/powerpublish90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a><br><br>"; return "<div style='float: right; width:200; background-color:".$Easy["LightColor2"]."; padding: 15 15 15 15; text-align:center;'> <div align=right><span class=light11><b>Advertizement</b></span></div><br> ".$PowerBlock[rand(0,Count($PowerBlock)-1)]."</div><br>"; }
function clFrontAds() { global $Easy; $PowerBlock[0]="<a href='http://myio.net/software/products/easybookmarker/' class=normal target=_ads>Get your bookmarks optimized in a few steps! Get your site<br><img src='../../images/banners/powerbookmarker90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a>"; $PowerBlock[1]="<a href='http://myio.net/software/products/easygallery/' class=normal target=_ads>Get your photoes on-line instantly! Get your site<br><img src='../../images/banners/powergallery90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a>"; $PowerBlock[2]="<a href='http://myio.net/software/products/easyclassifields/' target=_stoitsov class=normal><img src='../../images/banners/classifields90x30.gif' width='90' height='30' alt='Get your Yahoo-style portal for free!' border='0'><br>Get your Yahoo-style<br>portal for free!</a>"; $PowerBlock[3]="<a href='http://myio.net/software/products/easye-cards/' class=normal target=_ads>Offer e-cards on-line for free! Get your site<br><img src='../../images/banners/powere-cards90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a>"; $PowerBlock[4]="<a href='http://myio.net/software/products/easypublish/' class=normal target=_ads>Want own news on your site? Get your site<br><img src='../../images/banners/powerpublish90x30.gif' width='90' height='30' alt='Get powered!' border='0'></a>"; return $PowerBlock[rand(0,Count($PowerBlock)-1)]; }
function clSponsoredLink() { global $Easy; $PowerBlock[0]="<a href='http://myio.net/software' target=_new class=normali>Get your desired software from <b>Stoitsov.com</b> for FREE now!</a>"; $PowerBlock[1]="<a href='http://myio.net/software' target=_new class=normali>Free PHP powered software from <b>Stoitsov.com</b>!</a>"; return "<div style='background-color:".$Easy["LightColor1"]."; padding: 1 1 1 1; text-align:center;' ><b>Sponsored link:</b> ".$PowerBlock[rand(0,Count($PowerBlock)-1)]."</div>"; }
// ********************************************************************
// ********************** Functions
// ********************************************************************
function puFindParents($This,&$found) { global $sql, $EDP_SELF; $Query=puMyFetch("SELECT Parent,CName FROM edp_clcategory WHERE ID=$This;"); if ($Query["Parent"]==0) { $found="<a href='$EDP_SELF' class=normali><b>Home</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=browse&go=$This' class=normali>".$Query["CName"]."</a> ".$found; } else { $found=" <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=browse&go=$This' class=normali>".$Query["CName"]."</a> ".$found; puFindParents($Query["Parent"],$found); }  }
function puDisplayLink($Link,$track=0) { global $useradmin, $Stoitsov, $Easy, $EDP_SELF; $Temp=split("/",$Link["LUrl"]); $Domain=$Temp[2]; if ($track!=0) {  $found=""; puFindParents($Link["Parent"],$found); $SiteNavigation=$found."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'>"; }  return "<LI>".($track!=0 ? $SiteNavigation : "")."<a href='$EDP_SELF&out=".$Link["ID"]."' class=normal OnMouseover='self.status=\"GoTo: ".$Link["LUrl"]."\"; return true;' OnMouseOut='self.status=\"EasyClassifields ver.".$Easy["version"]."\"; return true;'>".$Link["LName"]."</a><br> <i>".$Link["LDescription"]."</i><br>". ($Link["Choice"]==1 ? "<img src='images/choice.gif' width='65' height='10' alt='' border='0' hspace=1>" : ""). ($Link["Date"]>date("Y-m-d",mktime(0,0,0,intval(date("m")),intval(date("d"))-$Easy["new_days"],intval(date("Y")))) ? "<img src='images/new.gif' width='22' height='10' alt='' border='0' hspace=1>" : ""). (($Link["Date"]>date("Y-m-d",mktime(0,0,0,intval(date("m")),intval(date("d"))-$Easy["new_days"],intval(date("Y")))) or $Link["Choice"]==1) ? "<br>" : ""). "<span class=light11>Rank:</span> <span class=light21>".$Link["Hits"]."</span> <span class=light11>Added:</span> <span class=light21>".$Link["Date"]."</span> <span class=light11>Modified:</span> <span class=light21>".$Link["Modify"]."</span> <span class=light11>Visited:</span> <span class=light21>".$Link["Visit"]."</span> <span class=light11>Domain:</span> <span class=light21>".$Domain."</span>". ($useradmin==2 ? " <a href='$EDP_SELF&page=edit_link&id=".$Link["ID"]."&parent=".$Link["Parent"]."' class=admin>Edit</a>" : "")." </LI><br><br>"; }
function puRegistered($Who){Global $Stoitsov;$ret=-1; if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puUsername"]===$Stoitsov["puUsername"] && $Who["puScreenName"]===$Stoitsov["puScreenName"] && $Who["ID"]===$Stoitsov["ID"] && $Who["puAdmin"]===$Stoitsov["puAdmin"]){ $ret=1; }if (isset($Stoitsov) && session_is_registered("Stoitsov") && $Who["puAdmin"]==1){ $ret=2; } return $ret;}
function puError($Heading="Error!",$Error="",$Solution="") {return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'><font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
function puTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function pustriplen($text,$len,&$saved) { if (strlen(strip_tags(str_replace(" ","",$text)))<=$len) { $saved=$text; } else { $mtext=""; $spl=split(",",$text); for ($t=0; $t<count($spl)-1; $t++) $mtext.=$spl[$t].", "; $mtext=substr($mtext,0,strlen($mtext)-2); pustriplen($mtext,$len,$saved); }  }
function puElement($Element="default",$Arg1="default",$Arg2="default",$Arg3="default",$Arg4="default",$Arg5="default",$Arg6="default") { switch ($Element) { case "form" : $Action=$Arg1; $Name=$Arg2; $Method=$Arg3; $Aditional=$Arg4; if ($Name=="default") $Name="my"; if ($Method=="default") $Method="POST"; if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<form action='$Action' name='$Name' method='$Method'".$Aditional.">\n"; break; case "hidden" : $Name=$Arg1; $Value=$Arg2; if ($Value=="default") $Value=""; return "<input type='hidden' name='".$Name."' value='".$Value."'>\n"; break; case "text" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; $Class=$Arg5; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Class=="default") { $Class=" class='f_text'"; } else { $Class=" class='".$Class."'"; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='text'".$Class.$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "textarea" :  $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Height=$Arg4; if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Height=="default") { $Height=""; } else { $Height=" Rows='$Height' "; } return "<textarea class='f_text' name='".$Name."'".$Width.$Height.">".$Value."</textarea>\n"; break; case "password" : $Name=$Arg1; $Value=$Arg2; $Width=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Value=="default") $Value=""; if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } return "<input type='password' class='f_text'".$ID." name='".$Name."' value='".$Value."'".$Width.$Aditional.">\n"; break; case "radio" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='radio'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; break; case "checkbox" : $Name=$Arg1; $Value=$Arg2; $Selected=$Arg3; $Aditional=$Arg4; if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("[",$Name); $TmpID=split("]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if ($Selected=="default") { $Selected=""; } else { $Selected=" checked"; } return "<input type='checkbox'".$ID." name='".$Name."' value='".$Value."'".$Selected.$Aditional.">"; break; case "submit" : $Value=$Arg1;  $Class=$Arg2; $Name=$Arg3; if ($Name=="default") { $Name=$Value; }if ($Class=="default") { $Class="f_text"; } return "<input type='submit' class='$Class' name='$Name' value='$Value'>"; break; case "button" : $Name=$Arg1; $Value=$Arg2; $OnClick=$Arg3; if ($OnClick=="default") { $OnClick=""; } else { $OnClick=" OnClick='".$OnClick."'"; } return "<input type='button' class='f_text' name='".$Name."' value='".$Value."'".$OnClick.">"; break; case "select" : $Name=$Arg1; $Values=$Arg2; $Selected=$Arg3; $Width=$Arg4; $Labels=$Arg5; $Aditional=$Arg6;  if (!is_array($Values)) $Values=Array("!!!няма въведени параметри!!!"); if ($Width=="default") { $Width=""; } else { $Width=" style='width: $Width;' "; } if ($Aditional=="default") { $Aditional=""; } else { $Aditional=" ".$Aditional; } if (strpos($Name,"[")===FALSE) { $ID=""; } else { $Tmp=split("\[",$Name); $TmpID=split("\]",$Tmp[1]); $ID=" ID='".$TmpID[0]."' "; } $ret="<select class='f_text' name='".$Name."'".$ID.$Width.$Aditional.">"; while(list($key,$val)=each($Values)) { $CurrentLabel=""; if (isset($Labels[$key])) $CurrentLabel=" Label='".$Labels[$key]."'"; $ret.="<option value='".$key."'".$CurrentLabel.($Selected==$key ? " selected" : "" ).">".$val."</option>\n"; } $ret.="</select>"; return $ret; break; case "reset" : $Value=$Arg1; if ($Value=="default") $Value="Изчиства"; return "<input type='reset' class='f_text' name='reset' value='".$Value."'>"; break; default : return "</form>"; break; } }
function puHeading($Heading,$BR=1) { $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }
function puMyQuery($Query) { Global $sql, $language; $Res=mysql_query($Query) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query.']."","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
function puMyFetch($Query) { Global $sql, $language; $Res=mysql_fetch_array(mysql_query($Query)) or Die (puError($language['Error']."!","<br>".$language['Invalid DataBase Query'].".","<PRE>".$language['The query is'].":<br>$Query</PRE>".$language['If the problem persists, contact the system administrator'].".")); return $Res; }
//function puHackers($Text) { $ret=strip_tags($Text); $ret=escapeshellcmd($ret); $ret=trim($ret);  $ret=str_replace("'","`",$ret); return $ret; }
function puHackers($Text) { $ret=strip_tags($Text); $ret=stripslashes($ret);  $ret=trim($ret);   $ret=str_replace("'","`",$ret);  return $ret;}
function puGetByID($Table,$Field,$ID) { Global $sql; $Result=puMyQuery("SELECT ".$Field." FROM ".$Table." WHERE ID='".$ID."';"); if (mysql_num_rows($Result)==0) { return "Error! (GetByID:".$Table.$Field.$ID.")"; } else { $Ret=mysql_fetch_array($Result); return $Ret[$Field]; } }
if (isset($out)) {
  if (puGetByID("edp_cllink","IP",$out)!=$REMOTE_ADDR) { puMyQuery("UPDATE edp_cllink SET Hits=Hits+1, Visit='".date("Y-m-d")."', IP='".$REMOTE_ADDR."' WHERE ID=$out;"); } else {puMyQuery("UPDATE edp_cllink SET Visit='".date("Y-m-d")."' WHERE ID=$out;"); }
  $Link=puMyFetch("SELECT LUrl From edp_cllink WHERE ID=$out;");
	Header("Location: ".$Link["LUrl"]);
	exit;
}
// ********************************************************************
// ************************ Actions
// ********************************************************************
$action_log="$action=='reg_user' or $action=='edit_reg_user'  or $action=='login' or $action=='logout' or $action=='add_user' or action=='edit_user'";
if($action_log) { include_once "../../admin/login.php";} $useradmin=puRegistered($Stoitsov);
if ($action=="add_folder") { if ($useradmin<0)  { $page="login"; $Error="<b>".$language['You need to be a registered user in order to add folders'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($clICName))<1) $Error="<b>Folder Name is empty.</b><br>"; if (strlen(puHackers($clICDescription))<1) $Error.="<b>Folder Description is empty.</b><br>"; if (isset($Error)) { $page="add_folder"; $parent=$clParent; } else { puMyQuery("INSERT INTO edp_clcategory VALUES(null,'".puHackers($clICName)."','".puHackers($clICDescription)."','$clParent');"); $page="browse"; $go=mysql_insert_id(); } } }
if ($action=="edit_folder") { if ($useradmin<0)  { $page="login"; $Error="<b>".$language['You need to be a registered user in order to edit folders'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($clICName))<1) $Error="<b>Folder Name is empty.</b><br>"; if (strlen(puHackers($clICDescription))<1) $Error.="<b>Folder Description is empty.</b><br>"; if (isset($Error)) { $page="edit_folder"; $id=$clID; } else { puMyQuery("UPDATE edp_clcategory SET Parent='".$clParent."', CName='".puHackers($clICName)."', CDescription='".puHackers($clICDescription)."' WHERE ID=$clID;"); $page="browse"; $go=$clID; } } }
if ($action=="delete_folder") { if ($useradmin<0)  { $page="login"; $Error="<b>".$language['You need to be a registered user in order to delete folders'].".</b><br>"; } else { puMyQuery("DELETE FROM edp_clcategory WHERE ID=$clID;"); $page="browse"; $go=$parent; } }
if ($action=="add_link") { unset($Error); if (strlen(puHackers($clLUrl))<8) $Error="<b>".$language['The link is invalid'].".</b><br>"; if (strlen(puHackers($clLName))<1) $Error="<b>Site Name is empty.</b><br>"; if (strlen(puHackers($clLDescription))<1) $Error.="<b>Site Description is empty.</b><br>"; if (isset($Error)) { $page="add_link"; $parent=$clParent; } else { puMyQuery("INSERT INTO edp_cllink VALUES(null,'".puHackers($clLUrl)."','".puHackers($clLName)."','".puHackers($clLDescription)."','".date("Y-m-d")."','".date("Y-m-d")."','".date("Y-m-d")."',0,'$clParent',0,'');"); $page="browse"; $go=$clParent; } }
if ($action=="edit_link") { if ($useradmin<0)  { $page="login"; $Error="<b>".$language['You need to be a registered user in order to edit links'].".</b><br>"; } else { unset($Error); if (strlen(puHackers($clLUrl))<8) $Error="<b>The link is invalid.</b><br>"; if (strlen(puHackers($clLName))<1) $Error="<b>Site Name is empty.</b><br>"; if (strlen(puHackers($clLDescription))<1) $Error.="<b>Site Description is empty.</b><br>"; if (isset($Error)) { $page="add_link"; $parent=$clParent; $id=$clID; } else { puMyQuery("UPDATE edp_cllink SET Parent='".$clParent."', LUrl='".puHackers($clLUrl)."', LName='".puHackers($clLName)."', LDescription='".puHackers($clLDescription)."', Modify='".date("Y-m-d")."', Visit='".date("Y-m-d")."', Choice='".$clChoice."' WHERE ID=$clID;"); $page="browse"; $go=$clParent; } } }  if ($action=="delete_link") { if ($useradmin<0)  { $page="login"; $Error="<b>You need to be a registered user in order to delete links.</b><br>"; } else { puMyQuery("DELETE FROM edp_cllink WHERE ID=$clID;"); $page="browse"; $go=$parent; } }
// ********************************************************************
// **************   EasyClassifields Screen Creation
// ********************************************************************
if (isset($page) && $page=="login" )                      {include_once "../../admin/login_page.php";}
if (isset($page) && $page=="register")                    {include_once "../../admin/register_page.php";}
if (isset($page) && $page=="users" && $useradmin==2)      {include_once "../../admin/users_page.php";}
// Start: Browse page
if (isset($page) && $page=="browse" && isset($go)) {
  if ($go==0) { unset($page); } else {
		$ResultHtml="";
		$found="";
    puFindParents($go,$found);
		$SiteNavigation=$found;
    $Folders=puMyQuery("SELECT * FROM edp_clcategory WHERE Parent=".$go." ORDER BY CName;");
    $ResultHtml.="<table  border='0' cellspacing='0' cellpadding='10' width=100%>
    <tr>
    <td width=100% bgcolor='".$Easy["LightColor1"]."' valign=top>
    <a href='$EDP_SELF&page=browse&go=$go' class=normalc>".puGetByID("edp_clcategory","CName",$go)."</a>".
    ($useradmin==2 ? " <a href='$EDP_SELF&page=edit_folder&id=$go' class=menuL>".$language['Administrator Edit']."</a>" : "") ."<br>
    <i>".puGetByID("edp_clcategory","CDescription",$go)."</i><br><br>".(mysql_num_rows($Folders)!=0 ? "<b>".$language['SubFolders'].":</b> " : " ");
			while ($Folder=mysql_fetch_array($Folders)) {
      $ResultHtml.="<a href='$EDP_SELF&page=browse&go=".$Folder["ID"]."' class=normali>".$Folder["CName"]."</a>, ";
      }
			if (mysql_num_rows($Folders)!=0) $ResultHtml=substr($ResultHtml,0,strlen($ResultHtml)-2);
      $ResultHtml.=($useradmin==2 ? " <a href='$EDP_SELF&page=add_folder&parent=$go' class=admin>".$language['Add subfolder']."</a>" : "") ."</td>
      ".puElement("form",$EDP_SELF,"search","GET").puElement("hidden","page","search").puElement("hidden","PageSection",$PageSection)."<td nowrap bgcolor='".$Easy["LightColor2"]."'>".puElement("text","search","",220).puElement("hidden","PageSection",$PageSection)." ".puElement("submit",$language['Search'])."<br>
      &nbsp;&nbsp;&nbsp;<b>".$language['What'].": </b>".puElement("radio","what","1",1)." ".$language['all words']." ".puElement("radio","what","2")." ".$language['exact phrase']."<br>
      <b>".$language['Where'].": </b>".puElement("checkbox","where[]","name",1)." ".$language['name']." ".puElement("checkbox","where[]","description",1)." ".$language['Description']."  ".puElement("checkbox","where[]","url")." ".$language['url']."
      </td>".puElement()."
		</tr>
		</table><br>";
		if (!isset($from)) $from=0;
    $TotalLinks=mysql_num_rows(puMyQuery("SELECT * FROM edp_cllink WHERE Parent=$go;"));
    if ($TotalLinks>0) $ResultHtml.=puHeading($language['Sites'],2).clSponsoredLink()."<UL>";
    $Links=puMyQuery("SELECT * FROM edp_cllink WHERE Parent=$go ORDER BY Hits Desc LIMIT $from,".$Easy["links_per_page"].";");
		$i=0;
    while ($Link=mysql_fetch_array($Links)) { $i++; if ($i==2 or $i==8) $ResultHtml.=clBlockAds(); $ResultHtml.=puDisplayLink($Link); }
		if ($TotalLinks>0) $ResultHtml.="</UL>";
    if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=browse&go=$go&from=".($from-$Easy["links_per_page"])."'><img src='images/prev.gif' width='66' height='14' alt='".$language['Previous Page']."' border='0'></a>";
    if ($TotalLinks>$from+$Easy["links_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=browse&go=$go&from=".($from+$Easy["links_per_page"])."'><img src='images/next.gif' width='66' height='14' alt='".$language['Next Page']."' border='0' hspace=4></a>";
		$ResultHtml.="<br>";
  } }
// Start: Main page
if (!isset($page)) {
  $ResultHtml=""; $SiteNavigation=""; $clWidth="500"; //chch
  $ResultHtml.="<table  border='0' cellspacing='0' cellpadding='20' width=".$clWidth." align=center>
  <tr>
    <td bgcolor='".$Easy["LightColor1"]."'>".puTr(25)."<br></td>" .puElement("form",$EDP_SELF,"search","GET").puElement("hidden","PageSection",$PageSection).puElement("hidden","page","search")."<td bgcolor='".$Easy["LightColor1"]."' width=100%>".puElement("text","search","",220)." ".puElement("submit",$language['Search'])."<br>
    &nbsp;&nbsp;&nbsp;<b>".$language['What'].": </b>".puElement("radio","what","1",1)." ".$language['all words']." ".puElement("radio","what","2")." ".$language['exact phrase']."<br>
    <b>".$language['Where'].": </b>".puElement("checkbox","where[]","name",1)." ".$language['name']." ".puElement("checkbox","where[]","description",1)." ".$language['Description']."  ".puElement("checkbox","where[]","url")." ".$language['url']."
    </td>".puElement()."
    <td align=center>".puTr(150,1)."<br>".clFrontAds()."<br> </td>
	</tr>
	</table>
  <table  border='0' cellspacing='4' cellpadding='2' width=".$clWidth." align=center>
  <tr> <td width=100%>
      <table  border='0' cellspacing='4' cellpadding='0' width=100%> ";
      $Categories=puMyQuery("SELECT * FROM edp_clcategory WHERE Parent=0 ORDER BY CName;");
      while ($Category=mysql_fetch_array($Categories)) {
      $Folders=puMyQuery("SELECT * FROM edp_clcategory WHERE Parent=".$Category["ID"]." ORDER BY CName;");
			$i++;
			if ($i % 2 !=0) { $ResultHtml.="<tr><td width=50%>"; } else { $ResultHtml.="<td width=50%>"; }
      $ResultHtml.="<a href='$EDP_SELF&page=browse&go=".$Category["ID"]."' class=normalc>".$Category["CName"]."</a><br>";
      $saved=$SubHtml="";
      while ($Folder=mysql_fetch_array($Folders)) {
      $SubHtml.="<a href='$EDP_SELF&page=browse&go=".$Folder["ID"]."' class=normali>".$Folder["CName"]."</a>, "; }
      $SubHtml=substr($SubHtml,0,strlen($SubHtml)-2);
      pustriplen($SubHtml,40,$saved);
      $ResultHtml.=$saved;
      if (strlen($saved)!=strlen($SubHtml)) $ResultHtml.="...";
			if ($i % 2 ==0) { $ResultHtml.="</td></tr>"; } else { $ResultHtml.="</td>"; }
    }
		if ($i % 2 != 0) { $ResultHtml.="<td>&nbsp;</td></td></tr>"; }
		$ResultHtml.="</table></td>
    <td bgcolor='".$Easy["LightColor2"]."' rowspan=2 valign=top>".puTr(180)."<br>&nbsp;<b>".$language['Editors Choice']."</b><br><br>";
    $News=puMyQuery("SELECT * FROM edp_cllink ORDER BY Choice DESC, Hits DESC Limit 13;");
		while ($New=mysql_fetch_array($News)) {
			$Result=substr($New["LName"],0,24);
			if (strlen($Result)!=strlen($New["LName"])) $Result.="...";
      $ResultHtml.="&nbsp;<a href='$EDP_SELF&out=".$New["ID"]."' class=normal>".$Result."</a><br>".puTr(1,4)."<br>";
    }
    $ResultHtml.="<div align=right><a href='$EDP_SELF&page=charts&chart=3' class=normal><b>".$language['More']."...</b></a>&nbsp;</div></td>
		</tr>
    <tr><td bgcolor='".$Easy["LightColor1"]."' align=center>".clSponsoredLink()."</td> </tr>
	</table>";
}
// Start: Charts page
if (isset($page) && $page=="charts" && isset($chart)) {
  if ($chart==1) {
    $ResultHtml=puHeading($language['What is New'],1)."".$language['Recently added sites']."<br><br><UL>";
    $SiteNavigation="<a href='$EDP_SELF' class=normali><b>".$language['Home']."</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['What is New']."</b>";
    $Links=puMyQuery("SELECT * FROM edp_cllink ORDER BY Date Desc LIMIT 20;");
		$i=0;
		while ($Link=mysql_fetch_array($Links)) {
			$i++;
			if ($i==2 or $i==8) $ResultHtml.=clBlockAds();
      $ResultHtml.=puDisplayLink($Link,1);
    }
		$ResultHtml.="</UL>";
  }
  if ($chart==2) {
    $ResultHtml=puHeading($language['Top sites'],1)."".$language['Most popular sites']."<br><br><UL>";
    $SiteNavigation="<a href='$EDP_SELF' class=normali><b>".$language['Home']."</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Top sites']."</b>";
    $Links=puMyQuery("SELECT * FROM edp_cllink ORDER BY Hits Desc LIMIT 20;");
		$i=0;
		while ($Link=mysql_fetch_array($Links)) {
			$i++;
			if ($i==2 or $i==8) $ResultHtml.=clBlockAds();
      $ResultHtml.=puDisplayLink($Link,1);
    }
		$ResultHtml.="</UL>";
  }
  if ($chart==3) {
    $ResultHtml=puHeading($language['Editors choice'],1)."".$language['Sites choosen by the editor as valuable']."<br><br><UL>";
    $SiteNavigation="<a href='$EDP_SELF' class=normali><b>".$language['Home']."</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Editors choice']."</b>";
    $Links=puMyQuery("SELECT * FROM edp_cllink WHERE Choice=1 ORDER BY Hits Desc LIMIT 20;");
		$i=0;
		while ($Link=mysql_fetch_array($Links)) {
			$i++;
			if ($i==2 or $i==8) $ResultHtml.=clBlockAds();
      $ResultHtml.=puDisplayLink($Link,1);
    }
		$ResultHtml.="</UL>";
  }
}
// Start: Search page
if (isset($page) && $page=="search") {
  $search=puHackers($search);
  $SiteNavigation="<a href='$EDP_SELF' class=normali><b>".$language['Home']."</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Search']."</b>";
	$clean=$search;
	$addurl="&search=".$search;
  if ($what==1) {
		$search="%".str_replace(" ","%",$search)."%";
		$addurl.="&what=1";
  } else {
		$search="%".$search."%";
		$addurl.="&what=2";
	}
	$w1=$w2=$w3="default";
	$Query="";
	if (count($where)>=1) {
    foreach ($where as $field) {
			if ($field=="name") { $Query.=" OR LName LIKE '".$search."'"; $addurl.="&where[]=name"; $w1=1;}
			if ($field=="description") { $Query.=" OR LDescription LIKE '".$search."'"; $addurl.="&where[]=description";  $w2=1;}
			if ($field=="url") { $Query.=" OR LUrl LIKE '".$search."'"; $addurl.="&where[]=url";  $w3=1;}
		}
	}
  $ResultHtml="<div style='float:right; padding:10 10 10 10; background-color:".$Easy["LightColor1"].";' >".puElement("form",$EDP_SELF,"search","GET").puElement("hidden","PageSection",$PageSection).puElement("hidden","page","search")."<b>Search again</b><br>".puElement("text","search",$clean,220)." ".puElement("submit",$language['Search'])."<br>
  &nbsp;&nbsp;&nbsp;<b>".$language['What'].": </b>".puElement("radio","what","1",$what)." ".$language['all words']." ".puElement("radio","what","2",$what)." ".$language['exact phrase']."<br>
  <b>".$language['Where'].": </b>".puElement("checkbox","where[]","name",$w1)." ".$language['name']." ".puElement("checkbox","where[]","description",$w2)." description  ".puElement("checkbox","where[]","url",$w3)." ".$language['url']."</div>";
	if (strlen($Query)>5) { $Query="WHERE ".substr($Query,3,strlen($Query)-3); } else { $nothing=1; }
  $Query="SELECT * FROM edp_cllink ".$Query." ORDER BY Hits Desc, Date Desc";
	if (!isset($from)) $from=0;
  if (!isset($nothing)) { $TotalLinks=mysql_num_rows(puMyQuery($Query.";")); } else { $TotalLinks=0; }
  $ResultHtml.=puHeading($language['Search results'],1)."".$language['Found']." ".$TotalLinks." ".$language['matches for']." \"<b>".$clean."</b>\"<ul>";
	if ($TotalLinks>0) {
    $Links=puMyQuery($Query." LIMIT $from,".$Easy["links_per_page"].";");
		$i=0;
		while ($Link=mysql_fetch_array($Links)) {
			$i++;
			if ($i==3 or $i==8) $ResultHtml.=clBlockAds();
      $ResultHtml.=puDisplayLink($Link,1);
    }
		if ($TotalLinks>0) $ResultHtml.="</UL>";
    if ($from!=0) $ResultHtml.= "<a href='$EDP_SELF&page=search&from=".($from-$Easy["links_per_page"]).$addurl."'><img src='images/prev.gif' width='66' height='14' alt='".$language['Previous Page']."' border='0'></a>";
    if ($TotalLinks>$from+$Easy["links_per_page"]) $ResultHtml.= "<a href='$EDP_SELF&page=search&from=".($from+$Easy["links_per_page"]).$addurl."'><img src='images/next.gif' width='66' height='14' alt='".$language['Next Page']."' border='0' hspace=4></a>";
  } else {
    $ResultHtml.="<b>".$language['Nothing found'].".</b> ".$language['Please, check your search string'].".</UL>";
	}
  $ResultHtml.="<br>".puElement();
}
// Start: Add Folder page
if (isset($page) && $page=="add_folder" && isset($parent)) {
	$ResultHtml="";
  if ($parent!=0) {
		$found="";
    puFindParents($parent,$found);
    $SiteNavigation=$found."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Add Folder']."</b>";
  } else {
    $SiteNavigation="<a href='$EDP_SELF' class=normali><b>".$language['Home']."</b></a> <img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Add Folder']."</b>";
  }
  if ($useradmin<0)  {
		$page="login";
    $Error="".$language['You need to be a registered user in order to add categories'].".";
  } else {
		if ($parent!=0) {
      $UnderCategory=puMyFetch("SELECT * FROM edp_clcategory WHERE ID=$parent LIMIT 1");
		} else {
      $UnderCategory["CName"]=$language['EasyClassifields'];
    }
    $ResultHtml.=puHeading($language['Add Folder'],1).
    "<b>".$language['Add Folder under']." ".$UnderCategory["CName"]."</b><br><br>
		<div align=center>
      <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
      <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['New Folder Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST")."
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Name'].":</b> [200 ".$language['Chars max']."]<br> ".puElement("text","clICName","",250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Description'].":</b> [255 ".$language['Chars max']."]<br> ".puElement("text","clICDescription","",250)."</td> </tr>
      <tr> <td align=right>".puElement("submit",$language['Create'],"f_button","Create")."</td> </tr> ".puElement("hidden","clParent",$parent).puElement("hidden","action","add_folder").puElement()."
		</table><br>".
		$Error
		."</div>";
  }
}
// Start: Edit Folder page
if (isset($page) && $page=="edit_folder" && isset($id)) {
  $ResultHtml=""; $found="";
  puFindParents($id,$found);
  $SiteNavigation=$found."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Edit Folder']."</b>";
  if ($useradmin<0)  { $page="login"; $Error="".$language['You need to be registered user in order to edit the folders'].".";
  } else {
    $EditFolder=puMyFetch("SELECT * FROM edp_clcategory WHERE ID=$id LIMIT 1");
    $isEmpty=mysql_num_rows(puMyQuery("SELECT * FROM edp_cllink Where Parent=".$EditFolder["ID"].";"))+
    mysql_num_rows(puMyQuery("SELECT * FROM edp_clcategory Where Parent=".$EditFolder["ID"].";"));
    $CatSelects=puMyQuery("SELECT * FROM edp_clcategory Where ID<>$id ORDER BY Parent, ID;");
		$Under=$Categories[0]="EasyClassifields";
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$found="";
      puFindParents($CatSelect["ID"],$found);
			$Categories[$CatSelect["ID"]]=strip_tags(str_replace("<img","> <img",$found));
    }
    $ResultHtml.= puHeading($language['Edit Folder'],1). "<b>".$language['Edit Folder under']." ".puGetByID("edp_clcategory","CName",$EditFolder["ID"])."</b><br><br>
		<div align=center>
      <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
      <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Folder Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Folder","POST")."
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Move folder under'].":</b> [".$language['no change - no move']."]<br> ".puElement("select","clParent",$Categories,$EditFolder["Parent"],250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Name'].":</b> [200 ".$language['Chars max']."]<br> ".puElement("text","clICName",$EditFolder["CName"],250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Description'].":</b> [255 ".$language['Chars max']."]<br> ".puElement("text","clICDescription",$EditFolder["CDescription"],250)."</td> </tr>
      <tr> <td align=right>".puElement("submit",$language['Change'],"f_button")."</td> </tr> ".puElement("hidden","action","edit_folder").
      puElement("hidden","parent",$EditFolder["Parent"]).
      puElement("hidden","clID",$EditFolder["ID"]).puElement()."
    </table><br>". $Error. ($isEmpty==0 ? "<a href='$EDP_SELF&action=delete_folder&clID=$id&parent=".$EditFolder["Parent"]."' class=normal>".$language['You may delete this folder. It is empty'].".</a>" : "".$language['You can not delete this folder. It is not empty']."." ) ."</div>";
  }
}
// Start: Add Link page
if (isset($page) && $page=="add_link" && isset($parent)) {
	$ResultHtml="";
  if ($parent==0) {
    $ResultHtml.=puHeading($language['Add site'],1)."<P>".$language['You need to enter a category in which you will place your site. Choose from bellow'].":</P><UL>";
    $CatSelects=puMyQuery("SELECT * FROM edp_clcategory ORDER BY Parent, ID;");
		while ($CatSelect=mysql_fetch_array($CatSelects)) {
			$found="";
      puFindParents($CatSelect["ID"],$found);
     $ResultHtml.="<LI><a href='$EDP_SELF&page=add_link&parent=".$CatSelect["ID"]."' class=normal>".strip_tags(str_replace("<img","> <img",$found))."</a></LI>";
    }
		$ResultHtml.="</UL>";
  } else {
		$found="";
    puFindParents($parent,$found);
    $SiteNavigation=$found."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Add site']."</b>";
		if ($parent!=0) {
      $UnderCategory=puMyFetch("SELECT * FROM edp_clcategory WHERE ID=$parent LIMIT 1");
		} else {
			$UnderCategory["CName"]="EasyClassifields";
    }     $ResultHtml.= puHeading($language['Add site'],1).
    "<b>".$language['Add site in']." ".$UnderCategory["CName"]."</b><br><br>
		<div align=center>
    <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
      <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['New Link Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Link","POST")."
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Link'].":</b> [255 ".$language['Chars max']."]<br> ".puElement("text","clLUrl","http://",250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Name'].":</b> [200 ".$language['Chars max']."]<br> ".puElement("text","clLName","",250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Description'].":</b><br> ".puElement("text","clLDescription","",250)."</td> </tr>
      <tr> <td align=right>".puElement("submit",$language['Add'],"f_button")."</td> </tr> ".puElement("hidden","clParent",$parent). puElement("hidden","action","add_link").puElement()."
    </table><br>". $Error."</div>";
} }
// Start: Edit Link page
if (isset($page) && $page=="edit_link" && isset($id) && isset($parent)) {
  $ResultHtml=""; $found="";
  puFindParents($parent,$found);
  $SiteNavigation=$found."<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><b>".$language['Edit Link']."</b>";
  if ($useradmin<0)  { $page="login"; $Error="".$language['You need to be a registered user in order to edit the links'].".";
  } else { if ($parent!=0) { $UnderCategory=puMyFetch("SELECT * FROM edp_clcategory WHERE ID=$parent LIMIT 1");
  } else { $UnderCategory["CName"]="EasyClassifields"; }
  $EditLink=puMyFetch("SELECT * FROM edp_cllink WHERE ID=$id LIMIT 1");
  $CatSelects=puMyQuery("SELECT * FROM edp_clcategory ORDER BY Parent;");
  while ($CatSelect=mysql_fetch_array($CatSelects)) { $found="";
      puFindParents($CatSelect["ID"],$found);
			$Categories[$CatSelect["ID"]]=strip_tags(str_replace("<img","> <img",$found));
    }
    $ResultHtml.= puHeading($language['Edit Links'],1).
    "<b>".$language['Edit Link under']." ".$UnderCategory["CName"]."</b><br><br>
		<div align=center>
      <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' width=200>
      <tr><td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Link Information']."</b></font></td> </tr> ".puElement("form",$EDP_SELF,"Link","POST")."
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Move Link under'].":</b> [".$language['no change - no move']."]<br> ".puElement("select","clParent",$Categories,$parent,250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Link'].":</b> [255 ".$language['Chars max']."]<br> ".puElement("text","clLUrl",$EditLink["LUrl"],250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Name'].":</b> [200 ".$language['Chars max']."]<br> ".puElement("text","clLName",$EditLink["LName"],250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Site Description'].":</b><br> ".puElement("text","clLDescription",$EditLink["LDescription"],250)."</td> </tr>
      <tr><td bgcolor=".$Easy["Background"]."><b>".$language['Editors choice'].":</b><br> ".puElement("select","clChoice",array("0"=>"No","1"=>"Yes"),$EditLink["Choice"],250)."</td> </tr>
      <tr><td align=right>".puElement("submit",$language['Change'],"f_button")."</td> </tr> ".puElement("hidden","action","edit_link").
      puElement("hidden","parent",$parent). puElement("hidden","clID",$EditLink["ID"]).puElement()." </table><br>". $Error. "<a href='$EDP_SELF&action=delete_link&clID=$id&parent=$parent' class=normal>You may delete this link.</a>" ."</div>";
  } }
$ResultH="
 <table  border='0' cellspacing='0' cellpadding='0' width='".$clWidth."' align=center>
	<tr>
   <td rowspan=2><a href='$EDP_SELF'><img src='images/logo1.gif' width='120' height='106' alt='' border='0'></a><br></td>
   <td valign=top  bgcolor='#DCFFE5'><a href='$EDP_SELF'><img src='images/logo2.gif' width='230' height='64' alt='' border='0'></a><br></td>
   <td width=100% background='images/repeat_top.gif' align=right>".puTr(1,55)."<br><img src='images/buttons.gif' width='186' height='22' alt='' border='0' USEMAP='#buttons_Map'><br></td>
   <td valign=top ><img src='images/top_right.gif' width='1' height='77' alt='' border='0'><br></td>
	</tr>
	<tr>
   <td colspan=2 valign=top  bgcolor='#DCFFE5'>".$SiteNavigation."</td>
    <td  bgcolor='#DCFFE5'>".puTr(1,28)."<br></td>
	</tr>
</table>
<MAP NAME='buttons_Map'>
<AREA SHAPE='rect' ALT='".$language['Add site to EasyClassifields']."' COORDS='135,2,177,14' HREF='$EDP_SELF&page=add_link&parent=$go'>
<AREA SHAPE='rect' ALT='".$language['Top visited sites']."' COORDS='89,2,133,14' HREF='$EDP_SELF&page=charts&chart=2'>
<AREA SHAPE='rect' ALT='".$language['What is new']."' COORDS='33,2,87,14' HREF='$EDP_SELF&page=charts&chart=1'>
<AREA SHAPE='rect' ALT='".$language['Home']."' COORDS='1,3,31,14' HREF='$EDP_SELF'>
</MAP>";
$LeftBlock.="
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><A ALT='".$language['Home']."'  HREF='$EDP_SELF' class=invert>".$language['Home']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><A ALT='".$language['What is new']."'  HREF='$EDP_SELF&page=charts&chart=1' class=invert>".$language['What is new']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><A ALT='".$language['Top visited sites']."'  HREF='$EDP_SELF&page=charts&chart=2' class=invert>".$language['Top visited']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><A ALT='".$language['Add site to EasyClassifields']."'  HREF='$EDP_SELF&page=add_link&parent=$go' class=invert>".$language['Add site']."</a><br><br>";
$Login=(!isset($Stoitsov["puUsername"]) ? "<a href='$EDP_SELF&page=login' class=menuL>".$language['Users (Login)']."</a>": "<a href='$EDP_SELF&action=logout' class=menuL> ".$Stoitsov["puScreenName"]." ".$language['(Logout)']."</a>" );
if ($useradmin==2) {
$Adminmenu="<br><span class=menuL><b>".$language['Admin menu']."</b></span><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users&do=add_user' class=menuL>".$language['Add user']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=users' class=menuL>".$language['Manage Users']."</a><br>
<br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=add_folder&parent=0' class=menuL>".$language['Add Category']."</a><br><img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easyclassifields/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=dpage' class=menuL>".$language['Edit Page']."</a><br>
<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='"."../../staticpages/easyclassifields/index.php?PageSection=".$PageSection."&page=config&do=add_page&du=site' class=menuL>".$language['Site Config']."</a>";
} elseif ($useradmin<1) {
  $Adminmenu.="<img src='images/menu_item.gif' width='9' height='8' alt='' border='0'><a href='$EDP_SELF&page=register&do=reg_user' class=menuL>".$language['Please register']."</a>";
}
$user=$Easy["user"];
if ($user == 1) {
$user=$language['Currently there is'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['User Online'];
} else {
$user=$language['Currently there are'].":<br>&nbsp;<font color=red><b>".$user."</font></b> ".$language['Users Online'];
}
$LeftBlock.="<br><div><a href='http://myio.net/software/products/description.php?software=EasyClassifields' target=_stoitsov><img src='images/EasyClassifieldsLogo_big.gif' height='90' width='105'  alt='EasyClassifields!' border='0'></a> </div><br>";
// ********************************************************************
// ********************** Left Center Right Blocks
// ********************************************************************
// Center Blocks $ResultHtml
$ResultH.=$ResultHtml; $ResultHtml="";
// pageconfig and site config
if (isset($page) && $page=="config" && $useradmin==2) { include_once "../../admin/config_page.php"; } // end: Config Page
$ResultHtml=$ResultH.$ResultHtml;
// dynamic $LeftBlock
$LeftBlockArray[0]=$LeftBlock;
$menuL="menuL"; $menuLlink="invert";
if($LeftBlockData[0]!==".php") {
for ($i=0; $i<count($LeftBlockData); $i++) {include "../../admin/Blocks/".$LeftBlockData[$i]; $LeftBlockArray[$i+1]=$Block; }
}
// no dynamic $RightBlock for this page
// No right blocks for this page
// ********************************************************************
// Call theme template output index
// ********************************************************************
include_once  "../../themes/".$ThemeName."/index.php";
?>

