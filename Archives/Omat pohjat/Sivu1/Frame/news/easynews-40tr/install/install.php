<?

//*** db_path and host variables ***
$edp_relative_path=str_replace("/install","",str_replace("\\","",dirname($_SERVER['PHP_SELF'])."/"));
require_once("../admin/serverdata.php");

//*** functions ***
function populate_db($DBname, $sqlfile='mysql.sql') { mysql_select_db($DBname); $query = fread(fopen($sqlfile, "r"), filesize($sqlfile)); $pieces  = split_sql($query); $errors = array(); for ($i=0; $i<count($pieces); $i++) { $pieces[$i] = trim($pieces[$i]); if(!empty($pieces[$i]) && $pieces[$i] != "#") { if (!$result = mysql_query ($pieces[$i])) { $errors[] = array ( mysql_error(), $pieces[$i] ); } } } }
function split_sql($sql) { $sql = trim($sql); $sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);  $buffer = array(); $ret = array(); $in_string = false;  for($i=0; $i<strlen($sql)-1; $i++) { if($sql[$i] == ";" && !$in_string) { $ret[] = substr($sql, 0, $i); $sql = substr($sql, $i + 1); $i = 0; }  if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") { $in_string = false; } elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")) { $in_string = $sql[$i]; } if(isset($buffer[1])) { $buffer[0] = $buffer[1]; } $buffer[1] = $sql[$i]; }  if(!empty($sql)) { $ret[] = $sql; }  return($ret); }
function clError($Heading="Error!",$Error="",$Solution="") { return "<br><table  border=0 cellspacing=0 cellpadding=0 align=center><tr><td><div style='background-color:#FFD8D8; border: 2px solid red; padding:10 10 10 10; font: 11px Verdana;'> <font color=red><b>$Heading</b></font><br><P>".mysql_error()."<b>$Error</b></P><i>$Solution</i></div></td></tr></table><br>";}
function clTr($width=1,$height=1) {return "<img src='images/tr.gif' width='$width' height='$height' alt='' border='0'>";}
function clMyQuery($Query) { Global $sql ; $Res=mysql_query($Query) or Die (clError("Error!","<br>Invalid DataBase Query.","<PRE>The query is:<br>$Query</PRE><a href='".$_SERVER["PHP_SELF"]."'>Click here</a> and correct the error.")); return $Res; }
function clHeading($Heading,$BR=1) { $ret.="<span class='h1s'>".$Heading."</span>"; for ($t=0; $t<$BR; $t++) $ret.="<BR>"; return $ret."\n"; }

//*** Version and install colors ***
$Easy[$PageSection]="#226834";  $Easy["Background"]="#DCFFE5"; $Easy["LightColor1"]="#CDEFD6"; $Easy["LightColor2"]="#C4E2CC";

//*** Step 1 ***
if (!isset($page)) {$ResultHtml=clHeading($Easy["product"]." Installation",1)."
<p><b>Step 1 of 3</b></p>
<b>Pre-installation check for version ".$Easy["version"]."</b>
<p>You have <font color=red>unziped</font> the source file in ";
if($edp_relative_path=="/") {$ResultHtml.=" your root directory <font color=blue>".$edp_relative_path."</font>."; } else { $ResultHtml.="the directory <font color=blue>".$edp_relative_path."</font> under your root."; }
$ResultHtml.="<br>Therefore, <font color=blue>".$edp_relative_path."</font> will be your ".$Easy["product"]." directory.</p>
<ol>
<b>1) If any of the items below are highlighted in red then please correct them:</b><br>";
$ResultHtml.= "<br>&nbsp; - PHP Version ".phpversion()." is &nbsp;"; if(phpversion()< '4.1') {$ResultHtml.= "<b><font color='red'>Not supported</font></b>";} else {$ResultHtml.= "<b><font color='green'>OK</font></b>";}
$ResultHtml.= "<br>&nbsp; - Zlib support for PHP is &nbsp;"; if(extension_loaded('zlib')) {$ResultHtml.= "<b><font color='green'>OK</font></b>"; } else {$ResultHtml.= "<b><font color='red'>Not supported</font></b>";}
$ResultHtml.= "<br>&nbsp; - XML support for PHP is &nbsp;"; if(extension_loaded('xml')) {$ResultHtml.= "<b><font color='green'>OK</font></b>"; } else {$ResultHtml.= "<b><font color='red'>Not supported</font></b>";}
$ResultHtml.= "<br>&nbsp; - MySQL support for PHP is &nbsp;"; if(function_exists('mysql_connect')) {$ResultHtml.= "<b><font color='green'>OK</font></b>";  } else {$ResultHtml.= "<b><font color='red'>Not supported</font></b>"; }

