"use strict";
var Intro = new Scene("Intro #1");
DemoScene.registerInitialScene(Intro);

Intro.init = function()
{
	this.clock = new THREE.Clock();
	this.state = 1;
	
	this.camera = new THREE.PerspectiveCamera(75, Statics.SCREEN_WIDTH / Statics.SCREEN_HEIGHT, 1, 10000);
	this.camera.position.z = 500;
	this.scene = new THREE.Scene();
	
	this.scene.add(new THREE.AmbientLight(0x404040));
	
    var geometry = new THREE.CircleGeometry(7);
    var material = new THREE.MeshBasicMaterial({ color: "rgb(222,222,222)" });
    this.dotMesh = new THREE.Mesh(geometry, material);
    this.dotMesh.position.y = 50;
    this.dotMesh.position.x = -50;
    
    this.colorvariation = false;
    this.endCooldown = 8;
    this.endingStarted = false;
    this.circleCooldown = 5;
    this.circles = [{
    		cooldown: 2,
    		dots: [ this.dotMesh ]
    }];
    
	this.scene.add(this.dotMesh);
	
	this.renderer = new THREE.WebGLRenderer({ clearColor: 0x000000, clearAlpha: 1, antialias: true, alpha: true });
	this.renderer.setSize(Statics.SCREEN_WIDTH, Statics.SCREEN_HEIGHT);
};

Intro.render = function()
{
	var delta = this.clock.getDelta();
	this.circleCooldown -= delta;
	
	if (this.colorvariation)
	{
		this.endCooldown -= delta;
	}
	
	for (var i=0; i < this.circles.length; i++)
	{
		var circleObj = this.circles[i];
		circleObj.cooldown -= delta;
		
		for (var c=0; c < circleObj.dots.length; c++)
		{
			var circle = circleObj.dots[c];
			var offset = (10*c);
			if (i == 0 || i % 2 == 0)
			{
				circle.position.y = 100 * Math.sin(this.clock.elapsedTime-offset) * -(i+1)/1.5;
				circle.position.x = 100 * Math.cos(this.clock.elapsedTime-offset) * (i+1)/1.5;
			}
			else
			{
				circle.position.y = 100 * Math.sin(this.clock.elapsedTime-offset) * -(i+1)/1.5;
				circle.position.x = 100 * Math.cos(this.clock.elapsedTime-offset) * -(i+1)/1.5;
			}
			
			if (circleObj.cooldown <= 0 && circleObj.dots.length < (22*(i+1)) && !this.endingStarted)
			{
				var newCircle = circle.clone();
				newCircle.material = new THREE.MeshBasicMaterial({ color: "rgb(222,222,222)" });
				circleObj.dots.push(newCircle);
				this.scene.add(newCircle);
				
				circleObj.cooldown = 3/circleObj.dots.length;
			}
			
			if (i == 4 && circleObj.dots.length > 20 && this.colorvariation == false)
			{
				this.colorvariation = true;
			}
			
			if (this.colorvariation == true)
			{
				circle.material.color.r = Math.sin(this.clock.elapsedTime + c);
				circle.material.color.g = Math.sin(this.clock.elapsedTime + c * i);
				circle.material.color.b = Math.sin(this.clock.elapsedTime + i);
			}
			
			if (this.endingStarted && i == this.circles.length-1)
			{
				circle.position.z += delta * 250;
				
				if (circle.position.z > 500)
				{
					this.scene.remove(circle);
					circleObj.dots.shift();
				}
				
				if (circleObj.dots.length == 0)
				{
					this.circles.pop();
					
					if (this.circles.length == 0)
					{
						this.state = 0;
					}
				}
			}
		}
	}
	
	if (this.circleCooldown <= 0 && this.circles.length < 5 && !this.endingStarted)
	{
		var newCircle = this.dotMesh.clone();
		var newCircleObj = { cooldown: 2, dots: [] };
		newCircleObj.dots.push(newCircle);
		this.circles.push(newCircleObj);
		
		this.circleCooldown = 3/this.circles.length;
	}
	else if (this.circles.length == 5)
	{
		this.circlesCreated = true;
	}
	
	if (this.endCooldown < 0 && this.endingStarted == false)
	{
		this.endingStarted = true;
	}
	
	this.renderer.render(this.scene, this.camera);
	
	return this.state;
};

Intro.unload = function()
{
	this.dotMesh = null;
	this.clock = null;
    this.colorvariation = null;
    this.endCooldown = null;
    this.endingStarted = null;
    this.circleCooldown = null;
    this.circles = null;
    this.state = 0;
	
	this.reset();
};