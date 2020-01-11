"use strict";
var hourtrapControllers = angular.module('hourtrapControllers', []);

/**
 * Controller for single day. 
 * One day has date and multiple tasks.
 */
hourtrapControllers.controller('DayController', ['$scope', '$interval', '$filter',
function($scope, $interval, $filter) {
	$scope.date = new Date();
	
	var defaultTask = null;
	// Restore tasks from local storage
	if (localStorageSupported() && typeof(localStorage.tasks) !== "undefined")
	{
		// Restore JSON tasks to actual tasks
		var tasks = JSON.parse(localStorage.tasks);
		if (typeof(tasks) === "object" && tasks.length > 0)
		{
			$scope.tasks = [];
			angular.forEach(tasks, function(taskJson, key) {
				var task = new Task(taskJson.customer, taskJson.type, taskJson.description, taskJson.start, taskJson.duration);
				$scope.tasks.push(task);
				if (taskJson.active)
				{
					defaultTask = task;
				}
			});
		}
	}
	
	if (defaultTask == null)
	{
		defaultTask = new Task();
		$scope.tasks = [ defaultTask ];
	}
	
	$scope.activateTask = function(task)
	{
		// Deactivate all tasks
		angular.forEach(this.tasks, function(task, key) {
			task.deactivate();
			$interval.cancel(task.promise);
		});
		
		task.activate();
		task.promise = $interval(function(count) { task.work(count); }, 1000);
	};
	$scope.activateTask(defaultTask);
	
	$scope.addTask = function()
	{
		var newTask = new Task();
		this.tasks.push(newTask);
		
		this.activateTask(newTask);
	};

	$scope.removeTask = function(task)
	{
		if (this.tasks.indexOf(task) < 0)
			return;
		
		var index = this.tasks.indexOf(task);
		this.tasks.splice(index, 1);
		
		if (task.active)
		{
			// Deactivate task
			task.deactivate();
			$interval.cancel(task.promise);
			
			// Activate something
			if (this.tasks.length > 0)
			{
				var latestTask = this.tasks[this.tasks.length-1];
				this.activateTask(latestTask);
			}
		}
	};
	
	$scope.getDuration = function(duration)
	{
		// Resetting duration to timezone zero
		var date = new Date(duration);
		return new Date(0, 0, 0,  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
	};
	
	$scope.getTotalDuration = function() {
		var totalDuration = 0;
		angular.forEach(this.tasks, function(task, key) {
			totalDuration += task.duration;
		});
		
		return this.getDuration(totalDuration);
	};
	
	$scope.getDurationAsString = function(duration)
	{
		return $filter('date')(this.getDuration(duration), 'HH:mm:ss');
	};

	$scope.clearTask = function(task)
	{
		task.clear();
	};
	
	$scope.toggleModal = function() {
		jQuery("#taskData textarea").text(JSON.stringify($scope.tasks));
		jQuery("#taskData").dialog({
			width : 800,
			height : 500,
			buttons : {
				"As JSON" : function()
				{
					jQuery("#taskData textarea").text(JSON.stringify($scope.tasks));
				},
				"As CSV" : function()
				{
					var csvHeader = "Start time;Customer;Type;Description;Duration\n";
					var csv = "";
					angular.forEach($scope.tasks, function(task, key) {
						csv += task.start +";"+ task.customer +";"+ task.type 
							+";"+ task.description +";"+ $scope.getDurationAsString(task.duration) +"\n";
					});
					jQuery("#taskData textarea").text(csvHeader + csv);
				},
				Cancel : function() {
					$(this).dialog("close");
				}
			}
		});
	};
	
	jQuery(window).on("unload", function() {
		if (localStorageSupported())
		{
			localStorage.tasks = JSON.stringify($scope.tasks);
		}
	});
}]);

