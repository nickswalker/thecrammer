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
	slow = false,
	timer = null;
	getQuestions();
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
	function handleReturn(returnedObject){

		
	};
	function startTimer ()	{
		clearTimeout(timer);
		slow = false;
		timer = setTimeout(function(){ slow = true;},10000);
	}
	function getQuestions()	{
		
		var numberOfQuestions = 1,
		numberOfChoices = 2,
		set = 'psat',
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
				$('#content').prepend(returnedObject);
				$('.test').removeClass('current');
					$currentTest = $('.test').first().addClass('current');
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
		answer = testData.answer,
		set = testData.set,
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
				console.log(returnedObject);
				handleReturn(returnedObject);
			}
		});
	}
});
</script>
  </head>

  <body>
	  <ul class="stats">
	  <li class="right" data-counter="0">0</li>
	  <li class="wrong" data-counter="0">0</li>
	  </ul>
        <div id="content">
	   
	       

        </div>

    

  </body>
</html>