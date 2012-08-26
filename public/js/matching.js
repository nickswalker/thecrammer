function Matching(setID) {
	this.setID = setID;
	this.numberOfLocalAnswers = localStorage.length || 0;
	this.numberOfLocalQuestions = 0;
}
Matching.prototype.localStoreAnswer = function(answer) {
	localStorage[this.numberOfLocalAnswers] = JSON.stringify(answer);
	++this.numberOfLocalAnswers;

}
Matching.prototype.grade = function(index, isCorrect) {
	var self = this;
	$('.questions li').each(function(index) {
		
		$inputKey = parseInt( $(this).children('input').val() );
		$correctIndex = $(this).data('index');
		$correctAnswer = $('.answers li[data-index="' + $correctIndex + '"]');
		$correctKey = $correctAnswer.data('key');
		if ($inputKey === $correctKey) {
			self.choiceMade($correctIndex, true);
			self.markAnswer($(this), $correctAnswer, true);
			
		} else {
			self.choiceMade($correctIndex, false);
			self.markAnswer($(this), $correctAnswer, false);
		}
		
	});
		if ( navigator.onLine) {
		this.postAnswers(localStorage);
	}
}
Matching.prototype.markAnswer = function($targetQuestion, $targetAnswer, isCorrect) {
	if(isCorrect){
		$targetQuestion.addClass('correct');
		$targetAnswer.addClass('correct');
	}
	else{
		$targetQuestion.addClass('incorrect').children('input').attr('value', $targetAnswer.data('key') );
		$targetAnswer.addClass('incorrect');
		
	}
	
}
Matching.prototype.choiceMade = function(index, isCorrect) {
	answer = {
		index: index,
		correct: isCorrect,
	}
	this.localStoreAnswer(answer);
}
Matching.prototype.postAnswers = function(localStore) {
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
	console.log(data);
	$.ajax({
		type: "POST",
		url: "/postanswers/" + self.setID ,
		data: data,
		dataType: "text",
		success: function(returnedObject) {
			localStorage.clear();
			self.numberOfLocalAnswers = 0;
		}
	});
}