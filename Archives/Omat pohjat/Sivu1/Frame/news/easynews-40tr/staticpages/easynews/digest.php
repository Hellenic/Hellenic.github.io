<?

echo "";
 for ($k=1; $k<$j; $k++) {
  $zfcategory3=$opmlfields[$k];  $PageSection=$NewsPageSection;
  $pagelink=$edp_relative_path.$FREED[$NewsPageSection]."/index.php?PageSection=".$NewsPageSection."&zfcategory=".$zfcategory3;
  echo "<br /><b><a href='".$pagelink."'>&nbsp;".$zfcategory3."</a></b>";
  $_GET['zftemplate']="myioaqua"; $_GET['zfcategory']=$zfcategory3; $_GET['zfposition']="p1"; include("news/zfeeder.php");
 }


?>
