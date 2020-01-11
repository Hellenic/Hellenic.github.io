<? // phpinfo(); ?>
<?
// Timer class
if(!defined('_PHP_TIMER_INCLUDED')) {define('_PHP_TIMER_INCLUDED',1);} class phpTimer {function phpTimer (){ $this->_version = '0.1';$this->_enabled = true;}function start ($name = 'default'){ if($this->_enabled){ $this->_timing_start_times[$name] = explode(' ', microtime());}}function stop ($name = 'default'){ if($this->_enabled){ $this->_timing_stop_times[$name] = explode(' ', microtime());}}function get_current ($name = 'default'){ if($this->_enabled){ if (!isset($this->_timing_start_times[$name])){ return 0;}if (!isset($this->_timing_stop_times[$name])){ $stop_time = explode(' ', microtime());}else{ $stop_time = $this->_timing_stop_times[$name];}$current = $stop_time[1] - $this->_timing_start_times[$name][1];$current += $stop_time[0] - $this->_timing_start_times[$name][0];return sprintf("%.10f",$current);}else{ return 0;}}}
$timer =& new phpTimer(); $timer->start('main');

// Particular page color
$EPS=$Easy[$PageSection];
$FDC=$FREEA["DarkColor"];
$FBG=$FREEA["Background"];
$FLC=$FREEA["LightColor"];
$EPScss=str_replace("#","color",$EPS);

//theme path
$theme_path=$edp_relative_path."themes/".$ThemeName."/";

// which is the current pagetitle
if(isset($zfcategory)) {
 $pagetitle=$zfcategory;
} else {
 for ($i=0; $i<$FREEMAX; $i++) {if($i==$PageSection){$pagetitle=str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])));}}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<TITLE>myio.net, WEB is a joy!</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<META content="general" name="rating">
<META content="index, follow" name="robots">
<META content="MSHTML 6.00.2800.1400" name="GENERATOR">
<META content="software, shopping cart software, web design, web development, online shopping, pay pal, software, free software, easy software download, web store, internet store, software, secure ordering, storefront, merchant account, marketplace, secure server, ebusiness, e-business, home business, sell products, online catalog, authorizenet, php, mysql, database driven web site" name=keywords>
<META content="Myio.net™ is place for software developement." name=description>
<META content="MyioSoft™" name=author>
<META content="©2004 www.myio.net" name=copyright>
<script language="JavaScript">
function YesNo(fURL,fMessage) { if (confirm(fMessage)) { self.top.location.href=fURL; } }
function submitMonthYear() {document.monthYear.method = "post"; document.monthYear.action = "index.php?PageSection=<? echo $PageSection; ?>&month=" + document.monthYear.month.value + "&year=" + document.monthYear.year.value; document.monthYear.submit();}
function submitYear() {document.ToYear.method = "post"; document.ToYear.action = "index.php?PageSection=<? echo $PageSection; ?>&page=yearview&year=" + document.ToYear.year.value; document.ToYear.submit();}
function PicWindow(fUrl,W,H) {  W=W+60; H=H+130;  if (H>700) H=700; var X=(screen.availWidth - W) / 2,Y=(screen.availHeight - H - 40) / 2;  w = window.open(fUrl, "fUrl", "left=" + X + ",top=" + Y + ",width=" + W + ",height=" + H +",scrollbars=yes"); w.opener=self; }
function selectColor ( color ) { url = "<? echo $edp_relative_path."admin/colors.php?color="; ?>" + color; var colorWindow = window.open(url,"ColorSelection","width=390,height=343,resizable=no,scrollbars=no"); }
</script>
<LINK href="<?= $theme_path ?>style/stylecss.php?EPScss=<?=$EPScss; ?>"  type="text/css" rel="stylesheet">
</head>
<body>

<!-- TOP LOGO TABLE -->
<table cellspacing="0" width=100%>
<td id="title"  height="60" align="left"  "nowrap"><? echo ucwords($pagetitle); ?></td>
<td id="title1" height="60" align="right" nowrap valign="middle"><img src="<?=$theme_path ?>images/banners/bookmarker468x60.gif" alt="advertisement"></td>
</tr>
</table>

<!-- MAIN TABLE -->
<table cellspacing="0">

<!-- ROW LINKS MENU -->
<tr id="content-top">
 <td id="sidetop" align=center>&nbsp;<? // echo  $pagetitle; ?></td>
 <td id="crumbs" colspan="2">&nbsp;
 </td>
</tr>
<tr>

<!-- #LEFT MENU START# -->
<td id="leftside">

<!-- LEFT TABLE START -->
<table cellspacing="0"><tr><td id="sidelinks">

<!-- LOCAL NEWS -->
<h4>Internal News</h4>
<?
for ($i=0; $i<$FREEMAX; $i++) {
 if (!eregi("staticpages", $FREED[$i]) or eregi("easypublish", $FREED[$i])) {
 if($i==$PageSection){
  $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i;
  echo "<a href='".$pagelink."' id=\"now\">".str_replace("_"," ",str_replace("edp_","",$FREET[$i]))."</a>\n";
 } else {
  echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."'>".str_replace("_"," ",str_replace("edp_","",$FREET[$i]))."</a>\n";
}}}
?>

