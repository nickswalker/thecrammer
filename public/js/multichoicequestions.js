function Questions(setID, numberOfChoices) {
	this.numberOfChoices = numberOfChoices;
	this.setID = setID;
	this.numberOfQuestions = 500;
	this.numberOfLocalQuestions = $('#storage .test').length;
}
Questions.prototype.showQuestion = function() {
		if ( this.numberOfLocalQuestions === 0) {
			this.getQuestions(this.showQuestion);
			return false;
		}
		if (this.numberOfLocalQuestions <= 2 && navigator.onLine) {
			getQuestions(null);
		}
		$('#storage .test:first-child').hide().prependTo('#content');
	
		$('#content .test:first-child').slideToggle(200, function() {
			$('body').trigger('shown');
			this.numberOfLocalQuestions--;
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
			url: "/multichoice/"+self.setID +"/getquestions",
			data: data,
			dataType: "text",
			success: function(returnedObject) {
				self.numberOfLocalQuestions = $('#storage .test').length;
				$('#storage').append(returnedObject);
				if (callback != null) {
					callback.call(self);
				}
			}
		});
	}
