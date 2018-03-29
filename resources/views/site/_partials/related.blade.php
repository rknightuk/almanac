@foreach($related->values() as $key => $r)
	<div class="almn-post almn-post__related @if ($key === 0) almn-post__related--first-{{$type}} @endif almn-post__{{ $r->rating_string }}">
		<div class="almn-post--titles--main almn-post--titles--main__related">
			<a href="{{ $r->permalink }}">
				{{ $r->title }} - {{ $r->date_completed->format('l jS F Y') }}
			</a>
		</div>
	</div>
@endforeach