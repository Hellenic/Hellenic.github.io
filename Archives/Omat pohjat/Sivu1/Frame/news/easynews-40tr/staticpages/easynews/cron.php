<? // phpinfo(); ?>
<?
require("../../admin/config.php");
require("../../staticpages/easynews/news/config.php");
$result=mysql_query("SELECT opmlname FROM edp_newsopml");
$k=0; while ($row = mysql_fetch_array($result)) {$k++; $categf[$k]=$row[opmlname];}
echo " Refreshing ".$k." categories<br><br>";
for ($j=1; $j <= $k; $j++) {
    echo " (".$j." out of ".$k.")<br>Category <b>".$categf[$j]."</b> is refreshing...<br />";
    $_GET['zftemplate']="myiocontent";
    $_GET['zfrefresh']="refreshnow";
    $_GET['zfcategory']=$categf[$j];
    include("../../staticpages/easynews/news/zfeeder.php");
    echo " Category <b>".$categf[$j]."</b> refreshed.<br /><br /><br />";
}
echo " <b>&laquo; EXIT &raquo;</b>";
?>
