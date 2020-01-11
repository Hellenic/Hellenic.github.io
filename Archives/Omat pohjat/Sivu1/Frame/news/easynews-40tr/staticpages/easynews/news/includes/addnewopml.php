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

if($_POST['dosave']=='Save settings')
{
  $NEWOPMLFIELD=ucwords($_POST['opmlfield']);
  $opmlbody="<?xml version=\"1.0\"?>\n
             <opml version=\"1.0\">\n
              <body>\n
             </body>\n
             </opml>\n";

  mysql_query("INSERT INTO edp_newsopml VALUES(null, '$NEWOPMLFIELD', '$opmlbody', '');");
  echo "<font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><br><center>new opml field <b>".$NEWOPMLFIELD."</b> saved ...</center><br></font>";
}
else
{
?>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="5">
  <form name="configform" action="<?php echo $_SERVER['PHP_SELF'].'?zfaction=addnewopml';?>" method="post">
    <tr valign="top">
      <td colspan="2" align="center"><font color="#CC3300" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
        notes:</font><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- take care when Creating new empty opml field (don't dublicate the names)<br>
        - use capitalized single words as a name of the new opml field
        </font></td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Create new empty opml field
        </font></strong></td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
        </font></td>
    </tr>
    <tr valign="top">
      <td height="22" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">*
        type new opml field :<br>
        </font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;
        <input name="opmlfield" type="text" id="opmlfield"></input>
        <font color="#006699" size="1">(where RSS files will be kept)</font> </font></td>
    </tr>
    <tr valign="top">
      <td height="22" align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">*
           existing opml fields :<br>
        </font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">
			<?php
				echo listCateg(ZF_CATEGORY);
			?>
        <font color="#006699" size="1">(do not dublicate these fields)</font></font></td>
    </tr>
    <tr valign="top">
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="top">
      <td colspan="2" align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <input type="submit" name="dosave"     id="dosave" value="Save settings" style="border-style:groove;"></input>
        </font></td>
    </tr>
    <tr valign="top">
      <td align="right"><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
      <td><font color="#000066" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
    </tr>
  </form>
</table>
<br>
<?php } ?>
