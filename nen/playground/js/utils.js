var Blankpace = {};

Blankpace.webglAvailable = function()
{
	try {
		var canvas = document.createElement( 'canvas' );
		return !!( window.WebGLRenderingContext && (
			canvas.getContext( 'webgl' ) ||
			canvas.getContext( 'experimental-webgl' ) )
		);
	} catch ( e ) {
		return false;
	}
};

Blankpace.isEmptyString = function(value)
{
	if (typeof(value) !== "string")
		return true;

	if (value == null)
		return true;

	if (value == "")
		return true;

	return false;
};

//degrees = radians * (180/pi)
Blankpace.toDegrees = function(radians)
{
	return radians * (180/Math.PI);
};

//radians = degrees * (pi/180)
Blankpace.toRadians = function(degrees)
{
	return degrees * (Math.PI/180);
};

/* Randomly generate an integer between two numbers. */
Blankpace.random = function(min, max)
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
};
