@layout('layouts/main')
@section('content')
<?php Asset::container('header')->add('answers.js', 'js/answers.js'); ?>
<?php Asset::container('header')->add('matchingquestions.js', 'js/matchingquestions.js'); ?>
<?php Asset::container('header')->add('slider.js', 'js/slider.js'); ?>
<?php Asset::container('header')->add('matching.css', 'css/matching.css'); ?>
<?php Asset::container('header')->add('stats.css', 'css/stats.css'); ?>

<body data-set="{{ $setID }}" data-number="10" data-settitle="{{ $setTitle }}" data-setdescription="{{ $setDescription }}">
	<ul class="stats">
		<li class="correct-count" data-counter="0">0</li>
		<li class="incorrect-count" data-counter="0">0</li>
		<li class="set-info"><a href="/{{ $setID }}">?</a></li>
		<li class="home"><a href="/">H</a></li>
	</ul>
	<div id="content">
	</div>
	<div class="controls">
	   <button class="left">&lt;</button>

	   <button class="done">Done</button>
	   <button class="right">&gt;</button>
   </div>
   <div id="storage"></div>

   <script>
   $(document).ready(function () {

	$crammerData = $(document.body).data();
	document.title = $crammerData.settitle + " | the crammer";

	questions = new Questions($crammerData.set, $crammerData.number);
	answers = new Answers($crammerData.set, $crammerData.number);

	$rightArrow = $('.right');
	$leftArrow = $('.left');
	slider = new Slider($('#content'), $leftArrow, $rightArrow);

	$rightArrow.on('click', function () {
		slider.updateCurrent('next');
	});
	$leftArrow.on('click', function () {
		slider.updateCurrent('previous');
	});

	$('.done').on('click', function () {
		grade($('#content .test:first-child'));
		questions.showTest();
		$(this).fadeOut(200, function () {
			$(this).remove();
			slider.toggleArrows();
			$('.right');
		});
	});
	$('body').bind('shown', function (event) {
		setUpNewTest();
	});


	function setUpNewTest() {
		$('input').bind('input', function () {
			$('.answers li').removeClass();
			$('input').each(function (index) {
				$input = $(this).val();
				$(this).removeClass();
				if ($input.length) {
					$success = $('li[data-key="' + $input + '"]').addClass('used');

					if (!$success.length) {
						$(this).addClass('no-match');

					}
				}
			});
		});

	}
	function grade ($test) {
		var self = this;
		$test.find('.questions li').each(function (index) {

			$inputKey = parseInt($(this).children('input').val());
			$correctIndex = $(this).data('index');
			$correctAnswer = $test.find('.answers li[data-index="' + $correctIndex + '"]');
			$correctKey = $correctAnswer.data('key');
			if ($inputKey === $correctKey) {
				answers.buildAnswer($correctIndex, true);
				markAnswer($(this), $correctAnswer, true);

			} else {
				answers.buildAnswer($correctIndex, false);
				markAnswer($(this), $correctAnswer, false);
			}

		});
		if (navigator.onLine) {
			answers.postAnswers();
		}
	}
	function markAnswer ($targetQuestion, $targetAnswer, isCorrect) {
		if (isCorrect) {
			$targetQuestion.addClass('correct');
			$targetAnswer.addClass('correct');
		} else {
			$targetQuestion.addClass('incorrect').children('input').attr('value', $targetAnswer.data('key'));
			$targetAnswer.addClass('incorrect');

		}

	}


	questions.showTest();
	slider.toggleArrows();
});
</script>
@endsection