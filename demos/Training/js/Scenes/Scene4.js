$(document).ready(function()
{
    if (!Detector.webgl)
        Detector.addGetWebGLMessage();
    
    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;

    var camera, scene, renderer;
    var container;
    var light, composer;
    var state = 0;
    
    var stats;
    
    var delta = 0.01;
    
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
                //new THREE.MeshLambertMaterial({ color: 0xAA0000, ambient: 0x550000, transparent: true, opacity: 1.0 }),
                new THREE.MeshBasicMaterial({color: 0x770000, transparent: false}),
                new THREE.MeshBasicMaterial({color: 0xFFFFFF, wireframe: true, transparent: false})
        ];
        
        geometry = THREE.SceneUtils.createMultiMaterialObject(new THREE.IcosahedronGeometry(4), materials);
        
        geometry.position.set(200, 0, 200);
        geometry.scale.x = geometry.scale.y = geometry.scale.z = 75;
        
        var extrudeSettings = {amount: 10, bevelEnabled: true, bevelSegments: 3, steps: 4, bevelThickness: 8, material: 0, extrudeMaterial: 1};
        //geometry = geometry.extrude(extrudeSettings);
        //mesh = new THREE.Mesh(geometry, materials);
        scene.add(geometry);
        
        renderer = new THREE.WebGLRenderer( {clearColor: 0x000000, clearAlpha: 1, antialias: true} );
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        renderer.autoClear = false;
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
        var effectBloom = new THREE.BloomPass( 1.3 );
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
        var timer = Date.now() * 0.0001;
        
        camera.position.x = Math.cos(timer) * 800;
        camera.position.z = Math.sin(timer) * 800;
        camera.lookAt(scene.position);
        
        geometry.rotation.x += 0.01;
        geometry.rotation.y += 0.005;
        
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