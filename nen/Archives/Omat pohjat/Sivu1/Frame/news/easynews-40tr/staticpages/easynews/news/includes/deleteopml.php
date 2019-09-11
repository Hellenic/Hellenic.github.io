<?php
// zFeeder 1.6 - copyright (c) 2004 Andrei Besleaga
// http://zvonnews.sourceforge.net

// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.


if(zfAuth()==false) {exit;}

function zfurl()
{
	$refer=$_SERVER['HTTP_REFERER'];
	if( isset($refer) && $refer!='') {
          return substr($refer,0,strrpos($refer,"/")+1);
	} else {
          return false;
	}
}

if($_POST['dosave']=='Do Changes')
{
  $DELOPMLFIELD=$_POST['opmlfield'];
  $RENOPMLFIELD=ucwords($_POST['newopmlfield']);
   if($RENOPMLFIELD=="") {
    mysql_query("DELETE FROM   edp_newsopml  WHERE opmlname='$DELOPMLFIELD'");
    echo "<font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><br><center>deleted opml field <b>".$DELOPMLFIELD."</b> ...</center><br></font>";
   } else {
    mysql_query("UPDATE edp_newsopml SET opmlname='$RENOPMLFIELD' WHERE opmlname='$DELOPMLFIELD'");
    echo "<font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><br><center>renamed opml field <b>".$DELOPMLFIELD."</b> to <b>".$RENOPMLFIELD."</b> ...</center><br></font>";
   }
}
else
{
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="5">
  <form name="configform" action="<?php echo $_SERVER['PHP_SELF'].'?zfaction=deleteopml';?>" method="post">
    <tr valign="top">
      <td colspan="2" align="center"><font color="#CC3300" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
        notes:</font><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        - take care when removing an opml field (rss feeds are also deleted). <br>Then you cannot restore deleted data
        </font></td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Delete existing opml field
        </font></strong></td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
        </font></td>
    </tr>
    <tr valign="top">
      <td height="22" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">*
           select opml field to delete/rename :<br>
        </font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
          <select name="opmlfield" id="opmlfield"  style="border-style:groove;">
			<?php
				echo listCateg(ZF_CATEGORY);
			?>
        </select>
        </input>
        <font color="#006699" size="1">(belonging rss feeds also deleted/renamed)</font></font></td>
    </tr>
    <tr valign="top">
      <td height="22" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">*
        type new name for the opml field chosen :<br>
        </font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
        <input name="newopmlfield" type="text" id="newopmlfield"></input>
        <font color="#006699" size="1">(if empty the field will be deleted)</font> </font></td>
    </tr>

    <tr valign="top">
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <input type="submit" name="dosave"  id="dosave" value="Do Changes" style="border-style:groove;"></input>
        </font></td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
    </tr>
  </form>
</table>
<br>
<?php } ?>