<!-- WORLD NEWS MENU -->
<h4>World News</h4>
 <?
 for ($i=0; $i<$FREEMAX; $i++) {if (eregi("staticpages/easynews", $FREED[$i])) {$NewsPageSection=$i;}}
 $result=mysql_query("SELECT opmlname FROM edp_newsopml");
 while ($row = mysql_fetch_array($result)) {
  $zfcategory1=$row[opmlname]; $i=$NewsPageSection;
  if(!isset($zfcategory) and $PageSection==$NewsPageSection) {$idnow="id=\"now\"";} else {$idnow="";}
  if ($zfcategory==$zfcategory1) {
    $idnow="id=\"now\""; $PageSection=$NewsPageSection;
    $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory1;
    echo "<a href='".$pagelink."' ".$idnow.">".$zfcategory1."</a></b>\n";
  } else {
    echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."&zfcategory=".$zfcategory1."' ".$idnow.">".ucwords($zfcategory1)."</a></font></b>\n";
  }
}
?>

<!-- TOOLS MENU -->
<h4>Tools</h4>
<?
for ($i=1; $i<$FREEMAX; $i++) {
 if (eregi("staticpages", $FREED[$i]) and !eregi("staticpages/easynews", $FREED[$i])) {
 if($i==$PageSection){
  $pagelink=$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i;
  echo "<a href='".$pagelink."' id=\"now\">".str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])))."</a>\n";
 } else {
  echo "<a href='".$edp_relative_path.$FREED[$i]."/index.php?PageSection=".$i."'>".str_replace("Easy","",str_replace("_"," ",str_replace("edp_","",$FREET[$i])))."</a>\n";
}}}
?>

<!-- MS MENU -->
<h4>Awebdate Links</h4>
<A href="http://awebdate.com/datesite/" target=_new>A Web Date</A>
<A href="http://awebdate.com/store/" target=_new>Store</A>
<A href="http://awebdate.com/datelist/" target=_new>Community</A>
<A href="http://awebdate.com/ads/" target=_new>Google Ads</A>
<A href="http://awebdate.com/promotion/" target=_new>Promotion</A>
<A href="http://awebdate.com/main/" target=_new>News Corner</A>
<br />

<!-- UsersOnline MENU -->
<div id="login"><? echo $user; ?> </div>
</td>
</tr>

<!-- LEFT SIDEBAR -->
<? if(Count($LeftBlockArray)>1) {  echo "
<tr><td  id=\"rightside\">
<table cellspacing=\"1\"><br>
<tr><th colspan=\"2\">Left Sidebar</th></tr>\n";  $clas="even";
for ($i=1; $i<Count($LeftBlockArray); $i++){ echo "<tr class=\"".$clas."\"><td align=\"center\"><br /><P>".$LeftBlockArray[$i]."</P></td></tr>\n";}
echo "</table><br /></td></tr>\n";}
?>
</table>
<!-- LEFT TABLE END -->
</td>
<!-- #LEFT MENU END# -->


<!-- #CONTENT START# -->
<td id="content">

<!-- LOCAL NEWS CONTENT -->
<?
if(!isset($zfcategory) and !isset($zfaction)) {
  if(count($newsa)>0 and $page!=="config" and $page!=="topics" and $page!=="contents" and $page!=="authors" and $page!=="search"){
   echo "<p>".$ResultHtml."</p>\n";
   for ($i=1; $i<=count($newsa); $i++) { echo "<p>".$newsa[$i]."</p>\n"; }
  }
  echo "<p>".$ResultHtml."</p>\n";
}
?>

<!-- WORLD NEWS CONTENT -->
<?
if(isset($zfcategory) and !isset($zfaction)) {
 $_GET['zfcategory']=$zfcategory;
 echo "<table><tr>\n
 <td width='150' valign='top'>\n
 <div id=\"traveltipleft\">\n
 <h1>ON THIS PAGE</h1>
 <a href='".$pagelink."&zfrefresh=refreshnow'>refresh ".$pagetitle." now</a><br /><br />\n";
 if($zfrefresh=="refreshnow") {
   $_GET['zfrefresh']=$zfrefresh;
   echo "<div class=\"pullquote\"><a href='".$pagelink."'>Go to the refreshed news ".$pagetitle." &raquo;</a></div><br />";
 }
 $_GET['zftemplate']="myiocontent_green"; include("../../staticpages/easynews/news/zfeeder.php");
 echo "</div><br />\n";
 if(!isset($zfrefresh)) {
   echo "</div><br /></td>\n
   <td valign='top' width='20'>&nbsp;&nbsp;&nbsp;</td>\n<td>\n";
   $_GET['zftemplate']="myio_green"; include("../../staticpages/easynews/news/zfeeder.php");
 } else {
   }
   echo "</td></tr></table>\n";
}
?>


