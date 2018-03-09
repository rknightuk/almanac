@extends('layouts.site')

@section('content')
	<h1>Browse all tags</h1>
	
	<ul>
		@foreach ($tags as $tag)
			<li><a href="/tags/{{ $tag }}">{{ $tag }}</a></li>
		@endforeach
	</ul>
@endsection
