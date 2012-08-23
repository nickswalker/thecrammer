@layout('layouts/main')
@section('content')
<?php Asset::container('header')->add('picker.css', 'css/picker.css'); ?>
<div id="content">
 <h1 class="color-shift">the crammer</h1>
	       	<input id="set" type="text" placeholder="Quizlet Set ID" />
	       	<a id="go" href="">Start</a>

	       		<h2>most recently studied</h2>
        <footer><a href="http://nickswalker.github.com/thecrammer/">about the crammer</a> </footer>
    <script>
	    $(document).ready(function(){
		    $('#set').change(function(){
			   $('#go').attr('href', 'multichoice/'+$(this).val() );
		    });
	    });
    </script>
</div>
@endsection