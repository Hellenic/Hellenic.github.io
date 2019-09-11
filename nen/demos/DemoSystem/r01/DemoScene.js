var Demo = Demo || new Object();
var Scenes = new Object();

var Statics = {
        SCREEN_WIDTH : window.innerWidth,
        SCREEN_HEIGHT : window.innerHeight,
        SCREEN_WIDTH_HALF : window.innerWidth / 2,
        SCREEN_HEIGHT_HALF : window.innerHeight / 2
};
var Scene = {
    camera : null,
    scene : null,
    renderer : null,
    container : $("<div />"),
    current : null,
    start : new Date(),
    state : 0,
    delta : 0.01
}
    
$(document).ready(function() {
    
    Demo.load.loadEssentials();
    
});

$.extend(Demo, {
    
    // Called by DemoLoader
    init : function()
    {
        console.debug("Initializing...");
        
        if (!Detector.webgl)
            Detector.addGetWebGLMessage();
        
        Demo.stats = new Stats();
        $("#stats").html(Demo.stats.domElement);
        
        Scene.state++;
        Scene.current = Intro;
        Scene.current.init();
        
        $("body").append(Scene.container);
        
        Scene.renderer.setSize(Statics.SCREEN_WIDTH, Statics.SCREEN_HEIGHT);
        Scene.container.append(Scene.renderer.domElement);
        
        Demo.animate();
    },
    
    animate : function()
    {
        if (Scene.state > 0)
            requestAnimationFrame(Demo.animate);
        
        var state = Scene.current.render();
        Demo.stats.update();
        
        if (state == 0)
            Demo.doStateChange();
        //else
        //    console.log("Do something here?");
        
        Demo.debug();
    },
    
    debug : function()
    {
        var debug = "";
        
        debug += "<br />Scene: "+ Scene.state;
        debug += "<br />SceneState: "+ Scene.current.state;
        $("#debug").html(debug);
    },
    
    doStateChange : function()
    {
        console.log("Scene change. "+ Scene.state);
        
        if (Scene.state == 1)
        {
            console.log("Scene1");
            Scene.current = Scene1;
            Scene.current.init();
        }
        else if (Scene.state == 2)
        {
            console.log("Scene2");
        }
        else if (Scene.state == 3)
        {
            console.log("Outro?");
        }
        else
        {
            Scene.state = -1;
            Scene.current = null;
            Scene.scene = null;
            Scene.renderer = null;
            Scene.camera = null;
            Scene.container.remove();
            $("body").html("<h1>The end.</h1>");
            console.log("End?");
        }
        
        Scene.state++;
    }
    
});