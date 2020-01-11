"use strict";
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

/**
*
* @class DemoScene
*/
(function(Demo, $) {

	Demo.container = $("<div />");
	var stats = null;
	var currentScene = null;
	var initialScene = null;
	var scenes = [];
	var debugEnabled = true;

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

	function init()
	{
		console.log("Initializing...");

		if (!Detector.webgl)
		{
			Detector.addGetWebGLMessage();
		}

		if (typeof(Stats) !== "undefined")
		{
			stats = new Stats();
			$("<figure />").attr("id", "stats").appendTo("body");
			$("#stats").html(stats.domElement);
		}

		if (debugEnabled)
		{
			$("<div />").attr("id", "debug").appendTo("body");
		}

		$("body").append(Demo.container);

		if (initialScene !== null)
		{
			scenes.push(initialScene);
			doSceneChange();
			animate();
		}

		console.log(" .// ... ///       ...    //.");
		console.log(" .//  DemoScene started!  ./.");
		console.log(" .// ...      ... ///     //.");
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

	function debug()
	{
			if (currentScene != null)
			{
				var debug = "";

				debug += "<br />Scene: "+ currentScene.name;
				debug += "<br />SceneState: "+ currentScene.state;
				$("#debug").html(debug);
			}
	}

	function doSceneChange()
	{
		console.debug("Scene changing...");
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
		console.debug("Initializing scene "+ currentScene.name);
		currentScene.init();
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

		console.log("Registering initial scene", scene.name);
		initialScene = scene;
	};

	Demo.registerScene = function(scene)
	{
		if (!(scene instanceof Scene))
		{
			return;
		}

		console.log("Registering scene", scene.name);
		scenes.push(scene);
	};

})(DemoScene, jQuery);
