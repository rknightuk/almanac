@extends('layouts.site')

@section('content')
	<div class="almn-post">
		<div class="almn-post--titles">
			<div class="almn-post--titles--main">
				Browse all tags
			</div>
		</div>

		<div class="almn-post--content">
			<ul>
				@foreach ($tags as $tag)
					<li><a href="/tags/{{ $tag }}">{{ $tag }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection
