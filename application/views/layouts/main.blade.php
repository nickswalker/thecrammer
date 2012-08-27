<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />
    <meta name="description" content="the crammer: Dead simple study tool." />
    <link rel="stylesheet" media="screen" href="/css/style.css">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>the crammer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      {{ Asset::container('header')->styles(); }}
        {{ Asset::container('header')->scripts(); }}
  </head>

  <body>

	        @yield('content')
 

    

  </body>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34345605-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</html>