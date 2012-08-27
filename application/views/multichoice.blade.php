@layout('layouts/main')
@section('content')
<?php Asset::container('header')->add('timer.js', 'js/timer.js'); ?>
<?php Asset::container('header')->add('multichoice.css', 'css/multichoice.css'); ?>
<?php Asset::container('header')->add('stats.css', 'css/stats.css'); ?>
<?php Asset::container('header')->add('stats.js', 'js/stats.js'); ?>
<?php Asset::container('header')->add('answers.js', 'js/answers.js'); ?>
<?php Asset::container('header')->add('multichoicequestions.js', 'js/multichoicequestions.js'); ?>

<body data-set="{{ $setID }}" data-choices="{{ $choices }}" data-settitle="{{ $setTitle }}" data-setdescription="{{ $setDescription }}">
	<ul class="stats">
		<li class="correct-count" data-counter="0">0</li>
		<li class="slow-count" data-counter="0">0</li>
		<li class="incorrect-count" data-counter="0">0</li>
		<li class="set-info"><a href="/{{ $setID }}">?</a></li>
		<li class="home"><a href="/">H</a></li>
	</ul>
	<div id="content">
	</div>
	<div id="storage"></div>
	<script>
$(document).ready(function () {

    $crammerData = $(document.body).data();
    document.title = $crammerData.settitle + " | the crammer";
    var timer = new Timer(($crammerData.choices * 500) + 6000);
    
    var answers = new Answers($crammerData.set);
    var questions = new Questions($crammerData.set, $crammerData.choices);

    var $correctCounter = $('.correct-count'),
        $incorrectCounter = $('.incorrect-count'),
        $slowCounter = $('.slow-count');
    var stats = new Stats($incorrectCounter, $correctCounter, $slowCounter);
    
    $incorrectCounter.on('click', function (event) {
        stats.toggleWrong();
    });
    $slowCounter.on('click', function (event) {
        stats.toggleSlow();
    });
    $('body').keyup(function (event) {
        switch (event.keyCode) {
        case 87:
            stats.toggleWrong();
            break;
        case 83:
            stats.toggleSlow();
            break;
        case 68:
            $(document.body).toggleClass('show-difficulty');
            break;
        default:
            break;
        }
    });

    $('body').on('click', '.choice', function (event) {
        console.log(localStorage);
        if (answers.numberOfLocalAnswers >= 5 && navigator.onLine) {
            answers.postAnswers();
        }
        event.preventDefault();
        timer.stop();
        $('.test').removeClass('current');

        if (!$(this).data().correct) {
            $('#content .test:first-child').addClass('incorrect');
            stats.updateStats(0, timer.slow);
        } else {
            stats.updateStats(1, timer.slow);
            $('#content .test:first-child').addClass('correct');
            if (timer.slow) {
                $('#content .test:first-child').addClass('slow');
            }
        }
        if(!timer.slow || !$(this).data().correct){
        answers.buildAnswer($(this).siblings('h1').data().index, $(this).data().correct);
        }
        questions.showQuestion();
    });

    $('body').bind('shown', function (event) {
        timer.start();
    });

   questions.showQuestion();

});    </script>

@endsection