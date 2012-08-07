$(document).ready(function() {
	var $currentTest = $('.test').addClass('current'),
		$correctCounter = $('.correct-count'),
		$incorrectCounter = $('.incorrect-count'),
		$slowCounter = $('.slow-count'),
		$crammerData = $(document.body).data(),
		slow = false,
		slowToggled = false,
		wrongToggled = false,
		timer = null;
		getQuestions();
		document.title = $crammerData.settitle + " | Crammer"
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
	$('body').on('click', 'a', function(event) {
		event.preventDefault();
		clearTimeout(timer);
		$('.test').removeClass('current');
		getQuestions();
		postAnswer($(this));
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

	function getQuestions() {
		var numberOfQuestions = 1,
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
				$('#content').prepend($(returnedObject).hide());
				$currentTest = $('.test').first().addClass('current').slideToggle(200);
				startTimer();
			}
		});
	}

	function postAnswer($clicked) {
		if (!$clicked.data().correct) {
			$currentTest.addClass('incorrect');
			updateStats(0);
		} else {
			$currentTest.addClass('correct');
			updateStats(1);
			if (slow) {
				$currentTest.addClass('slow');
			}
		}

		var testData = $clicked.siblings('h1').data(),
			index = testData.index,
			correct = $clicked.data().correct,
			set = $crammerData.set,
			data = {
				index: index,
				correct: correct,
				set: set,
				slow: slow
			};
		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject) {
				console.log(returnedObject);
			}
		});
	}
});