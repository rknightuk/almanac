@extends('layouts.site')

@section('content')
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
