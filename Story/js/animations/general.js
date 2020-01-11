"use strict";

$(document).ready(function() {
	
	// Light switch (icon & background)
	$(".light-switch").on("mouseleave", function() {
		$(this).toggleClass("light-on");
		$(this).toggleClass("light-off");
		
		$("body").toggleClass("light");
		$("body").toggleClass("dark");
	});
	
});