$ResultHtml.="<br><br>
<b>2) The file <font color=blue>serverdata.php</font> from <font color=blue>".$edp_relative_path."admin/</font> directory contains the following information:</b><br>
<br><font color=blue>&nbsp;&nbsp;\$Easy[\"mysql_host\"]=\"".$Easy["mysql_host"]."\";
<br>&nbsp;&nbsp;\$Easy[\"mysql_user\"]=\"".$Easy["mysql_user"]."\";
<br>&nbsp;&nbsp;\$Easy[\"mysql_pass\"]=\"".$Easy["mysql_pass"]."\";
<br>&nbsp;&nbsp;\$Easy[\"mysql_base\"]=\"".$Easy["mysql_base"]."\";</font>
<br><br>
<b>If this information is not correct <font color=red>open the file </font> with your preffered text editor and <font color=red> make </font> the changes:</b>
<br><br>&nbsp;&nbsp;<font color=red>Change</font> the variable <font color=blue>".$Easy["mysql_host"]."</font> to your <b>DataBase server name</b>.
<br>&nbsp;&nbsp;<font color=red>Change</font> the variable <font color=blue>".$Easy["mysql_user"]."</font> to your <b>DataBase server user name</b>.
<br>&nbsp;&nbsp;<font color=red>Change</font> the variable <font color=blue>".$Easy["mysql_pass"]."</font> to your <b>DataBase server password</b>.
<br>&nbsp;&nbsp;<font color=red>Change</font> the variable <font color=blue>".$Easy["mysql_base"]."</font> to your <b>DataBase name</b>.
<br><br><b><font color=red>Save </font> the file <font color=blue>serverdata.php</font></b><br>
</ol>
&nbsp;&nbsp;&nbsp;<a href='".$_SERVER["PHP_SELF"]."?page=2' class=normal><b>NEXT >></b></a> ";}
// <input type='radio' name='help_version' value='2'><b>All Tables with minimal input + some help information</b><br>

//*** Step 2 ***
if (isset($page) && $page==2) {
$ResultHtml.=clHeading($Easy["product"]." Installation",1)."
<p><b>Step 2 of 3</b></p>
<b>Database tables.</b><br><br>
<b>The Database called <font color=blue>".$Easy["mysql_base"]."</font> will be created in your MySQL server, unless you have it already created.
<br>Notice that all tables from your previouse instalations of ".$Easy["product"]." will be deleted.</b><br><br>
<ol>
<p><b>The <font color=red>install program is going to create and populate</font> the required tables into <br> your MySQL Server (<font color=blue>".$Easy["mysql_host"]."</font>) with database (<font color=blue>".$Easy["mysql_base"]."</font>)</b>.<br></p>
</ol>";

$ResultHtml.= "<p><b>If there are errors after you click the link <b>NEXT</b> below, hit <font color=red>back</font> of your web browser and try to correct them.</b></p>

&nbsp;&nbsp;&nbsp;<a href='".$_SERVER["PHP_SELF"]."?page=3' class=normal><b>NEXT >></b></a> ";
if (!($mysql_link = @mysql_connect( $Easy['mysql_host'], $Easy['mysql_user'], $Easy['mysql_pass']))) {
echo "Step Back!, the password and/or username provided are incorrect"; Die;}
$sql = "CREATE DATABASE `".$Easy['mysql_base']."`"; $mysql_result = mysql_query( $sql );
$test = mysql_errno(); if ($test <> 0 && $test <> 1007) { echo "StepBack, a database error occurred\n<b>".mysql_error()."</b>"; }
}

//*** Step 3 ***
if (isset($page) && $page==3) {
if (!($mysql_link = @mysql_connect( $Easy['mysql_host'], $Easy['mysql_user'], $Easy['mysql_pass'])))
{echo "Step Back!, the password and/or username provided are incorrect"; Die;}
populate_db($Easy['mysql_base'],'mysql.sql');
$ResultHtml=clHeading($Easy["product"]." Installation",1)."<br>&nbsp;&nbsp;&nbsp;<b>Step 3 of 3</b>
<ol>
<left><h1>Congatulations!</h1><br></left>
<left><h1>Now, you are able to use your ".$Easy["product"].".</h1><br></left>
<b>Your admin name and passwords are <font color=red>demo, demo</font>.</b> <font color=red>Please, do not forget to change them and delete the install folder</font>.<br>
<left><h1><br><a href='".str_replace("install/install.php","index.php",$_SERVER['PHP_SELF'])."'>Click here</a> and Enjoy !</h1></left>
</ol>";
}
// str_replace("/install","",str_replace("\\","",dirname($_SERVER['PHP_SELF'])."/"));
// *** HTML Output ***
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
<head>
<title>.: ".$Easy["product"]." - v".$Easy["version"]." :.</title>
<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=windows-1251\">
<META NAME=\"description\" CONTENT=\"".$Easy["product"]." Software - by http://myio.net/software\">
<META NAME=\"author\" CONTENT=\"Idea&development - Cyber/SAS & Mario Stoitsov\">
<style type=\"text/css\">
body {font: 15px Arial, Helvetica; color:black; background-color: ".$Easy["Background"]."; scrollbar-DarkShadow-Color: ".$Easy[$PageSection]."; scrollbar-Track-Color: ".$Easy[$PageSection]."; scrollbar-Face-Color:        ".$Easy[$PageSection]."; scrollbar-Shadow-Color: ".$Easy["Background"]."; scrollbar-Highlight-Color: ".$Easy["Background"]."; scrollbar-3dLight-Color: ".$Easy[$PageSection]."; scrollbar-Arrow-Color: ".$Easy["Background"].";}
.h1s {font: 18px Verdana; font-weight:bold; color: ".$Easy[$PageSection].";}
a:link.normal, a:visited.normal {font: 11px Arial; color: ".$Easy[$PageSection]."; text-decoration:none;}
a:hover.normal {font: 11px Arial; color: red; text-decoration:none;}
</style>
</head>
<body OnLoad='self.status=\"".$Easy["product"]." ver.".$Easy["version"]."\"; return true;'>\n".$ResultHtml."
</body>\n
</html>";
?>
