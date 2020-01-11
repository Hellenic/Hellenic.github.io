$(document).ready(function()
{
    var camera, scene, renderer, geometry, material, mesh, birds, bird;

    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;

    var boid, boids;
    
    var stats;
    
    init();
    animate();

    function init()
    {
        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(75, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 10000);
        camera.position.z = 450;
        scene.add(camera);

        geometry = new THREE.CubeGeometry(200, 200, 200);
        material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

        mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);
        
        birds = [];
        boids = [];

        for (var i = 0; i < 200; i++)
        {
            boid = boids[ i ] = new Boid();
            boid.position.x = Math.random() * 400 - 200;
            boid.position.y = Math.random() * 400 - 200;
            boid.position.z = Math.random() * 400 - 200;
            boid.velocity.x = Math.random() * 2 - 1;
            boid.velocity.y = Math.random() * 2 - 1;
            boid.velocity.z = Math.random() * 2 - 1;
            boid.setAvoidWalls( true );
            boid.setWorldSize( 500, 500, 400 );

            bird = birds[i] = new THREE.Mesh(new Bird(), new THREE.MeshBasicMaterial({ color:Math.random() * 0xffffff }));
            bird.phase = Math.floor(Math.random() * 62.83);
            bird.position = boids[i].position;
            bird.doubleSided = true;
            // bird.scale.x = bird.scale.y = bird.scale.z = 10;
            scene.add(bird);
        }

        renderer = new THREE.CanvasRenderer();
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        
        document.addEventListener('mousemove', onDocumentMouseMove, false);
        document.body.appendChild(renderer.domElement);
        
        stats = new Stats();
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        
        document.getElementById("stats").appendChild(stats.domElement);
    }

    function animate()
    {
        requestAnimationFrame(animate);
        render();
        
        stats.update();
    }

    function render()
    {
        mesh.rotation.x += 0.01;
        mesh.rotation.y += 0.02;
        
        for (var i = 0, il = birds.length; i < il; i++)
        {
            boid = boids[i];
            boid.run(boids);

            bird = birds[i];

            color = bird.material.color;
            color.r = color.g = color.b = (500 - bird.position.z) / 1000;

            bird.rotation.y = Math.atan2(-boid.velocity.z, boid.velocity.x);
            bird.rotation.z = Math.asin(boid.velocity.y / boid.velocity.length());

            bird.phase = (bird.phase + (Math.max(0, bird.rotation.z) + 0.1)) % 62.83;
            bird.geometry.vertices[5].position.y = bird.geometry.vertices[4].position.y = Math.sin(bird.phase) * 5;
        }
        
        renderer.render(scene, camera);
    }
    
    
    function onDocumentMouseMove(event)
    {
        var vector = new THREE.Vector3(event.clientX - SCREEN_WIDTH_HALF, - event.clientY + SCREEN_HEIGHT_HALF, 0);
        for (var i = 0, il = boids.length; i < il; i++)
        {
            boid = boids[i];
            vector.z = boid.position.z;
            boid.repulse(vector);
        }
    }
    
});