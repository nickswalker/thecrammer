<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="Crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="style.css">
    <title>Crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="test-interface.js"></script>
</head>

<body data-set="<?php echo $this->vars['set']; ?>" data-choices="<?php if (isset($_GET['choices'])){ echo $_GET['choices']; } else {echo 2;}?>">
	<ul class="stats">
		<li class="correct-count" data-counter="0">0</li>
		<li class="slow-count" data-counter="0">0</li>
		<li class="incorrect-count" data-counter="0">0</li>
	</ul>
	<div id="content">
	</div>

</body>
</html>