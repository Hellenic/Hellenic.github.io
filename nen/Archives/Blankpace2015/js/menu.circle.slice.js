/**
 * 
 * @param index
 * @param sliceConfig Object
 * @param thetaStart radians
 * @param thetaLength radians
 */
function MenuSlice(index, sliceConfig, thetaStart, thetaLength)
{
	this.index = index;
	this.text = (sliceConfig.text) ? sliceConfig.text : "Hello";
	this.title = (sliceConfig.title) ? sliceConfig.title : "";
	this.textFont = "Ubuntu";
	this.textFontSize = (sliceConfig.textSize) ? sliceConfig.textSize : 50;
	this.textSize = { width: MenuSlice.getTextWidth(this.text), height: this.textFontSize };
	this.textColor = (sliceConfig.textColor) ? sliceConfig.textColor : "black";
	this.link = (sliceConfig.link) ? sliceConfig.link : "#";
	this.innerRadius = (sliceConfig.innerRadius) ? sliceConfig.innerRadius : 100;
	this.outerRadius = (sliceConfig.outerRadius) ? sliceConfig.outerRadius : 500;
	this.textOffset = (sliceConfig.textOffset) ? sliceConfig.textOffset : 150;
	this.bgColor = (sliceConfig.bgColor) ? sliceConfig.bgColor : "#ACACAC";
	this.zIndex = (sliceConfig.zIndex) ? sliceConfig.zIndex : 0;
	this.thetaStart = thetaStart;
	this.thetaLength = thetaLength;
	this.sliceCap = sliceConfig.sliceCap;
	this.lineEdgeCap = 0.1;
       
	// Build geometry & material
	// There seems to be some other bugs with theta stuff... Let's work with this the best we can for now
    this.geometry = new THREE.RingGeometry(this.innerRadius, this.outerRadius, 50, 0, this.thetaStart, this.thetaLength);
    this.material = new THREE.MeshBasicMaterial({ map: this.buildTexture() });
    this.mesh = new THREE.Mesh(this.geometry, this.material);
    this.mesh.position.z = sliceConfig.zIndex;
    
    // Build submenu for this circle if it's defined
    if (sliceConfig.submenu)
    {
    	this.submenu = new MenuCircle(sliceConfig.submenu);
    }
}

MenuSlice.getTextWidth = function(text)
{
	var canvas = document.createElement("canvas");
	var context = canvas.getContext("2d");
	context.font = this.textFontSize + "pt "+ this.textFont;
	return context.measureText(text).width;
};

// Make texture with text for this slice
MenuSlice.prototype.buildTexture = function()
{
	this.sliceSize = {width: this.outerRadius, height: this.outerRadius};
	
	// Create canvas as the size of the slice
	var canvas = document.createElement("canvas");
	canvas.width = this.sliceSize.width;
	canvas.height = this.sliceSize.height;
	context = canvas.getContext("2d");
	context.font = this.textFontSize +"pt "+ this.textFont;
	
	// Do background for the slice
	context.fillStyle = this.bgColor;
	context.fillRect(0, 0, this.sliceSize.width, this.sliceSize.height);
	
	// Configurations for the position of the text and arc
	context.textAlign = "center";
	context.textBaseline = "bottom";
	context.fillStyle = this.textColor;
	
	var arcCenter = {x: this.sliceSize.width/2, y: this.sliceSize.height/2};
	var arcStart = this.thetaStart + this.lineEdgeCap;
	var arcLength = this.thetaLength - this.sliceCap/2 - this.lineEdgeCap;
	
	// Draw the text to slice
	this.drawArcText(context, this.text, arcCenter.x, arcCenter.y, this.textOffset, -arcStart);
	
	// Arc line under the text
	context.beginPath();
	context.lineWidth = 2;
	context.arc(arcCenter.x, arcCenter.y, this.textOffset, -arcStart, -(arcStart + arcLength), true);
	context.stroke();
	context.closePath();
	
	var texture = new THREE.Texture(canvas);
	texture.needsUpdate = true;
	
	return texture;
};

MenuSlice.prototype.getObject = function()
{
    return this.mesh;
};

MenuSlice.prototype.getSubmenu = function()
{
	return this.submenu;
};

// TODO This function is not totally ready yet. I think it is provided with all the required information but calculation is still off
MenuSlice.prototype.drawArcText = function(context, text, centerX, centerY, radius, start)
{
	// TODO At least now when I grow 'thetaLength' text length grows more than the slice
	var textAngle = toRadians(this.textSize.width)*2; // TODO Fix the hard coded value
	if (textAngle > this.thetaLength)
		textAngle = this.thetaLength - this.sliceCap/2;
	
	context.save();
	context.translate(centerX, centerY);
	
	// Set the starting point for the text, same as for the arc below
	context.rotate(start);
	
	// Then adjust the starting still by the length of the text
	// TODO Just cannot seem to figure this one out...
	var lengthAdjustment = 0.63;
	if (this.text == "Cardeon")
		lengthAdjustment = 0.51;
	context.rotate(lengthAdjustment);
	
	for (var i=0; i<text.length; i++)
	{
		context.save();
		context.translate(0, -1 * radius);
		var char = text[i];
		context.fillText(char, 0, 0);
		context.restore();
		context.rotate(textAngle / text.length);
	}
	context.restore();
};

MenuSlice.prototype.toggleHighlight = function(show)
{
	if (show)
	{
		// When mouse is over the slice, wrap the whole canvas to anchor
		// So when hovering, browser will display link in status bar and change cursor as it normally does for links
		var ahref = $("<a />").attr("href", this.link).attr("title", this.title);
		$("canvas").wrap(ahref);
		// Bit of a hack, I know...
		
		this.mesh.scale.x += 0.05;
		this.mesh.scale.y += 0.05;
	}
	else
	{
		$("canvas").unwrap();
		this.mesh.scale.x -= 0.05;
		this.mesh.scale.y -= 0.05;
	}
};