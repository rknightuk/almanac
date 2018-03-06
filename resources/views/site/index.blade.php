@extends('layouts.site')

@section('content')
	ALL POSTS

	@foreach ($posts as $post)
		{{ $post['title'] }}
	@endforeach
@endsection
