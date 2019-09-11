"use strict";

var DemoLoader = {};

/**
 * DemoLoader is a loader for DemoScene system. Loader will load the actual DemoScene system
 * but also every other script it's given. Once the loading is completed, it will initialize
 * the DemoScene system.
 *
 * @version 0.4
 * @class DemoLoader
 */
(function(Loader, $) {

	var settings = {
		pointerlock: false,
		progressBar: false,
		audio: false
	};

	// Path to DemoSystem
	var currentPath = document.currentScript.src;
	var ROOT_PATH = currentPath.substring(0, currentPath.lastIndexOf("/")+1);

	var scripts = {};
	// Files will be loaded in given order
	scripts.internal = [
		{file: ROOT_PATH + "Detector.js"},
		{file: ROOT_PATH + "DemoScene.js"},
		{file: ROOT_PATH + "services/ModelService.js"},
		{file: ROOT_PATH + "services/InteractionService.js"},
		{file: ROOT_PATH + "controllers/Controls.js"},
		{file: ROOT_PATH + "controllers/Interactor.js"},
		{file: ROOT_PATH + "models/Scene.js"},
		{file: ROOT_PATH + "models/Model.js"},
		{file: ROOT_PATH + "models/Interaction.js"},
		{file: ROOT_PATH + "DemoUtils.js"}
	];
	scripts.essential = [];
	scripts.general = [];
	scripts.shaders = [];
	scripts.models = [];
	scripts.scenes = [];
	var scriptsCount = 0;

	var STEPS = {
		PREPARING: 0,
		ESSENTIALS: 1,
		GENERALS: 2,
		MODELS: 3,
		SCENES: 4,
		DONE: 5
	};
	var currentStep = STEPS.PREPARING;

	function loadInternals()
	{
		// Count all the files that will be downloaded
		// At this point, no new files shouldn't be added
		for (var arrayName in scripts)
		{
			scriptsCount += scripts[arrayName].length;
		}

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
		switch (currentStep)
		{
			case STEPS.PREPARING:
				currentStep = STEPS.ESSENTIALS;

				// Initialize progress bar, if it should be
				if (typeof(DemoLoader.Progress) !== "undefined")
				{
					DemoLoader.Progress.initialize({ fileCount: scriptsCount });
					DemoLoader.Progress.start();
				}

				// Next, load essentials
				loadFirstScript(scripts.essential);
				break;

			case STEPS.ESSENTIALS:
				currentStep = STEPS.GENERALS;

				// Trigger load event for DemoScene
				$("body").trigger("Demo.loaded.essentials", settings);

				// Next, load generals and shaders
				loadFirstScript(scripts.general);
				loadShaders();
				break;

			case STEPS.GENERALS:
				currentStep = STEPS.MODELS;
				$("body").trigger("Demo.loaded.general");

				loadFirstScript(scripts.models);
				break;

			case STEPS.MODELS:
				currentStep = STEPS.SCENES;
				$("body").trigger("Demo.loaded.models");

				loadFirstScript(scripts.scenes);
				break;

			case STEPS.SCENES:
				currentStep = STEPS.DONE;
				// Update progressbar
				if (typeof(DemoLoader.Progress) !== "undefined")
					DemoLoader.Progress.done();

				$("body").trigger("Demo.loaded.all");
				break;
		};
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
		if (currentStep > STEPS.PREPARING)
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
		if (settings.audio)
		{
			scripts.internal.push(getScriptObject(ROOT_PATH + "soundsystem/AudioPlayer.js"));
			scripts.internal.push(getScriptObject(ROOT_PATH + "soundsystem/MusicPlayer.js"));
			scripts.internal.push(getScriptObject(ROOT_PATH + "soundsystem/SoundPlayer.js"));
		}
	}

    $(document).ready(loadInternals);

})(DemoLoader, jQuery);
