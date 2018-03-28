@extends('layouts.site', ['title' => $post->title])

@section('content')
	@include('site._partials.post', ['post' => $post])
@endsection
