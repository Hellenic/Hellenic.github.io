"use strict";
var Ki = new Scene("Ki");
DemoScene.registerScene(Ki);

Ki.init = function()
{
	this.state = 1;
	this.clock = new THREE.Clock();

	this.camera = new THREE.PerspectiveCamera(40, Statics.SCREEN_WIDTH / Statics.SCREEN_HEIGHT, 1, 1000);
	this.camera.position.z = 500;

	this.scene = new THREE.Scene();

	this.attributes = {
		size: {	type: 'f', value: [] },
		ca:   {	type: 'c', value: [] },
	    displacement: {
	        type: 'f', // a float
	        value: [] // an empty array
	    }
	};

	this.uniforms = {
		time: { type: "f", value: 1.0 },
		resolution: { type: "v2", value: new THREE.Vector2() },
		amplitude: { type: "f", value: 1.0 },
		color:     { type: "c", value: new THREE.Color(0xffffff) },
		texture:   { type: "t", value: THREE.ImageUtils.loadTexture("img/spark.png") },
	};
	this.uniforms.texture.value.wrapS = this.uniforms.texture.value.wrapT = THREE.RepeatWrapping;

	this.shaderMaterial = new THREE.ShaderMaterial({
		uniforms: 		this.uniforms,
		attributes:     this.attributes,
		vertexShader:   Shaders.vertexShader,
		fragmentShader: Shaders.fragmentShader,

		blending: 		THREE.AdditiveBlending,
		depthTest: 		false,
		transparent:	true
	});

	var radius = 100, inner = 0.8 * radius;
	var geometry = new THREE.SphereGeometry(inner, 80, 60, 0, Math.PI * 2, 0, Math.PI * 2);
	var sphereSmaller = new THREE.SphereGeometry(inner*0.7, 60, 50);

	this.geometryVLength = geometry.vertices.length;
	this.smallSphereVLength = sphereSmaller.vertices.length;

	// Displacement for sphere
	var values = this.attributes.displacement.value;
	for(var v = 0; v < geometry.vertices.length; v++) {
		if (v % 2 == 1)
			values.push(Math.random() * 1.5);
		//else
		//	values.push(2);
	}

	var m, dummyMaterial = new THREE.MeshFaceMaterial();

	radius = 120;
	var geometry2 = new THREE.CubeGeometry(radius, 0.1 * radius, 0.1 * radius, 50, 5, 5);

	function addGeo(geo, x, y, z, ry)
	{
		m = new THREE.Mesh(geo, dummyMaterial);
		m.position.set(x, y, z);
		m.rotation.y = ry;

		THREE.GeometryUtils.merge(geometry, m);
	}

	addGeo(geometry, 0, 0, 0, 0);
	addGeo(sphereSmaller, 0, 0, 0, 0);

	// side 1
	addGeo(geometry2, 0,  100,  100, 0);
	addGeo(geometry2, 0,  100, -100, 0);
	addGeo(geometry2, 0, -100,  100, 0);
	addGeo(geometry2, 0, -100, -100, 0);

	// side 2
	addGeo(geometry2,  100,  100, 0, Math.PI/2);
	addGeo(geometry2,  100, -100, 0, Math.PI/2);
	addGeo(geometry2, -100,  100, 0, Math.PI/2);
	addGeo(geometry2, -100, -100, 0, Math.PI/2);

	// corner edges
	var geometry3 = new THREE.CubeGeometry(0.1 * radius, radius * 1.2, 0.1 * radius, 5, 60, 5);

	addGeo(geometry3,  100, 0,  100, 0);
	addGeo(geometry3,  100, 0, -100, 0);
	addGeo(geometry3, -100, 0,  100, 0);
	addGeo(geometry3, -100, 0, -100, 0);

	// particle system
	this.object = new THREE.ParticleSystem(geometry, this.shaderMaterial);
	this.object.dynamic = true;

	// custom attributes
	var vertices = this.object.geometry.vertices;

	var values_size = this.attributes.size.value;
	var values_color = this.attributes.ca.value;

	// Coloring the vertices
	for (var v=0; v < vertices.length; v++)
	{
		values_size[v] = 10;
		values_color[v] = new THREE.Color(0xffffff);

		// Coloring the sphere
		if (v < this.geometryVLength)
		{
			values_color[v].setHSL(0.5 + 0.2 * (v / this.geometryVLength), 1, 0.6);
		}
		// Color the smaller sphere inside
		else if (v > this.geometryVLength && v < (this.geometryVLength+this.smallSphereVLength))
		{
			values_color[v].setHSL(0.25, 1.0, 0.6);
		}
		// Coloring cube itself
		else {
			values_size[v] = 55;
			values_color[v].setHSL(0.75, 1.0, 0.6);
		}
	}

	this.scene.add(this.object);

	this.renderer = new THREE.WebGLRenderer({ alpha: true });
	this.renderer.setSize(Statics.SCREEN_WIDTH, Statics.SCREEN_HEIGHT);
//	this.renderer.autoClear = false;
//	this.renderer.gammaInput = true;
//	this.renderer.gammaOutput = true;

	// Apply Post processing
//	this.composer = new THREE.EffectComposer(this.renderer);
//	this.composer.addPass(new THREE.RenderPass(this.scene, this.camera));

	// RGB Shift shader pass
//	var effectRgbShift = new THREE.ShaderPass(THREE.RGBShiftShader);
//	effectRgbShift.uniforms["amount"].value = 0.0015;
//	effectRgbShift.renderToScreen = true;
//	this.composer.addPass(effectRgbShift);
};

Ki.render = function()
{
	// Calling getDelta is mandatory to get clock.elapsedTime ;d
	var delta = this.clock.getDelta();
	var time = Date.now() * 0.01;
	this.object.rotation.y = this.object.rotation.z = 0.01 * time;

	for (var i=0; i < this.attributes.size.value.length; i++)
	{
		// Modify size attribute of the internal cube
		if (i < this.geometryVLength)
		{
			this.attributes.size.value[i] = Math.max(0, 40 + 80 * Math.sin(0.1 * i + 0.3 * time));
		}
		// Else do something for other vertices (cube itself)
//		else
//		{
//			this.attributes.size.value[i] = Math.max(0, 10 + 32 * Math.sin(0.1 * i + 0.6 * time));
//		}
	}

	this.uniforms.time.value = this.clock.elapsedTime;
	this.uniforms.amplitude.value = Math.sin(this.clock.elapsedTime)/2+0.5;

	this.attributes.size.needsUpdate = true;

//	this.renderer.clear();
//	this.composer.render();
	this.renderer.render(this.scene, this.camera);

	return this.state;
};

Ki.unload = function()
{
	console.log("Ki unload");
};
