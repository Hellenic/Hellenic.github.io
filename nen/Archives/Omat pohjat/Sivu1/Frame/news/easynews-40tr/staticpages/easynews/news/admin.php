<?php
// zFeeder 1.6 - copyright (c) 2003-2004 Andrei Besleaga
// http://zvonnews.sourceforge.net
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.


// security
if($edp_relative_path=="../../") {
 include ("../../staticpages/easynews/news/config.php");
 include ("../../staticpages/easynews/news/includes/adminfuncs.php");
} else if($edp_relative_path=="../"){
 include ("../staticpages/easynews/news/config.php");
 include ("../staticpages/easynews/news/includes/adminfuncs.php");
} else {
 include ("config.php");
 include ("includes/adminfuncs.php");
}


error_reporting (E_ALL ^ E_NOTICE);
if ($_GET['zfaction'] == 'logout') zfLogout();

if(ZF_LOGINTYPE=='server')
{
	if ($_SERVER['PHP_AUTH_USER'] != ZF_ADMINNAME || md5($_SERVER['PHP_AUTH_PW']) != ZF_ADMINPASS) {
	    header("WWW-Authenticate: Basic realm=\"zFeeder Authentication\"");
	    header("HTTP/1.0 401 Unauthorized");
		zfLoginFailed();
        } else {
	    define(ZF_ADMINLOGGED, "yes");
	}
}
elseif(ZF_LOGINTYPE=='session')
{
	session_start(); // needed if authentication mechanism is session
	if ($_POST['submit_login'] == 'Log In!')
	{
		if ($_POST['admin_user'] != ZF_ADMINNAME || md5($_POST['admin_pass']) != ZF_ADMINPASS)
		{
			zfLoginFailed();
		} else	{
			$_SESSION['admin_user'] = $_POST['admin_user'];	// set username
			$_SESSION['admin_pass'] = $_POST['admin_pass'];	// set password
			$_SESSION['logged_in'] = 1;
		}
	 }
	if ($_SESSION['logged_in'] != 1)
	{
		echo "<html><head><title>zFeeder Authentication</title></head><body>";
		echo "<div align=\"center\"><form action={$_SERVER['PHP_SELF']} method=\"post\">";
		echo "Username: <input type=\"text\" name=\"admin_user\"> <br/>";
		echo "Password: <input type=\"password\" name=\"admin_pass\"> <br/>";
		echo "<input type=\"submit\" name=\"submit_login\" value=\"Log In!\">";
		echo "</form></div></body></html>";
		exit;
	} else {
	    define(ZF_ADMINLOGGED, "yes");
	}
} else {
	echo '<html><head><title>zFeeder Admin Panel - auth not set</title><body><h3>Authentication mechanism not configured !</h3></body></html>';
        exit;
}

    $result=mysql_query("SELECT * FROM edp_newsopml");
    while ($row = mysql_fetch_array($result)) {
     if(ZF_CATEGORY==$row[opmlname])         { $deffopmlfile=$row[opmlbody]; }
     if($_POST['zfcategory']==$row[opmlname]) { $curropmlfile=$row[opmlbody]; }
    }



$zfpath = str_replace("\\", "/", dirname(__FILE__)) . "/";
if (isset($_POST['zfcategory']) && $_POST['zfcategory']!='' && isset($curropmlfile)) {
	$crtcategory=$_POST['zfcategory'];
        $opmlfilename=$curropmlfile;
} else {
	$crtcategory=ZF_CATEGORY;
        $opmlfilename=$deffopmlfile;
}

ini_set("user_agent","zfeeder/".ZF_VER." (http://zvonnews.sf.net)");
?>

<!--
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<title>zFeeder admin panel</title>
	<body>
-->
	<table width="334" align="center">
	  <tr>
    <td width="90" height="18" align="center"><font color="#006699" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="http://zvonnews.sourceforge.net">zvonnews.sourceforge.net</a></font></td>
    <td width="229" align="left" valign="middle"><font color="#006699" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>zFeeder
      administration panel</strong></font></td>
	  </tr>
	</table>

