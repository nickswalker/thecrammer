$(document).ready(function() {
	var $currentTest = $('.test').addClass('current'),
		$correctCounter = $('.correct-count'),
		$incorrectCounter = $('.incorrect-count'),
		$slowCounter = $('.slow-count'),
		$crammerData = $(document.body).data(),
		slow = false,
		slowToggled = false,
		wrongToggled = false,
		timer = null,
		numberOfLocalAnswers = localStorage.length || 0,
		numberOfLocalQuestions = 0;
	document.title = $crammerData.settitle + " | the crammer"
	showQuestion();
	$('body').keyup(function(event) {
		switch (event.keyCode) {
		case 87:
			toggleWrong();
			break;
		case 83:
			toggleSlow();
			break;
		default:
			break;
		}
	});
	$('body').on('click', '.choice', function(event) {
		event.preventDefault();
		clearTimeout(timer);
		$('#content .test:first-child').removeClass('current');
		if (!$(this).data().correct) {
			$currentTest.addClass('incorrect');
			updateStats(0);
		} else {
			$currentTest.addClass('correct');
			updateStats(1);
			if (slow) {
				$currentTest.addClass('slow');
			}
		}
		var testData = $(this).siblings('h1').data(),
			answer = {
				index: testData.index,
				correct: $(this).data().correct,
				slow: slow
			}
		showQuestion();
		localStoreAnswer(answer);
	});
	$incorrectCounter.on('click', function(event) {
		toggleWrong();
	});
	$slowCounter.on('click', function(event) {
		toggleSlow();
	});

	function toggleWrong() {
		if (slowToggled) {
			$('.incorrect').slideToggle(200);
			$incorrectCounter.toggleClass('activated');
			wrongToggled = !wrongToggled;
			return true;
		}
		$('.correct').slideToggle(200);
		$incorrectCounter.toggleClass('activated');
		wrongToggled = !wrongToggled;
	}

	function toggleSlow() {
		if (wrongToggled) {
			$('.slow').slideToggle(200);
			$slowCounter.toggleClass('activated');
			slowToggled = !slowToggled;
			return true;
		}
		$('.correct:not(.slow), .incorrect').slideToggle(200);
		$slowCounter.toggleClass('activated');
		slowToggled = !slowToggled;
	}

	function updateStats(isCorrect) {
		if (!isCorrect) {
			$incorrectCounter.data().counter++;
			$incorrectCounter.text(String($incorrectCounter.data().counter));
		} else {
			if (slow) {
				$slowCounter.data().counter++;
				$slowCounter.text(String($slowCounter.data().counter));
			} else {
				$correctCounter.data().counter++;
				$correctCounter.text(String($correctCounter.data().counter));
			}
		}
	}

	function startTimer() {
		clearTimeout(timer);
		slow = false;
		allowedTime = ($crammerData.choices * 500) + 6000;
		timer = setTimeout(function() {
			slow = true;
		}, allowedTime);
	}

	function showQuestion() {
		if (numberOfLocalQuestions === 0){
			getQuestions(showQuestion);
			return false;
		}
		if (numberOfLocalQuestions <= 2 && navigator.onLine ) {
			getQuestions(null);
		}
		$('#storage .test:first-child').hide().prependTo('#content');
		--numberOfLocalQuestions; /* Removing old questions improves performance with more than 20 questions on mobile devices.*/
		/* $currentTest.remove(); */
		$currentTest = $('#content .test:first-child').addClass('current').slideToggle(200, function() {
			startTimer();
		});
	}

	function getQuestions(callback) {
		var numberOfQuestions = 30,
			numberOfChoices = $crammerData.choices,
			set = $crammerData.set,
			data = {
				questions: numberOfQuestions,
				choices: numberOfChoices,
				set: set
			};
		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject) {
				$('#storage').append(returnedObject);
				numberOfLocalQuestions = $('#storage .test').length;
				callback();
			}
		});
	}

	function localStoreAnswer(answer) {
		localStorage[numberOfLocalAnswers] = JSON.stringify(answer);
		++numberOfLocalAnswers;
		if (numberOfLocalAnswers >= 5 && navigator.onLine ) {
			postAnswers(localStorage);
		}
	}

	function postAnswers(localStore) {
		var preparedSubmitData = new Array;
		for (i = 0; i <= localStore.length - 1; i++) {
			key = localStore.key(i);
			val = localStore.getItem(key);
			preparedSubmitData.push( JSON.parse(val) );
			
		}
		data = {
			answers: preparedSubmitData,
			set: $crammerData.set
		}
		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject) {
				localStorage.clear();
				numberOfLocalAnswers = 0;
			}
		});
	}
});