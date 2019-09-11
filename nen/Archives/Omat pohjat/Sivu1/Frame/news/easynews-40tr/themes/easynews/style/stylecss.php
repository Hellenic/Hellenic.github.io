<?php
 header("Content-type: text/css");


// to treat as a php stylecss in firefox
ob_start ("ob_gzhandler");
header("Content-type: text/css");
header("Cache-Control: must-revalidate");
$offset = 60 * 60; // 3600 seconds = 1hr
$ExpStr = "Expires: " .
gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);




// colors for the logo
$logobrown="#D62408";
$logoblue="#1849B5;";
$logoyellow="#D6AE00";
$logogreen="#109618";
// other colors
$bodybkg="#ffffff";
$bodytxt="#000000";
$gray="#F4F4EE";
$graylight="#FBFBFB";
$logobrownlink="#990000";
$sidelink=$logobrownlink;

// $path1= setThemePath();

?>


BODY { MARGIN: 3px; PADDING: 0px;    color: <?=$bodytxt; ?>; BACKGROUND-IMAGE: url(../images/io.jpg); BACKGROUND-POSITION: 30 7; BACKGROUND-REPEAT: no-repeat;
       SCROLLBAR-FACE-COLOR: <?=$graylight; ?>; SCROLLBAR-HIGHLIGHT-COLOR: <?=$logobrownlink; ?>; SCROLLBAR-SHADOW-COLOR:  <?=$logobrownlink; ?>; SCROLLBAR-3DLIGHT-COLOR: <?=$gray; ?>; SCROLLBAR-ARROW-COLOR: <?=$logoyellow; ?>; SCROLLBAR-TRACK-COLOR: <?=$gray; ?>; SCROLLBAR-DARKSHADOW-COLOR: <?=$logobrownlink; ?>;}
table    {width: 100%; margin: 0;}
table td {padding: 0;  vertical-align: top; font-family: Arial, Helvetica, Verdana, sans-serif;  }
#logo1   {vertical-align: top;  color: <?=$logoblue; ?>;  font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif; padding: 0.2em 0.2em;  margin:  0.0em 0.0em;  font-size: 190%; font-weight: bold;  position: absolute; }
#logo2   {vertical-align: top;  color: <?=$logogreen; ?>;  font-family: 'Trebuchet MS', Arial, Helvetica, Verdana, sans-serif; padding: 0.0em 5.0em;  margin:  0.0em  0.0em;  font-size: 140%; font-weight: bold; position: absolute;}
#logo3   {vertical-align: top;  color: <?=$logobrown; ?>; font-family: 'Trebuchet MS', Arial, Helvetica, Verdana, sans-serif; padding: 0.5em 0.85em;  margin:  0.0em 0.0em;  font-size: 180%; font-weight: bold; position: absolute; }
#logo4   {vertical-align: top;  color: <?=$logoyellow; ?>;  font-family: 'Trebuchet MS', Arial, Helvetica, Verdana, sans-serif; padding: 0.5em 3.05em;  margin:  0.0em 0.0em;  font-size: 180%; font-weight: bold; position: absolute;}
div#google {float: right; width: 280px;}
#contenttop td {vertical-align: middle; font-weight: bold; padding: 0.1em 0.2em 0;}
tr td#sidetop1 {font-weight: bold; font-size: 115%;  font-family: Arial, Helvetica, Verdana, sans-serif; width: 150px; }
tr td#sidetop2 {font-weight: bold; font-size: 100%;  font-family: Arial, Helvetica, Verdana, sans-serif;  background: <?=$gray; ?>; font-size: 80%;  border-top:  2px solid; border-color: <?=$logobrown; ?>;}
td#content     {padding:  17px 17px; width: 100%;}
td#content p   {font-family: Courier New, Courier, mono; }

A:link, A:visited, A:active {   color: <?=$logobrownlink; ?>;  TEXT-DECORATION: none; }

