"use strict";

var Blankpace = {};
// This method constructs the settings for building the menu
// TODO These could be pulled from HTML and thus the menu could be generated based on HTML content
Blankpace.getMenuSettings = function()
{
	var conf = new MenuSettings();
	conf.innerRadius = 100;
	conf.outerRadius = 500;
	conf.thetaStart = 15;
	conf.thetaLength = 75;
	conf.textOffset = 170;
	conf.bgColor = "#C9C9C9";
	conf.divideEventually = true;
	conf.slices = [];
	conf.slices.push({ text: "Cardeon", link: "/Cardeon/", title: "Card game playable in browser [WIP]" });
	conf.slices.push({ text: "Me", link: "/HK/", title: "Homepage of Hannu Kärkkäinen\r\n \/\/ My homepage" });

	var miscMenuConf = new MenuSettings();
	miscMenuConf.innerRadius = 400;
	miscMenuConf.outerRadius = 720;
	miscMenuConf.thetaStart = 30;
	miscMenuConf.thetaLength = 65;
	miscMenuConf.textOffset = 270;
	miscMenuConf.bgColor = "#A2A2A2";
	miscMenuConf.divideEventually = true;
	miscMenuConf.zIndex = -10;

	miscMenuConf.slices.push({ text: "HourTrap", link: "/HT/", title: "Time tracking tool | HTML5 & AngularJS" });
	miscMenuConf.slices.push({ text: "Story", link: "/Story/", title: "Interactive multi-branch stories | HTML5 & AngularJS"});
	miscMenuConf.slices.push({ text: "Travel", link: "/Travel/", title: "Travel countdown" });
	miscMenuConf.slices.push({ text: "Katya's", link: "http://missbehaviour.blankpace.net/", title: "Katya's blog" });
	miscMenuConf.slices.push({ text: "Quiz   ", link: "/NatureQuiz/", title: "NatureQuiz" });

	conf.slices.push({ text: "Misc", link: "#", submenu: miscMenuConf, title: "Toggle submenu for odds & ends" });
	conf.slices.push({ text: "Demos", link: "/Demos/", title: "WebGL demos with my custom DemoScene system" });

	return conf;
};

Blankpace.isEmptyString = function(value)
{
	if (typeof(value) !== "string")
		return true;

	if (value == null)
		return true;

	if (value == "")
		return true;

	return false;
};

$(document).ready(function() {

	if (typeof(HMenu) !== "undefined")
	{
		if (HMenu.isSupported())
		{
			$("div.information-panel").removeClass("hide");
			$("div.container").remove();

			var menuConfig = Blankpace.getMenuSettings();
			HMenu.initialize(menuConfig);
		}
	}

	$("div.information-panel a").on("click", function() {
		$(this).parent().remove();
		return false;
	});
});
