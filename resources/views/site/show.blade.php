@extends('layouts.site', ['singlePost' => $post])

@section('content')
	@include('site._partials.post', [
		'post' => $post,
		'showRelated' => true,
	])
@endsection