div#boxshortnews {text-align: left; border: 0px solid; border-color: <?=$logobrown; ?>; background: <?=$graylight; ?>;  margin-top: 0.0em; padding: 10px; font-size: 66%;  width: 150px; border: 1px solid; border-color: <?=$logobrown; ?>;}
div#boxside      {border: 1px solid; border-color: <?=$logobrown; ?>; background: <?=$graylight; ?>;  text-align: center; margin-top: 1.5em; padding: 8px; font-size: 66%; margin-top: 0px;}
div#login        {width: 150px; border: 1px solid; border-color: <?=$logobrown; ?>; background: <?=$graylight; ?>; text-align: center; margin-top: 1.5em; padding: 8px; font-size: 76%; font-weight: bold; }
div#loginl       {width: 150px; border: 1px solid; border-color: <?=$logobrown; ?>; background: <?=$graylight; ?>; text-align: left;   margin-top: 1.5em; padding: 8px; font-size: 76%; font-weight: bold; }
tr#footer td     {vertical-align: middle; font-size: 66%; border-top: 2px solid; border-color: <?=$logobrown; ?>; }
td#footerleft    {padding: 0.2em; background:  <?=$graylight; ?>; background-color: <?=$bodybkg; ?>; }
td#footercenter    {padding: 0.2em; background:  <?=$graylight; ?>; background-color: <?=$bodybkg; ?>; BACKGROUND-IMAGE: url(../images/io.jpg); BACKGROUND-POSITION: center 3; BACKGROUND-REPEAT: no-repeat;}
td#footerright   {padding: 0.2em; background: <?=$gray; ?>;}

td#rightside    {width: 150px; background:  <?=$gray; ?>; padding: 3px}
td#rightside td {font-size: 66%; padding: 1px;}
td#rightside th {font-size: 85%; padding: 2px; background: <?=$logobrown; ?>; color: <?=$bodybkg; ?>;}
tr.even td      {background: <?=$gray; ?>; width: 50%;}
tr.odd  td      {background: <?=$graylight; ?>; width: 50%;}
tr.evenadv td   {background: <?=$gray; ?>; width: 50%; border: 1px solid; border-color: <?=$logobrown; ?>;}
tr.oddadv td    {background: <?=$graylight; ?>; width: 50%;  border: 1px solid; border-color: <?=$logobrown; ?>;}
//div#empty       {background: <?=$graylight; ?>; width: 100%;  color:  <?= $sidelink; ?>; }
//td#rightside a       {margin: 0;   text-decoration: underline; color: <?= $sidelink; ?>; }
//td#rightside a:hover {margin: 0;  background-color:  <?=$gray; ?>;   color:  <?= $sidelink; ?>; }

td#leftside          {width: 150px; background: <?=$graylight; ?>;  padding: 0.px;}
td#leftside td       {padding: 0 0.0em 1px 0.0em;  }
td#leftside table    {width: 150px; margin-top: 0px; }
td#sidelinks a       {margin: 0; display: block; text-decoration: underline; padding: 2px 10px 1px 20px; font-size: 70%;  color: <?= $sidelink; ?>; font-weight: bold; }
td#sidelinks a#now   {color:  <?=$logogreen; ?>; ; FONT-WEIGHT: bold;  font-weight: bold; }
td#sidelinks a:hover {margin: 0;  background-color:  <?=$gray; ?>;   color:  <?= $sidelink; ?>;  font-weight: bold; }
td#sidelinks h4      {margin: 0; padding: 0.33em 0.25em 0;   font-weight: bold;  font-size: 80%; border-bottom: 2px solid; border-color: <?=$logobrown; ?>; background-color: <?=$gray; ?>;}

td#tdgray            {padding: 5px; background:  <?=$gray; ?>;}
td#tdgraylight       {padding: 5px; background:  <?=$graylight; ?>;}

div#left             {vertical-align: bottom; float: left; text-align: right;}
div#link1 a          {text-decoration: underline;}
div#link1 a:visited  {text-decoration: underline;}
div#link1 a:hover    {color: #000080; text-decoration: underline;}

