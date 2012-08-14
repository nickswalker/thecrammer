<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="the crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="style.css">

    <title>Crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  </head>

  <body>
	  <?php $statsFormat = '
	  <h2>total answered</h2>
	  {{Total}}
	  	<h2>hardest</h2>
	  	<ul>{{Top}}</ul>
	  	<h2>easiest</h2>
	  	<ul>{{Bottom}}</ul>
	  ';
	  ?>
        <div id="content">
	        <h1>stats</h1>
	        <?php $this->showStats($statsFormat);?>
	        <a href="/">back to set</a>
        </div>

    

  </body>
</html>