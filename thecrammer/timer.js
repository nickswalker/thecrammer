Timer = function(allowedTime) {
	this.timer = null; 
	this.slow = null;
	this.allowedTime = allowedTime;
}
Timer.prototype.start = function() {
	var self = this;
	clearTimeout(this.timer);
	this.slow = false;
	this.timer = setTimeout(function() {
		self.slow = true;
	}, this.allowedTime);
}

Timer.prototype.stop = function(){
	clearTimeout(this.timer);
}