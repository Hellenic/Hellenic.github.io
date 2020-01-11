		var renderer, scene, camera, stats;

		var sphere, uniforms, attributes;

		var noise = [];

		var WIDTH = window.innerWidth,
			HEIGHT = window.innerHeight;

		init();
		animate();

		function init() {

			container = $("<div />");
        		$("body").append(container);

			camera = new THREE.PerspectiveCamera( 30, WIDTH / HEIGHT, 1, 10000 );
			camera.position.z = 300;

			scene = new THREE.Scene();

			scene.add( camera );

			attributes = {

				displacement: {	type: 'f', value: [] }

			};

			uniforms = {

				amplitude: { type: "f", value: 1.0 },
				color:     { type: "c", value: new THREE.Color( 0xff2200 ) },
				texture:   { type: "t", value: 0, texture: THREE.ImageUtils.loadTexture( "textures/water.jpg" ) },

			};

			uniforms.texture.texture.wrapS = uniforms.texture.texture.wrapT = THREE.RepeatWrapping;

			var shaderMaterial = new THREE.ShaderMaterial( {

				uniforms: 	uniforms,
				attributes:     attributes,
				vertexShader:   $("#vertexshader").text(),
				fragmentShader: $("#fragmentshader").text()

			});


			var radius = 50, segments = 128, rings = 64;
			var geometry = new THREE.SphereGeometry( radius, segments, rings );
			geometry.dynamic = true;

			sphere = new THREE.Mesh( geometry, shaderMaterial );

			var vertices = sphere.geometry.vertices;
			var values = attributes.displacement.value;

			for( var v = 0; v < vertices.length; v++ ) {

				values[ v ] = 0;
				noise[ v ] = Math.random() * 5;

			}

			scene.add( sphere );

			renderer = new THREE.CanvasRenderer( { clearColor: 0x050505, clearAlpha: 1 } );
			renderer.setSize( WIDTH, HEIGHT );

			container.append(renderer.domElement);

        		stats = new Stats();
        		$("#stats").html(stats.domElement);
		}

		function animate() {

			requestAnimationFrame( animate );

			render();
			stats.update();

		}

		function render() {

			var time = Date.now() * 0.01;

			sphere.rotation.y = sphere.rotation.z = 0.01 * time;

			uniforms.amplitude.value = 2.5 * Math.sin( sphere.rotation.y * 0.125 );
			THREE.ColorUtils.adjustHSV( uniforms.color.value, 0.0005, 0, 0 );

			for( var i = 0; i < attributes.displacement.value.length; i ++ ) {

				attributes.displacement.value[ i ] = Math.sin( 0.1 * i + time );

				noise[ i ] += 0.5 * ( 0.5 - Math.random() );
				noise[ i ] = THREE.Math.clamp( noise[ i ], -5, 5 );

				attributes.displacement.value[ i ] += noise[ i ];

			}

			attributes.displacement.needsUpdate = true;

			renderer.render( scene, camera );

		}
