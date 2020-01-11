var target = new Date();
var ticker = null;
var state = 0;

$(document).ready(function() {

	// This is the time when we are leaving!
	// So, month and date
    target.setMonth(5, 1); // Remember, months are counted from 0
    // And year of course
    target.setFullYear(2020);
    // Hour, minute and second
    target.setHours(14, 0, 0); // Hour 6 means actually 8, timezone thing maybe? dunno

    var t = formatDate(target);

    $("figure.target").html(t.toString());

    tick();

    $("#sneakpeak").bind("click", function() {
        haveLoveWillTravel();
    });
});

function tick()
{
    var now = new Date();
    now = formatDate(now);
    $("figure.now").html(now.toString());

    var c = formatCountdown();
    $("figure.countdown").html(c.toString());

    if (target.getTime() - new Date() < 120000 && state == 0)
    {
        $("section.content").last().html($("<figure />").addClass("travel").html("You should get ready now!"));
        state++;
    }
    else if (target.getTime() - new Date() < 63000 && state == 1)
    {
        clearTimeout(ticker);
        haveLoveWillTravel();
        state++;
    }
    else if (target.getTime() - new Date() < 0 && state == 2)
    {
        clearTimeout(ticker);
        $("#sneakpeak").show();
        state++;
    }

    ticker = setTimeout(tick, 1000);
}

function formatDate(date)
{
    var d = date.getDate() +"."+ (date.getMonth()+1) +"."+ date.getFullYear();

    d += " "+ date.toLocaleTimeString();

    return d;
}

function formatCountdown()
{
    var now = new Date();
    var c = new Date();
    c.setTime(target.valueOf() - now.valueOf());

    //var daysLeft = Math.floor(((target.getTime() - now.getTime()) / (60*60*24)) / 1000);

    var d = "Time left: <br /><br />";
    // TODO A bug here, year is wrong in 'c' variable
    var years = c.getFullYear() - 1970;
    var months = years * 12 + c.getMonth();

    d += months +" months <br />";
    d += (c.getDate()-1) +" days <br />";
    d += (c.getHours()-2) +" hours <br />";
    d += z(c.getMinutes()) +" minutes <br/>";
    d += z(c.getSeconds()) + " seconds";

    return d;
}

function z(d)
{
    if (d.toString().length < 2)
        d = "0" + d;

    return d;
}

function haveLoveWillTravel()
{
    $("#travelmusic")[0].volume = 0;
    $("#travelmusic")[0].play();

    var from = { property: 1 };
    var to = { property: 0 };

    var delta = new Date();
    var bg = 171;
    jQuery(from).animate(to, {
        duration: 30000,
        step: function() {
            $(".remove").css("opacity", this.property);
            var val = (new Date() - delta) * 0.02;
            delta = new Date();
            bg = bg - val;

            var vol = val * 0.006;
            if ($("#travelmusic")[0].volume + vol < 1)
                $("#travelmusic")[0].volume += vol;
            else
                $("#travelmusic")[0].volume = 1;

            var rgb = "rgb("+ Math.floor(bg) +","+ Math.floor(bg) +","+ Math.floor(bg) +")";
            $("body").css("background-color", rgb);
        },
        complete: function() {
            $(".remove").remove();
            $("body").css("background-color", "black");
            $("#travelmusic")[0].volume = 1;
            Demo.init();
        }
    });
}
