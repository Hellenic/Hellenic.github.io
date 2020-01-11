/**
 * Radial (pie) menu system.
 * Depends on jQuery and THREE.js
 * 
 * This namespace contains some methods that are meant for the HK's Radial Menu.
 * 
 * Note: This Menu is created only for Blankpace.net and I have not tested it, if it works when you add more slices or menus.
 * It can also break if you need different sizes or what so ever. 
 * Feel free to use the code but most likely you will need to do some corrections.
 *  -- HK
 * 
 * @namespace
 */
var HMenu = {};
(function(menu, $) {
	
	/** @private */
	var camera = null;
	var scene = null;
	var renderer = null;
	var menuCircle = null;
	var mouse = new THREE.Vector2();
	var renderingSettings = {alpha: true, antialias: true};
	
    var SCREEN_WIDTH = window.innerWidth,
	    SCREEN_HEIGHT = window.innerHeight,
	    SCREEN_WIDTH_HALF = SCREEN_WIDTH  / 2,
	    SCREEN_HEIGHT_HALF = SCREEN_HEIGHT / 2;
	
	/**
	 * 
	 * @returns True if browser can render the menu, otherwise false.
	 * @public
	 */
	menu.isSupported = function()
	{
	    if (window.WebGLRenderingContext)
		{
	    	return true;
		}
	    console.debug("WebGL not supported, trying 2D canvas...");
	    
	    if (window.CanvasRenderingContext2D)
	    {
	    	return true;
	    }
	    console.debug("2D canvas rendering not supported, menu cannot be initialized.");
	    
	    return false;
	};
	
	/**
	 * Builds and starts the menu.
	 */
	menu.initialize = function(config)
	{
		if (!(config instanceof MenuSettings))
		{
			config = new MenuSettings();
		}
		
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(75, SCREEN_WIDTH / SCREEN_HEIGHT, 1, 10000);
        camera.position.z = 1000;
        scene.add(camera);
        
        menuCircle = new MenuCircle(config);
        scene.add(menuCircle.getObject());
        
        renderer = (window.WebGLRenderingContext) ? new THREE.WebGLRenderer(renderingSettings) : new THREE.CanvasRenderer(renderingSettings);
        renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
        renderer.sortObjects = false;
        
        $("body").append(renderer.domElement);
		
        registerEvents();
        
        renderMenu();
	};
	
	function registerEvents()
	{
		$("body").on("mousemove", function(event) {
			mouse.x = (event.clientX / SCREEN_WIDTH) * 2 - 1;
			mouse.y = - (event.clientY / SCREEN_HEIGHT) * 2 + 1;
			menuCircle.findHighlight(mouse, camera);
		});
		
		$("body").on("click", function(event) {
			menuCircle.onClick();
		});
		
		$(window).on("resize", function(event) {
			SCREEN_WIDTH = window.innerWidth;
			SCREEN_HEIGHT = window.innerHeight;
			
			camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
			camera.updateProjectionMatrix();
			renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
		});
	}
	
    function renderMenu()
    {
        requestAnimationFrame(renderMenu);
        var cameraCap = 150;
        
        camera.position.x = camera.position.x + (3 * mouse.x);
        if (camera.position.x > cameraCap)
        	camera.position.x = cameraCap;
        if (camera.position.x < -cameraCap)
        	camera.position.x = -cameraCap;
        
        camera.position.y = camera.position.y + (3 * mouse.y);
        if (camera.position.y > cameraCap)
        	camera.position.y = cameraCap;
        if (camera.position.y < -cameraCap)
        	camera.position.y = -cameraCap;
        
        camera.lookAt(scene.position);
        
        renderer.render(scene, camera);
    }
	
}(HMenu, jQuery));