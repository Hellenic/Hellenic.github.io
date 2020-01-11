Intro = {
    
    state : 0,
    
    init : function()
    {
        console.log("Intro init");

        Scene.scene = new THREE.Scene();
        Scene.scene.fog = new THREE.FogExp2(0x000000, 0.0012);

        Scene.camera = new THREE.PerspectiveCamera(75, Statics.SCREEN_WIDTH / Statics.SCREEN_HEIGHT, 1, 10000);
        Scene.camera.position.z = 1000;
        Scene.scene.add(Scene.camera);
        
        Scene.scene.add(new THREE.AmbientLight(0x404040));

        var light = new THREE.DirectionalLight(0xffffff);
        light.position.set(0, 0, 1);
        Scene.scene.add(light);
        
        var geometry = new THREE.CubeGeometry(100, 100, 100);
        var material = new THREE.MeshBasicMaterial({ color: 0xffffff });
        for (var i=0; i < 200; i++)
        {
            var mesh = new THREE.Mesh(geometry, material);
            mesh.overdraw = true;
            mesh.position.x = Math.random() * 2000 - 1000;
            mesh.position.y = Math.random() * 2000 + 1000;
            mesh.position.z = Math.random() * 2000;
            mesh.rotation.x = Math.random() * 360 * (Math.PI / 180);
            mesh.rotation.y = Math.random() * 360 * (Math.PI / 180);
            //mesh.matrixAutoUpdate = false;
            mesh.updateMatrix();
            Scene.scene.add(mesh);
        }
        
        Scene.renderer = new THREE.WebGLRenderer({ clearColor: 0x000000, clearAlpha: 1, antialias: true });
        
        Intro.state++;
    },
    
    render : function()
    {
        var timer = Date.now() * 0.0001;
        Scene.camera.lookAt(Scene.scene.position);

        for (var i=0; i < Scene.scene.children.length; i++)
        {
            var mesh = Scene.scene.children[i];
            mesh.rotation.x += 0.01;
            mesh.rotation.y += 0.005;
            mesh.position.y -= 5;
        }
        
        if (Scene.start.getTime()+5000 < (new Date()).getTime() && Intro.state == 1)
            Intro.state = 2;
        else if (Scene.start.getTime()+10000 < (new Date()).getTime() && Intro.state == 2)
            Intro.unload();

        Scene.renderer.render(Scene.scene, Scene.camera);
        
        return Intro.state;
    },
    
    unload : function()
    {
        console.debug("Unload Intro");
        Scene.renderer.clear();
        
        /*
        for (var i=0; i < Scene.scene.objects.length; i++)
        {
            Scene.scene.removeObject(Scene.scene.objects[i]);
        }
        */
        Intro.state = 0;
    }
    
};