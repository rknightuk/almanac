@extends('layouts.site')

@section('content')
	@if (isset($search) && $search && $posts->count() !== 0)
		@include('site._partials.fakepost', [
			'title' => "Results for $search",
			'content' => $posts->count() . ' post' . ($posts->count() === 1 ? '' : 's') . ' found',
			'icon' => 'search',
		])
	@endif

	@forelse ($posts as $post)
		@include('site._partials.post', ['post' => $post])
	@empty
		@include('site._partials.fakepost', [
			'title' => 'No Posts Found',
			'content' => '<p>Try <a href="/tags">a different tag</a> or <a href="/">got to the home page</a>.',
			'icon' => 'search',
		])
	@endforelse

	{{ $posts->links() }}
@endsection
