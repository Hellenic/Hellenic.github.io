var page = new Object();
page.sidebar = new Object();
page.content = new Object();
page.s = new Object();

page.s.PAGE_PARAM = "?page=";
page.s.PAGE_PARAM_LENGTH = 6;

$(document).ready(function() {
    
    Shadowbox.init();
    
    // Load component on startup if hash
    if (window.location.hash.length > 0 && window.location.href.indexOf(page.s.PAGE_PARAM) == -1)
        page.loadPage();
    
    $(window).bind("hashchange", page.loadPage);
    
    // CV h1 click
    //$(".cv h1,.works h1").disableSelection();
    $(".cv h1,.works h1").live("click", function() {
        
        var title = $(this).text();
        $("section article div.section").each(function() {
            
            if ($(this).attr("data-for") == title)
            {
                if ($(this).is(":visible"))
                    $(this).hide("fast");
                else
                    $(this).show("fast");
            }
            
        });
        
        return false;
    });
    
    // Navigation click
    $("a[href*='?page']").live("click", function() {
        if ($(this).attr("rel") != null)
            return false;
        
        $("section.main").hide();
        
        var PAGE_PARAM = page.s.PAGE_PARAM;
        var PAGE_PARAM_LENGTH = page.s.PAGE_PARAM_LENGTH;
        
        var h = $(this).attr("href");
        var component = "home";
        if (h.indexOf(PAGE_PARAM) > 0)
            component = h.substring(h.indexOf(PAGE_PARAM)+PAGE_PARAM_LENGTH, h.length);
        
        // Load component
        $(".ajax-loader").fadeIn("fast");
        $("section.main").load("components/"+ component +".html", function() {
            
            $("section.main").fadeIn("fast");
            window.location.hash = component;
            
            var restore = "";
            // Set width and restore the variable
            if (page.content.width != null)
            {
                restore = $("section.content").css("width");
                $("section.content").animate({width: page.content.width}, 500, function() {
                    page.content.width = restore;
                });
            }
            
            // Set background and restore the variable
            if (page.background != null)
            {
                restore = $("div.bg-container").css("background-image");
                $("div.bg-container").fadeOut("slow", function() {
                    
                    var bgImg = new Image();
                    $(bgImg).load(function() { 
                        $("div.bg-container").css("background-image", "url('"+ page.background +"')");
                        $("div.bg-container").fadeIn("slow");
                        page.background = restore;
                    });
                    bgImg.src = page.background;
                });
            }
            $(".ajax-loader").fadeOut("fast");
        });
        
        return false;
    });
    
    
    $(this).bind("click", function(event) {
        // Hide slider
        if ($("section.slider").is(":visible") && closeSlider(event))
        {
            //var b = -$("section.slider").height();
            var b = -window.screen.availHeight || -1000;
            $("section.slider").animate({bottom: b+"px"}, 800, function() {
                $(this).hide();
            });
        }
        
        // Hide gallery
        if ($("section.gallery").is(":visible") && closeGallery(event))
        {
            //var c = -$("section.gallery").width();
            var c = -window.screen.availWidth || -2000;
            $("section.gallery").animate({right: c+"px"}, 800, function() {
                $(this).hide();
            });
        }
    });
});

$.extend(page, {
   
   loadPage : function()
   {
        $("section.main").hide();
        $("section.main").load("components/"+ window.location.hash.substring(1) +".html", function() {
            $("section.main").fadeIn("fast");
        });
   }
   
});

function closeSlider(event)
{
    if ($(event.target).hasClass("slider") || $(event.target).isChildOf("section.slider") ||
        $(event.target).attr("id") == "sb-container" || $(event.target).isChildOf("#sb-container"))
    {
        return false;
    }
        
        
    return true;
}

function closeGallery(event)
{
    if ($(event.target).hasClass("gallery") || $(event.target).isChildOf("section.gallery") ||
        $(event.target).attr("id") == "sb-container" || $(event.target).isChildOf("#sb-container"))
    {
        return false;
    }
        
    return true;
}