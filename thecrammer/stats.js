 function Stats($incorrectCounter, $correctCounter, $slowCounter) {
 	this.slowToggled = false;
 	this.wrongToggled = false;
 	this.$correctCounter = $correctCounter;
 	this.$incorrectCounter = $incorrectCounter;
 	this.$slowCounter = $slowCounter;
 }
 Stats.prototype.toggleWrong = function() {
 	if (this.slowToggled) {
 		$('.incorrect').slideToggle(200);
 		this.$incorrectCounter.toggleClass('activated');
 		this.wrongToggled = !this.wrongToggled;
 		return true;
 	}
 	$('.correct').slideToggle(200);
 	this.$incorrectCounter.toggleClass('activated');
 	this.wrongToggled = !this.wrongToggled;
 }
 Stats.prototype.toggleSlow = function() {
 	if (this.wrongToggled) {
 		$('.slow').slideToggle(200);
 		this.$slowCounter.toggleClass('activated');
 		this.slowToggled = !this.slowToggled;
 		return true;
 	}
 	$('.correct:not(.slow), .incorrect').slideToggle(200);
 	this.$slowCounter.toggleClass('activated');
 	this.slowToggled = !this.slowToggled;
 }
 Stats.prototype.updateStats = function(isCorrect, isSlow) {
 	if (!isCorrect) {
 		this.$incorrectCounter.data().counter++;
 		this.$incorrectCounter.text(String(this.$incorrectCounter.data().counter));
 	} else {
 		if (isSlow) {
 			this.$slowCounter.data().counter++;
 			this.$slowCounter.text(String(this.$slowCounter.data().counter));
 		} else {
 			this.$correctCounter.data().counter++;
 			this.$correctCounter.text(String(this.$correctCounter.data().counter));
 		}
 	}
 }