var camX = 2900, camY = 300, direction = 1;

$(document).ready(function()
{
    var camera, scene, renderer;

    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;
    
    var container;
    var geometry, group;
    
    var stats;
    
    init();
    animate();

    function init()
    {
        container = $("<div />");
        $("body").append(container);

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(60, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 10000);
        camera.position.z = 500;
        camera.target = new THREE.Vector3();
        scene.add(camera);

        var geometry = new THREE.CubeGeometry(100, 100, 100);
        var material = new THREE.MeshNormalMaterial();

        group = new THREE.Object3D();

        for (var i = 0; i < 200; i++)
        {
            var mesh = new THREE.Mesh(geometry, material);
            mesh.overdraw = true;
            mesh.position.x = Math.random() * 2000 - 1000;
            mesh.position.y = Math.random() * 2000 - 1000;
            mesh.position.z = Math.random() * 2000 - 1000;
            mesh.rotation.x = Math.random() * 360 * (Math.PI / 180);
            mesh.rotation.y = Math.random() * 360 * (Math.PI / 180);
            mesh.matrixAutoUpdate = false;
            mesh.updateMatrix();
            group.add(mesh);
        }

        scene.add(group);

        renderer = new THREE.CanvasRenderer();
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        renderer.sortObjects = false;
        container.append(renderer.domElement);
        
        stats = new Stats();
        $("#stats").html(stats.domElement);
    }

    function animate()
    {
        requestAnimationFrame(animate);
        render();
        
        stats.update();
    }

    function render()
    {
        if (direction == 1)
        {
            if (camX < 5000)
                camX += 10;
            else
                direction = 2;
        }
        else
        {
            if (camX > -5000)
                camX -= 10;
            else
                direction = 1;
        }
        
        camera.position.x += ( camX - camera.position.x ) * .05;
        camera.position.y += ( -camY - camera.position.y ) * .05;
        camera.lookAt( scene.position );
        
        group.rotation.x = Math.sin( new Date().getTime() * 0.0007 ) * 0.5;
        group.rotation.y = Math.sin( new Date().getTime() * 0.0003 ) * 0.5;
        group.rotation.z = Math.sin( new Date().getTime() * 0.0002 ) * 0.5;

        renderer.render(scene, camera);
        
        $("#debug").html("CamX: "+ camX + " -- CamY: " + camY);
    }
});