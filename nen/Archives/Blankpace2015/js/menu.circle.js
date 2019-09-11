/**
 * 
 * 
 */
function MenuCircle(config)
{
	this.config = config;
	this.circle = new THREE.Object3D();
	this.visible = true;
	this.slices = [];
	
	var sliceCount = this.config.slices.length;
	var thetaLength = toRadians(this.config.thetaLength);
    
    // Construct slices based on given configs
    for (var i=0; i<sliceCount; i++)
    {
    	var sliceConf = this.config.slices[i];
    	
    	var thetaStart = toRadians(this.config.thetaStart) + (i * thetaLength);
    	var totalCap = (Math.PI*2 - (sliceCount * thetaLength));
    	sliceConf.sliceCap = (totalCap / sliceCount);
    	
    	if (this.config.divideEventually)
    	{
    		thetaStart += sliceConf.sliceCap * i;
    	}
    	
    	// Set slice global configs from circle configuration, if they're not explicitly set for slice
    	if (!sliceConf.innerRadius) sliceConf.innerRadius = config.innerRadius;
    	if (!sliceConf.outerRadius) sliceConf.outerRadius = config.outerRadius;
    	if (!sliceConf.bgColor) sliceConf.bgColor = config.bgColor;
    	if (!sliceConf.zIndex) sliceConf.zIndex = config.zIndex;
    	if (!sliceConf.textOffset) sliceConf.textOffset = config.textOffset;
    	
    	// Create the slice, and add it as a child
    	var slice = new MenuSlice(i, sliceConf, thetaStart, thetaLength);
    	this.slices.push(slice);
        this.circle.add(slice.getObject());
        
        // Construct submenu for slice, if it's defined
        if (sliceConf.submenu)
        {
        	// Push them to temporary array first
        	this.circle.add(slice.getSubmenu().getObject());
        	slice.getSubmenu().toggleVisibility(); // Hide submenus by default
        }
    }
	
	this.projector = new THREE.Projector();
	this.raycaster = new THREE.Raycaster();
	this.highlighted = null;
}

MenuCircle.prototype.getObject = function()
{
    return this.circle;
};

MenuCircle.prototype.findHighlight = function(mouse, camera)
{
    // Active hover / find intersections
	var vector = new THREE.Vector3(mouse.x, mouse.y, 1);
	this.projector.unprojectVector(vector, camera);
	this.raycaster.set(camera.position, vector.sub(camera.position).normalize());

	// Revert highlight
	if (this.highlighted != null)
	{
		this.highlighted.toggleHighlight(false);
		this.highlighted = null;
	}
	
	// Cast rays to find intersecting object
	var intersect = this._findIntersect(this.circle.children);
	if (intersect != null)
	{
		// Find MenuSlice object for intersecting THREE object
		var slice = this._findSliceForObject(this.slices, intersect);
		// If slice was found, do highlight
		if (slice != null)
		{
			this.highlighted = slice;
			this.highlighted.toggleHighlight(true);
		}
	}
};

/**
 * Cast rays to given objects to find intersecting object 
 */
MenuCircle.prototype._findIntersect = function(objects)
{
	var intersects = this.raycaster.intersectObjects(objects);
	// If nothing was found, try children
	// Note: This is recursive
	if (intersects.length == 0)
	{
		for (var i=0; i<objects.length; i++)
		{
			if (objects[i].children.length > 0)
			{
				var intersect = this._findIntersect(objects[i].children);
				if (intersect != null)
					return intersect;
			}
		}
	}
	else
	{
		return intersects[0];
	}
	
	return null;
};

/**
 * Ray cast will only find THREE objects, I want to find my Slice object
 */
MenuCircle.prototype._findSliceForObject = function(slices, candidateObject)
{
	for (var i=0; i<slices.length; i++)
	{
		var slice = slices[i];
        if (slice.getObject() == candidateObject.object)
        {
    		return slice;
        }
        
        if (slice.getSubmenu())
        {
        	var submenu = slice.getSubmenu();
        	var maybe = this._findSliceForObject(submenu.slices, candidateObject);
        	if (maybe != null)
        		return maybe;
        }
	}
	
	return null;
};

MenuCircle.prototype.toggleVisibility = function()
{
    var from = { x: 1, y: 1, rotationz: 0 };
    var to   = { x: 4, y: 4, rotationz: 2 };
    
	if (this.visible)
	{
        this.animate(from, to, this.config.animationDuration);
	}
	else
	{
		this.animate(to, from, this.config.animationDuration);
	}
	
	this.visible = !this.visible;
};

MenuCircle.prototype.animate = function(from, to, duration)
{
    var that = this;
    jQuery(from).animate(to, {
        duration: duration,
        step: function() {
        	that.circle.scale.x = this.x;
        	that.circle.scale.y = this.y;
        	that.circle.rotation.z = this.rotationz;
        },
        // Finally, set values exactly to the value we wanted - steps might only take us close
        complete: function() {
        	that.circle.scale.x = to.x;
        	that.circle.scale.y = to.y;
        	that.circle.rotation.z = to.rotationz;
        }
    });
};

MenuCircle.prototype.onClick = function()
{
	if (this.highlighted == null)
	{
		return;
	}
	
	if (this.highlighted.getSubmenu())
	{
		this.highlighted.getSubmenu().toggleVisibility();
	}
};