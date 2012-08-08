$(document).ready(function() {
	localStore = new Array();
	var $currentTest = $('.test').addClass('current'),
		$correctCounter = $('.correct-count'),
		$incorrectCounter = $('.incorrect-count'),
		$slowCounter = $('.slow-count'),
		$crammerData = $(document.body).data(),
		slow = false,
		slowToggled = false,
		wrongToggled = false,
		timer = null,
		numberOfLocalAnswers = 0;
	getQuestions();
	document.title = $crammerData.settitle + " | the crammer"
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
				$('#content').prepend($(returnedObject).hide()); /* 				console.log(returnedObject); */
				$currentTest = $('.test').first().addClass('current').slideToggle(200);
				startTimer();
			}
		});
	}

	function localStoreAnswer(answer) {
		localStore.push(answer);
		++numberOfLocalAnswers;
		if (numberOfLocalAnswers >= 10) {
			JSON.stringify({
				answers: localStore
			});
			postAnswers(localStore);
			localStore = new Array();
			numberOfLocalAnswers = 0;
		}
	}

	function postAnswers(localStore) {
		data = {
			answers: localStore,
			set: $crammerData.set
		}
		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject) { /* console.log(returnedObject); */
			}
		});
	}
});