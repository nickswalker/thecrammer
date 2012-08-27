function Answers(setID) {
	this.setID = setID;
	this.numberOfLocalAnswers = localStorage.length || 0;
}

Answers.prototype.localStoreAnswer = function(answer) {
	localStorage[this.numberOfLocalAnswers] = JSON.stringify(answer);
	++this.numberOfLocalAnswers;

}
Answers.prototype.buildAnswer = function(index, isCorrect) {
	answer = {
		index: index,
		correct: isCorrect,
	}
	this.localStoreAnswer(answer);
}
Answers.prototype.postAnswers = function(localStore) {
	if(!localStore)	{
		localStore = localStorage;
	}
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
		url: "/postanswers/" + self.setID,
		data: data,
		dataType: "text",
		success: function(returnedObject) {
			console.log(returnedObject);
			localStorage.clear();
			self.numberOfLocalAnswers = 0;
		}
	});
}