<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
  if (puRegistered($Stoitsov)<0) {  $page="login"; $Error="<b>".$language['You need to be a registered user to use this function'].".</b><br>"; } else {
      if (isset($Preview)) {  $page="edit_news"; } else {
			unset($Error);
      if (strlen(puHackers($puHeading))<4) $Error.="<b>".$language['Heading is invalid. Min 4 character']."</b><br>";
      if (strlen(puHackers($message))<4)   $Error.="<b>".$language['Body is invalid. Min 4 character'].".</b><br>";
      if (strlen(puHackers($puDate))!=10)  $Error.="<b>".$language['Date is invalid. Date format: YYYY-MM-DD'].".</b><br>";
      if (isset($Error)) {  $page="edit_news"; } else {
      $aaa=puMyFetch("SELECT puTopic FROM  ".$FREETDB[$PageSection]." WHERE ID=$id"); $oldTopic=$aaa["puTopic"];
      if($oldTopic==$newTopic){
      puMyQuery("UPDATE ".$newTopic." SET puHeading='".puHackers($puHeading)."', puBody='".puHackers($message)."', puDate='".puHackers($puDate)."', puUserID='".puHackers($puUserID)."', puTopic='".$newTopic."' WHERE ID='".$id."'");
      $puTopicID=$id;
      } else {
      puMyQuery("DELETE FROM ".$oldTopic." Where ID='$id'");
      puMyQuery("INSERT INTO ".$newTopic." VALUES(null,'".puHackers($puHeading)."','".puHackers($message)."','".puHackers($puDate)."','".puHackers($puUserID)."','".$newTopic."');");
      $puTopicID=mysql_insert_id();
      }
      $pupTopicNum=mysql_num_rows(puMyQuery("SELECT puTopic FROM ".edp_pupublish." WHERE puTopicID=$puTopicID"));
      if($home==1 or $pupTopicNum!=0) {
        puMyQuery("DELETE FROM edp_pupublish WHERE puTopic='$oldTopic' AND puTopicID=$id");
        puMyQuery("INSERT INTO edp_pupublish VALUES(null,'".puHackers($puHeading)."','".puHackers($message)."','".puHackers($puDate)."','".puHackers($puUserID)."','".$newTopic."','".$puTopicID."');");}
      }
}}
?>
