"use strict";

/**
* DemoScene system.
* DemoScene handles the initialization for scenes, possible errors,
* the actual demo loop, etc.
*
* @version 0.4
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

var Shaders = {
	vertexShader : null,
	fragmentShader : null
};

(function(Demo, $) {

	Demo.container = ($("#demoscreen").length == 1) ? $("#demoscreen") : $("body");
	var stats = null;
	var physicStats = null;
	var currentScene = null;
	var initialScene = null;
	var scenes = [];
	var debugEnabled = true;
	var debugContainer = null;
	var infoContainer = $("#middle-box");
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
			DemoScene.Pointerlock.initialize(Demo.container, onPointerlockCallback);
		}

		if (typeof(Stats) !== "undefined")
		{
			var statsContainer = $("#stats");
			if (statsContainer.length != 1)
			{
				statsContainer = $("<div />").attr("id", "stats").appendTo("body");
			}

			stats = new Stats();
			statsContainer.html(stats.domElement);

			if (typeof(Physijs) !== "undefined")
			{
				// Physics stats
				physicStats = new Stats();
				statsContainer.append(physicStats.domElement);
			}
		}

		if (debugEnabled)
		{
			debugContainer = $("#debug");
			if (debugContainer.length != 1)
			{
				debugContainer = $("<div />").attr("id", "debug").appendTo("body");
			}
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

		if (debugEnabled)
			debug();
	}

	function updatePhysics()
	{
		if (physicStats != null)
		{
			physicStats.update();
		}

		currentScene.updatePhysics();
	}

	function debug()
	{
		if (currentScene != null)
		{
			var debug = "";

			debug += "<br />Scene: "+ currentScene.name;
			debug += "<br />SceneState: "+ currentScene.state;
			debugContainer.html(debug);
		}
	}

	function doSceneChange()
	{
		if (currentScene !== null)
		{
			console.debug("Unloading "+ currentScene.name);
			currentScene.unload();
			Demo.container.empty();
			Demo.container.hide();
		}

		// If no more scenes to run, end.
		if (scenes.length == 0)
		{
			currentScene = null;
			Demo.container.remove();
			console.log("The end.");
			return;
		}

		currentScene = scenes.shift();
		console.info("Initializing scene "+ currentScene.name);
		currentScene.init();

		// If we are using Physijs, attach the physics update event listener
		if (currentScene.scene instanceof Physijs.Scene)
		{
			currentScene.scene.addEventListener("update", updatePhysics);
		}

		Demo.container.append(currentScene.renderer.domElement);
		Demo.container.fadeIn("fast");

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

})(DemoScene, jQuery);
