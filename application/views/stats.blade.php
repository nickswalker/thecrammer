@layout('layouts/main')
@section('content')
	<h1>stats</h1>

	<h2>total</h2>
	{{ $stats['total'] }}
	<h2>easiest</h2>
	<ul>
@foreach ($stats['bottom'] as $bottom)
	<li>{{ $bottom }}</li>
@endforeach
	</ul>
	<h2>hardest</h2>
	<ul>
@foreach ($stats['top'] as $top)
	<li>{{ $top }}</li>
@endforeach
	</ul>

	
	</div>
@endsection