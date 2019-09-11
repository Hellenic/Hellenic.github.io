<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
        ******************************************** software.stoitsov.com */

if($edp_relative_path==="../") { include_once "../admin/serverdata.php"; } else { include_once "../../admin/serverdata.php";}
  //ob_gzhandler
  $gzhandler=0;
  if($gzhandler!==0)  { $phpver = phpversion();
   if ($phpver >= '4.0.4pl1' && strstr($HTTP_USER_AGENT,'compatible')) {
    if (extension_loaded('zlib')) { ob_end_clean(); ob_start('ob_gzhandler'); }
   } else if ($phpver > '4.0') {
    if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) {
      if (extension_loaded('zlib')) {
       $do_gzip_compress = TRUE; ob_start(); ob_implicit_flush(0);
       header('Content-Encoding: gzip');
      }
    }
   }
  }
// Installation On/Off
// $installT=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF'])."/install.php";
// $installF=$_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
// if($installT==$installF) { return; }
// Connect server, select dbase
mysql_connect($Easy["mysql_host"],$Easy["mysql_user"],$Easy["mysql_pass"]);
mysql_select_db($Easy["mysql_base"]);
// FETCH edp_usersonline: '$to_secs'- the time to reset IP address's value in seconds (120 is 2 minutes)
$to_secs = 120; $t_stamp = time(); $timeout = $t_stamp - $to_secs; $ip = $_SERVER["REMOTE_ADDR"];
mysql_query("INSERT INTO edp_usersonline VALUES('".$t_stamp."','".$ip."')");
mysql_query("DELETE FROM edp_usersonline WHERE timestamp<$timeout");
$Easy["user"] = mysql_num_rows(mysql_query("SELECT DISTINCT ip FROM edp_usersonline"));
// FETCH edp_CONFIG
$result = mysql_query("SELECT sitetitle, sitecharset, sitecontent, siteauthor, pagesectionhome, themename, abackground, adarkcolor, agraycolor, alightcolor, ebackground, elightcolor1, eightcolor2, earticles, econtact, enews_per_page, ehead_per_page, etable_width, elinks_per_page, enew_days, epage_width, egd_version, epics_per_page, edemo_mode, emedia_folder, ecats_per_page,  eupload_fields, eupload_resizex, eupload_resizey, thelanguage  from edp_config where ID=1");
list($sitetitle, $sitecharset, $sitecontent, $siteauthor, $PageSectionHome, $ThemeName, $Easy["Background"],$Easy["DarkColor"],$Easy["GrayColor"],$Easy["LightColor"],$Easy["Background"],$Easy["LightColor1"],$Easy["LightColor2"], $Easy["Articles"],$Easy["Contact"],$Easy["news_per_page"],$Easy["head_per_page"],$Easy["table_width"],$Easy["links_per_page"],$Easy["new_days"],$Easy["page_width"],$Easy["gd_version"],$Easy["pics_per_page"],$Easy["demo_mode"],$Easy["media_folder"],$Easy["cats_per_page"],$Easy["upload_fields"],$Easy["upload_resizeX"],$Easy["upload_resizey"], $lang) = mysql_fetch_row($result);
// Set the HomePageSection
If(!isset($PageSection)) $PageSection=$PageSectionHome;
// FETCH edp_PCONFIG
$Config=mysql_query("SELECT * FROM edp_pconfig ORDER BY ID");
$toc=-1; while ($Conf=mysql_fetch_array($Config) ) {$toc++; $FREEID[$toc]=$Conf["ID"]; $FREEIS[$Conf["ID"]]=$toc;
$Easy[$toc]=$Conf["dpFREE"]; $FREED[$toc]=$Conf["dpFREED"]; $FREETDB[$toc]=$Conf["dpFREET"]; $FREET[$toc]=str_replace("_"," ",str_replace("edp_","",$FREETDB[$toc]));
$LBData[$toc]=$Conf["dpLBData"]; $RBData[$toc]=$Conf["dpRBData"];
If(isset($BookMarker) && $FREED[$toc]=="staticpages/easybookmarker") {$PageSection=$toc;}}
// Set Number of all pages
$FREEMAX=count($FREET);
// Charge LeftBlockData array
$spL=preg_split('/:/',$LBData[$PageSection]);
for ($i=0; $i<count($spL); $i++) {$LeftBlockData[$i]=$spL[$i].".php";}
// Charge RightBlockData array
$spR=preg_split('/:/',$RBData[$PageSection]);
for ($i=0; $i<count($spR); $i++) {$RightBlockData[$i]=$spR[$i].".php";}
// Languages
if(!include_once  "language/language_".$lang.".php"){include_once  "language/language_us.php";}
if($edp_relative_path==="../") {
if(!include_once  "../themes/".$ThemeName."/language/language_".$lang.".php") {include_once  "../themes/".$ThemeName."/language/language_us.php";}
include_once      "../themes/".$ThemeName."/indexf.php";
} else {
if(!include_once  "../../themes/".$ThemeName."/language/language_".$lang.".php") {include_once  "../../themes/".$ThemeName."/language/language_us.php";}
include_once      "../../themes/".$ThemeName."/indexf.php";
}
?>
