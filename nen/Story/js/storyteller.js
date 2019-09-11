"use strict";

/* App Module */
var storyteller = angular.module("story", [
	"ngRoute",
	"controllers",
	"services",
	"animations",
	"ngSanitize"
]);

var storyControllers = angular.module("controllers", []);
var storyServices = angular.module("services", ["ngResource"]);
var storyAnimations = angular.module("animations", ["ngAnimate"]);

storyteller.config(["$routeProvider", function($routeProvider) {
	$routeProvider
	.when("/stories", {
		templateUrl : "partials/stories.html",
		controller : "StoryListController"
	})
	.when("/story/:storyId", {
		redirectTo : "/story/:storyId/page/1"
	})
	.when("/story/:storyId/page/:page", {
		templateUrl : "partials/story.html",
		controller : "StoryController"
	})
	.otherwise({
		redirectTo : "/stories"
	});
} ]);

function isLocalStorageSupported() {
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch (e) {
		return false;
	}
}
