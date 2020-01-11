"use strict";

/**
* DemoScene system with Three.js
* DemoScene handles the initialization for scenes, possible errors,
* the actual demo loop, etc.
*
* @version 0.6
* @class DemoScene
*/
var DemoScene = {};

(function(Scene, $) {

    var started = false;
    var settings = {};

    // Path to DemoSystem
    var currentPath = document.currentScript.src;
    var ROOT_PATH = currentPath.substring(0, currentPath.lastIndexOf("/")+1);

    var shaderCallback = function(name, file, content, callback)
    {
        Shaders[name] = content;
        callback();
    };
    var modelCallback = function(name, file, content, callback)
    {
        var modelClass = eval(name);
        if (modelClass instanceof Model)
        {
            ModelService.load(modelClass, callback);
        }
    };

    // Constructor
    (function() {

        DemoLoader.addScript(ROOT_PATH + "libs/Detector.js", true);
        DemoLoader.addScript(ROOT_PATH + "models/Scene.js", true);
        DemoLoader.addScript(ROOT_PATH + "models/Model.js", true);
        DemoLoader.addScript(ROOT_PATH + "models/Action.js", true);
        DemoLoader.addScript(ROOT_PATH + "models/AreaTrigger.js", true);
        DemoLoader.addScript(ROOT_PATH + "services/DemoService.js", true);
        DemoLoader.addScript(ROOT_PATH + "services/ActionService.js", true);
        DemoLoader.addScript(ROOT_PATH + "services/ModelService.js", true);
        DemoLoader.addScript(ROOT_PATH + "services/PhysicsService.js", true);
        DemoLoader.addScript(ROOT_PATH + "services/TriggerService.js", true);
        DemoLoader.addScript(ROOT_PATH + "managers/ActionManager.js", true);
        DemoLoader.addScript(ROOT_PATH + "controllers/DemoController.js", true);
        DemoLoader.addScript(ROOT_PATH + "controllers/InteractionController.js", true);
        DemoLoader.addScript(ROOT_PATH + "controllers/TriggerController.js", true);
        DemoLoader.addScript(ROOT_PATH + "controllers/DialogController.js", true);
        DemoLoader.addScript(ROOT_PATH + "controllers/EventController.js", true);
        DemoLoader.addScript(ROOT_PATH + "utils/DemoUtils.js", true);
        DemoLoader.addScript(ROOT_PATH + "utils/Statics.js", true);
        DemoLoader.addScript(ROOT_PATH + "utils/Support.js", true);

    })();

    Scene.setProperties = function(config)
    {
        if (started)
        {
            console.warn("You cannot set properties anymore after DemoScene engine has been started.");
            return;
        }
        settings = config;

        if (settings.stats)
        {
            DemoLoader.addScript(ROOT_PATH + "libs/Stats.js", true);
        }
        if (settings.controls)
        {
            DemoLoader.addScript(ROOT_PATH + "extend/Controls.js", true);
        }
        if (settings.pointerlock)
        {
            DemoLoader.addScript(ROOT_PATH + "extend/Pointerlock.js",true);
        }
        if (settings.audio)
        {
            DemoLoader.addScript(ROOT_PATH + "soundsystem/AudioPlayer.js", true);
            DemoLoader.addScript(ROOT_PATH + "soundsystem/MusicPlayer.js", true);
            DemoLoader.addScript(ROOT_PATH + "soundsystem/SoundPlayer.js", true);
        }
    };

    Scene.addGenericScript = function(name, scriptFile, initial, callback)
    {
        DemoLoader.addScript({name: name, file: scriptFile}, initial, callback);
    };

    Scene.addScene = function(sceneConfig)
    {
        DemoLoader.addScripts(sceneConfig.shaders, sceneConfig.initial, shaderCallback);
        DemoLoader.addScripts(sceneConfig.models, sceneConfig.initial, modelCallback);
        DemoLoader.addScript(sceneConfig.scene, sceneConfig.initial);
    };

    $(document).ready(function(){
        $(document).trigger("initialize.DemoSystem");
        started = true;
        DemoLoader.start();
    })

})(DemoScene, jQuery);
