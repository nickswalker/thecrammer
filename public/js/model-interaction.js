function Crammer(setID, setTitle, numberOfChoices) {
	this.setTitle = setTitle;
	this.setID = setID;
	this.numberOfChoices = numberOfChoices;
	this.numberOfLocalAnswers = localStorage.length || 0;
	this.numberOfQuestions = 30;
	this.numberOfLocalQuestions = 0;
	document.title = this.setTitle + " | the crammer";
}
Crammer.prototype.showQuestion = function() {
	var self = this;
	if (this.numberOfLocalQuestions === 0) {
		this.getQuestions(this.showQuestion);
		return false;
	}
	if (this.numberOfLocalQuestions <= 2 && navigator.onLine) {
		this.getQuestions(null);
	}
	$('#storage .test:first-child').hide().prependTo('#content');
	--this.numberOfLocalQuestions; /* Removing old questions improves performance with more than 20 questions on mobile devices.*/
	/* $currentTest.remove(); */
	$('#content .test:first-child').slideToggle(200, function() {
		$('body').trigger('shown');
	});
}
Crammer.prototype.getQuestions = function(callback) {
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
			$('#storage').append(returnedObject);
			self.numberOfLocalQuestions = $('#storage .test').length;
			if (callback != null) {
				callback.call(self);
			}
		}
	});
}
Crammer.prototype.localStoreAnswer = function(answer) {
	localStorage[this.numberOfLocalAnswers] = JSON.stringify(answer);
	++this.numberOfLocalAnswers;
	if (this.numberOfLocalAnswers >= 5 && navigator.onLine) {
		this.postAnswers(localStorage);
	}
}
Crammer.prototype.choiceMade = function(index, isCorrect) {
	answer = {
		index: index,
		correct: isCorrect,
	}
	this.localStoreAnswer(answer);
}
Crammer.prototype.postAnswers = function(localStore) {
	var self = this;
	var preparedSubmitData = new Array;
	for (i = 0; i <= localStore.length - 1; i++) {
		key = localStore.key(i);
		val = localStore.getItem(key);
		preparedSubmitData.push(JSON.parse(val));
	}
	data = {
		answers: preparedSubmitData,
		set: this.setID
	}
	$.ajax({
		type: "POST",
		url: "/multichoice/"+self.setID +"/postanswers",
		data: data,
		dataType: "text",
		success: function(returnedObject) {
			console.log(returnedObject);
			localStorage.clear();
			self.numberOfLocalAnswers = 0;
		}
	});
}