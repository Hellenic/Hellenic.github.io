<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
  if (puRegistered($Stoitsov)<0) {  $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else {
    if (isset($Preview)) { $page="add_news"; } else {
			unset($Error);
      if (strlen(puHackers($puHeading))<4) $Error.="<b>".$language['Heading is invalid. Min 4 character']."</b><br>";
      if (strlen(puHackers($message))<4) $Error.="<b>".$language['Body is invalid. Min 4 character'].".</b><br>";
      if (strlen(puHackers($puDate))!=10) $Error.="<b>".$language['Date is invalid. Date format: YYYY-MM-DD'].".</b><br>";
      if (isset($Error)) { $page="add_news"; } else {
      puMyQuery("INSERT INTO $FREETDB[$PageSection] VALUES(null,'".puHackers($puHeading)."','".puHackers($message)."','".puHackers($puDate)."','".puHackers($puUserID)."','".$FREETDB[$PageSection]."');"); $puTopicID=mysql_insert_id();
  } } }
?>
