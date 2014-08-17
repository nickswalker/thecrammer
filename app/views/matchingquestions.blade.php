<div class="test">
<ul class="questions">
	@foreach($questions as $question)
	<li data-index="{{$question['index'] }}" data-definition="{{ $question['definition'] }}">
	<input type="text" placeholder="&middot;" />
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