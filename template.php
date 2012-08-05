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
	slow = false,
	timer = null;
	startTimer();
	$('body').on('click', 'a', function(event){
			event.preventDefault();
		postAnswer(this);
	});
	
	function handleReturn(returnedObject){
		$('.test').removeClass('current');
		$('#content').prepend(returnedObject);

		if($('.return-message').text() == 'Incorrect'){
			$currentTest.addClass('incorrect');
		}
		else{
			if (slow)	{
				$currentTest.addClass('slow');
			}
			else{
				$currentTest.addClass('correct');
			}
		}
	
		$('.return-message').remove();
		$currentTest = $('.test').first().addClass('current');
		startTimer();
		
	};
	function startTimer ()	{
		clearTimeout(timer);
		slow = false;
		timer = setTimeout(function(){ slow = true;},5000);
	}

	function postAnswer(clicked){
		var term = $('h1').data('term'),
		answer = $(clicked).data('answer'),
		set = $('h1').data('set'),
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
				//console.log(returnedObject);
				handleReturn(returnedObject);
			}
		});
	}
});
</script>
  </head>

  <body>

        <div id="content">
	   
	        <?php $this->showTest(); ?>

        </div>

    

  </body>
</html>