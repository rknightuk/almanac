@foreach($related->values() as $key => $r)
	<div class="almn-post almn-post__related @if ($key === 0) almn-post__related--first-{{$type}} @endif">
		<div class="almn-post--titles--main almn-post--titles--main__related">
			<a href="{{ $r->permalink }}">
				{{ ucfirst($r->verb) }} on {{ $r->date_completed->format('jS F Y') }}
			</a>
		</div>
	</div>
@endforeach
