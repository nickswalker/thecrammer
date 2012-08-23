
@foreach($questions as $question)
<div class="test">


<h1 data-index="{{ $question[0]['index'] }}" data-difficulty="{{ $question[0]['counter'] }}">
	{{ $question[0]['name'] }}
</h1>		

<?php shuffle($question);?>
	@foreach($question as $choice)
		<a class="choice" data-correct="{{ $choice['isCorrect'] }}" data-name="{{ $choice['name'] }}" data-definition="{{ $choice['definition'] }}" href="">{{ $choice['definition'] }}</a>
	@endforeach
</div>
@endforeach
			
