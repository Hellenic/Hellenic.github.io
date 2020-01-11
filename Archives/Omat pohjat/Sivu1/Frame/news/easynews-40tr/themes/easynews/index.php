<?
// phpinfo(); // Timer class
if(!defined('_PHP_TIMER_INCLUDED')) {define('_PHP_TIMER_INCLUDED',1);} class phpTimer {function phpTimer (){ $this->_version = '0.1';$this->_enabled = true;}function start ($name = 'default'){ if($this->_enabled){ $this->_timing_start_times[$name] = explode(' ', microtime());}}function stop ($name = 'default'){ if($this->_enabled){ $this->_timing_stop_times[$name] = explode(' ', microtime());}}function get_current ($name = 'default'){ if($this->_enabled){ if (!isset($this->_timing_start_times[$name])){ return 0;}if (!isset($this->_timing_stop_times[$name])){ $stop_time = explode(' ', microtime());}else{ $stop_time = $this->_timing_stop_times[$name];}$current = $stop_time[1] - $this->_timing_start_times[$name][1];$current += $stop_time[0] - $this->_timing_start_times[$name][0];return sprintf("%.10f",$current);}else{ return 0;}}}  $timer =& new phpTimer(); $timer->start('main');
// theme path
$theme_path=$edp_relative_path."themes/".$ThemeName."/";

// current pagetitle
if(isset($zfcategory)) {$pagetitle=$zfcategory; } else { for ($i=0; $i<$FREEMAX; $i++) {if($i==$PageSection){$pagetitle=str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])));}} }
$refresh=""; if($zfrefresh=="refreshnow") {$refresh="<font color='#E07330'>Refreshing </font>";}
?>
<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><TITLE><?=$sitetitle; ?></TITLE>
<META http-equiv="Content-Type" content="text/html; <?=$sitecharset; ?>">
<META content="general" name="rating">
<META content="index, follow" name="robots">
<META content="MSHTML 6.00.2800.1400" name="GENERATOR">
<META content="software, web design, web development, pay pal, free software, easy software, download, web store, internet store,  secure server, ebusiness, e-business, home business, sell products, online catalog, php, mysql, database driven web site" name="keywords">
<META content="<?=$sitecontent; ?>" name="description">
<META content="<?=$siteauthor; ?>" name="author">
<META content="MyioSoft, myio.net" name="copyright">
<script language="JavaScript">
function YesNo(fURL,fMessage) { if (confirm(fMessage)) { self.top.location.href=fURL; } }
function submitMonthYear() {document.monthYear.method = "post"; document.monthYear.action = "index.php?PageSection=<? echo $PageSection; ?>&month=" + document.monthYear.month.value + "&year=" + document.monthYear.year.value; document.monthYear.submit();}
function submitYear() {document.ToYear.method = "post"; document.ToYear.action = "index.php?PageSection=<? echo $PageSection; ?>&page=yearview&year=" + document.ToYear.year.value; document.ToYear.submit();}
function PicWindow(fUrl,W,H) {  W=W+60; H=H+130;  if (H>700) H=700; var X=(screen.availWidth - W) / 2,Y=(screen.availHeight - H - 40) / 2;  w = window.open(fUrl, "fUrl", "left=" + X + ",top=" + Y + ",width=" + W + ",height=" + H +",scrollbars=yes"); w.opener=self; }
function selectColor ( color ) { url = "<? echo $edp_relative_path."admin/colors.php?color="; ?>" + color; var colorWindow = window.open(url,"ColorSelection","width=390,height=343,resizable=no,scrollbars=no"); }
</script>
<LINK href="<?= $theme_path ?>style/stylecss.php"  type="text/css" rel="stylesheet">
</head><body>
<? // TOP LOGO TABLE
echo "<table cellspacing='0' width='100%'>
<tr>
 <td  hight='60' align='left'  valign='top' 'nowrap' width='100%'>
  <div  id='logo1'>E&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N</div><div id='logo2'>".$refresh.ucwords($pagetitle)."</div><div  id='logo3'>asy</div><div  id='logo4'>ews</div><br /><br />
 </td>
 <td>
 <div id='google'>
  <FORM method=GET action='http://www.google.com/custom'>
    <A HREF='http://www.google.com/' target='_new'><img src='".$theme_path."images/Logo_25wht.gif' border='0' ALT='Google' align='absmiddle'></A>
    <INPUT TYPE='text' name='q' size='15' maxlength='255' value=''>
    <INPUT type='submit' name='sa' VALUE='Search'>
    <input type='hidden' name='client' value='pub-4843959578128079'>
    <input type='hidden' name='forid' value='1'>
    <input type='hidden' name='ie' value='ISO-8859-1'>
    <input type='hidden' name='oe' value='ISO-8859-1'>
    <input type='hidden' name='cof' value='GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:F8CD98;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;LH:25;LW:64;L:http://myio.net/main/themes/myio/images/myiosearchlogo.jpg;S:http://;FORID:1;'>
    <input type='hidden' name='hl' value='en'>
  </FORM>
 </div>
 </td>
