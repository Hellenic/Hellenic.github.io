"use strict";

/**
 * Controller for single story view.
 */
storyControllers.controller("StoryController", 
		["$scope", "$routeParams", "$location", "StoryService", "PageService", "ContentService", "CacheService",
function($scope, $routeParams, $location, storyService, pageService, contentService, cacheService) {
	
	// Contructor called on page load
	$scope.initialize = function()
	{
		var storyId = $routeParams.storyId;
		
		// Get story from cache
		$scope.story = cacheService.getStory(storyId);
		
		// Load story, if it is not yet loaded
		if (typeof($scope.story) == "undefined" || $scope.story == null)
		{
			$scope.doLoadStory(storyId);
		}
		// Otherwise load only new page
		else
		{
			$scope.doLoadPage($routeParams.page);
		}
	};
	
	// Load the story for given URL
	$scope.doLoadStory = function(storyId)
	{
		$scope.story = storyService.get({storyId: storyId}, function(story) {
			story.pages = [];
			story.input = {};
			
			// Generate story page URLs
			for (var i=1; i<=story.pageCount; i++)
			{
				// e.g. epic-story/page-1.json
				story.pages.push(story.id + "/page-"+ i +".json");
			}
			
			$scope.doLoadPage($routeParams.page);
			
			cacheService.setStory(story);
		});
	};
	
	// Load single story page for given number
	$scope.doLoadPage = function(pageNumberParam)
	{
		// Validate the page number input
		var pageNumber = 1;
		if (typeof(pageNumberParam) !== "undefined" && !isNaN(pageNumberParam))
		{
			pageNumber = parseInt(pageNumberParam);
		}
		
		// Load page by the number
		var story = $scope.story;
		story.page = pageService.get({storyId: story.id, page: pageNumber}, function(page) {
			
			// Preset the defaults, just to make the HTML side cleaner
			$scope.setPageDefaults(page);
			
			page.number = pageNumber;
			var contentPromise = contentService.get(story.id +"/"+ page.file);
			contentPromise.then(function(content) {
				// Render the page content through Mustache
				// TODO How to do this with angular as simple as Mustache?
				page.content = Mustache.render(content, story.input);
			});
			
		});
	};
	
	// Redirect to page
	$scope.gotoPage = function(pageNumber)
	{
		if (pageNumber > 0 && pageNumber <= $scope.story.pageCount)
		{
			$location.url("/story/"+ $scope.story.id +"/page/"+ pageNumber);
		}
	};
	
	// Persist the user input to local storage
	$scope.onChange = function(key, value)
	{
		var story = $scope.story;
		story.input[key] = value;
		cacheService.setStory(story);
		
		// Validate the input
		var input = $scope.getInputByName(key);
		$scope.validateAnswer(input, value);
	};
	
	$scope.validateAnswer = function(input, answer)
	{
		if (input != null && typeof(input.answer) !== "undefined" )
		{
			var story = $scope.story;
			if (input.answer == answer)
			{
				if (input.revealActions)
				{
					story.page.actions.visible = true;
				}
				if (input.required)
				{
					story.page.allowPrevious = true;
					story.page.allowNext = true;
				}
			}
			else
			{
				// Answer was not correct, but probably no need to hide anything?
				// If user got it right once, we can just keep them visible
			}
		}
	};
	
	$scope.getInputByName = function(name)
	{
		var story = $scope.story;
		for (var i=0; i<story.page.inputs.inputs.length; i++)
		{
			var input = story.page.inputs.inputs[i];
			if (input.name == name)
				return input;
		}
		
		return null;
	};
	
	// Set defaults to make HTML cleaner
	$scope.setPageDefaults = function(page)
	{
		// Allow previous page 	= true
		if (typeof(page.allowPrevious) === "undefined")
			page.allowPrevious = true;
		// Allow next page 		= true
		if (typeof(page.allowNext) === "undefined")
			page.allowNext = true;
		
		// Check if answer was inputted earlier (user came back to same page)
		var story = $scope.story;
		if (typeof(story.page.inputs) !== "undefined")
		{
			for (var i=0; i<story.page.inputs.inputs.length; i++)
			{
				var input = story.page.inputs.inputs[i];
				var userInput = story.input[input.name];
				$scope.validateAnswer(input, userInput);
			}
		}
		
		// If actions are not defined, then actions component is not visible by default
		if (typeof(page.actions) === "undefined")
		{
			page.actions = {};
			page.actions.visible = false;
		}
		// If actions are defined but visible is not defined, default is visible
		else if (typeof(page.actions) !== "undefined" && typeof(page.actions.visible) === "undefined")
			page.actions.visible = true;
	};
	
	$scope.initialize();
	
}]);