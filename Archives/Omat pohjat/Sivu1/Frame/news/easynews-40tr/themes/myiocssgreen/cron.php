<? // phpinfo(); ?>
<?
$theme_path="";
$handle = opendir($theme_path."news/categories");
while($dirfile = readdir($handle)) {
  if (is_file($theme_path."news/categories/".$dirfile) && substr($dirfile,strlen($dirfile)-4,strlen($dirfile))=='opml' ) { $categf=substr($dirfile,0,strlen($dirfile)-5);
    echo "Category <b>".$categf."</b> is refreshing...<br />";
    $_GET['zftemplate']="myiocontent";
    $_GET['zfrefresh']="refreshnow";
    $_GET['zfcategory']=$categf;
    include($theme_path."news/zfeeder.php");
    echo "<br />Category <b>".$categf."</b> refreshed.<br /><br /><br />";
  }
}
closedir($handle);
echo "<b>&laquo; EXIT &raquo;</b>";
?>
