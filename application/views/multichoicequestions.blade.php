
@foreach($questions as $question)
<div class="test">


<h1 data-index="{{ $question['correctChoice'][0]['index'] }}" data-difficulty="{{ $question['correctChoice'][0]['counter'] }}">
	{{ $question['correctChoice'][0]['name'] }}
</h1>		


	@foreach($question['choices'] as $choice)
		<a class="choice" data-correct="{{ $choice['isCorrect'] }}" data-name="{{ $choice['name'] }}" data-definition="{{ $choice['definition'] }}" href="">{{ $choice['definition'] }}</a>
	@endforeach
</div>
@endforeach
			
