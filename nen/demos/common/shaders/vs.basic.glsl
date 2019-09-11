attribute float size;
attribute vec4 ca;

varying vec4 vColor;

uniform float amplitude;
attribute float displacement;

void main() {
	vColor = ca;
	
    vec3 newPosition = position;
    if (displacement > 1.0) newPosition = position * vec3(displacement * amplitude);
	
	vec4 mvPosition = modelViewMatrix * vec4(newPosition, 1.0);
	gl_PointSize = size * (150.0 / length(mvPosition.xyz));
	
	gl_Position = projectionMatrix * mvPosition;
}