</tr>
</table>";
// MAIN TABLE
echo "<table cellspacing='0'>";
// ROW LINKS MENU
echo "
<tr id='contenttop'>\n<td id='sidetop1' align='center' width='150'>&nbsp;</td>\n
  <td id='sidetop2' align='right' colspan='2' 'nowrap' >&nbsp;";
  for ($i=1; $i<$FREEMAX; $i++) {
  if (eregi("staticpages", $FREED[$i]) and !eregi("staticpages/easynews", $FREED[$i])) {
   if($i!=1) echo " | ";
   echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."'>".str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])))."</a>";
  }}
 echo "&nbsp;
 </td>\n
</tr>\n";
///////////////////////////////////////////////////////
/////////////// LEFT MENU START ///////////////////////
///////////////////////////////////////////////////////
echo "<tr><td id='leftside' width='150'>";
// LEFT TABLE START
echo "<table cellspacing='0'><tr><td id='sidelinks'>";
// WORLD NEWS MENU
echo "<div id='h1d'>World News</div>";
 for ($i=0; $i<$FREEMAX; $i++) {
  if (eregi("staticpages/easynews", $FREED[$i])) {
   $NewsPageSection=$i;
   $zfcategory2=str_replace("_"," ",str_replace("edp_","",$FREET[$i])); $opmlfields[0]=$zfcategory2;
   if(!isset($zfcategory) and $PageSection==$NewsPageSection) {$idnow="id=\"now\"";} else {$idnow="";}
   if ($zfcategory==$zfcategory2) {
     $idnow="id=\"now\""; $PageSection=$NewsPageSection;
     $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory2;
     echo "<a href='".$pagelink."' ".$idnow.">".$zfcategory2."</a></b>";
   } else {
     echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory2."' ".$idnow.">".ucwords($zfcategory2)."</a>";
  }}
 }
 $j=0;
 $result=mysql_query("SELECT opmlname FROM edp_newsopml");
 while ($row = mysql_fetch_array($result)) { $j++;
  $zfcategory1=$row[opmlname];  $opmlfields[$j]=$zfcategory1;    $i=$NewsPageSection;
  if(!isset($zfcategory) and $PageSection==$NewsPageSection) {$idnow="id=\"now\"";} else {$idnow="";}
  if ($zfcategory==$zfcategory1) {
    $idnow="id=\"now\""; $PageSection=$NewsPageSection;
    $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory1;
    echo "<a href='".$pagelink."' ".$idnow.">".$zfcategory1."</a></b>";
  } else {
    echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory1."' ".$idnow.">".ucwords($zfcategory1)."</a>";
  }
 }
// LOCAL NEWS
echo "<div id='h1d'>Internal News</div>";
for ($i=0; $i<$FREEMAX; $i++) {
 if (!eregi("staticpages", $FREED[$i]) or eregi("easypublish", $FREED[$i])) {
 if($i==$PageSection){
  $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i;
  echo "<a href='".$pagelink."' id=\"now\">".str_replace("_"," ",str_replace("edp_","",$FREET[$i]))."</a>";
 } else {
  echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."'>".str_replace("_"," ",str_replace("edp_","",$FREET[$i]))."</a>";
 }}
}
// TOOLS MENU
echo "<div id='h1d'>Tools</div>";
for ($i=1; $i<$FREEMAX; $i++) {
 if (eregi("staticpages", $FREED[$i]) and !eregi("staticpages/easynews", $FREED[$i])) {
 if($i==$PageSection){
  $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i;
  echo "<a href='".$pagelink."' id=\"now\">".str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])))."</a>";
 } else {
  echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."'>".str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])))."</a>";
 }}
}
// MYIOSOFT MENU
echo "<div id='h1d'>MyioSoft Demo</div>
<A href='http://myio.net/software/products/demos/easydynamicpages' target=_new>EsayDynamicPages</A>
<A href='http://myio.net/software/products/demos/easycalendar' target=_new>EsayCalendar</A>
<A href='http://myio.net/software/products/demos/easygallery' target=_new>EsayGallery</A>
<A href='http://myio.net/software/products/demos/easyclassifields' target=_new>EsayClassifields</A>
<A href='http://myio.net/software/products/demos/easybookmarker' target=_new>EsayBookmarker</A>
<A href='http://myio.net/software/products/demos/easypublish' target=_new>EsayPublish</A>
<A href='http://myio.net/software/products/demos/easyecards' target=_new>EsayEcards</A>
<A href='http://myio.net/software/products/demos/easyonlineads' target=_new>EsayOnlineAds</A>";
// USERSONLINE MENU
echo "<div id='h1d'>Users online</div>
<div id='empty'><center><font size='-1'>".$user."</font><br /><br /></center></div>
</td></tr>";
// Advertisement
if(Count($LeftBlockArray)>1) {  echo "
<tr><td  id=\"rightside\">
 <table cellspacing=\"1\">
 <tr><th colspan=\"2\" bgcolor=\"#D62408\">Advertisement</th></tr>";  $cls="evenadv";
 for ($i=1; $i<Count($LeftBlockArray); $i++){
 echo "<tr class=\"".$cls."\"><td  align=\"center\"><br /><P>".$LeftBlockArray[$i]."</P></td></tr>";
 if($cls=="evenadv"){ $cls="oddadv";} else { $cls="evenadv"; }
 }
 echo "</table>";}
