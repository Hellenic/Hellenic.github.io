<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
  $ResultHtml=""; $ResultHtml.="<script language=\"JavaScript\" type=\"text/javascript\">
	<!--
	// bbCode control by subBlue design (www.subBlue.com)
	var imageTag = false; var theSelection = false;
	var clientPC = navigator.userAgent.toLowerCase(); var clientVer = parseInt(navigator.appVersion);
	var is_ie = ((clientPC.indexOf(\"msie\") != -1) && (clientPC.indexOf(\"opera\") == -1));
	var is_nav  = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1) && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1) && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
	var is_win   = ((clientPC.indexOf(\"win\")!=-1) || (clientPC.indexOf(\"16bit\") != -1)); var is_mac    = (clientPC.indexOf(\"mac\")!=-1);
	b_help = \"Bold text: [b]text[/b]  (alt+b)\"; i_help = \"Italic text: [i]text[/i]  (alt+i)\"; u_help = \"Underline text: [u]text[/u]  (alt+u)\"; q_help = \"Paragraf text: [p]text[/p]  (alt+q)\"; c_help = \"Heading 1: [h1]Heading[/h1]  (alt+c)\"; l_help = \"Heading 2: [h2]text[/h2] (alt+l)\"; o_help = \"List: [ul]text[/ul]  (alt+o)\"; p_help = \"Insert image: [img]http://image_url[/img]  (alt+p)\"; w_help = \"Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]  (alt+w)\"; a_help = \"Close all open tags\"; s_help = \"Font color: [color=red]text[/color]  Tip: you can also use color=#FF0000\"; f_help = \"Font size: [size=x-small]small text[/size]\";
	bbcode = new Array(); bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[p]','[/p]','[h1]','[/h1]','[h2]','[/h2]','[ul]','[/ul]','[img]','[/img]','[url]','[/url]'); imageTag = false;
	function helpline(help) { document.post.helpbox.value = eval(help + \"_help\"); }
	function getarraysize(thearray) { for (i = 0; i < thearray.length; i++) { if ((thearray[i] == \"undefined\") || (thearray[i] == \"\") || (thearray[i] == null)) return i; } return thearray.length; }
	function arraypush(thearray,value) { thearray[ getarraysize(thearray) ] = value; }
	function arraypop(thearray) { thearraysize = getarraysize(thearray); retval = thearray[thearraysize - 1]; delete thearray[thearraysize - 1]; return retval; }
	function bbfontstyle(bbopen, bbclose) { if ((clientVer >= 4) && is_ie && is_win) { theSelection = document.selection.createRange().text; if (!theSelection) { document.post.message.value += bbopen + bbclose; document.post.message.focus(); return; } document.selection.createRange().text = bbopen + theSelection + bbclose; document.post.message.focus(); return; } else { document.post.message.value += bbopen + bbclose; document.post.message.focus(); return; } storeCaret(document.post.message); }
	function bbstyle(bbnumber) { donotinsert = false; theSelection = false; bblast = 0; if (bbnumber == -1) { while (bbcode[0]) { butnumber = arraypop(bbcode) - 1; document.post.message.value += bbtags[butnumber + 1]; buttext = eval('document.post.addbbcode' + butnumber + '.value'); eval('document.post.addbbcode' + butnumber + '.value =\"' + buttext.substr(0,(buttext.length - 1)) + '\"'); } imageTag = false; ocument.post.message.focus(); return; }
	if ((clientVer >= 4) && is_ie && is_win) theSelection = document.selection.createRange().text;
	if (theSelection) { document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1]; document.post.message.focus(); theSelection = ''; return; }
	for (i = 0; i < bbcode.length; i++) { if (bbcode[i] == bbnumber+1) { bblast = i; donotinsert = true; } }
  if (donotinsert) { while (bbcode[bblast]) { butnumber = arraypop(bbcode) - 1; document.post.message.value += bbtags[butnumber + 1]; buttext = eval('document.post.addbbcode' + butnumber + '.value'); eval('document.post.addbbcode' + butnumber + '.value =\"' + buttext.substr(0,(buttext.length - 1)) + '\"'); imageTag = false; } document.post.message.focus(); return; } else {
	if (imageTag && (bbnumber != 14)) { document.post.message.value += bbtags[15]; lastValue = arraypop(bbcode) - 1; document.post.addbbcode14.value = \"Img\";	imageTag = false; } document.post.message.value += bbtags[bbnumber];
	if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; arraypush(bbcode,bbnumber+1); eval('document.post.addbbcode'+bbnumber+'.value += \"*\"'); document.post.message.focus(); return; } storeCaret(document.post.message); }
	function storeCaret(textEl) { if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate(); }
  //--> </script>";
  $result = mysql_query("SELECT dpFREET FROM edp_pconfig WHERE dpFREED='dynamicpages'"); $it=0; while(list($aaa) = mysql_fetch_row($result)) { $it++; $allTopics[$it]=$aaa;}
  if (!isset($step))     {$News=puMyFetch("SELECT * FROM ".$FREETDB[$PageSection]." WHERE ID=$id"); }
  if (!isset($newTopic)) {$oldTopic=$News["puTopic"]; $puTopicID=$News["puTopicID"];} else {$oldTopic=$newTopic;}
  $ResultHtml.=puHeading($language['Edit']." ".$Easy["Articles"],1)."".$language['Registered users can add, edit or delete']." ".$Easy["Articles"].".<br><br>
  <b>".$language['Preview']."</b><br>
  <div style='background-color: ".$Easy["LightColor2"].";'> <span class=h1s>".(isset($News) ? $News["puHeading"] : $puHeading )."</span><br><br>".BBCode2HTML(puHackers((isset($News) ? $News["puBody"] : $message )))."<br><br><b>".$language['Topic'].":</b> ".str_replace("_"," ",str_replace("edp_","",$oldTopic))."&nbsp;&nbsp:.&nbsp;&nbsp;<b>".$language['Author'].":</b> ".(isset($News) ? puShowAuthor($News["puUserID"]) : puShowAuthor($puUserID) )."&nbsp;&nbsp:.&nbsp;&nbsp;<b>".$language['Date'].":</b> ".(isset($News) ? $News["puDate"] : $puDate )." </div>
  ".puElement("form",$EDP_SELF."&home=".$home,"post","POST").puElement("submit",$language['Preview'],"f_button","Preview")." ".puElement("submit",$language['Update'],"f_button","Update")."<br><br>
  <div align=center>
   <table  border='0' cellspacing='1' cellpadding='2' bgcolor='".$Easy[$PageSection]."' >
    <tr> <td>&nbsp;<font color=".$Easy["Background"]."><b>.: ".$language['Edit']."</b></font></td> </tr>
    <tr> <td bgcolor=".$Easy["Background"]."><b>".$language['Heading']."</b><br>".puElement("text","puHeading",(isset($News) ? $News["puHeading"] : $puHeading ),400)."</td> </tr> ";
    $ResultHtml.= "<tr><td bgcolor=".$Easy["Background"]."><b>".$language['Topics'].": </b><select name=\"newTopic\" class=f_text>";
     for ($j=1; $j <= $it; $j++) { if($allTopics[$j]==$oldTopic) {$sel=" selected";}else{$sel=" ";} $ResultHtml.="<option ".$sel."  value='".$allTopics[$j]."'>".str_replace("_"," ",str_replace("edp_","",$allTopics[$j]))."</option>"; }
    $ResultHtml.="</select></td></tr>";
    $ResultHtml.="<tr> <td bgcolor=".$Easy["Background"]."><b>".$language['Body']."</b><br>
    <table   border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
				<tr align=\"center\" valign=\"middle\">
					<td><input type=\"button\" class=\"f_text\" accesskey=\"b\" name=\"addbbcode0\" value=\" B \" style=\"font-weight:bold; width: 30px\" onClick=\"bbstyle(0)\" onMouseOver=\"helpline('b')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"i\" name=\"addbbcode2\" value=\" i \" style=\"font-style:italic; width: 30px\" onClick=\"bbstyle(2)\" onMouseOver=\"helpline('i')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"u\" name=\"addbbcode4\" value=\" u \" style=\"text-decoration: underline; width: 30px\" onClick=\"bbstyle(4)\" onMouseOver=\"helpline('u')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"q\" name=\"addbbcode6\" value=\"P\" style=\"width: 30px\" onClick=\"bbstyle(6)\" onMouseOver=\"helpline('q')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"c\" name=\"addbbcode8\" value=\"Heading 1\" style=\"width: 55px\" onClick=\"bbstyle(8)\" onMouseOver=\"helpline('c')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"l\" name=\"addbbcode10\" value=\"Heading 2\" style=\"width: 55px\" onClick=\"bbstyle(10)\" onMouseOver=\"helpline('l')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"o\" name=\"addbbcode12\" value=\"List\" style=\"width: 40px\" onClick=\"bbstyle(12)\" onMouseOver=\"helpline('o')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"p\" name=\"addbbcode14\" value=\"Img\" style=\"width: 40px\"  onClick=\"bbstyle(14)\" onMouseOver=\"helpline('p')\" /></td>
					<td><input type=\"button\" class=\"f_text\" accesskey=\"w\" name=\"addbbcode16\" value=\"URL\" style=\"text-decoration: underline; width: 40px\" onClick=\"bbstyle(16)\" onMouseOver=\"helpline('w')\" /></td>
				</tr>
        <tr> <td colspan=\"9\">
            <table   border=\"0\" cellspacing=\"0\" cellpadding=\"0\"> <tr>
                <td>&nbsp;".$language['Font colour'].":<select name=\"addbbcode18\" onChange=\"bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]')\" onMouseOver=\"helpline('s')\" class=f_text>
								<option style=\"color:black; background-color: #FFFFFF \" value=\"#004c75\" >Default</option>\n<option style=\"color:darkred; background-color: #DEE3E7\" value=\"darkred\" >Dark Red</option>\n<option style=\"color:red; background-color: #DEE3E7\" value=\"red\" >Red</option>
								<option style=\"color:orange; background-color: #DEE3E7\" value=\"orange\" >Orange</option>\n<option style=\"color:brown; background-color: #DEE3E7\" value=\"brown\" >Brown</option>\n<option style=\"color:yellow; background-color: #DEE3E7\" value=\"yellow\" >Yellow</option>
								<option style=\"color:green; background-color: #DEE3E7\" value=\"green\" >Green</option>\n<option style=\"color:olive; background-color: #DEE3E7\" value=\"olive\" >Olive</option>\n<option style=\"color:cyan; background-color: #DEE3E7\" value=\"cyan\" >Cyan</option>
								<option style=\"color:blue; background-color: #DEE3E7\" value=\"blue\" >Blue</option>\n<option style=\"color:darkblue; background-color: #DEE3E7\" value=\"darkblue\" >Dark Blue</option>\n<option style=\"color:indigo; background-color: #DEE3E7\" value=\"indigo\" >Indigo</option>
								<option style=\"color:violet; background-color: #DEE3E7\" value=\"violet\" >Violet</option>\n<option style=\"color:white; background-color: #DEE3E7\" value=\"white\" >White</option>\n<option style=\"color:black; background-color: #DEE3E7\" value=\"black\" >Black</option>
                </select> &nbsp;".$language['Font size'].":<select name=\"addbbcode20\" onChange=\"bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')\" onMouseOver=\"helpline('f')\" class=f_text>
                <option value=\"7\" >Tiny</option>\n<option value=\"9\" >Small</option>\n<option value=\"12\" selected >Normal</option>\n<option value=\"18\" >Large</option>\n<option  value=\"24\" >Huge</option></select> </td>
                <td nowrap=\"nowrap\" align=\"right\"><a href=\"javascript:bbstyle(-1)\"  onMouseOver=\"helpline('a')\">".$language['Close tags']."</a></td>
              </tr> </table>
          </td> </tr>
          <tr> <td colspan=\"9\"><input type=\"text\" name=\"helpbox\" size=\"45\" maxlength=\"100\" style=\"width:400px; font-size:10px\" class=\"info_panel\" value=\"".$language['Tip: Styles can be applied quickly to selected text'].".\" /></td> </tr>
          <tr> <td colspan=\"9\"><textarea name=\"message\" rows=\"15\" cols=\"35\" wrap=\"virtual\" style=\"width:400px\" tabindex=\"3\" class=\"post\" onselect=\"storeCaret(this);\" onclick=\"storeCaret(this);\" onkeyup=\"storeCaret(this);\" class=f_text>".puHackers((isset($News) ? $News["puBody"] : $message ))."</textarea></td> </tr>
			</table>";
    $ResultHtml.="</td> </tr>
    <tr> <td bgcolor=".$Easy["Background"]."><b>".$language['Date']."</b> [YYYY-MM-DD]<br>".puElement("text","puDate",(isset($News) ? $News["puDate"] : ((isset($puDate) && $puDate!="") ? $puDate : date("Y-m-d") ) ),200)."</td> </tr>
    <tr> <td align=right>".puElement("submit",$language['Preview'],"f_button","Preview")." ".puElement("submit",$language['Update'],"f_button","Update")."</td> </tr>
    ".puElement("hidden","action","edit_news").puElement("hidden","puTopicID",$puTopicID).puElement("hidden","oldTopic",$oldTopic).puElement("hidden","step","set").puElement("hidden","id",$id).puElement("hidden","puUserID",(isset($News) ? $News["puUserID"] : $puUserID )).puElement()."
  </table><br>". $Error ."</div> ";
?>
