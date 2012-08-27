function Questions(setID, numberOfChoices) {
	this.numberOfChoices = numberOfChoices;
	this.setID = setID;
	this.numberOfQuestions = 500;
	this.numberOfLocalTests = $('#storage .test').length;
}

Questions.prototype.showTest = function() {
	var self = this;
	if (this.numberOfLocalTests === 0) {
		this.getQuestions(this.showTest);
		return false;
	}
	if (this.numberOfLocalTests <= 2 && navigator.onLine) {
		this.getQuestions(null);
	}
	$('#storage .test:first-child').hide().appendTo('#content');
	--this.numberOfLocalTests; /* Removing old questions improves performance with more than 20 questions on mobile devices.*/
	/* $currentTest.remove(); */
	$('#content .test:last-child').fadeIn(200, function() {
		$('body').trigger('shown');
	});
}
Questions.prototype.getQuestions = function(callback) {
	var self = this,
		data = {
			questions: this.numberOfQuestions,
			choices: this.numberOfChoices,
			set: this.setID
		};
	$.ajax({
		type: "POST",
		url: "/matching/"+self.setID +"/getquestions",
		data: data,
		dataType: "text",
		success: function(returnedObject) {
			$('#storage').append(returnedObject);
			self.numberOfLocalTests = $('#storage .test').length;
			if (callback != null) {
				callback.call(self);
			}
		}
	});
}
