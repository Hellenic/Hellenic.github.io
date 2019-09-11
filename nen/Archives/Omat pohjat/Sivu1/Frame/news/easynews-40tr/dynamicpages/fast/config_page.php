<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
  $ResultHtml="";
   if ($do=="add_page") {
    switch($du) {
     case "site":
     if($edp_relative_path==="../") {
     include_once "../admin/site_settings.php";
     } else {
     include_once "../../admin/site_settings.php";
     }
     break;
     case "dpage":
     if($edp_relative_path==="../") {
     include_once "../admin/dpage_settings.php";
     } else {
     include_once "../../admin/dpage_settings.php";
     }
     break;
     case "page_delete":
      puMyQuery("DELETE FROM edp_pconfig WHERE dpFREET='$FREETDB[$PageSection]'");
      puMyQuery("DELETE FROM  edp_pupublish Where puTopic='$FREETDB[$PageSection]'");
      puMyQuery("DROP TABLE IF EXISTS $FREETDB[$PageSection]");
      $PageSection1=$PageSection-1;
      Header("Location: ".$_SERVER["PHP_SELF"]."?PageSection=".$PageSection1);
      break;
     case "page_add":
      $PageSection1=$FREEMAX;
      $colornew=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9); //$colornew="#7b9ae7";
      $namenew="edp_New".$colornew;
      $colornew="#".$colornew;
      puMyQuery("INSERT INTO edp_pconfig VALUES(null, '$colornew', 'dynamicpages', '$namenew', 'Picture:Donations:ComrsialSoftware', 'RespectedSites:StoitsovCom:GetPowered:AdvertizementAlinea:ShareCode:Promote');");
      puMyQuery("DROP TABLE IF EXISTS `$namenew`;");
      puMyQuery("CREATE TABLE `$namenew` (`ID` bigint(20) NOT NULL auto_increment,`puHeading` varchar(255) NOT NULL default '',`puBody` text NOT NULL,`puDate` date NOT NULL default '0000-00-00',`puUserID` bigint(20) NOT NULL default '0',`puTopic` varchar(255) NOT NULL default '',PRIMARY KEY  (`ID`),KEY `ID` (`ID`),KEY `puDate` (`puDate`),KEY `puUserID` (`puUserID`)) TYPE=MyISAM");
      Header("Location: ".$_SERVER["PHP_SELF"]."?PageSection=".$PageSection1."&page=config&do=add_page&du=dpage");
      break;
    }
   }
?>
