function Task(customer, type, description, start, duration)
{
	this.customer = (customer) ? customer : "";
	this.type = (type) ? type : "Testing";
	this.description = (description) ? description : "";
	this.start = (start) ? start : new Date();
	this.duration = (duration) ? duration : 0;
	this.active = false;
	this.promise = null;
}

// Expecting to be called every 1000ms
Task.prototype.work = function(count)
{
	this.duration += 1000;
};

Task.prototype.activate = function()
{
	this.active = true;
};

Task.prototype.deactivate = function()
{
	this.active = false;
};

Task.prototype.clear = function()
{
	this.customer = "";
	this.type = "Testing";
	this.description = "";
	//this.start = null;
	//this.duration = 0;
	//this.active = false;
};