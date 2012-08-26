@layout('layouts/main')
@section('content')
<?php Asset::container('header')->add('picker.css', 'css/picker.css'); ?>
<div id="content">
 <h1 class="color-shift">the crammer</h1>
 <div class="form">
	       	<input id="set" type="text" placeholder="quizlet set ID" />
	       	<a id="go" href="">Start</a>
 </div>

	       		<h2>most recently studied</h2>

	       		<?php
foreach ($recentlyStudied as $key => $row) {
    $date[$key]  = $row['date'];
}

// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
array_multisort($date, SORT_DESC, $recentlyStudied);
?>
<ul class="recent">
@foreach($recentlyStudied as $item)
<li data-description="{{ $item['description'] }}" data-set="{{ substr($item['name'] , 0, -4) }}">{{ $item['title'] }}</li>
@endforeach
</ul>
	 
        <footer><a href="http://nickswalker.github.com/thecrammer/">about the crammer</a> </footer>
    <script>
	    $(document).ready(function(){
		    $('#set').change(function(){
			   $('#go').attr('href', 'multichoice/'+$(this).val() );
		    });
		    $("#set").keyup(function(event){
		    
			    if(event.keyCode == 13){
					window.location= $('#go').attr('href');
				}
});
	$('.recent').on('click', 'li', function(){
		$('#set').attr('value', $(this).data('set') ).change();
	});
	    });
    </script>
</div>
@endsection