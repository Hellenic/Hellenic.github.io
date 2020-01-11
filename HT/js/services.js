"use strict";
// TODO Finish this service and make support for multiple days

/* Services */
var hourtrapServices = angular.module("hourtrapServices", ["ngResource"]);

hourtrapServices.factory("Day", [
   function()
   {
		if (localStorageSupported() && typeof(localStorage.days) !== "undefined")
		{
			daysJson = localStorage.days;
			var days = JSON.parse(localStorage.days);
			if (typeof(days) === "object" && days.length > 0)
			{
				console.log("TODO");
			}
		}
   }
]);