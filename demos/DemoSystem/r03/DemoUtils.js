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
