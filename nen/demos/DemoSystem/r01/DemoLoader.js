/**
 * DemoLoader v0.1
 */
var Demo = Demo || new Object();

Demo.load = new Object();
Demo.load.scripts = new Object();
// These files will be loaded in this order
Demo.load.scripts.essential = ["../common/js/threejs/Stats.js", "../common/js/threejs/Detector.js", "js/Intro.js"];
Demo.load.scripts.general =
    ["../common/js/ShaderExtras.js",
        "../common/js/Postprocessing/CopyShader.js",
        "../common/js/Postprocessing/EffectComposer.js",
        "../common/js/Postprocessing/RenderPass.js",
        "../common/js/Postprocessing/BloomPass.js",
        "../common/js/Postprocessing/ShaderPass.js",
        "../common/js/Postprocessing/MaskPass.js",
        "../common/js/Postprocessing/FilmPass.js",
        "../common/js/Postprocessing/DotScreenPass.js",
        "../common/js/Postprocessing/TexturePass.js"];

Demo.load.scripts.scenes = ["js/Scene1.js", "js/Scene2.js"];

/**
 * 0 - Not loading
 * 1 - Loading
 * 2 - Loaded
 * 3 - Error
 */
Demo.load.loadStatus = 0;

/**
 * 0 - Not started
 * 1 - Essentials
 * 2 - General
 * 3 - Scenes
 */
Demo.load.loadStep = 0;

$.extend(Demo.load, {

    loadEssentials : function()
    {
        if (Demo.load.scripts.essential.length > 0)
        {
            Demo.load.loadStatus = 1;
            Demo.load.loadFirstScript(Demo.load.scripts.essential);
        }
    },

    loadGeneral : function()
    {
        if (Demo.load.scripts.general.length > 0)
        {
            Demo.load.loadStatus = 1;
            Demo.load.loadFirstScript(Demo.load.scripts.general);
        }
    },

    loadScenes : function()
    {
        if (Demo.load.scripts.scenes.length > 0)
        {
            Demo.load.loadStatus = 1;
            Demo.load.loadFirstScript(Demo.load.scripts.scenes);
        }
    },

    loadFirstScript : function(list)
    {
        var file = list.shift();
        $.getScript(file).done(function(script, textStatus)
        {
            if (list.length > 0)
                Demo.load.loadFirstScript(list);
            else if (list.length == 0)
                Demo.load.doneLoading();
        })
        .fail(function(jqxhr, settings, exception)
        {
            console.warn("Loading failed! File "+ file +"<br />"+ jqxhr.status, exception);
        });
    },

    doneLoading : function()
    {
        Demo.load.loadStatus = 2;
        console.debug("Loading done!");

        if (Demo.load.loadStep == 0)
        {
            console.log("Essentials loaded.");
            Demo.init();

            Demo.load.loadStep = 1;
            // Then load rest of the stuff
            Demo.load.loadGeneral();
        }
        else if (Demo.load.loadStep == 1)
        {
            console.log("General stuff loaded.");
            Demo.load.loadStep = 2;

            Demo.load.loadScenes();
        }
        else if (Demo.load.loadStep == 2)
        {
            console.log("Scenes loaded.");
            Demo.load.loadStep = 3;
            console.log("Loading finished.");
        }
        else
        {
            console.log("???!! DemoLoader.doneLoading unknown step");
        }
    }

});
