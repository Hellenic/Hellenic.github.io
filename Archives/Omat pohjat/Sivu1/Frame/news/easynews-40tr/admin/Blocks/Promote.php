<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
// Generates Promotion Block for the right MENU
        $PromoteBlock[0]="<span class=".$menuL."><b>Promote EasyBookmarker</b></span><br><a href='http://software.stoitsov.com/donate/?page=promote&what=EasyBookmarker' class=menuR>Place this code on your webpage:</a><br><div align=center class=".$menuLlink."><br><a href='http://myio.net/software/products/easybookmarker/' target=_stoitsov class=".$menuLlink."><img src='".$edp_relative_path."images/banners/bookmarker90x30.gif' width='90' height='30' alt='".$Alt["EasyBookmarker"]."' border='0' class=".$menuLlink."></a></div><br>";
        $PromoteBlock[1]="<span class=".$menuL."><b>Promote EasyGallery</b></span><br><a href='http://software.stoitsov.com/donate/?page=promote&what=EasyGallery' class=menuR>Place this code on your webpage:</a><br><div align=center class=".$menuLlink."><br><a href='http://myio.net/software/products/easygallery/' target=_stoitsov class=".$menuLlink."><img src='".$edp_relative_path."images/banners/gallery90x30.gif' width='90' height='30' alt='".$Alt["EasyGallery"]."' border='0' class=".$menuLlink."></a></div><br>";
        $PromoteBlock[2]="<span class=".$menuL."><b>Promote EasyClassifields</b></span><br><a href='http://software.stoitsov.com/donate/?page=promote&what=EasyClassifields' class=menuR>Place this code on your webpage:</a><br><div align=center class=".$menuLlink."><br><a href='http://myio.net/software/products/easyclassifields/' target=_stoitsov class=".$menuLlink."><img src='".$edp_relative_path."images/banners/classifields90x30.gif' width='90' height='30' alt='".$Alt["EasyClassifields"]."' border='0' class=".$menuLlink."></a></div><br>";
        $PromoteBlock[3]="<span class=".$menuL."><b>Promote EasyE-Cards</b></span><br><a href='http://software.stoitsov.com/donate/?page=promote&what=EasyE-Cards' class=".$menuLlink.">Place this code on your webpage:</a><br><div align=center><br><a href='http://myio.net/software/products/easye-cards/' target=_stoitsov class=".$menuLlink."><img src='".$edp_relative_path."images/banners/e-cards90x30.gif' width='90' height='30' alt='".$Alt["EasyE-Cards"]."' border='0' class=".$menuLlink."></a></div><br>";
        $PromoteBlock[4]="<span class=".$menuL."><b>Promote EasyPublish</b></span><br><a href='http://software.stoitsov.com/donate/?page=promote&what=EasyPublish' class=".$menuLlink.">Place this code on your webpage:</a><br><div align=center><br><a href='http://myio.net/software/products/easypublish/' target=_stoitsov class=".$menuLlink."><img src='".$edp_relative_path."images/banners/publish90x30.gif' width='90' height='30' alt='".$Alt["EasyPublish"]."' border='0' class=".$menuLlink."></a></div><br>";
        $Block=$PromoteBlock[rand(0,Count($PromoteBlock)-1)]."";
?>