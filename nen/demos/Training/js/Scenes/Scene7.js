
    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;

    var camera, scene, renderer;
    var container;
    var light, composer;
    var state = 0;
    var group = new THREE.Object3D();
    var geometry;

    var changeColor = false;
    
    var stats;
    
    var twist = 0;
    var twistDirection = 1;
    var delta = new Date();
    var timer = 0;
    var second = 0;

$(document).ready(function()
{
    
    init();
    animate();

    function init()
    {
        container = $("<div />");
        $("body").append(container);

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(45, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 2000);
        camera.position.y = 200;
        scene.add(camera);

        scene.add(new THREE.AmbientLight(0x404040));
       
        var materials = [
                new THREE.MeshBasicMaterial({color: 0x770077, transparent: false}),
                new THREE.MeshBasicMaterial({color: 0xFFFFFF, wireframe: true, transparent: false})
        ];
        
        geometry = THREE.SceneUtils.createMultiMaterialObject(new THREE.CubeGeometry(40, 40, 40), materials);       	
        geometry.position.set(200, 0, 200);
	geometry.distance = 0;
	group.add(geometry);

	for (var i=-10; i<=10; i++)
	{
		var obj = THREE.SceneUtils.cloneObject(geometry);
		obj.position.x -= 50 * i;
		obj.distance = i;
		group.add(obj);
	}

	for (var i=-10; i<=10; i++)
	{
                var obj = THREE.SceneUtils.cloneObject(geometry);
                obj.position.z -= 50 * i;
                obj.distance = i;
                group.add(obj);
	}

        for (var i=-10; i<=10; i++)
        {
                var obj = THREE.SceneUtils.cloneObject(geometry);
                obj.position.y -= 50 * i;
                obj.distance = i;
		obj.horizontal = true;
                group.add(obj);
        }

	
	scene.add(group);

        renderer = new THREE.CanvasRenderer( {clearColor: 0x000000, clearAlpha: 1, antialias: true} );
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        //renderer.autoClear = false;
        renderer.gammaInput = true;
        renderer.gammaOutput = true;
        
        //applyShaders();
        
        container.append(renderer.domElement);
        
        stats = new Stats();
        $("#stats").html(stats.domElement);
    }
    
    function applyShaders()
    {
        var renderModel = new THREE.RenderPass( scene, camera );
        var effectBloom = new THREE.BloomPass( 2.3 );
        var effectScreen = new THREE.ShaderPass( THREE.ShaderExtras[ "screen" ] );
        var effectFXAA = new THREE.ShaderPass( THREE.ShaderExtras[ "fxaa" ] );

        effectFXAA.uniforms[ 'resolution' ].value.set( 1 / SCREEN_WIDTH, 1 / SCREEN_HEIGHT );

        effectScreen.renderToScreen = true;

        composer = new THREE.EffectComposer( renderer );

        composer.addPass( renderModel );
        composer.addPass( effectFXAA );
        composer.addPass( effectBloom );
        composer.addPass( effectScreen );
    }
    
    function animate()
    {
        requestAnimationFrame(animate);

        render();
        stats.update();
        
        debug();
    }

    function render()
    {
	var time = Date.now() * 0.00005;
        var deltaMs = new Date() - delta;
	var frameDelta = deltaMs / 1000;
	delta = new Date();
	timer += deltaMs;
        second += deltaMs;

        camera.position.x = Math.cos(time) * 800;
        camera.position.z = Math.sin(time) * 800;
        camera.lookAt(scene.position);
        
	$.each(group.children, function(key, value) {
		
		var multiplier = (value.distance < 0) ? -(value.distance*value.distance) : value.distance*value.distance;
		var val = 0.05 * multiplier;
		if (value.distance == 10)
			twist += (twistDirection == 1) ? val : -val;
		
		if (state > 20)
		{
			value.rotation.x += 1 * frameDelta;
        		value.rotation.y += 5 * frameDelta;
		}

		if (twistDirection == 1)
		{
			if (value.horizontal)
				value.position.x += val;
			else
				value.position.y += val;
		}
		else
		{
                        if (value.horizontal)
                                value.position.x -= val;
                        else
                                value.position.y -= val;
		}

		if (twist > 600)
			twistDirection = 0;
		else if (twist < -600)
			twistDirection = 1;
		
		if (second >= 1000)
		{
			second = 0;
			//renderer.autoClear = !renderer.autoClear;
			state++;
		}

		if (timer > 5000)
		{
			changeColor = true;
			var m = geometry.children[0].material;
			if (m.targetColor != null)
			{
				m.color = m.targetColor;
			}
			m.targetColor = new THREE.Color();
			m.targetColor.r = Math.random();
                        m.targetColor.g = Math.random();
                        m.targetColor.b = Math.random();
			timer = 0;
		}
		
		if (changeColor)
		{
			var m = geometry.children[0].material;
			m.color.r += ((m.targetColor.r < m.color.r) ? m.targetColor.r : -m.targetColor.r) * 0.0001;
			m.color.g += ((m.targetColor.g < m.color.g) ? m.targetColor.g : -m.targetColor.g) * 0.0001;
			m.color.b += ((m.targetColor.b < m.color.b) ? m.targetColor.b : -m.targetColor.b) * 0.0001;
		}
	});

        group.rotation.x += 0.01;
        group.rotation.y += 0.005;
        
        //renderer.clear();
        //composer.render();
        renderer.render(scene, camera);
    }
    
    function debug()
    {
        var debug = "X: "+ geometry.rotation.x + "<br />Y: " + geometry.rotation.y;
        
        debug += "<br />State: "+ state;
        $("#debug").html(debug);
    }
});
