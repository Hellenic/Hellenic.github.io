var DemoUtils = {};

/**
* Checks if given string parameter is empty or null.
*
* @param {string} string - String to be checked if it's an empty string
* @public
*/
DemoUtils.isEmptyString = function(param)
{
    if (typeof(param) !== "string" || param == null || param.length <= 0)
        return true;

    return false;
}

DemoUtils.getFilename = function(file)
{
    var filename = file;
    if (filename.indexOf("/") >= 0)
    {
        filename = filename.substring(filename.lastIndexOf("/")+1);
    }

    if (filename.indexOf(".") < 0)
        return filename;

    return filename.substring(0, filename.lastIndexOf("."));
}

/**
 *
 */
DemoUtils.getUrlParam = function(name)
{
    var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
    if (results == null)
        return 0;

    return results[1]
}

DemoUtils.toScreenXY = function(position, camera, jqdiv)
{
    var pos = position.clone();
    projScreenMat = new THREE.Matrix4();
    projScreenMat.multiply(camera.projectionMatrix, camera.matrixWorldInverse);
    projScreenMat.multiplyVector3(pos);

    var x = (pos.x + 1) * jqdiv.width() / 2 + jqdiv.offset().left;
    var y = (-pos.y + 1) * jqdiv.height() / 2 + jqdiv.offset().top;

    return {x: x, y: y};
}
