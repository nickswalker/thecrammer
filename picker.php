<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="Crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="style.css">

    <title>Crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  </head>

  <body>

        <div id="content">
	   
	       <h1>crammer</h1>
	       <form method="get" action="index.php">
	       <input type="text" placeholder="Quizlet Set ID" name="set" required></input>
	       <input type="number" name="choices" placeholder="Number of Choices" required min="2" max="6"></input>
	       <input type="submit"></input>
		</form>

        </div>

    

  </body>
</html>