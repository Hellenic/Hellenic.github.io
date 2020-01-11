<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
  if (puRegistered($Stoitsov)!=2) { $page="login"; $Error="<b>".$language['You need to be an administrator to use this function'].".</b><br>"; } else {
  unset($Error); $page="config"; $do="add_page"; }
?>
