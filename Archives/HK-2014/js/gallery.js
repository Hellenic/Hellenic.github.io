$(document).ready(function() {
    
    if (window.screen.availWidth)
    {
        $("section.gallery").css({
            right: -window.screen.availWidth + "px",
            height: window.screen.availHeight*0.75 + "px",
            width: window.screen.availWidth-350 + "px",
            "max-width": window.screen.availWidth-350 + "px"
        });
    }
    
    $("a[rel='gallery']").live("click", function() {
        $(".ajax-loader").fadeIn("fast");
        
        var href = $(this).attr("href");
        $("section.gallery article").load(href, function() {
            Shadowbox.setup();
            
            if ($("section.gallery").is(":visible"))
            {
                $("section.gallery").hide();
                $("section.gallery").fadeIn("fast");
            }
            else
            {
                $("section.gallery").show(function() {
                    $("section.gallery").animate({right: "0px"}, 800);
                });
                
            }
            
            $(".ajax-loader").fadeOut("fast");
        });
        
        return false;
    });
});