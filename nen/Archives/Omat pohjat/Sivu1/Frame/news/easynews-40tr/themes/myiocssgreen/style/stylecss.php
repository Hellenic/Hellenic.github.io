<?php
// to treat as a php stylecss in firefox
ob_start ("ob_gzhandler");
header("Content-type: text/css");
header("Cache-Control: must-revalidate");
$offset = 60 * 60; // 3600 seconds = 1hr
$ExpStr = "Expires: " .
gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);
$EPScss=str_replace("color","#",$EPScss);
?>

<?
$rightsidebkg=$pullquoteborder=$leftsideborder=$crumbs="#3E765D";
$rightsidetxt=$crumbsalink=$content_top=$body_bkg="#ffffff";
$body_txt="#000000"; $calink="#204937"; $td_title="#442200";

$side_top="#204937";
$h1="#602020"; $copyr="#999";
$tdheadbkg="#D6B58C";
$even="#E9FBEB";
$h1border=$tipborder="#3E765D";
$tdr3="#660";  $tdr5="#060";
$pullquote=$tipbkg=$leftsidebkg="#E9FBEB";
$feetbkg=$footerborder="#87D992";
?>


body {margin: 4px; color: <?=$body_txt; ?>; background-color: <?=$body_bkg; ?>;}
table {width: 100%; margin: 0;}
table td {padding: 0; border-width: 0; vertical-align: top; font-family: Arial, Helvetica, Verdana, sans-serif;}
A:link, A:visited, A:active { color: <?=$calink; ?>;  TEXT-DECORATION: none; }
td#title  {vertical-align: bottom; color: #204937; background: transparent url(../images/topbg.jpg)  no-repeat top left; font-family: 'Trebuchet MS', Arial, Helvetica, Verdana, sans-serif; padding: 0.0em 7.5em; font-size: 140%; font-weight: bold; }
td#title1 {vertical-align: middle; color: #204937; background: transparent url(../images/topbg1.jpg) top left; font-family: 'Trebuchet MS', Arial, Helvetica, Verdana, sans-serif;  font-size: 140%; font-weight: bold; }
td#advert {width: 234px;}
#content-top td {vertical-align: middle; color: <?=$content_top; ?>; font-weight: bold; padding: 0.1em 0.2em 0;}
tr td#sidetop {background: <?=$side_top; ?>; font-weight: bold; font-size: 115%;  font-family: Arial, Helvetica, Verdana, sans-serif;}
tr td#crumbs {background: <?=$crumbs; ?>; font-size: 80%; border-left: 1px solid <?=$leftsideborder; ?>;}
tr td#crumbs a:link {color: <?=$crumbsalink; ?>; TEXT-DECORATION: none;}
tr td#crumbs a:visited {TEXT-DECORATION: none;}
td#content {padding: 17px 42px; width: 100%;}
td#content p {font-size: 85%; font-family: Arial, Helvetica, Verdana, sans-serif;}
h1 {font-weight: bold; font-size: 100%; font-family: Arial, Helvetica, Verdana, sans-serif; color: <?=$h1; ?>; border-bottom: 3px solid <?=$h1border; ?>;  margin-bottom: 0px;}
div.edit {float: center; width: 100%; border-top: 3px solid <?=$h1border; ?>;  padding-bottom: 2px;  font-weight: bold; font-size: 80%;  font-family:  Arial, Helvetica, Verdana, sans-serif;  padding: 3px 2px; }
div.pullquote {float: right; width: 140px; color: <?=$pullquote; ?>; border: solid <?=$pullquoteborder; ?>; border-width: 7px 0;  font-weight: bold; font-size: 1em;  font-family:  Arial, Helvetica, Verdana, sans-serif;  padding: 3px 2px; margin: 1px 7px;}
div.google    {float: right; width: 268px; color: <?=$pullquote; ?>; border: solid <?=$pullquoteborder; ?>; border-width: 7px 0;  font-weight: bold; font-size: 1em;  font-family:  Arial, Helvetica, Verdana, sans-serif;  padding: 3px 2px; margin: 1px 7px;}
td.head {background: <?=$tdheadbkg; ?>#D6B58C; text-align: center; font-weight: bold;}
td.r3 {color: <?=$tdr3; ?>;}
td.r5 {color: <?=$tdr5; ?>;}
div#traveltip {border: 3px solid <?=$tipborder; ?>; background: <?=$tipbkg; ?>; text-align: center; margin-top: 1.5em; padding: 8px; font-size: 66%;}
div#traveltipleft {border: 0px solid <?=$tipborder; ?>; background: #FBFBFB; text-align: left; margin-top: 1.5em; padding: 8px; font-size: 66%; margin-top: 0px;}
tr#footer td {vertical-align: middle; font-size: 66%; border-top: 3px solid <?=$footerborder; ?>;}
td#feedback {text-align: center; padding: 0.2em; background: <?=$feetbkg; ?>;}
tr#footer td#tg {font-size: 85%; text-align: center;}
td#copyright {text-align: right; font-style: italic; color: <?=$copyr; ?>;}


td#decript {vertical-align: middle; color: #49516B; background: transparent url(../images/topbgd.jpg) no-repeat top left; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 2;  }



FORM { PADDING-RIGHT: 0px; DISPLAY: inline; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px;}



/* menu styles */
td#rightside {width: 150px; }
td#rightside th {font-size: 85%; padding: 2px; background: <?=$rightsidebkg; ?>; color: <?=$rightsidetxt; ?>;}
td#rightside td {font-size: 66%; padding: 1px;}
tr.even td      {background: <?=$even; ?>; width: 50%;}
div#login  {width: 150px; border: 3px solid <?=$tipborder; ?>; background: <?=$tipbkg; ?>; text-align: center; margin-top: 1.5em; padding: 8px; font-size: 76%; font-weight: bold; }
div#loginl {width: 150px; border: 3px solid <?=$tipborder; ?>; background: <?=$tipbkg; ?>; text-align: left;   margin-top: 1.5em; padding: 8px; font-size: 76%; font-weight: bold; }


td#leftside          {width: 120px; background: <?=$leftsidebkg; ?>; }
td#leftside td       {border-bottom: 0px solid <?=$leftsideborder; ?>;  padding: 0 0 1px 0.em; }
td#leftside table    {margin-top: 0px;}
td#sidelinks a       {margin: 0; display: block; text-decoration: none; padding: 2px 10px 1px 20px; font-size: 70%; color: <?= $side_top; ?>; border: 1px solid <?=$leftsidebkg; ?>; border-color: rgb(90%,85%,80%) rgb(60%,55%,50%) rgb(60%,55%,50%) rgb(90%,85%,80%);  background-color: <?=$leftsidebkg; ?>;}
td#sidelinks a#now   {background-color: <?=$body_bkg; ?>; color: #D71C06; FONT-WEIGHT: bold;}
td#sidelinks a:hover {margin: 0; background-color: #e6e6e6;   color: <?= $side_top; ?>; }
td#sidelinks h4      {margin: 0; padding: 0.33em 0.25em 0;  color: <?=white ?>; font-weight: bold;  font-size: 80%; border: 1px solid <?=$leftsideborder; ?>; background-color: <?=$crumbs; ?>;}


/* EasyCalendar */
.week_cell        { FONT-SIZE: 12px;  background-color: #DCDCCE; height: 25; width: 15; }
.day_cell         { FONT-SIZE: 12px;  background-color: #EDECD8; height: 25; width: 25; }
.empty_day_cell   { FONT-SIZE: 12px;  background-color: #EEEEEE; height: 25; width: 25; }
.today_cell       { FONT-SIZE: 12px;  background-color: #B1C6F3; height: 25; width: 25; }
.day_number       { FONT-SIZE: 12px;  FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif; color:#000 }
.days_header      { FONT-SIZE: 12px; background-color: #200080; FONT-WEIGHT: bold; COLOR: #dee6e8; LINE-HEIGHT: 20px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.tablehl          { FONT-SIZE: 12px; background-color: #200080; FONT-WEIGHT: bold; COLOR: #dee6e8; LINE-HEIGHT: 18px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.text             { FONT-SIZE: 12px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.textblue         { FONT-SIZE: 12px; COLOR:#200080;  FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif; }
.error            { FONT-SIZE: 12px; COLOR: #ff0000; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.today_cell a:link, .today_cell a:visited, .today_cell  a:hover { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }
.day_cell a:link, .day_cell a:visited, .day_cell  a:hover       { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }
.week_cell a:link, .week_cell a:visited, .week_cell  a:hover    { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }


/* EasyAllTheRest */
.h1s{ font-weight: bold; }
a:link.normal, a:visited.normal {font: 12px Arial; color: ".$Easy[$PageSection]."; text-decoration:none;}
a:hover.normal {font: 12px Arial; color: red; text-decoration:none; }
a:link.admin, a:visited.admin {font: 11px Arial; color: red; text-decoration:none; font-weight:bold; }
a:hover.admin {font: 12px Arial; color: yellow; text-decoration:none;  font-weight:bold; }
a:link.normalc, a:visited.normalc {font: 16px Arial; color: ".$Easy["DarkColor"]."; text-decoration:none; font-weight:bold; }
a:hover.normalc {font: 16px Arial; color: red; text-decoration:none; font-weight:bold;  }
a:link.normali, a:visited.normali {font: 12px Arial; color: ".$Easy["DarkColor"]."; text-decoration:none; font-style:italic; }
a:hover.normali {font: 12px Arial; color: red; text-decoration:none; font-style:italic; }


.f_text {font: 11px Arial, Helvetica; color: black; background-color: ".$FREEA["Background"]."; border: 1px dotted ".$FREEA["DarkColor"]."; }
.f_button {font: 11px Arial, Helvetica; color: ".$FREEA["Background"]."; background-color: ".$FREEA["DarkColor"]."; border: 1px solid black; }







