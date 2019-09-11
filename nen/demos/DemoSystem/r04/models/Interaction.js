"use strict";
function Interaction(model, position, rotation, text, sound)
{
	this.model = model;
	this.position = position;
	this.rotation = rotation;
	this.text = text;
	this.sound = sound;
	// TODO Animation, like constant rotation
}
Interaction.prototype.apply = function(mesh)
{
	if (mesh)
	{
		if (this.position)
		{
			mesh.position.copy(this.position);
		}
		if (this.rotation)
		{
			mesh.rotation.y += 0.1;
			//mesh.rotation.copy(this.rotation);
		}
	}
	if (this.text)
	{
		console.log("TODO Show interaction text", this.text);
	}
	if (this.sound)
	{
		SoundPlayer.setSource(this.sound);
		SoundPlayer.play();
	}
};
