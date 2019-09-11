"use strict";

var SCREEN_WIDTH = window.innerWidth,
SCREEN_HEIGHT = window.innerHeight,
SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;

var isWebkit = /Webkit/i.test(navigator.userAgent),
isChrome = /Chrome/i.test(navigator.userAgent),
isMobile = !!("ontouchstart" in window),
isAndroid = /Android/i.test(navigator.userAgent),
isIE = document.documentMode;

/* Override the default easing type with something a bit more jazzy. */
$.Velocity.defaults.easing = "easeInOutsine";

$(document).ready(function() {

	/*******************
	Dot Creation
	*******************/

	// Differentiate dot counts based on roughly-guestimated device and browser capabilities
	var dotsCount,
	dotsHtml = "",
	$dots;

	if (window.location.hash) {
		dotsCount = window.location.hash.slice(1);
	} else {
		dotsCount = isMobile ? (isAndroid ? 40 : 60) : (isChrome ? 175 : 125);
	}

	// Bind events
	$(".toggle-more").on("click", function(event) {
		$(".menu-priority").slideToggle(500);
		$(".menu-secondary").slideToggle(500);

		$("html, body").animate({ scrollTop: 0 }, 500);

		return false;
	});

	// Generate the dots
	for (var i = 0; i < dotsCount; i++)
	{
		var classes = ['hexagon', 'hexagon-blue'];
		var randomIndex = Math.floor(Math.random() * classes.length);
		var cssClass = classes[randomIndex];
		dotsHtml += "<div class='"+ cssClass +"'></div>";
	}

	$dots = $(dotsHtml);

	/*************
	Setup
	*************/
	var $container = $("#container");
	var $welcome = $("#welcome");
	var $content = $("#content");

	var translateZMin = -725,
	translateZMax = 600;

	var containerAnimationMap = {
		perspective: [ 215, 50 ],
		opacity: [ 0.90, 0.55 ]
	};

	/* IE10+ produce odd glitching issues when you rotateZ on a parent element subjected to 3D transforms. */
	if (!isIE) {
		containerAnimationMap.rotateZ = [ 5, 0 ];
	}

	/*****************
	Animation
	*****************/

	// Fade out the welcome message
	$welcome.velocity({ opacity: [ 0, 0.65 ] }, { display: "none", delay: 3500, duration: 1000 });

	// Fade in the content
	$content.velocity({ opacity: [ 0.85 ] }, { display: "block", delay: 3500, duration: 1500 });

	// Special visual enhancement for WebKit browsers, which are faster at box-shadow manipulation
	if (isWebkit) {
		$dots.css("boxShadow", "0px 0px 4px 0px #4bc2f1");
	}

	// Position the dots container
	$container.css("perspective-origin", SCREEN_WIDTH/2 + "px " + SCREEN_HEIGHT*0.45 + "px");

	// Animate the dots' container
	$container.velocity(containerAnimationMap, { duration: 1200, delay: 3250, loop: true });

	// Animate the dots
	$dots.velocity({
			translateX: [
				function() { return "+=" + Blankpace.random(-SCREEN_WIDTH/2.5, SCREEN_WIDTH/2.5) },
				function() { return Blankpace.random(0, SCREEN_WIDTH) }
			],
			translateY: [
				function() { return "+=" + Blankpace.random(-SCREEN_HEIGHT/2.75, SCREEN_HEIGHT/2.75) },
				function() { return Blankpace.random(0, SCREEN_HEIGHT) }
			],
			translateZ: [
				function() { return "+=" + Blankpace.random(translateZMin, translateZMax) },
				function() { return Blankpace.random(translateZMin, translateZMax) }
			],
			opacity: [
				function() { return Math.random() },
				function() { return Math.random() + 0.1 }
			]
		}, { duration: 6000, loop: true })
		.velocity("reverse", { easing: "easeOutQuad" })
		.appendTo($container);
});
