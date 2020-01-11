"use strict";

/**
* DemoScene system with Oimo.js
* DemoScene handles the initialization for scenes, possible errors,
* the actual demo loop, etc.
*
* @version 0.5
* @class DemoScene
*/
var DemoScene = {};

var Statics = {
	SCREEN_WIDTH : window.innerWidth,
	SCREEN_HEIGHT : window.innerHeight,
	SCREEN_WIDTH_HALF : window.innerWidth / 2,
	SCREEN_HEIGHT_HALF : window.innerHeight / 2,
	MAX_HEX : 16777215
};

var Shaders = {};

(function(Demo, $) {

	var container = ($("#demoscreen").length == 1) ? $("#demoscreen") : $("body");
	var stats = null;
	var currentScene = null;
	var initialScene = null;
	var scenes = [];
	var statsContainer = $("#stats");
	var debugContainer = $("#debug");
	var infoContainer = $("#demo-info");
 	var settings = null;
	var paused = false;

	function onGeneralsLoaded()
	{

	}

	function onEverythingLoaded()
	{
		// Once everything is loaded, check if there is scene
		// If there is not, initial scene was not defined, then start running actual scenes
		if (currentScene == null)
		{
			doSceneChange();
			animate();
		}
	}

	function init(event, data)
	{
		console.info("Initializing DemoScene...");
		settings = data;

		if (!checkSupport())
		{
			console.error("Unable to start DemoSystem. Essential functionalities are not supported by the browser.");
			return;
		}

		if (settings.pointerlock)
		{
			DemoScene.Pointerlock.initialize(container, onPointerlockCallback);
		}

		if (typeof(Stats) !== "undefined")
		{
			if (statsContainer.length != 1)
			{
				statsContainer = $("<div />").attr("id", "stats").appendTo("body");
			}

			stats = new Stats();
			statsContainer.html(stats.domElement);
		}

		// Create new debug container if given doesn't exist
		if (settings.debug && debugContainer.length != 1)
		{
			debugContainer = $("<div />").attr("id", "debug").appendTo("body");
		}

		if (initialScene !== null)
		{
			scenes.push(initialScene);
			doSceneChange();
			animate();
		}

		console.info(" .// ... ///       ...    //.");
		console.info(" .//  DemoScene started!  ./.");
		console.info(" .// ...      ... ///     //.");
	}

	function checkSupport()
	{
		var supportContainer = $("#support");
		var supported = true;

		if (Detector.webgl)
		{
			supportContainer.find("[data-api='webgl']").remove();
		}
		else
		{
			supported = false;
			console.warn("WebGL not supported.");
		}

		if (settings.pointerlock)
		{
			if (Detector.pointerlock)
			{
				supportContainer.find("[data-api='pointerlock']").remove();
			}
			else
			{
				supported = false;
				console.warn("Pointerlock Control not supported.");
			}
		}

		if (supported)
			supportContainer.remove();
		else
			supportContainer.show();

		return supported;
	}

	function onPointerlockCallback(isLocked)
	{
		if (isLocked)
		{
			infoContainer.hide();
			currentScene.pause(false);
			paused = false;
		}
		else
		{
			infoContainer.show();
			currentScene.pause(true);
			paused = true;
		}
	}

	function animate()
	{
		if (currentScene !== null)
		{
			requestAnimationFrame(animate);

			var sceneState = currentScene.render();
			if (sceneState == 0)
				doSceneChange();
		}

		if (stats != null)
			stats.update();

		if (settings.debug)
		{
			var debugInfo = Demo.getDebugInfo();
			debugContainer.html(debug);
		}
	}

	function doSceneChange()
	{
		if (currentScene !== null)
		{
			console.debug("Unloading "+ currentScene.name);
			currentScene.unload();
			container.empty();
			container.hide();
		}

		// If no more scenes to run, end.
		if (scenes.length == 0)
		{
			currentScene = null;
			container.remove();
			console.log("The end.");
			return;
		}

		currentScene = scenes.shift();
		console.info("Initializing scene "+ currentScene.name);
		currentScene.init();

		container.append(currentScene.renderer.domElement);
		container.fadeIn("fast");

		window.addEventListener("resize", function() { currentScene.resize(); }, false);
	}

	$("body").on("Demo.loaded.essentials", init);
	$("body").on("Demo.loaded.general", onGeneralsLoaded);
	$("body").on("Demo.loaded.all", onEverythingLoaded);

	Demo.registerInitialScene = function(scene)
	{
		if (!(scene instanceof Scene))
		{
			return;
		}

		console.info("Registering initial scene", scene.name);
		initialScene = scene;
	};

	Demo.registerScene = function(scene)
	{
		if (!(scene instanceof Scene))
		{
			return;
		}

		console.info("Registering scene", scene.name);
		scenes.push(scene);
	};

	Demo.getContainer = function() {
		return container;
	};
	Demo.getStatsContainer = function() {
		return statsContainer;
	};
	Demo.getInfoContainer = function() {
		return infoContainer;
	};
	Demo.getDebugContainer = function() {
		return debugContainer;
	};
	Demo.getCurrentScene = function() {
		return currentScene;
	};
	Demo.getDebugInfo = function() {
		var debug = "";
		if (currentScene != null)
		{
			debug += "<br />Scene: "+ currentScene.name;
			debug += "<br />SceneState: "+ currentScene.state;
		}
		return debug;
	};

})(DemoScene, jQuery);