// LEFT TABLE END
echo "</td></tr></table>";
// LEFT MENU END
echo "</td>";
///////////////////////////////////////////////////////
//////////////// CONTENT START ////////////////////////
///////////////////////////////////////////////////////
echo "<td id='content'>
<center>
<script type='text/javascript'><!--
google_ad_client = 'pub-4843959578128079';
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = '468x60_as';
google_ad_channel ='';
google_color_border = '660000';
google_color_bg = '7D2626';
google_color_link = 'FFFFFF';
google_color_url = 'DAA520';
google_color_text = 'BDB76B';
//--></script>
<script type='text/javascript'
  src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
</script>
</center>";

if(isset($zfaction)) {
   // ADMIN CONFIG CONTENT
   if($edp_relative_path=="../../") { include ("../../staticpages/easynews/news/admin.php"); } else { include ("../staticpages/easynews/news/admin.php"); }
} else {
   if(isset($zfcategory)) {
     if($zfcategory==$zfcategory2) {
       // DIGEST CONTENT
       include_once "digest.php";
     } else {
       // WORLD NEWS
       if(!isset($zfrefresh)) {
        // SHOW NEWS
        $_GET['zftemplate']="myio_light"; include("../../staticpages/easynews/news/zfeeder.php");
       } else {
        // REFRESH NEWS
        $_GET['zfrefresh']=$zfrefresh;
        echo "<div id='h2usolid'>Refreshing news ".$pagetitle." log data</div><br />";
        $_GET['zftemplate']="myiocontent_light"; include("../../staticpages/easynews/news/zfeeder.php");
        echo "<br /><div id=\"h2osolid\"><a href='".$pagelink."'>Go to refreshed news ".$pagetitle." &raquo;</a></div>";
       }
     }
   } else {
     // LOCAL NEWS
     if(count($newsa)>0 and $page!=="config" and $page!=="topics" and $page!=="contents" and $page!=="authors" and $page!=="search"){
      echo "<p>".$ResultHtml."</p>";
      for ($i=1; $i<=count($newsa); $i++) {echo "<p>".$newsa[$i]."</p>"; }
     }
     echo "<p>".$ResultHtml."</p>";
   }
}
echo "</td>";
///////////////////////////////////////////////////////
////////////////////// RIGHT SIDEBAR START ////////////
///////////////////////////////////////////////////////
echo "<td id='rightside' valign='top'>";
// LOGIN
echo "<div id='login'>";
if (eregi("register",$Adminmenu)){
 echo $Login."<br>".$Adminmenu."";
} else {
 echo str_replace("(Logout)","<br>(Logout)",str_replace("(Login)","<br>(Login)",$Login))."";
}
echo "</div><br>";
// ADMIN MENU
if (!eregi("register",$Adminmenu)) {
echo "<div id=\"loginl\">".str_replace("<br><span","<span",$Adminmenu)."
<br /><br />&nbsp;&raquo;&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?PageSection=".$PageSection."&zfaction=empty\" >RSS Admin</a>
      <br />&nbsp;&raquo;&nbsp;<a href=\"".$edp_relative_path."staticpages/easynews/cron.php\" target=\"_new\">Refresh Now</a></div><br>";
}
// WORLD NEWS IN SHORT
if(isset($zfcategory) and !isset($zfaction) and $zfrefresh!=="refreshnow" and $zfcategory!==$zfcategory2) {
 $_GET['zfcategory']=$zfcategory;
 echo "<div id=\"boxshortnews\"><div id='h2usolid'>ON THIS PAGE</div>
       <a href='index.php?PageSection=8&zfcategory=".$zfcategory."&zfrefresh=refreshnow'>Refresh ".$pagetitle." now</a>";
 $_GET['zftemplate']="myiocontent_light"; include("../../staticpages/easynews/news/zfeeder.php");
 echo "</div><br />";
}
// PAGE MENU
if($LeftBlockArray[0]!=""  and  !isset($zfcategory)){
 echo "<div id='login'>
 <table cellspacing=\"1\">
 <tr class=\"odd\"><td align=\"center\">".str_replace("100;'","100;' size=12",$LeftBlockArray[0])."</td></tr>
 </table></div><br>";
// ON THIS PAGE
 echo "<div id=\"boxside\"><p>".$RightBlockArray[0]."</p></div><br>";
}
 // MYIO.NET
 echo "<div id='login'>
 <table cellspacing='1'>
  <tr><td><div id='h2usolid'>Myio.net</div></td></tr>
  <tr class='odd'><td><A href='http://myio.net/software/' target='_new'>MyioSoft</A></td></tr>
  <tr class='even'><td><A href='http://myio.net/store/' target='_new'>MyioStore</A></td></tr>
  <tr class='odd'><td><A href='http://myio.net/photostore/' target='_new'>Royalty-Free</A></td></tr>
  <tr class='even'><td><A href='http://myio.net/promotion/' target='_new'>AdSense</A></td></tr>
  <tr class='odd'><td><A href='http://myio.net/date/' target='_new'>MyioDating</A></td></tr>
  <tr class='even'><td><A href='http://myio.net/gambling/' target='_new'>MyioGambling</A></td></tr>
  <tr class='odd'><td><A href='http://myio.net/ipw-web/bulletin/bb/index.php' target='_new'>MyioForum</A></td></tr>
 </table></div><br>";
