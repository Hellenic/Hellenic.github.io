"use strict";

/* App Module */
var hourtrapApp = angular.module("hourtrapApp", [
	"ngRoute",
	"hourtrapControllers",
	"hourtrapServices"
]);

hourtrapApp.config(["$routeProvider", function($routeProvider) {
	$routeProvider.when("/today", {
		templateUrl : "partials/task.html",
		controller : "DayController"
	}).when("/task/:date", {
		templateUrl : "partials/task.html",
		controller : "DayController"
	}).otherwise({
		redirectTo : "/today"
	});
} ]);

function localStorageSupported() {
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch (e) {
		return false;
	}
}