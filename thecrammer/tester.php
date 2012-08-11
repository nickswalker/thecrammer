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
    <script src="/thecrammer/test-interface.js"></script>
</head>

<body data-set="<?php echo $this->vars['set']; ?>" data-choices="<?php if (isset($_GET['choices'])){ echo $_GET['choices']; } else {echo 4;}?>" data-settitle="<?php echo $this->vars['set_title']; ?>" data-setdescription="<?php echo $this->vars['set_description']; ?>">
	<ul class="stats">
		<li class="correct-count" data-counter="0">0</li>
		<li class="slow-count" data-counter="0">0</li>
		<li class="incorrect-count" data-counter="0">0</li>
		<li class="set-info">?</li>
		<li class="home"><a href="/">H</a></li>
	</ul>
	<div id="content">
	</div>
	<div id="storage"></div>
</body>
</html>