// Advertisement
if(Count($RightBlockArray)>1) { echo "
 <table cellspacing=\"1\">
 <tr><th colspan=\"2\" bgcolor=\"#D62408\">Advertisement</th></tr>"; $cls="evenadv";
 for ($i=1; $i<Count($RightBlockArray); $i++){
  echo "<tr class=\"".$cls."\"><td align=\"center\"><P>".$RightBlockArray[$i]."</P></td></tr>";
  if($cls=="evenadv"){ $cls="oddadv";} else { $cls="evenadv"; }
 }
 echo "</table><br />";
}
// RIGHT SIDEBAR END
echo "</td>";
// MAIN TABLE END
echo "</tr></table>";
////////////////////////////////////////////////////////////
/////////////////////// FOOTER START ///////////////////////
////////////////////////////////////////////////////////////
echo "<table cellspacing='0'>";
// TOP-HOME-BACK
echo "<tr><td align='left' id='footerleft'  width='150'><br />
<MAP NAME='small_navigator_Map'><AREA SHAPE='rect' ALT='Previous visited page' COORDS='82,4,120,20' HREF='javascript:self.history.back();'><AREA SHAPE='rect' ALT='Top of current page' COORDS='45,4,80,19' HREF='#top'><AREA SHAPE='rect' ALT='Root Page' COORDS='4,4,42,18' HREF=''></MAP>
<img src='".$theme_path."images/small_navigator.gif' width='124' height='24' alt='' border='0' hspace=9 USEMAP='#small_navigator_Map'><br />
<br /></td><td></td><td   id='footerright'  width='156'></td></tr>";
?>
<tr id="footer">
    <TD id="footerleft" width="150"  align='center'>
      <a href='http://ads.ipowerweb.com/~afftrend/transaction.php?APID=21&affID=00000000000000014505'><img src='http://ads.ipowerweb.com/~afftrend/gadserv.php?APID=21&affID=00000000000000014505' border='0'></a>
    </TD>
    <TD align="center" id="footercenter">
      <DIV class="footercenter" align="center">
       Powered by EasyNews<br>
      <? $timer->stop('main'); echo $language['Page created in']." ".($timer->get_current('main'))." ".$language['sec']; ?>
      <br>© MyioSoft™ 2003-<?php print(date(Y)); ?>
      </DIV>
   </TD>
    <TD  id="footerright"  width="150" align='center'><br />
    <script type='text/javascript'>
    <!--
    var adhearus_webmaster_id = 10194;
    var adhearus_site_id = 13442;
    var adhearus_ad_size = '120x60';
    -->
    </script>
   <script type='text/javascript' src='http://adhearus.com/display_ad.js'></script>
   <?//- End Adhearus.com Ad Code ?>
    </TD>
</tr>
</table>
</body>
</html>






