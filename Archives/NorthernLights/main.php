<?php
$p = $_GET['p'];
if ( !empty($p) && file_exists('./news/' . $p . '.php') && stristr( $p, '.' ) == False ) 
{
   $file = './news/' . $p . '.php';
}
else
{
   $file = './news/news.php';
}
include $file;
?>
