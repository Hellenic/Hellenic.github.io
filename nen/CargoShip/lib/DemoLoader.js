'use strict';

Object.defineProperty(exports, '__esModule', {
    value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _coreLoaderUtils = require('./core/LoaderUtils');

var _coreLoaderUtils2 = _interopRequireDefault(_coreLoaderUtils);

var _coreProgress = require('./core/Progress');

var _coreProgress2 = _interopRequireDefault(_coreProgress);

/**
* DemoLoader is a loader for DemoScene system. Loader will load the actual DemoScene system
* but also every other script it's given. Once the loading is completed, it will initialize
* the DemoScene system.
*
* TODO In the future DemoLoader will be refactored away from jQuery to use ES6 dynamic module loading
* However, since that standard is not finished I feel like there's no point to do this yet.
* I could use System.js to load modules and something else, but at least shaders are not supported yet,
* so I would need jQuery for that still anyways.
*/

var DemoLoader = (function () {
    function DemoLoader() {
        _classCallCheck(this, DemoLoader);

        this.initialScripts = [];
        this.scripts = [];
        this.initialsLoaded = false;

        this.progress = new _coreProgress2['default']();

        /*
        this.rootPath = rootPath;
         // Set our baseURL reference path
        System.config({
            baseURL: rootPath
        });
         System.import('lib/Detector').then(Detector) {
            console.log("Detector loaded", Detector);
        });
        */
    }

    _createClass(DemoLoader, [{
        key: 'addScripts',
        value: function addScripts(scripts, initial, callback) {
            for (var i = 0; i < scripts.length; i++) {
                var script = scripts[i];
                this.addScript(script, initial, callback);
            }
        }
    }, {
        key: 'addScript',
        value: function addScript(scriptData, initial, callback) {
            var scriptObj = this.getScriptObject(scriptData, callback);
            if (initial) {
                this.initialScripts.push(scriptObj);
            } else {
                this.scripts.push(scriptObj);
            }
        }
    }, {
        key: 'doLoad',
        value: function doLoad() {
            // Get next script to load
            var scriptObject = this.getNextScript();

            // If nothing to load, broadcast and quit
            if (!scriptObject) {
                // Broadcast event that everything was loaded
                $(document).trigger("loaderDone.DemoSystem");
                return;
            }

            $(document).trigger("loaderTick.DemoSystem", { name: scriptObject.name, file: scriptObject.file });

            var $loader = _coreLoaderUtils2['default'].getLoader(scriptObject.file);
            var thisRef = this;

            // Load the script
            $loader(scriptObject.file).done(function (script, textStatus) {
                // After loading, execute callback
                if (typeof scriptObject.callback === "function") {
                    // That script callback, will get secondary callback, which should
                    // continue this loading when ready.
                    return scriptObject.callback(scriptObject.name, scriptObject.file, script, function () {
                        thisRef.doLoad();
                    });
                }

                // When done with this file, load more
                thisRef.doLoad();
            }).fail(function (jqxhr, settings, exception) {
                console.error("Loading failed! File: " + scriptObject.file + " // Status: " + jqxhr.status, exception);
            });
        }
    }, {
        key: 'getNextScript',
        value: function getNextScript() {
            // Get the prioritized non-empty array
            var scriptArray = this.getScriptArray();
            if (scriptArray == null) return null;

            // Return the next script object fromt he list
            return scriptArray.shift();
        }
    }, {
        key: 'getScriptArray',
        value: function getScriptArray() {
            if (this.initialScripts.length > 0) return this.initialScripts;

            if (!this.initialsLoaded) {
                this.initialsLoaded = true;
                $(document).trigger("loaderReady.DemoSystem");
            }

            if (this.scripts.length > 0) return this.scripts;

            return null;
        }
    }, {
        key: 'getScriptObject',
        value: function getScriptObject(scriptData, callback) {
            var name = "";
            var file = "";

            if (typeof scriptData === "object") {
                name = scriptData.name;
                file = scriptData.file;
            } else {
                name = _coreLoaderUtils2['default'].getFilename(scriptData);
                file = scriptData;
            }

            return { name: name, file: file, callback: callback };
        }
    }, {
        key: 'getFilename',
        value: function getFilename(file) {
            var filename = file;
            if (filename.indexOf("/") >= 0) {
                filename = filename.substring(filename.lastIndexOf("/") + 1);
            }

            if (filename.indexOf(".") < 0) return filename;

            return filename.substring(0, filename.lastIndexOf("."));
        }
    }, {
        key: 'start',
        value: function start() {
            // Count scripts
            var scriptCount = this.initialScripts.length + this.scripts.length + 1;

            // Broadcast event that loading is about to start
            $(document).trigger("loaderStart.DemoSystem", { fileCount: scriptCount });

            // Start loading from the initial scripts
            this.doLoad();
        }
    }]);

    return DemoLoader;
})();

exports['default'] = DemoLoader;
module.exports = exports['default'];