@extends('layouts.site')

@section('content')
	@if ($posts->total() !== 0)

		@php ($content = $posts->total() . ' post' . ($posts->total() === 1 ? '' : 's') . ' found')

		@if (isset($search) && $search)
			@include('site._partials.fakepost', [
				'title' => "Results for \"$search\"",
				'content' => $content,
				'icon' => 'search',
			])
		@endif

		@if (isset($tags) && is_array($tags) && $tags)
			@include('site._partials.fakepost', [
				'title' => "Posts tagged with \"" . implode(', ', $tags) . "\"",
				'content' => $content,
				'icon' => 'tag',
			])
		@endif

		@if (isset($category) && $category)
			@include('site._partials.fakepost', [
				'title' => $category . " posts",
				'content' => $content,
				'icon' => 'search',
			])
		@endif

		@if (isset($platform) && $platform)
			@include('site._partials.fakepost', [
				'title' => $posts->first()->platform . " games",
				'content' => $content,
				'icon' => 'gamepad',
			])
		@endif

		@if (isset($year) && $year)
			@include('site._partials.fakepost', [
				'title' => $year . (isset($month) && $month ? '/' . sprintf("%02d", $month) : '') . (isset($day) && $day ? '/' . sprintf("%02d", $day) : ''),
				'content' => $content,
				'icon' => 'calendar-alt',
			])
		@endif
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
