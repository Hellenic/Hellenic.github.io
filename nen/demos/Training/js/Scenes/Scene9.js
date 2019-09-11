var container, stats;

var start_time;

var camera, scene, renderer;
var uniforms, attributes, material, mesh;

var mouseX = 0, mouseY = 0,
lat = 0, lon = 0, phy = 0, theta = 0;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

var clock = new THREE.Clock();

init();
animate();

function init() {

	container = document.getElementById( 'container' );

	camera = new THREE.PerspectiveCamera(100, windowHalfX / windowHalfY, 1, 3000 );
	camera.position.z = 4;

	scene = new THREE.Scene();

	start_time = Date.now();

	uniforms = {
		time: { type: "f", value: 1.0 },
		resolution: { type: "v2", value: new THREE.Vector2() },
		texture: { type: "t", value: THREE.ImageUtils.loadTexture( "textures/disturb.jpg" ) },
	    amplitude: { type: 'f', value: 0 }
	};
	uniforms.texture.value.wrapS = uniforms.texture.value.wrapT = THREE.RepeatWrapping;

	attributes = {
	    displacement: {
	        type: 'f', // a float
	        value: [] // an empty array
	    }
	};

	var size = 1.25;

	material = new THREE.ShaderMaterial( {
		uniforms: uniforms,
		attributes: attributes,
		vertexShader: document.getElementById("vertexshader").textContent,
		fragmentShader: document.getElementById("fragmentshader").textContent
	});

	mesh = new THREE.Mesh(new THREE.SphereGeometry(size, 50, 40), new THREE.MeshFaceMaterial([material, material, material, material, material, material]));
	mesh.position.x = 0;
	mesh.position.y = 0;
	scene.add(mesh);

	var vertices = mesh.geometry.vertices;
	var values = attributes.displacement.value;
	for(var v = 0; v < vertices.length; v++) {
		if (v % 4 == 1)
			values.push(Math.random() * 1.5);
		else
			values.push(2);
	}

	renderer = new THREE.WebGLRenderer({ alpha: true });
	container.appendChild(renderer.domElement);

	onWindowResize();

	window.addEventListener( 'resize', onWindowResize, false );

}

function onWindowResize( event )
{
	uniforms.resolution.value.x = window.innerWidth;
	uniforms.resolution.value.y = window.innerHeight;

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize(window.innerWidth, window.innerHeight);
}

function animate() {
	requestAnimationFrame( animate );
	render();
}

function render()
{
	var delta = clock.getDelta();

	uniforms.time.value = clock.elapsedTime;

    uniforms.amplitude.value = Math.sin(clock.elapsedTime)/2+0.3;

	mesh.rotation.y += delta * 0.5 * ( 2 % 2 ? 1 : -1 );
	mesh.rotation.x += delta * 0.5 * ( 2 % 2 ? -1 : 1 );

	renderer.render(scene, camera);
}
