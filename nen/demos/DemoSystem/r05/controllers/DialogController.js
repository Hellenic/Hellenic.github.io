"use strict";
var DialogController = {};

/**
* DialogController
*
* @class DialogController
*/
(function(Controller, $) {

    var $notification = $("#notification");
    $notification.hide();

    Controller.showText = function(textData)
    {
        if (!textData)
            return;

        if (textData.hasOwnProperty("title"))
            $notification.find("h2").text(textData.title);

        if (textData.hasOwnProperty("content"))
            $notification.find("p").html(textData.content);
        
        $notification.fadeIn().delay(textData.timeout).fadeOut();
    };

})(DialogController, jQuery);
