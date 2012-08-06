<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="Crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="style.css">

    <title>Crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {

	var $currentTest = $('.test').addClass('current'),
	$rightCounter = $('.right'),
	$wrongCounter = $('.wrong'),
	$crammerData = $(document.body).data(),
	slow = false,
	slowToggled = false,
	wrongToggled = false,
	timer = null;

	getQuestions();
		$('body').keyup(function (event) {
					switch (event.keyCode) {
						case 87: toggleWrong();

						break;
						case 83: toggleSlow();

						break;
						default: 
						break;
					}
				});
	function toggleWrong(){
		if(slowToggled){
			$('.incorrect').slideToggle(200);
			wrongToggled = !wrongToggled;
			return true;
		}
		$('.correct').slideToggle(200);
		wrongToggled = !wrongToggled;
	}
	function toggleSlow(){
		if(wrongToggled){
			$('.slow').slideToggle(200);
			slowToggled = !slowToggled;
			return true;
		}
		$('.correct:not(.slow), .incorrect').slideToggle(200);
		slowToggled = !slowToggled;
	}

	$('body').on('click', 'a', function(event){
		event.preventDefault();
		clearTimeout(timer);
		postAnswer($(this));
	});

	function updateStats(isCorrect){
		if(isCorrect){
			$rightCounter.data().counter++;
			$rightCounter.text(String($rightCounter.data().counter));
		}
		else{
			$wrongCounter.data().counter++;
			$wrongCounter.text(String($wrongCounter.data().counter));
		}
	}

	function startTimer ()	{
		clearTimeout(timer);
		slow = false;
		allowedTime = ($crammerData.choices * 500) + 6000;
		timer = setTimeout(function(){ slow = true;},allowedTime);
	}
	function getQuestions()	{
		
		var numberOfQuestions = 1,
		numberOfChoices = $crammerData.choices,
		set = $crammerData.set,
		 data = { questions : numberOfQuestions,
				choices : numberOfChoices,
				set : set
		};

		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject){
				$('#content').prepend($(returnedObject).hide());
				$('.test').removeClass('current');
					$currentTest = $('.test').first().addClass('current').slideToggle(200);
					startTimer();
			}
		});

	}
	function postAnswer($clicked){
		
		if(!$clicked.data().answer){
			$currentTest.addClass('incorrect');
			updateStats(0);
		}
		else{
			$currentTest.addClass('correct');
			updateStats(1);
			if (slow)	{
				$currentTest.addClass('slow');
			}
		}
		getQuestions();
	
		var testData = $clicked.siblings('h1').data(),
		term = testData.term,
		answer = $clicked.data().answer,
		set = $crammerData.set,
		 data = { term: term,
				answer : answer,
				set : set,
				slow : slow
		};
		$.ajax({
			type: "POST",
			url: "index.php",
			data: data,
			dataType: "text",
			success: function(returnedObject){
			}
		});
	}
});
</script>
  </head>

<body data-set="<?php echo $this->vars['set']; ?>" data-choices="<?php if (isset($_GET['choices'])){ echo $_GET['choices']; } else {echo 2;}?>">
	<ul class="stats">
		<li class="right" data-counter="0">0</li>
		<li class="wrong" data-counter="0">0</li>
	</ul>
	<div id="content">
	</div>

</body>
</html>