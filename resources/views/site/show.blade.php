@extends('layouts.site')

@section('content')
	@include('site._partials.post', ['post' => $post])
@endsection
