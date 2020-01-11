//degrees = radians * (180/pi)
function toDegrees(radians)
{
	return radians * (180/Math.PI);
}

//radians = degrees * (pi/180)
function toRadians(degrees)
{
	return degrees * (Math.PI/180);
}

var Orientation = {
		CURVED_UP: 1,
		CURVED_DOWN: 2
};

function getOrientation(radians)
{
	var degrees = toDegrees(radians);
	if (degrees > 90 && degrees < 270)
	{
		return Orientation.CURVED_UP;
	}
	
	return Orientation.CURVED_DOWN;
}