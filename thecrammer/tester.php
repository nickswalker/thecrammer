<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="the crammer: Dead simple study tool." />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="apple-touch-icon-precomposed" href="/thecrammer/assets/icon.png"/>
    <link rel="apple-touch-startup-image" href="/thecrammer/assets/splash.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" media="screen" href="style.css">
    <title>the crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="/thecrammer/model-interaction.js"></script>
    <script src="/thecrammer/stats.js"></script>
    <script src="/thecrammer/timer.js"></script>
    <script>
    	$(document).ready(function() {
    	$crammerData = $(document.body).data();
    	var timer = new Timer( ($crammerData.choices * 500) + 6000);
    	var crammer = new Crammer($crammerData.set, $crammerData.settitle, $crammerData.choices, timer.start);
    	
    	var $correctCounter = $('.correct-count'),
		$incorrectCounter = $('.incorrect-count'),
		$slowCounter = $('.slow-count');
    	var stats = new Stats($incorrectCounter, $correctCounter, $slowCounter);
    	
    	$incorrectCounter.on('click', function(event) {
			stats.toggleWrong();
		});
	$slowCounter.on('click', function(event) {
		stats.toggleSlow();
	});
	$('body').keyup(function(event) {
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
	
	
		$('body').on('click', '.choice', function(event) {
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
		crammer.choiceMade(  $(this).siblings('h1').data().index ,$(this).data().correct);
		crammer.showQuestion();
	});
 
		$('body').bind('shown', function(event) {
			timer.start();
			});

	crammer.showQuestion();
	
	});
    </script>
</head>

<body data-set="<?php echo $this->vars['set']; ?>" data-choices="<?php if (isset($_GET['choices'])){ echo $_GET['choices']; } else {echo 4;}?>" data-settitle="<?php echo $this->vars['set_title']; ?>" data-setdescription="<?php echo $this->vars['set_description']; ?>">
	<ul class="stats">
		<li class="correct-count" data-counter="0">0</li>
		<li class="slow-count" data-counter="0">0</li>
		<li class="incorrect-count" data-counter="0">0</li>
		<li class="set-info"><a href="/?set=<?php echo $this->vars['set']; ?>&amp;stats=yes">?</a></li>
		<li class="home"><a href="/">H</a></li>
	</ul>
	<div id="content">
	</div>
	<div id="storage"></div>
</body>
</html>