<!-- ADMIN CONFIG CONTENT -->
<?
if(isset($zfaction)) {
if($edp_relative_path=="../../") {
  include ("../../staticpages/easynews/news/admin.php");
} else {
  include ("../staticpages/easynews/news/admin.php");
}}
?>


<!-- GOOGLE SEARCH CONTENT -->
<div class="google">
  <FORM method=GET action='http://www.google.com/custom'>
    <A HREF='http://www.google.com/' target="_new"><img src='<?=$theme_path ?>images/Logo_25wht.gif' border='0' ALT='Google' align='absmiddle'></A>
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
<!-- #CONTENT END# -->



<!-- #RIGHT SIDEBAR START# -->
<td id="rightside">

<!-- LOGIN -->
<div id="login">
<?
if (eregi("register",$Adminmenu)){echo $Login."<br>".$Adminmenu."\n"; }
else { echo str_replace("(Logout)","<br>(Logout)",str_replace("(Login)","<br>(Login)",$Login))."\n"; }
?>
</div><br>

<!-- ADMIN MENU -->
<? if (!eregi("register",$Adminmenu)) {echo "<div id=\"loginl\">\n".str_replace("<br><span","<span",$Adminmenu)."\n
<br /><br />&nbsp;&raquo;&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?PageSection=".$PageSection."&zfcategory=".$zfcategory."&zfaction=empty\" >RSS Admin</a>
      <br />&nbsp;&raquo;&nbsp;<a href=\"".$edp_relative_path."staticpages/easynews/cron.php\" target=\"_new\">Refresh Now</a></div><br>";}
?>

<!-- AWEBDATE.NET -->
<table cellspacing="1">
 <tr><th colspan="2">AWebDate.com</th></tr>
 <tr class="odd"><td><A href="http://awebdate.com/datesite/" target=_new>A Web Date</A></td></tr>
 <tr class="even"><td><A href="http://awebdate.com/store/" target=_new>Store</A></td></tr>
 <tr class="odd"><td><A href="http://awebdate.com/datelist/" target=_new>Community</A></td></tr>
 <tr class="even"><td><A href="http://awebdate.com/ads/" target=_new>Google Ads</A></td></tr>
 <tr class="odd"><td><A href="http://awebdate.com/promotion/" target=_new>Promotion</A></td></tr>
 <tr class="even"><td><A href="http://awebdate.com/main/" target=_new>News Corner</A></td></tr>
</table><br>
<!-- PAGE MENU --><? if($LeftBlockArray[0]!=""  and  !isset($zfcategory)){echo "
<table cellspacing=\"1\">
<tr><th colspan=\"2\">Page Menu</th></tr>
<tr class=\"even\"><td align=\"center\"><P>".str_replace("100;'","100;' size=12",$LeftBlockArray[0])."</P></td></tr>
</table><br>\n"; }
?>

<!-- ON THIS PAGE -->
<? if($RightBlockArray[0]!=""){ echo "<div id=\"traveltip\"><p>".$RightBlockArray[0]."</p></div><br>\n"; } ?>

<!-- RIGHT SIDEBAR --><? if(Count($RightBlockArray)>1) { echo "
<table cellspacing=\"1\">
<tr><th colspan=\"2\">Right Sidebar</th></tr>\n"; $clas="even";
for ($i=1; $i<Count($RightBlockArray); $i++){ echo "<tr class=\"".$clas."\"><td align=\"center\"><P>".$RightBlockArray[$i]."</P></td></tr>\n";}
echo "</table><br />\n";}
?>
</td><!-- #RIGHT SIDEBAR END# -->
</tr>
</table>

<!-- #FOOTER START# -->
<table cellspacing="0">
<tr id="footer">
    <TD id="feedback" width="150">
      <a href='http://ads.ipowerweb.com/~afftrend/transaction.php?APID=21&affID=00000000000000014505'><img src='http://ads.ipowerweb.com/~afftrend/gadserv.php?APID=21&affID=00000000000000014505' border='0'></a>
    </TD>
    <TD align="center">
      <DIV class="footer_text" align="center">Powered by EasyDynamicPages<br>
      <? $timer->stop('main'); echo $language['Page created in']." ".($timer->get_current('main'))." ".$language['sec']; ?>
      <br>Copyright © 2004 AWebDate™
      </DIV>
   </TD>
    <TD id="copyright"  width="150" align="center"><br />
    <!--- Start Adhearus.com Ad Code ----->
    <script type='text/javascript'>
    <!--
    var adhearus_webmaster_id = 10194;
    var adhearus_site_id = 13442;
    var adhearus_ad_size = '120x60';
    //-->
    </script>
   <script type='text/javascript' src='http://adhearus.com/display_ad.js'></script>
   <!--- End Adhearus.com Ad Code ----->
    </TD>
</tr><!-- #FOOTER END# -->
</table>
</body>
</html>
