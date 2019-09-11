"use strict";
var MusicPlayer = {};

/**
* MusicPlayer
*
* @class MusicPlayer
*/
(function(MusicPlayer, $) {

    var element = null;

    MusicPlayer.initialize = function(autoplay, volume)
    {
        if (element == null)
        {
            element = $("<audio />");
            if (autoplay)
                element.attr("autoplay", "autoplay");

                var media = element.get(0);
                media.volume = volume;
            }

            $("body").append(element);
        }

    MusicPlayer.addTrack = function(url, mimetype)
    {
        var sourceElement = $("<source />");
        sourceElement.attr("src", url);
        sourceElement.attr("type", mimetype);

        element.html(sourceElement);
    }

})(MusicPlayer, jQuery);
