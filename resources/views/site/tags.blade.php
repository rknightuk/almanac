@extends('layouts.site')

@section('content')
	@include('site._partials.fakepost', [
		'title' => 'Browse all tags',
		'icon' => 'tags',
		'content' => 'includeTags',
	])
@endsection
