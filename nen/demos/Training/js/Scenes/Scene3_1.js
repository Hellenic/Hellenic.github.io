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
    var light, mesh, material, composer;
    
    var change = new Date();
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

        light = new THREE.DirectionalLight(0xffffff);
        light.position.set(0, 0, 1);
        scene.add(light);

        /*
        materials = [
                new THREE.MeshLambertMaterial({ ambient: 0xbbbbbb, map: THREE.ImageUtils.loadTexture('textures/ash_uvgrid01.jpg'), transparent: true, opacity: 0.0 }),
                new THREE.MeshBasicMaterial({ color: 0xffffff, wireframe: true, transparent: true, opacity: 0.3 })
        ];
        
        object = THREE.SceneUtils.createMultiMaterialObject(new THREE.IcosahedronGeometry(4), materials);
        */
       
        var geometry = new THREE.IcosahedronGeometry(4);
        material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

        mesh = new THREE.Mesh(geometry, material);
        //mesh.dynamic = true;
        mesh.position.set(200, 0, 200);
        mesh.scale.x = mesh.scale.y = mesh.scale.z = 75;
        scene.add(mesh);
        
        //renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
        renderer = new THREE.WebGLRenderer( { clearColor: 0x000000, clearAlpha: 1, antialias: false } );
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        //renderer.sortObjects = false;
        //renderer.autoClearColor = false;
        //renderer.setClearColorHex( 0x000000, 1 );
        renderer.autoClear = false;
        
        renderer.gammaInput = true;
        renderer.gammaOutput = true;
        
        applyShaders();
        
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
    
    function applyShaders2()
    {
        var shaderBleach = THREE.ShaderExtras[ "bleachbypass" ];
        var shaderSepia = THREE.ShaderExtras[ "sepia" ];
        var shaderVignette = THREE.ShaderExtras[ "vignette" ];
        var shaderScreen = THREE.ShaderExtras[ "screen" ];

        var effectBleach = new THREE.ShaderPass( shaderBleach );
        var effectSepia = new THREE.ShaderPass( shaderSepia );
        var effectVignette = new THREE.ShaderPass( shaderVignette );
        var effectScreen = new THREE.ShaderPass( shaderScreen );

        effectBleach.uniforms[ "opacity" ].value = 0.95;

        effectSepia.uniforms[ "amount" ].value = 0.9;

        effectVignette.uniforms[ "offset" ].value = 0.95;
        effectVignette.uniforms[ "darkness" ].value = 1.6;

        var effectBloom = new THREE.BloomPass( 0.5 );
        var effectFilm = new THREE.FilmPass( 0.35, 0.025, 648, false );
        var effectFilmBW = new THREE.FilmPass( 0.35, 0.5, 2048, true );
        var effectDotScreen = new THREE.DotScreenPass( new THREE.Vector2( 0, 0 ), 0.5, 0.8 );

        var effectHBlur = new THREE.ShaderPass( THREE.ShaderExtras[ "horizontalBlur" ] );
        var effectVBlur = new THREE.ShaderPass( THREE.ShaderExtras[ "verticalBlur" ] );
        effectHBlur.uniforms[ 'h' ].value = 2 / ( SCREEN_WIDTH/2 );
        effectVBlur.uniforms[ 'v' ].value = 2 / ( SCREEN_HEIGHT/2 );

        var effectColorify1 = new THREE.ShaderPass( THREE.ShaderExtras[ "colorify" ] );
        var effectColorify2 = new THREE.ShaderPass( THREE.ShaderExtras[ "colorify" ] );
        effectColorify1.uniforms[ 'color' ].value.setRGB( 1, 0.8, 0.8 );
        effectColorify2.uniforms[ 'color' ].value.setRGB( 1, 0.75, 0.5 );

        var clearMask = new THREE.ClearMaskPass();
        var renderMask = new THREE.MaskPass( sceneModel, cameraPerspective );
        var renderMaskInverse = new THREE.MaskPass( sceneModel, cameraPerspective );

        renderMaskInverse.inverse = true;

        effectVignette.renderToScreen = true;
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
        if (change.getTime()+3000 < new Date().getTime())
        {
            doStateChange();
            change = new Date();
        }
        
        var timer = Date.now() * 0.0001;

        camera.position.x = Math.cos(timer) * 800;
        camera.position.z = Math.sin(timer) * 800;
        camera.lookAt(scene.position);
        
        mesh.rotation.x += 0.01;
        mesh.rotation.y += 0.005;
        
        renderer.clear();
        composer.render();
        //renderer.render(scene, camera);
    }
    
    function debug()
    {
        var debug = "X: "+ mesh.rotation.x + "<br />Y: " + mesh.rotation.y;
        
        debug += "<br />State: "+ state;
        $("#debug").html(debug);
    }
    
    function doStateChange()
    {
        if (state == 1)
        {
            material.color.setHex(0x00ff00);
        }
        else if (state == 2)
        {
            //materials[0].opacity = 0.5;
            material.color.setHex(0xffffff);
        }
        
        state++;
    }
});