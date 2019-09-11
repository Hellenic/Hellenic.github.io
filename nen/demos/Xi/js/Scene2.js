Scene2 = {
    
    state : 0,
    composer : null,
    material : null,
    change : new Date(),
    mesh : null,
    
    init : function()
    {
        console.log("Scene2 init");
        
        Scene.scene = new THREE.Scene();

        Scene.camera = new THREE.PerspectiveCamera(45, Statics.SCREEN_WIDTH / Statics.SCREEN_HEIGHT, 1, 2000);
        Scene.camera.position.y = 200;
        Scene.scene.add(Scene.camera);

        Scene.scene.add(new THREE.AmbientLight(0x404040));

        var light = new THREE.DirectionalLight(0xffffff);
        light.position.set(0, 0, 1);
        Scene.scene.add(light);

        /*
        materials = [
                new THREE.MeshLambertMaterial({ ambient: 0xbbbbbb, map: THREE.ImageUtils.loadTexture('textures/ash_uvgrid01.jpg'), transparent: true, opacity: 0.0 }),
                new THREE.MeshBasicMaterial({ color: 0xffffff, wireframe: true, transparent: true, opacity: 0.3 })
        ];
        
        object = THREE.SceneUtils.createMultiMaterialObject(new THREE.IcosahedronGeometry(4), materials);
        */
       
        var geometry = new THREE.IcosahedronGeometry(4);
        Scene2.material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

        Scene2.mesh = new THREE.Mesh(geometry, Scene2.material);
        //mesh.dynamic = true;
        Scene2.mesh.position.set(200, 0, 200);
        Scene2.mesh.scale.x = Scene2.mesh.scale.y = Scene2.mesh.scale.z = 75;
        Scene.scene.add(Scene2.mesh);
        
        //renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
        Scene.renderer = new THREE.WebGLRenderer({ clearColor: 0x000000, clearAlpha: 1, antialias: false });
        //renderer.sortObjects = false;
        //renderer.autoClearColor = false;
        //renderer.setClearColorHex( 0x000000, 1 );
        Scene.renderer.autoClear = false;
        
        Scene.renderer.gammaInput = true;
        Scene.renderer.gammaOutput = true;
        
        Scene2.applyShaders();
        
        Scene2.state++;
    },
    
    applyShaders : function()
    {
        var renderModel = new THREE.RenderPass(Scene.scene, Scene.camera);
        var effectBloom = new THREE.BloomPass(1.3);
        var effectScreen = new THREE.ShaderPass(THREE.ShaderExtras["screen"]);
        var effectFXAA = new THREE.ShaderPass(THREE.ShaderExtras["fxaa"]);

        effectFXAA.uniforms["resolution"].value.set(1 / Statics.SCREEN_WIDTH, 1 / Statics.SCREEN_HEIGHT);

        effectScreen.renderToScreen = true;

        Scene2.composer = new THREE.EffectComposer(Scene.renderer);

        Scene2.composer.addPass(renderModel);
        Scene2.composer.addPass(effectFXAA);
        Scene2.composer.addPass(effectBloom);
        Scene2.composer.addPass(effectScreen);
    },
    
    render : function()
    {
        if (Scene2.change.getTime()+3000 < new Date().getTime())
        {
            Scene2.doStateChange();
            Scene2.change = new Date();
        }
        
        var timer = Date.now() * 0.0001;

        Scene.camera.position.x = Math.cos(timer) * 800;
        Scene.camera.position.z = Math.sin(timer) * 800;
        Scene.camera.lookAt(Scene.scene.position);
        
        Scene2.mesh.rotation.x += 0.01;
        Scene2.mesh.rotation.y += 0.005;
        
        Scene.renderer.clear();
        Scene2.composer.render();
        //renderer.render(scene, camera);
        
        return Scene2.state;
    },
    
    doStateChange : function()
    {
        Scene2.state++;
        
        if (Scene2.state == 2)
        {
            Scene2.material.color.setHex(0x00ff00);
        }
        else if (Scene2.state == 3)
        {
            //materials[0].opacity = 0.5;
            Scene2.material.color.setHex(0xffffff);
        }
        else
            Scene2.state = 0;
        
    }
};