<table width="850" border="0" align="center">
  <tr>
    <td height="22" align="center" bgcolor="#EBDAC6"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?zfaction=empty">main</a>
           <?php if (ZF_USEOPML == 'yes') echo " :: <a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=addnew\">add new feeds</a>";?>
	   <?php if (ZF_USEOPML == 'yes') echo " :: <a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=subscriptions\">subscriptions</a>";?>
       :: <a href="<?php echo $_SERVER['PHP_SELF'] . '?zfaction=config';?>">config</a>
           <?php if (ZF_USEOPML == 'yes') echo " :: <a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=addnewopml\">add opml</a>";?>
           <?php if (ZF_USEOPML == 'yes') echo " :: <a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=deleteopml\">delete/rename opml</a>";?>
	   <?php if (ZF_USEOPML == 'yes') echo " :: <a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=importlist\">import feed list</a>";?>
	   :: <a href="<?php echo $_SERVER['PHP_SELF'] . '?zfaction=updates';?>">updates</a>
	  </font></td>
  </tr>
  <tr>
    <td bgcolor="#F9F9F9">
<?php
        if ($_GET['zfaction'] == 'subscriptions')  include('includes/subscriptions.php');
        elseif ($_GET['zfaction'] == 'addnew')     include('includes/addnewfeed.php');
        elseif ($_GET['zfaction'] == 'addnewopml') include('includes/addnewopml.php');
        elseif ($_GET['zfaction'] == 'deleteopml') include('includes/deleteopml.php');
	elseif ($_GET['zfaction'] == 'importlist') include('includes/importlist.php');
        elseif ($_GET['zfaction'] == 'config')     include('includes/changeconfig.php');
	elseif ($_GET['zfaction'] == 'updates') {
?>
      <table width="400" border="0" align="center">
		<tr align="left" valign="top">
			  <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
<?php
    echo "<br><br>Your zFeeder version: <font color=\"#CC3300\"> " . ZF_VER . " </font><br><br>";
    @$update = readfile('http://zvonnews.sourceforge.net/latest.php');
    if (!$update) echo "Error: could not open update file.<br><br>You can check it manually at: <a href=\"http://zvonnews.sourceforge.net/latest.php\">http://zvonnews.sourceforge.net/latest.php</a>.";
    echo '<br><br>';

?>
			  <br>
			  </td>
		</tr>
	</table>
<?php } else { ?>
      <table width="450" border="0" align="center" cellpadding="0" cellspacing="5"><br />
<!--
        <tr>
          <td height="50" colspan="2" align="center" valign="middle"><br>
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#009900">welcome <?php echo ZF_ADMINNAME;?> !</font>
              <br><br>
          </td>
        </tr>
-->
        <tr valign="middle" bgcolor="#F3F3F3">
          <td width="50%" height="16" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <?php if (ZF_USEOPML == 'yes') echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=addnew\">add new feeds</a>"; else echo 'add new feeds';?>
		   </font></td>
          <td align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">-
            add new feeds (channels)</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
	   <?php if (ZF_USEOPML == 'yes') echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=subscriptions\">subscriptions</a>"; else echo 'subscriptions';?>
		  </font></td>
          <td align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">-
            modify / delete news feeds</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="<?php echo $_SERVER['PHP_SELF'] . '?zfaction=config';?>">config</a></font></td>
          <td align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">-
            change zFeeder configuration</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td height="16" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <?php if (ZF_USEOPML == 'yes') echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=addnewopml\">add opml</a>"; else echo 'add opml';?>
		   </font></td>
          <td align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">-
            add new empty opml</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td height="16" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <?php if (ZF_USEOPML == 'yes') echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=deleteopml\">delete/rename</a>"; else echo 'delete/rename';?>
		   </font></td>
          <td align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">-
            delete/rename existing opml field</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td height="16" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
	 	   <?php if (ZF_USEOPML == 'yes') echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?zfaction=importlist\">import feed list</a>";  else echo 'import feed list'; ?>
		  </font></td>
          <td width="336" align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
            - import feeds from opml feedlist</font></td>
        </tr>
        <tr valign="middle" bgcolor="#F3F3F3">
          <td height="16" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="<?php echo $_SERVER['PHP_SELF'] . '?zfaction=updates'; ?>">updates</a></font></td>
          <td width="336" align="left"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
            - check of updates on zFeeder site</font></td>
        </tr>
      </table>
      <br>
<?php } ?>
	</td>
  </tr>
  <tr>
        <td height="20" align="center" valign="middle" bgcolor="#EBDAC6"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      powered by <a href="http://zvonnews.sourceforge.net">zFeeder <?php echo ZF_VER;?></a>
      - &copy;2003-2004 by Andrei Besleaga </font></td>
  </tr>
	</table>
<!--
</body>
</html>
-->
