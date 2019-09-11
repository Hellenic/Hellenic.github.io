'use strict';

/**
* TODO Finish ES6 transform, DemoUtils
*/
Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var LoaderUtils = (function () {
    function LoaderUtils() {
        _classCallCheck(this, LoaderUtils);
    }

    /**
    * Checks if given string parameter is empty or null.
    *
    * @param {string} string - String to be checked if it's an empty string
    * @public
    */

    _createClass(LoaderUtils, null, [{
        key: "isEmptyString",
        value: function isEmptyString(param) {
            if (typeof param !== "string" || param == null || param.length <= 0) return true;

            return false;
        }
    }, {
        key: "getFilename",
        value: function getFilename(file) {
            var filename = file;
            if (filename.indexOf("/") >= 0) {
                filename = filename.substring(filename.lastIndexOf("/") + 1);
            }

            if (filename.indexOf(".") < 0) return filename;

            return filename.substring(0, filename.lastIndexOf("."));
        }
    }, {
        key: "getUrlParam",
        value: function getUrlParam(name) {
            var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
            if (results == null) return 0;

            return results[1];
        }

        /**
        * Get jQuery loader based on the file extension.
        */
    }, {
        key: "getLoader",
        value: function getLoader(file) {
            // Use $.get for shaders
            if (file.indexOf(".glsl") > 0) {
                return $.get;
            }

            // Otherwise just loading scripts
            return $.getScript;
        }
    }]);

    return LoaderUtils;
})();

exports["default"] = LoaderUtils;
module.exports = exports["default"];