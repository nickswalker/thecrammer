@layout('layouts/main')
@section('content')
<?php Asset::container('header')->add('matching.js', 'js/matching.js'); ?>
<?php Asset::container('header')->add('matching.css', 'css/matching.css'); ?>

<body data-set="{{ $setID }}" data-number="10" data-settitle="{{ $setTitle }}" data-setdescription="{{ $setDescription }}">
	<div id="content">
	<ul class="questions">
	@foreach($questions as $question)
	<li data-index="{{$question['index'] }}" data-definition="{{ $question['definition'] }}">
	<input type="text" />
	<span>{{ $question['name' ]}}</span>
	</li>
	@endforeach
	</ul>
	
	<?php shuffle($questions) ?>
	<ul class="answers">
	@foreach($questions as $key => $answer)
	<li data-index="{{ $answer['index'] }}"data-name="{{ $answer['name'] }}" data-key="{{ $key }}" data-definition="{{ $answer['definition'] }}">
	<b>{{ $key }}</b>. {{ $answer['definition'] }}
	</li>
	@endforeach
	</ul>
	</div>
	<div class="controls">
		<button class="done">Done</button>
	</div>
<script>
	$(document).ready(function(){
		$crammerData = $(document.body).data();
		document.title = $crammerData.settitle + " | the crammer";
		matching = new Matching($crammerData.set);
		$('.done').on('click', function(){
			matching.grade();
		});
		$('input').bind('input', function() { 
		$('.answers li').removeClass();
			$('input').each(function(index) {
				$input = $(this).val();
				$(this).removeClass();
				if($input.length){
					
					$success = $('li[data-key="'+ $input +'"]').addClass('used');
					
					if ( !$success.length ){
						$(this).addClass('no-match');
					}
				}
				
				
			});
			
		});
	});
</script>
@endsection