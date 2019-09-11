Scene1 = {
    
    state : 0,
    change : new Date(),
    mesh : null,
    
    init : function()
    {
        console.log("Scene1 init");
        
        //Scene.scene = new THREE.Scene();

        //Scene.camera = new THREE.PerspectiveCamera(75, Statics.SCREEN_WIDTH / Statics.SCREEN_HEIGHT, 1, 10000);
        //Scene.camera.position.z = 450;
        //Scene.scene.add(Scene.camera);
        
        Scene.scene.add(new THREE.AmbientLight(0x404040));

        var light = new THREE.DirectionalLight(0xffffff);
        light.position.set(0, 0, 1);
        Scene.scene.add(light);
        
        var geometry = new THREE.IcosahedronGeometry(4);
        Scene1.material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

        Scene1.mesh = new THREE.Mesh(geometry, Scene1.material);
        //mesh.dynamic = true;
        Scene1.mesh.position.set(200, -800, 1000);
        Scene1.mesh.scale.x = Scene1.mesh.scale.y = Scene1.mesh.scale.z = 100;
        Scene.scene.add(Scene1.mesh);
        
        //Scene.renderer = new THREE.WebGLRenderer();
        
        Scene.renderer.autoClear = false;
        Scene.renderer.gammaInput = true;
        Scene.renderer.gammaOutput = true;
        
        Scene1.applyShaders();
        Scene1.state++;
    },
    
    applyShaders : function()
    {
        var renderModel = new THREE.RenderPass(Scene.scene, Scene.camera);
        var effectBloom = new THREE.BloomPass(1.3);
        var effectScreen = new THREE.ShaderPass(THREE.ShaderExtras["screen"]);
        effectScreen.renderToScreen = true;

        Scene1.composer = new THREE.EffectComposer(Scene.renderer);
        Scene1.composer.addPass(renderModel);
        Scene1.composer.addPass(effectBloom);
        Scene1.composer.addPass(effectScreen);
    },
    
    render : function()
    {
        if (Scene1.change.getTime()+3000 < new Date().getTime())
        {
            Scene1.doStateChange();
            Scene1.change = new Date();
        }
        
        var timer = Date.now() * 0.0001;
        
        //Scene1.mesh.position.x += Math.cos(timer);
        //Scene1.mesh.position.z += Math.sin(timer);
        
        Scene1.mesh.rotation.x += 0.01;
        Scene1.mesh.rotation.y += 0.005;
        
        if (Scene.camera.position.z < 1500)
            Scene.camera.position.z += 1;
        
        Scene.renderer.clear();
        Scene1.composer.render();
        Scene.renderer.render(Scene.scene, Scene.camera);
        
        return Scene1.state;
    },
    
    doStateChange : function()
    {
        Scene1.state++;
        
        if (Scene1.state == 2)
        {
            Scene1.material.color.setHex(0x00ff00);
        }
        else if (Scene1.state == 3)
        {
            //materials[0].opacity = 0.5;
            Scene1.material.color.setHex(0xffffff);
        }
        else
            Scene1.state = 0;
        
    },
    
    unload : function()
    {
        
    }
};