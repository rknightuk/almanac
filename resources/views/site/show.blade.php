@extends('layouts.site', ['singlePost' => $post])

@section('content')
	@include('site._partials.post', [
		'post' => $post,
		'singlePost' => true,
	])
@endsection
