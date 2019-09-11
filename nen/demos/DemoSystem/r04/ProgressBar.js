"use strict";
DemoLoader.Progress = {};

/**
* Progress
*
* TODO There's some bugs on progress count
*
* @class Progress
*/
(function(Progress, $) {

    var element = $("#progress");
    var barElement = $("#progressbar");
    var currentState = null;
    var currentProgress = 0;

    var fileCount = 0;
    var currentCount = 0;

    Progress.initialize = function(properties)
    {
        if (element.length == 0)
        {
            console.warn("Element not defined, not initializing Progress...");
            return;
        }

        fileCount = properties.fileCount;

        setBar(null, 0);

        // Change state to initial "before"
        changeState("before");
    }

    Progress.start = function()
    {
        changeState("loading");
        setBar(null, 0);
    }

    Progress.done = function()
    {
        changeState("done");
        setBar(null, 100);
    }

    Progress.incrementProgress = function(file)
    {
        currentCount = currentCount+1;
        var newProgress = Math.floor((currentCount / fileCount) * 100);
        setBar(file, newProgress);
    }

    function setBar(file, progress)
    {
        var fileElem = barElement.find(".progress-file");
        var progressElem = barElement.find(".progress-percent");
        var barElem = barElement.find(".progress-width");

        if (file)
            fileElem.text(file).show();
        else
            fileElem.text("").hide();

        if (!isNaN(progress))
        {
            currentProgress = progress;
            progressElem.text(progress);

            barElem.css("width", progress+"%");
        }
    }

    function changeState(nextState)
    {
        currentState = nextState;

        // Hide everything but the progressbar within the element
        element.children().hide();
        barElement.show();

        // Get the element for current state and show it
        var stateElem = element.children("[data-state='"+ currentState +"']");
        var hideElemSelect = stateElem.data("hide");
        var showElemSelect = stateElem.data("show");

        stateElem.show();

        if (hideElemSelect != "")
        {
            $(hideElemSelect).hide();
        }

        if (showElemSelect != "")
        {
            $(showElemSelect).show();
        }
    }

})(DemoLoader.Progress, jQuery);
