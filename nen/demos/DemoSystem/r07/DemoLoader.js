"use strict";

/**
* DemoLoader is a loader for DemoScene system. Loader will load the actual DemoScene system
* but also every other script it's given. Once the loading is completed, it will initialize
* the DemoScene system.
*
* @version 0.6
* @class DemoLoader
*/
var DemoLoader = {};

(function(Loader, $) {

    var initialScripts = [];
    var scripts = [];
    var initialsLoaded = false;

    Loader.addScripts = function(scripts, initial, callback)
    {
        for (var i=0; i<scripts.length; i++)
        {
            var script = scripts[i];
            Loader.addScript(script, initial, callback);
        }
    };

    Loader.addScript = function(scriptData, initial, callback)
    {
        var scriptObj = getScriptObject(scriptData, callback);
        if (initial)
        {
            initialScripts.push(scriptObj);
        }
        else
        {
            scripts.push(scriptObj);
        }
    };

    Loader.start = function()
    {
        // Count scripts
        var scriptCount = initialScripts.length + scripts.length +1;

        // Broadcast event that loading is about to start
        $(document).trigger("loaderStart.DemoSystem", {fileCount: scriptCount});

        // Start loading from the initial scripts
        doLoad();
    };

    var doLoad = function()
    {
        // Get next script to load
        var scriptObject = getNextScript();

        // If nothing to load, broadcast and quit
        if (!scriptObject)
        {
            // Broadcast event that everything was loaded
            $(document).trigger("loaderDone.DemoSystem");
            return;
        }

        $(document).trigger("loaderTick.DemoSystem", {name: scriptObject.name, file: scriptObject.file});

        var $loader = DemoUtils.getLoader(scriptObject.file);

        // Load the script
        $loader(scriptObject.file).done(function(script, textStatus)
        {
            // After loading, execute callback
            if (typeof(scriptObject.callback) === "function")
            {
                // That script callback, will get secondary callback, which should
                // continue this loading when ready.
                return scriptObject.callback(scriptObject.name, scriptObject.file, script, function() {
                    doLoad();
                });
            }

            // When done with this file, load more
            doLoad();
        })
        .fail(function(jqxhr, settings, exception)
        {
            console.error("Loading failed! File: "+ scriptObject.file +" // Status: "+ jqxhr.status, exception);
        });
    };

    function getNextScript()
    {
        // Get the prioritized non-empty array
        var scriptArray = getScriptArray();
        if (scriptArray == null)
            return null;

        // Return the next script object fromt he list
        return scriptArray.shift();
    };

    function getScriptArray()
    {
        if (initialScripts.length > 0)
            return initialScripts;

        if (!initialsLoaded)
        {
            initialsLoaded = true;
            $(document).trigger("loaderReady.DemoSystem")
        }

        if (scripts.length > 0)
            return scripts;

        return null;
    };

    function getScriptObject(scriptData, callback)
    {
        var name = "";
        var file = "";

        if (typeof(scriptData) === "object")
        {
            name = scriptData.name;
            file = scriptData.file;
        }
        else
        {
            name = DemoUtils.getFilename(scriptData);
            file = scriptData;
        }

        return {name: name, file: file, callback: callback};
    };

})(DemoLoader, jQuery);
