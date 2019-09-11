'use strict';

Object.defineProperty(exports, '__esModule', {
    value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _DemoLoader = require('./DemoLoader');

var _DemoLoader2 = _interopRequireDefault(_DemoLoader);

//import Configuration from './core/Configuration';

/**
* DemoScene system with Three.js
* DemoScene handles the initialization for scenes, possible errors,
* the actual demo loop, etc.
*
* TODO Finish ES6 transform
*/

var DemoScene = (function () {
    function DemoScene(config, path) {
        _classCallCheck(this, DemoScene);

        // Root path of the DemoSystem
        this.setupRootPath(path);

        this.loader = new _DemoLoader2['default']();

        this.started = false;
        this.settings = config;
        this.applySettings();

        // TODO Refactor
        // Give all the internal engine scripts to the loader
        this.loader.addScript(this.ROOT_PATH + "lib/Detector.js", true);
        this.loader.addScript(this.ROOT_PATH + "models/Scene.js", true);
        this.loader.addScript(this.ROOT_PATH + "models/Model.js", true);
        this.loader.addScript(this.ROOT_PATH + "models/Action.js", true);
        this.loader.addScript(this.ROOT_PATH + "models/AreaTrigger.js", true);
        this.loader.addScript(this.ROOT_PATH + "services/DemoService.js", true);
        this.loader.addScript(this.ROOT_PATH + "services/ActionService.js", true);
        this.loader.addScript(this.ROOT_PATH + "services/ModelService.js", true);
        this.loader.addScript(this.ROOT_PATH + "services/PhysicsService.js", true);
        this.loader.addScript(this.ROOT_PATH + "services/TriggerService.js", true);
        this.loader.addScript(this.ROOT_PATH + "managers/ActionManager.js", true);
        this.loader.addScript(this.ROOT_PATH + "controllers/DemoController.js", true);
        this.loader.addScript(this.ROOT_PATH + "controllers/InteractionController.js", true);
        this.loader.addScript(this.ROOT_PATH + "controllers/TriggerController.js", true);
        this.loader.addScript(this.ROOT_PATH + "controllers/DialogController.js", true);
        this.loader.addScript(this.ROOT_PATH + "controllers/EventController.js", true);
        this.loader.addScript(this.ROOT_PATH + "utils/DemoUtils.js", true);
        this.loader.addScript(this.ROOT_PATH + "utils/Statics.js", true);
        this.loader.addScript(this.ROOT_PATH + "utils/Support.js", true);
    }

    /**
        Private methods
    */

    _createClass(DemoScene, [{
        key: 'setupRootPath',
        value: function setupRootPath(path) {
            this.ROOT_PATH = path;
            if (!path && document.currentScript) {
                var currentPath = document.currentScript.src;
                if (currentPath) {
                    this.ROOT_PATH = currentPath.substring(0, currentPath.lastIndexOf("/") + 1);
                } else {
                    this.ROOT_PATH = '/';
                }
            }
        }
    }, {
        key: 'shaderCallback',
        value: function shaderCallback(name, file, content, callback) {
            Shaders[name] = content;
            callback();
        }
    }, {
        key: 'modelCallback',
        value: function modelCallback(name, file, content, callback) {
            var modelClass = eval(name);
            if (modelClass instanceof Model) {
                ModelService.load(modelClass, callback);
            }
        }
    }, {
        key: 'setProperties',

        /**
            Public methods
        */
        value: function setProperties(config) {
            if (this.started) {
                console.warn("You cannot set properties anymore after the DemoScene engine has been started.");
                return;
            }

            // Merge existing settings and given config
            this.settings = Object.assign(config, this.settings);
            this.applySettings();
        }
    }, {
        key: 'applySettings',
        value: function applySettings() {
            if (this.settings.controls) {
                this.loader.addScript(this.ROOT_PATH + "modules/CharacterControls.js", true);
            }
            if (this.settings.pointerlock) {
                this.loader.addScript(this.ROOT_PATH + "modules/Pointerlock.js", true);
            }
            if (this.settings.audio) {
                this.loader.addScript(this.ROOT_PATH + "soundsystem/AudioPlayer.js", true);
                this.loader.addScript(this.ROOT_PATH + "soundsystem/MusicPlayer.js", true);
                this.loader.addScript(this.ROOT_PATH + "soundsystem/SoundPlayer.js", true);
            }
        }
    }, {
        key: 'addGenericScript',
        value: function addGenericScript(name, scriptFile, initial, callback) {
            this.loader.addScript({ name: name, file: scriptFile }, initial, callback);
        }
    }, {
        key: 'addScene',
        value: function addScene(sceneConfig) {
            var initial = sceneConfig.initial;
            this.loader.addScripts(sceneConfig.shaders, initial, this.shaderCallback);
            this.loader.addScripts(sceneConfig.models, initial, this.modelCallback);
            this.loader.addScript(sceneConfig.scene, initial);
        }
    }, {
        key: 'start',
        value: function start() {
            this.started = true;
            this.loader.start();

            return true;
        }
    }]);

    return DemoScene;
})();

exports['default'] = DemoScene;
module.exports = exports['default'];