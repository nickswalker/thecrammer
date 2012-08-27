//Get width of Slider Container and set li width to this on every window resize if possible (at load is fine too)
function Slider ( container, $leftArrow, $rightArrow) {
	this.current = 0,
	this.$leftArrow = $leftArrow,
	this.$rightArrow = $rightArrow,
	this.$slider = $('#content'),
	this.maxIndex = 0,
	this.liWidth = 600;
	this.toggleArrows();
}

Slider.prototype.updateCurrent = function (direction) {
	this.$sliderList = $('#content .test'),
	this.maxIndex = $('#content .test').length - 1;
	
	this.current += ( ~~ (direction === 'next') || -1 );
	if (this.current<0) this.current =0;
	if (this.current>this.maxIndex) this.current = this.maxIndex;
	this.shift();
};
Slider.prototype.shift = function	( target)	{
	if (target || target===0) this.current = target;
	this.$slider.css('marginLeft', -(this.current * this.liWidth) );
	this.toggleArrows();
};

Slider.prototype.toggleArrows = function	()	{
	this.$sliderList = $('#content .test'),
	this.maxIndex = $('#content .test').length - 1;
	(this.current === this.maxIndex) ? this.$rightArrow.attr('disabled', 'disabled') : this.$rightArrow.removeAttr('disabled');
	(this.current === 0) ? this.$leftArrow.attr('disabled', 'disabled') : this.$leftArrow.removeAttr('disabled');
		if(this.maxIndex === -1 ){
		this.$rightArrow.attr('disabled', 'disabled');
	}
};
