"use strict";
var Intro = new Scene("Intro #1");
DemoScene.registerInitialScene(Intro);

Intro.init = function()
{
	console.log("Intro init");
};

Intro.render = function()
{
	console.log("Intro render");
};

Intro.unload = function()
{
	console.log("Intro unload");
};