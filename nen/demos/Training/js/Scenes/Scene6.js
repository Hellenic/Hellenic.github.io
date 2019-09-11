$(document).ready(function()
{
    if (!Detector.webgl)
        Detector.addGetWebGLMessage();

    var SCREEN_WIDTH = window.innerWidth,
        SCREEN_HEIGHT = window.innerHeight,
        SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
        SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;

    var container, stats;
    var camera, scene, renderer,
            materials = [], objects = [],
            singleMaterial, zmaterial = [],
            parameters, i, j, k, h, color, x, y, z, s, n, nobjects,
            material_depth, cubeMaterial;

    var mouseX = 0, mouseY = 0;

    var height = SCREEN_HEIGHT - 300;

    var postprocessing = { enabled  : true };

    init();
    animate();

    function init()
    {
        container = $("<div />");
        $("body").append(container);

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera( 70, SCREEN_WIDTH / height, 1, 3000 );
        camera.position.z = 200;
        scene.add( camera );

        renderer = new THREE.WebGLRenderer( { antialias: false } );
        renderer.setSize( SCREEN_WIDTH, height);
        container.append(renderer.domElement);

        renderer.sortObjects = false;

        material_depth = new THREE.MeshDepthMaterial();

        parameters = { color: 0xff1100, shading: THREE.FlatShading };
        cubeMaterial = new THREE.MeshBasicMaterial( parameters );

        singleMaterial = false;

        if( singleMaterial ) zmaterial = [ cubeMaterial ];

        //var geo = new THREE.CubeGeometry( 1, 1, 1 );
        //var geo = new THREE.IcosahedronGeometry( 2 );
        var geo = new THREE.SphereGeometry( 1, 20, 10 );

        var start = new Date().getTime();

        renderer.initMaterial( cubeMaterial, scene.lights, scene.fog );

        var xgrid = 14,
                ygrid = 9,
                zgrid = 14;

        nobjects = xgrid * ygrid * zgrid;

        c = 0;

        //var s = 0.25;
        var s = 60;

        for ( i = 0; i < xgrid; i ++ )
        for ( j = 0; j < ygrid; j ++ )
        for ( k = 0; k < zgrid; k ++ ) {

                if ( singleMaterial ) {

                        mesh = new THREE.Mesh( geo, zmaterial );

                } else {

                        materials[ c ] = new THREE.MeshBasicMaterial( parameters );
                        mesh = new THREE.Mesh( geo, materials[ c ] );
                        renderer.initMaterial( materials[ c ], scene.lights, scene.fog, mesh );

                }

                x = 200 * ( i - xgrid/2 );
                y = 200 * ( j - ygrid/2 );
                z = 200 * ( k - zgrid/2 );

                mesh.position.set( x, y, z );
                mesh.scale.set( s, s, s );

                mesh.matrixAutoUpdate = false;
                mesh.updateMatrix();

                scene.add( mesh );
                objects.push( mesh );

                c ++;

        }

        //console.log("init time: ", new Date().getTime() - start );

        scene.matrixAutoUpdate = false;

        initPostprocessing();

        renderer.autoClear = false;

        renderer.domElement.style.position = 'absolute';
        renderer.domElement.style.top = "150px";
        renderer.domElement.style.left = "0px";

        stats = new Stats();
        $("#stats").html(stats.domElement);
    }

    function initPostprocessing()
    {
        postprocessing.scene = new THREE.Scene();

        postprocessing.camera = new THREE.OrthographicCamera( SCREEN_WIDTH / - 2, SCREEN_WIDTH / 2,  SCREEN_HEIGHT / 2, SCREEN_HEIGHT / - 2, -10000, 10000 );
        postprocessing.camera.position.z = 100;

        postprocessing.scene.add( postprocessing.camera );

        var pars = { minFilter: THREE.LinearFilter, magFilter: THREE.LinearFilter, format: THREE.RGBFormat };
        postprocessing.rtTextureDepth = new THREE.WebGLRenderTarget( SCREEN_WIDTH, height, pars );
        postprocessing.rtTextureColor = new THREE.WebGLRenderTarget( SCREEN_WIDTH, height, pars );

        var bokeh_shader = THREE.ShaderExtras[ "bokeh" ];

        postprocessing.bokeh_uniforms = THREE.UniformsUtils.clone( bokeh_shader.uniforms );

        postprocessing.bokeh_uniforms[ "tColor" ].texture = postprocessing.rtTextureColor;
        postprocessing.bokeh_uniforms[ "tDepth" ].texture = postprocessing.rtTextureDepth;
        postprocessing.bokeh_uniforms[ "focus" ].value = 1.1;
        postprocessing.bokeh_uniforms[ "aspect" ].value = SCREEN_WIDTH / height;

        postprocessing.materialBokeh = new THREE.ShaderMaterial({
            uniforms: postprocessing.bokeh_uniforms,
            vertexShader: bokeh_shader.vertexShader,
            fragmentShader: bokeh_shader.fragmentShader
        });

        postprocessing.quad = new THREE.Mesh( new THREE.PlaneGeometry( SCREEN_WIDTH, SCREEN_HEIGHT ), postprocessing.materialBokeh );
        postprocessing.quad.position.z = - 500;
        postprocessing.scene.add( postprocessing.quad );
    }
    
    function animate()
    {
        requestAnimationFrame(animate);

        render();
        stats.update();
    }

    function render()
    {
        var time = Date.now() * 0.00005;

        camera.position.x += 1;
        camera.position.y += 0.25;

        camera.lookAt( scene.position );

        if ( !singleMaterial )
        {
                for( i = 0; i < nobjects; i ++ ) {
                        h = ( 360 * ( i / nobjects + time ) % 360 ) / 360;
                        materials[ i ].color.setHSV( h, 1, 1 );
                }
        }

        if (postprocessing.enabled)
        {
                renderer.clear();
                // Render scene into texture
                scene.overrideMaterial = null;
                renderer.render( scene, camera, postprocessing.rtTextureColor, true );

                // Render depth into texture
                scene.overrideMaterial = material_depth;
                renderer.render( scene, camera, postprocessing.rtTextureDepth, true );

                // Render bokeh composite
                renderer.render( postprocessing.scene, postprocessing.camera );
        }
        else
        {
                renderer.clear();
                renderer.render( scene, camera );
        }
    }
});