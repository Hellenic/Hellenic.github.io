$(document).ready(function()
{
    if (!Detector.webgl)
        Detector.addGetWebGLMessage();
    
    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;
    
    var container, stats;
    var camera, scene, renderer, composer;
    
    var speed = 50;
    
    var delta = 1, clock = new THREE.Clock();
    
    var particleCloud, sparksEmitter, emitterPos;
    var pointLight, attributes;

    init();
    animate();

    function init()
    {
        container = $("<div />");
        $("body").append(container);
        
        scene = new THREE.Scene();
        
        camera = new THREE.PerspectiveCamera(70, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 2000);
        camera.position.set(0, 150, 400);
        scene.add(camera);

        // LIGHTS
        var directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
        directionalLight.position.set(0, -1, 1);
        directionalLight.position.normalize();
        scene.add(directionalLight);

        pointLight = new THREE.PointLight(0xffffff, 2, 300);
        pointLight.position.set(0, 0, 0);
        scene.add(pointLight);
        
        createMesh();
        
        createParticles();
        
        renderer = new THREE.WebGLRenderer();
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        renderer.setClearColorHex(0x000000, 1);

        container.append(renderer.domElement);
        
        stats = new Stats();
        $("#stats").html(stats.domElement);
        
        createShaders();
        
        //$(document).bind("mousemove", onDocumentMouseMove);
    }
    
    function createMesh()
    {
        var geometry = new THREE.IcosahedronGeometry(4);
        var material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

        var mesh = new THREE.Mesh(geometry, material);
        //mesh.dynamic = true;
        mesh.position.set(200, 0, 200);
        mesh.scale.x = mesh.scale.y = mesh.scale.z = 75;
        scene.add(mesh);
    }
    
    function createParticles()
    {
        ///// Create particle objects for Three.js
        var particlesLength = 70000;

        var particles = new THREE.Geometry();
        function newpos( x, y, z )
        {
            return new THREE.Vertex( new THREE.Vector3( x, y, z ) );
        }
        
        var Pool = {
                __pools: [],

                // Get a new Vector
                get: function() {
                        if ( this.__pools.length > 0 ) {
                                return this.__pools.pop();
                        }
                        console.log( "pool ran out!" )
                        return null;
                },

                // Release a vector back into the pool
                add: function( v ) {
                        this.__pools.push( v );
                }
        };
        
        for (var i = 0; i < particlesLength; i++)
        {
            particles.vertices.push(newpos(Math.random() * 200 - 100, Math.random() * 100 + 150, Math.random() * 50));
            Pool.add(i);
        }
        
        // Create pools of vectors
        attributes = {
            size:  { type: 'f', value: [] },
            pcolor: { type: 'c', value: [] }
        };

        var sprite = generateSprite();

        var texture = new THREE.Texture(sprite);
        texture.needsUpdate = true;

        var uniforms = {
            texture:   { type: "t", value: 0, texture: texture }
        };

        // PARAMETERS

        // Steadycounter
        // Life
        // Opacity
        // Hue Speed
        // Movement Speed
        function generateSprite()
        {
            var canvas = document.createElement("canvas");
            canvas.width = 128;
            canvas.height = 128;
            var context = canvas.getContext("2d");

            context.beginPath();
            context.arc( 64, 64, 60, 0, Math.PI * 2, false) ;
            context.closePath();

            context.lineWidth = 0.5; //0.05
            context.stroke();
            context.restore();

            var gradient = context.createRadialGradient( canvas.width / 2, canvas.height / 2, 0, canvas.width / 2, canvas.height / 2, canvas.width / 2 );

            gradient.addColorStop( 0, 'rgba(255,255,255,1)' );
            gradient.addColorStop( 0.2, 'rgba(255,255,255,1)' );
            gradient.addColorStop( 0.4, 'rgba(200,200,200,1)' );
            gradient.addColorStop( 1, 'rgba(0,0,0,1)' );

            context.fillStyle = gradient;

            context.fill();

            return canvas;
        }
        
        var shaderMaterial = new THREE.ShaderMaterial(
        {
            uniforms:       uniforms,
            attributes:     attributes,

            vertexShader:   $("#vertexshader").text(),
            fragmentShader: $("#fragmentshader").text(),

            blending:       THREE.AdditiveBlending,
            depthWrite:     false,
            transparent:    true
        });

        particleCloud = new THREE.ParticleSystem(particles, shaderMaterial);

        particleCloud.dynamic = true;
        //particleCloud.sortParticles = true;

        var vertices = particleCloud.geometry.vertices;
        var values_size = attributes.size.value;
        var values_color = attributes.pcolor.value;

        for (var v=0; v < vertices.length; v++)
        {
            values_size[v] = 50;
            
            values_color[v] = new THREE.Color(0xffffff);
            values_color[v].setHSV(0, 0, 0);
            
            particles.vertices[v].position.set(Number.POSITIVE_INFINITY, Number.POSITIVE_INFINITY, Number.POSITIVE_INFINITY);
        }

        var parent = new THREE.Object3D();
        parent.add(particleCloud);
        particleCloud.y = 800;
        scene.add(parent);

        // Create Particle Systems
        // EMITTER STUFF
        var hue = 0;

        var setTargetParticle = function()
        {
            var target = Pool.get();
            values_size[ target ] = Math.random() * 200 + 100;
            
            return target;
        };

        var onParticleCreated = function(p)
        {
            var position = p.position;
            p.target.position = position;

            var target = p.target;

            if (target)
            {
                hue += 0.0003 * delta;
                if (hue > 1)
                    hue -= 1;
                
                pointLight.position.x = emitterPos.x;
                pointLight.position.y = emitterPos.y;
                pointLight.position.z = 100;

                particles.vertices[target].position = p.position;

                values_color[target].setHSV(hue, 0.8, 0.15);

                pointLight.color.setHSV(hue, 0.8, 0.95);
            };
        };

        var onParticleDead = function(particle)
        {
            var target = particle.target;

            if (target)
            {
                // Hide the particle
                values_color[target].setHSV(0, 0, 0);
                particles.vertices[target].position.set(Number.POSITIVE_INFINITY, Number.POSITIVE_INFINITY, Number.POSITIVE_INFINITY);

                // Mark particle system as available by returning to pool
                Pool.add( particle.target );
            }
        };

        sparksEmitter = new SPARKS.Emitter( new SPARKS.SteadyCounter( 500 ) );

        emitterPos = new THREE.Vector3( 0, 0, 0 );

        sparksEmitter.addInitializer( new SPARKS.Position( new SPARKS.PointZone( emitterPos ) ) );
        sparksEmitter.addInitializer( new SPARKS.Lifetime( 1, 15 ));
        sparksEmitter.addInitializer( new SPARKS.Target( null, setTargetParticle ) );


        sparksEmitter.addInitializer( new SPARKS.Velocity( new SPARKS.PointZone( new THREE.Vector3( 0, -5, 1 ) ) ) );
        // TOTRY Set velocity to move away from centroid

        sparksEmitter.addAction( new SPARKS.Age() );
        sparksEmitter.addAction( new SPARKS.Accelerate( 0, 0, -50 ) );
        sparksEmitter.addAction( new SPARKS.Move() );
        sparksEmitter.addAction( new SPARKS.RandomDrift( 90, 100, 2000 ) );
        
        sparksEmitter.addCallback( "created", onParticleCreated );
        sparksEmitter.addCallback( "dead", onParticleDead );
        sparksEmitter.start();
        // End Particles
    }
    
    function createShaders()
    {
        // POST PROCESSING
        var effectFocus = new THREE.ShaderPass(THREE.ShaderExtras["focus"]);

        var effectScreen = new THREE.ShaderPass(THREE.ShaderExtras["screen"]);
        var effectFilm = new THREE.FilmPass(0.5, 0.25, 2048, false);

        var shaderBlur = THREE.ShaderExtras["triangleBlur"];
        var effectBlurX = new THREE.ShaderPass(shaderBlur, 'texture');
        var effectBlurY = new THREE.ShaderPass(shaderBlur, 'texture');

        var radius = 15;
        var blurAmountX = radius / SCREEN_WIDTH;
        var blurAmountY = radius / SCREEN_HEIGHT;

        var hblur = new THREE.ShaderPass(THREE.ShaderExtras["horizontalBlur"]);
        var vblur = new THREE.ShaderPass(THREE.ShaderExtras["verticalBlur"]);

        hblur.uniforms['h'].value =  1 / window.innerWidth;
        vblur.uniforms['v'].value =  1 / window.innerHeight;

        effectBlurX.uniforms['delta'].value = new THREE.Vector2(blurAmountX, 0);
        effectBlurY.uniforms['delta'].value = new THREE.Vector2(0, blurAmountY);

        effectFocus.uniforms['sampleDistance'].value = 0.99; //0.94
        effectFocus.uniforms['waveFactor'].value = 0.003;  //0.00125

        var renderScene = new THREE.RenderPass(scene, camera);

        composer = new THREE.EffectComposer(renderer);
        composer.addPass(renderScene);
        composer.addPass(hblur);
        composer.addPass(vblur);
        //composer.addPass( effectBlurX );
        //composer.addPass( effectBlurY );
        //composer.addPass( effectScreen );
        //composer.addPass( effectFocus );
        //composer.addPass( effectFilm );

        vblur.renderToScreen = true;
        effectBlurY.renderToScreen = true;
        effectFocus.renderToScreen = true;
        effectScreen.renderToScreen = true;
        effectFilm.renderToScreen = true;
    }

    function onDocumentMouseMove(event)
    {
        emitterPos.x = event.clientX * 0.2;
        emitterPos.y = event.clientY * 0.2;
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
        delta = speed * clock.getDelta();

        particleCloud.geometry.__dirtyVertices = true;
        attributes.size.needsUpdate = true;
        attributes.pcolor.needsUpdate = true;
        
        //emitterPos.x = Math.sin(emitterPos.x + delta * 300) * 300;
        //emitterPos.y = Math.cos(emitterPos.y + delta * 300) * 300;
        
        var t = new Date().getTime() * 0.00025;
        emitterPos.y = Math.sin(t) * 150 + 150;
        emitterPos.x = (Math.sin(t) * 150) / emitterPos.y;
        
        renderer.clear();
        //renderer.render(scene, camera);
        composer.render(0.1);
    }
    
    function debug()
    {
        var debug = "Todo...";
        $("#debug").html(debug);
    }
});