@extends('layouts.site')

@section('content')
	@foreach ($posts as $post)
		@include('site._partials.post', ['post' => $post])
	@endforeach
@endsection
