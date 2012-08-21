@layout('layouts/main')
@section('content')
<div id="content">
 <h1 class="color-shift">the crammer</h1>
	       		
	       		{{ Form::open('multichoice', 'POST') }}
	       		{{ Form::text('set', '', array('placeholder' => 'Quizlet Set ID')); }}
	       		{{ Form::submit('Start'); }}
	       		{{ Form::close() }}
	       		<h2>most recently studied</h2>
        <footer><a href="http://nickswalker.github.com/thecrammer/">about the crammer</a> </footer>
    <script>
	    $(document).ready(function(){
		    $('input').change(function(){
			   $('form').attr('action', 'multichoice/'+$(this).val() );
		    });
	    });
    </script>
</div>
@endsection