div#h2odashed        {font-weight: bold; font-size: 100%; font-family: Arial, Helvetica, Verdana, sans-serif; color: <?=$logobrownlink; ?>; border-top:    2px dashed; border-color:    <?=$logobrown ?>;margin-bottom: 0px;}
div#h2osolid         {font-weight: bold; font-size: 100%; font-family: Arial, Helvetica, Verdana, sans-serif; color: <?=$logobrownlink; ?>; border-top:    2px solid;  border-color:    <?=$logobrown ?>;margin-bottom: 0px;}
div#h2udashed        {font-weight: bold; font-size: 100%; font-family: Arial, Helvetica, Verdana, sans-serif; color: <?=$logobrownlink; ?>; border-bottom:    2px dashed; border-color:    <?=$logobrown ?>;margin-bottom: 0px;}
div#h2usolid         {font-weight: bold; font-size: 100%; font-family: Arial, Helvetica, Verdana, sans-serif; color: <?=$logobrownlink; ?>; border-bottom:    2px solid;  border-color:    <?=$logobrown ?>;margin-bottom: 0px; }
div#h1d              {margin: 0; padding: 0.33em 0.25em 0;   font-weight: bold;  font-size: 80%; border-bottom: 2px solid; border-color: <?=$logobrown; ?>; background-color: <?=$gray; ?>;}

/* EasyCalendar */
td.blue           {background:   #200080;}
.week_cell        { FONT-SIZE: 12px;  background-color: #EEEEEE; height: 25; width: 15; }
.day_cell         { FONT-SIZE: 12px;  background-color: #FBFBFB; height: 25; width: 25; }
.empty_day_cell   { FONT-SIZE: 12px;  background-color: #EEEEEE; height: 25; width: 25; }
.today_cell       { FONT-SIZE: 12px;  background-color: #B1C6F3; height: 25; width: 25; }
.day_number       { FONT-SIZE: 12px;  FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif; color:#000 }
.days_header      { FONT-SIZE: 12px; background-color: #1849B5; FONT-WEIGHT: bold; COLOR: #dee6e8; LINE-HEIGHT: 20px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.tablehl          { FONT-SIZE: 12px; background-color: #1849B5; FONT-WEIGHT: bold; COLOR: #dee6e8; LINE-HEIGHT: 18px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.text             { FONT-SIZE: 12px; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.textblue         { FONT-SIZE: 12px; COLOR:#200080;  FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif; }
.error            { FONT-SIZE: 12px; COLOR: #ff0000; FONT-FAMILY: 'Trebuchet MS', Arial, Helvetica, sans-serif;}
.today_cell a:link, .today_cell a:visited, .today_cell  a:hover { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }
.day_cell a:link, .day_cell a:visited, .day_cell  a:hover       { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }
.week_cell a:link, .week_cell a:visited, .week_cell  a:hover    { FONT-SIZE: 12px;  FONT-WEIGHT: normal;  TEXT-DECORATION: none; }


/* EasyAllTheRest */
.h1s{ font-weight: bold; }
a:link.normal, a:visited.normal   {font: 12px Arial; color: ".$Easy[$PageSection]."; text-decoration:none;}
a:hover.normal                    {font: 12px Arial; color: red; text-decoration:none; }
a:link.admin, a:visited.admin     {font: 11px Arial; color: red; text-decoration:none; font-weight:bold; }
a:hover.admin                     {font: 12px Arial; color: yellow; text-decoration:none;  font-weight:bold; }
a:link.normalc, a:visited.normalc {font: 16px Arial; color: ".$Easy["DarkColor"]."; text-decoration:none; font-weight:bold; }
a:hover.normalc                   {font: 16px Arial; color: red; text-decoration:none; font-weight:bold;  }
a:link.normali, a:visited.normali {font: 12px Arial; color: ".$Easy["DarkColor"]."; text-decoration:none; font-style:italic; }
a:hover.normali                   {font: 12px Arial; color: red; text-decoration:none; font-style:italic; }
.f_text   {font: 11px Arial, Helvetica; color: black; background-color: ".$FREEA["Background"]."; border: 1px dotted ".$FREEA["DarkColor"]."; }
.f_button {font: 11px Arial, Helvetica; color: ".$FREEA["Background"]."; background-color: ".$FREEA["DarkColor"]."; border: 1px solid black; }
 FORM     { PADDING-RIGHT: 0px; DISPLAY: inline; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px;}

