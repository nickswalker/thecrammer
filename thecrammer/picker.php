<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="the crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="style.css">

    <title>the crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  </head>

  <body>

        <div id="content">
	   
	       <h1>the crammer</h1>
	       <form method="get" action="index.php">
	       <input type="text" placeholder="quizlet set ID" name="set" required></input>
	       <input type="number" name="choices" placeholder="# choices" required min="2" max="6"></input>
	       <input type="submit" value="Start"></input>
		</form>
		<h2>most recently studied</h2>
		<ul class="recent">
		<?php $this->listMostRecent(); ?>
		</ul>

        </div>
        <footer><a href="http://nickswalker.github.com/thecrammer/">about the crammer</a></footer>

    

  </body>
</html>