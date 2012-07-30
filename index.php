<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="NeueGal : A simple, no-database PHP image gallery." />
    <link rel="stylesheet" media="screen" href="../global.css">

    <title>Crammer</title>
  </head>

  <body>

        <div id="content">
	   
	<?php 
	require('crammer.php');

$crammer = new Crammer;


$crammer->initialize();
$crammer->showTest();

?>
        </div>

    

  </body>
</html>
