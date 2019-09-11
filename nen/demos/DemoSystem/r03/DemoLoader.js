"use strict";

var DemoLoader = {};

/**
 * DemoLoader is a loader for DemoScene system. Loader will load the actual DemoScene system
 * but also every other script it's given. Once the loading is completed, it will initialize
 * the DemoScene system.
 *
 * @version 0.3
 * @class DemoLoader
 */
(function(Loader, $) {

	var scripts = {};
	var settings = {
		pointerlock: false,
		progressBar: false,
		music: false
	};

	// Path to DemoSystem
	var currentPath = document.currentScript.src;
	var ROOT_PATH = currentPath.substring(0, currentPath.lastIndexOf("/")+1);

	// Files will be loaded in given order
	scripts.internal = [
		{file: ROOT_PATH + "Detector.js"},
		{file: ROOT_PATH + "DemoScene.js"},
		{file: ROOT_PATH + "Scene.js"},
		{file: ROOT_PATH + "Model.js"},
		{file: ROOT_PATH + "DemoUtils.js"}
	];
	scripts.essential = [];
	scripts.general = [];
	scripts.models = [];
	scripts.scenes = [];

	var scriptsCount = 0;

	// Shaders will be download along with generals
	scripts.shaders = [];

	/**
	 * 0 - Not started
	 * 1 - Essentials
	 * 2 - General
	 * 3 - Models
	 * 4 - Scenes
	 */
	var loadStep = 0;

	function loadInternals()
	{
		// Count all the files that will be downloaded
		// At this point, no new files shouldn't be added
		scriptsCount = scripts.essential.length + scripts.general.length
					+ scripts.models.length + scripts.scenes.length;

		// Start by loading internals
		loadFirstScript(scripts.internal);
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

	function getScriptObject(file, callback)
	{
		return {file: file, callback: callback};
	}

    function loadFirstScript(list, callback)
    {
		// If nothing to load on the list, increment progress
		if (list == null || list.length == 0)
		{
			incrementProgress();
			return;
		}

		// Take the next object from the list
        var object = list.shift();
		var file = object.file;
		var callback = object.callback;

		// Update progressbar
		if (typeof(DemoLoader.Progress) !== "undefined")
			DemoLoader.Progress.incrementProgress(file);

		// Load the script
        $.getScript(file).done(function(script, textStatus)
        {
			// After loading, execute callback
			if (typeof(callback) === "function")
			{
				// So... This is  a bit of a mess.
				// Any loaded script can have callback, which will be executed here
				// once the script is loaded.

				// That script callback, will get secondary callback, which should
				// continue this loading when ready.
				return callback(function() {
					loadFirstScript(list);
				});
			}

			// When done with this file, load more from this list
            loadFirstScript(list);
        })
        .fail(function(jqxhr, settings, exception)
        {
            console.error("Loading failed! File: "+ file +" // Status: "+ jqxhr.status, exception);
        });
    }

    function incrementProgress()
    {
        if (loadStep == 0)
        {
        	loadStep = 1;

			// Initialize progress bar, if it should be
			if (typeof(DemoLoader.Progress) !== "undefined")
			{
				DemoLoader.Progress.initialize({ fileCount: scriptsCount });
				DemoLoader.Progress.start();
			}

			// Next, load essentials
			loadFirstScript(scripts.essential);
		}
		else if (loadStep == 1)
		{
			loadStep = 2;

			// Trigger load event for DemoScene
			$("body").trigger("Demo.loaded.essentials", settings);

            // Next, load generals and shaders
			loadFirstScript(scripts.general);
            loadShaders();
        }
        else if (loadStep == 2)
        {
            loadStep = 3;
            $("body").trigger("Demo.loaded.general");

			loadFirstScript(scripts.models);
		}
		else if (loadStep == 3)
		{
			loadStep = 4;
			$("body").trigger("Demo.loaded.models");

			loadFirstScript(scripts.scenes);
		}
        else if (loadStep == 4)
        {
			// Update progressbar
			if (typeof(DemoLoader.Progress) !== "undefined")
				DemoLoader.Progress.done();

            loadStep = 5;
            $("body").trigger("Demo.loaded.all");
        }
    }

    Loader.addEssentialScript = function(script, callback)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.essential.push(getScriptObject(script, callback));
    };

    Loader.addGeneralScript = function(script, callback)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.general.push(getScriptObject(script, callback));
    };

    Loader.addSceneScript = function(script, callback)
    {
    	if (typeof(script) === "undefined" || script == null) {
    		return;
		}

    	scripts.scenes.push(getScriptObject(script, callback));
    };

	Loader.addModelScript = function(script, callback)
	{
		if (typeof(script) === "undefined" || script == null) {
			return;
		}

		/**
			If callback is not defined, we assume that:
			 * The loaded script is type of Model
			 * Model is named the same as the file
			And then callback for file: Character.js will be
			 => Character.load(callback);
		*/
		if (typeof(callback) === "undefined" || callback == null) {
			callback = function(callback) {
				var filename = DemoUtils.getFilename(script);
				var modelClass = eval(filename);
				if (modelClass instanceof Model)
				{
					modelClass.load(callback);
				}
			}
		}

		scripts.models.push(getScriptObject(script, callback));
	};

    // Add the shader file and it's variable to queue
    Loader.addShader = function(shaderfile, variable)
    {
    	scripts.shaders.push({shader: shaderfile, variable: variable});
    };

	Loader.setProperties = function(properties)
	{
		if (loadStep > 0)
		{
			console.warn("You cannot set properties anymore after loading has already begun.");
			return;
		}
		settings = properties;

		if (settings.pointerlock)
		{
			scripts.internal.push(getScriptObject(ROOT_PATH + "Pointerlock.js"));
		}
		if (settings.progressBar)
		{
			scripts.internal.push(getScriptObject(ROOT_PATH + "ProgressBar.js"));
		}
		if (settings.music)
		{
			scripts.internal.push(getScriptObject(ROOT_PATH + "MusicPlayer.js"));
		}
	}

    $(document).ready(loadInternals);

})(DemoLoader, jQuery);
