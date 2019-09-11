"use strict";
function Model(name, files)
{
	this.name = (name) ? name : "Default Model";
	this.files = files || [];
	this.mesh = new THREE.Object3D();
	this.interactiveObjects = [];
	this.interaction = null;
	this.loader = new THREE.JSONLoader();
}

// TODO Maybe this loading should be part of DemoLoader also?
Model.prototype.load = function(demoLoaderCallback)
{
	var scope = this;
	var fileCount = this.files.length;
	var currentCount = 0;

	scope.beforeLoad();

	if (fileCount > 0)
	{
		$.each(this.files, function(key, file) {
			scope.loader.load(file, function(model, materials) {
				currentCount++;

				var fileName = DemoUtils.getFilename(file);
				// Optional callback to "onFileLoaded" where File is the name of the file
				// e.g. file: BirdModel.json => callback: onBirdModelLoaded
				var callbackName = "on"+fileName+"Loaded";
				if (scope.hasOwnProperty(callbackName))
				{
					scope[callbackName](model, materials);
				}

				// Notify DemoLoader that model once the final file has been loaded
				if (currentCount == fileCount)
				{
					// Notify onLoad that whole model has been loaded
					scope.onLoad();
					demoLoaderCallback(scope);
				}
			});
		});
	}
	else
	{
		scope.onLoad();
		demoLoaderCallback(scope);
	}
};
Model.prototype.beforeLoad = function() {

};
Model.prototype.onLoad = function() {

};
Model.prototype.animate = function() {

};
Model.prototype.getObject = function() {
	return this.mesh;
};
Model.prototype.getInteraction = function() {
	return this.interaction;
};
Model.prototype.getInteractiveObjects = function() {
	return this.interactiveObjects;
};
Model.prototype.unload = function() {
	this.mesh.remove();
	this.mesh = null;
	this.files = null;
	this.loader = null;
};
