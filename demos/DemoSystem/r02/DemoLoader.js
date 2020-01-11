"use strict";
var DemoLoader = {};

/**
 *
 * @class DemoLoader
 */
(function(Loader, $) {

	var scripts = {};

	// Files will be loaded in given order
	scripts.essential = ["../common/js/threejs/Detector.js", "../DemoSystem/r02/DemoScene.js", "../DemoSystem/r02/Scene.js"];
	scripts.general =
		["../common/js/ShaderExtras.js",
		"../common/js/Postprocessing/BloomPass.js",
		"../common/js/Postprocessing/BokehShader.js",
		"../common/js/Postprocessing/CopyShader.js",
		"../common/js/Postprocessing/DotScreenPass.js",
		"../common/js/Postprocessing/DotScreenShader.js",
		"../common/js/Postprocessing/FilmPass.js",
		"../common/js/Postprocessing/MaskPass.js",
		"../common/js/Postprocessing/RenderPass.js",
		"../common/js/Postprocessing/RGBShiftShader.js",
		"../common/js/Postprocessing/SavePass.js",
		"../common/js/Postprocessing/ShaderPass.js",
		"../common/js/Postprocessing/TexturePass.js",
		"../common/js/Postprocessing/EffectComposer.js"];
	scripts.scenes = [];

	// Shaders will be download along with generals
	scripts.shaders = [];

	/**
	 * 0 - Not started
	 * 1 - Essentials
	 * 2 - General
	 * 3 - Scenes
	 */
	var loadStep = 0;

    function loadEssentials()
    {
        if (scripts.essential.length > 0)
        {
            loadFirstScript(scripts.essential);
        }
    }

    function loadGeneral()
    {
        if (scripts.general.length > 0)
        {
            loadFirstScript(scripts.general);
        }
    }

    function loadScenes()
    {
        if (scripts.scenes.length > 0)
        {
            loadFirstScript(scripts.scenes);
        }
    }

    function loadShaders()
    {
    	if (scripts.shaders.length > 0)
		{
    		var shaderInfo = scripts.shaders.shift();

			$.get(shaderInfo.shader, function(data) {
				Shaders[shaderInfo.variable] = data;
				loadShaders();
			});
		}
    }

    function loadFirstScript(list)
    {
        var file = list.shift();
        $.getScript(file).done(function(script, textStatus)
        {
            if (list.length > 0)
                loadFirstScript(list);
            else if (list.length == 0)
                doneLoading();
        })
        .fail(function(jqxhr, settings, exception)
        {
            console.warn("Loading failed! File "+ file +"<br />"+ jqxhr.status, exception);
        });
    }

    function doneLoading()
    {
        if (loadStep == 0)
        {
        	loadStep = 1;

            // Trigger load event for DemoScene
            $("body").trigger("Demo.loaded.essentials");

            // Then load rest of the stuff
            loadGeneral();
            loadShaders();
        }
        else if (loadStep == 1)
        {
            loadStep = 2;
            $("body").trigger("Demo.loaded.general");

            loadScenes();
        }
        else if (loadStep == 2)
        {
            loadStep = 3;
            $("body").trigger("Demo.loaded.all");
        }
        else
        {
            console.warn("???!! DemoLoader.doneLoading unknown step");
        }
    }

    Loader.addEssentialScript = function(script)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.essential.push(script);
    };

    Loader.addGeneralScript = function(script)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.general.push(script);
    };

    Loader.addSceneScript = function(script)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.scenes.push(script);
    };

    // Add the shader file and it's variable to queue
    Loader.addShader = function(shaderfile, variable)
    {
    	scripts.shaders.push({shader: shaderfile, variable: variable});
    };

    $(document).ready(loadEssentials);

})(DemoLoader, jQuery);
