var Music = new Object();

$(document).ready(function()
{
    Music.element = $("<audio />").attr("autoplay", "autoplay");
    Music.element.hide();
    Music.media = Music.element.get(0);

    Music.media.volume = 0.25;

    //var track = $("<source />").attr("src", "music/cannon.mp3").attr("type", "audio/mp3");
    var track = $("<source />").attr("src", "/Demos/common/music/quantum.ogg").attr("type", "audio/ogg");
    Music.element.append(track);

    $("body").append(Music.element);
});
