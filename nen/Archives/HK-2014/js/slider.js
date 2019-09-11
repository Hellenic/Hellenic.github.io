$(document).ready(function() {
    
    if (window.screen.availHeight)
    {
        $("section.slider").css({
            bottom: -window.screen.availHeight,
            "max-height": window.screen.availHeight-350 + "px"
        });
    }
    
    $("a[rel='slider']").live("click", function() {
        $(".ajax-loader").fadeIn("fast");
        
        $("section.slider article").load($(this).attr("href"), function() {
            
            if ($("section.slider").is(":visible"))
            {
                $("section.slider").hide();
                $("section.slider").fadeIn("fast");
            }
            else
            {
                $("section.slider").show(function() {
                    $("section.slider").animate({bottom: "0px"}, 800);
                });
            }
            
            $(".ajax-loader").fadeOut("fast");
        });
        
        return false;
    });
});