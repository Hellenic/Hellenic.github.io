"use strict";

/**
 * Service for loading stories.
 */
storyServices.factory("StoryService", function($resource) {
	
	var actions = {
		query: {method: "GET", params: {storyId: "stories"}, isArray:true}
	};
	
	return $resource("stories/:storyId.json", {}, actions);
});

storyServices.factory("PageService", function($resource) {
	return $resource("stories/:storyId/page-:page.json");
});

storyServices.factory("ContentService", function($http, $q) {
	return {
		get : function(page) {
			var deferred = $q.defer();

			$http.get("stories/"+ page).then(function(response) {
				deferred.resolve(response.data);
			});

			return deferred.promise;
		}
	};
});

storyServices.factory("CacheService", function() {
	
	// Reset the cache content if it's corrupted
	try {
		JSON.parse(localStorage.stories);
	} catch (exception) {
		localStorage.stories = JSON.stringify([]);
	}
	
	return {
		getStory : function(storyId) {
			var stories = JSON.parse(localStorage.stories);
			if (typeof(stories) === "undefined")
				return null;
			
			for (var i=0; i<stories.length; i++)
			{
				var cachedStory = stories[i];
				if (cachedStory.id == storyId)
				{
					return cachedStory;
				}
			}
			
			return null;
		},
		setStory : function(story) {
			
			// Initialize the array if nothing is saved yet
			var stories = JSON.parse(localStorage.stories);
			if (typeof(stories) === "undefined")
			{
				stories = [];				
			}
			
			// Remove old cached version
			for (var i=0; i<stories.length; i++)
			{
				var cachedStory = stories[i];
				if (cachedStory.id == story.id)
				{
					stories.splice(i, 1);
				}
			}
			
			// Add new story
			stories.push(story);
			
			// Save to local storage
			localStorage.stories = JSON.stringify(stories);
		}
	};
});