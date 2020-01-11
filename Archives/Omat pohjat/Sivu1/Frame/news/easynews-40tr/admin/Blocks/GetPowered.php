<?
/*      ******************************************************************
        **********************  EasyDynamicPages  ************************
	******************************************** software.stoitsov.com  */
        $PowerBlock[0]="<a href='/products/easybookmarker/' class=".$menuLlink.">".$Alt["EasyBookmarker"]."<br><img src='".$edp_relative_path."images/banners/powerbookmarker90x30.gif' width='90' height='30' alt='Get powered!' border='0' class=".$menuLlink."></a><br><br>";
        $PowerBlock[1]="<a href='/products/easygallery/' class=".$menuLlink.">".$Alt["EasyGallery"]."<br><img src='".$edp_relative_path."images/banners/powergallery90x30.gif' width='90' height='30' alt='Get powered!' border='0' class=".$menuLlink."></a><br><br>";
        $PowerBlock[2]="<a href='/products/easyclassifields/' class=".$menuLlink.">".$Alt["EasyClassifields"]."<br><img src='".$edp_relative_path."images/banners/powerclassifields90x30.gif' width='90' height='30' alt='Get powered!' border='0' class=".$menuLlink."></a><br><br>";
        $PowerBlock[3]="<a href='/products/easye-cards/' class=".$menuLlink.">".$Alt["EasyE-Cards"]."<br><img src='".$edp_relative_path."images/banners/powere-cards90x30.gif' width='90' height='30' alt='Get powered!' border='0' class=".$menuLlink."></a><br><br>";
        $PowerBlock[4]="<a href='/products/easypublish/' class=".$menuLlink.">".$Alt["EasyPublish"]."<br><img src='".$edp_relative_path."images/banners/powerpublish90x30.gif' width='90' height='30' alt='Get powered!' border='0' class=".$menuLlink."></a><br><br>";
        $Block="<div style='padding: 5 5 5 5; text-align:center;'>
        <div align=left><span class=".$menuL."><b>Gain power</b></span></div>
        ".$PowerBlock[rand(0,Count($PowerBlock)-1)]."</div>";
?>
