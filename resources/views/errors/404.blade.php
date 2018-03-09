@extends('layouts.site')

@section('content')
	@include('site._partials.fakepost', [
		'title' => 'Oh No!',
		'icon' => 'exclamation-circle',
		'content' => '
			<p>This page might have moved or been deleted.</p>

			<p><a href="/">Maybe the home page has what you\'re looking for?</a></p>
		',
		'rating' => 'bad'
	])
@endsection
