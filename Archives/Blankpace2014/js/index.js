$(document).ready(function() {
    
    $("figure.choice, figure.choice-small").bind("click", function() {
        
        var link = $(this).find("a").attr("href");
        window.location = link;
        
    });
    
});