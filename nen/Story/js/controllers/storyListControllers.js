"use strict";

/**
 * Controller for story list page view.
 */
storyControllers.controller("StoryListController", ["$scope", "StoryService",
function($scope, storyService) {
	
	$scope.stories = storyService.query();
	$scope.orderProp = "name";

}]);