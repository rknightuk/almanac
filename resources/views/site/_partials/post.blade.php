@if (isset($showRelated) && $showRelated)
	@include('site._partials.related', [
		'related' => $post->getFuturePosts(),
		'type' => 'future',
	])
@endif

<div class="almn-post almn-post__{{ $post->rating_string }}">
	<a
			href="/?category={{ strtolower($post->type) }}"
			class="almn-post--icon almn-post--icon__{{ $post->rating_string }}"
	>
		<i class="fas fa-{{ $post->icon }}" @if(in_array($post->icon, ['tv', 'book'])) data-fa-transform="shrink-3" @endif></i>
	</a>
	<div class="almn-post--titles">
		<div class="almn-post--titles--main">
			@if ($post->isQuote())
				<div class="almn-post--titles--main__quote">
					{!! $post->html !!}
				</div>
			@endif
			<a href="{{ $post->permalink }}">
				@if ($post->isQuote()) — @endif{{ $post->title }}
			</a>
			@if ($post->year)
				<span class="almn-post--titles--main__meta">
					{{ $post->year }}
				</span>
			@endif
		</div>
		@if ($post->subtitle_output)
			<div class="almn-post--titles--sub">
				{!! $post->subtitle_output !!}
			</div>
		@endif
	</div>

	@if ($post->html && !$post->isQuote())
		<div class="almn-post--content">
			{!! $post->html !!}
		</div>
	@endif

	@if ($post->hasTags())
		<div class="almn-post--tags">
			@foreach ($post->tags->sortBy('name') as $tag)
				<a class="almn-post--tags--tag" href="/?tags[]={{ $tag->name }}">{{ $tag->name }}</a>
			@endforeach
		</div>
	@endif

	<footer class="almn-post--footer @if (Auth::user()) almn-post--footer--manage @endif">
		<div class="almn-post--footer--date">
			<a href="{{ $post->permalink }}">
				{{ $post->date_completed->format('jS F Y') }}
				@if ($post->related_count > 1 && $post->shouldShowCount())
					<span class="almn-post--footer--date--rewatched">
						<i class="fas fa-sync"></i>
					</span>
				@endif
			</a>
		</div>
		@if ($post->link || Auth::user())
			<div class="almn-post--footer--links @if (Auth::user()) almn-post--footer--manage--links @endif">
				@if (Auth::user())
					<a
							href="/app/posts/{{$post->id}}"
							target="_blank"
							title="Edit Post"
					>
						<i class="fas fa-edit"></i>
					</a>
					<a
						href="/app/new/{{$post->type}}/{{$post->id}}"
						target="_blank"
						title="Rewatch"
					>
						<i class="fas fa-sync"></i>
					</a>
					<a
						href="https://twitter.com/intent/tweet?url={{env('APP_URL') . $post->permalink}}&text={{$post->title}}"
						target="_blank"
						title="Share to Twitter"
					>
						<i class="fab fa-twitter"></i>
					</a>
				@endif
				@if ($post->link)
					<a href="{{ $post->link }}" title="Post Source">
						<i class="fas fa-link"></i>
					</a>
				@endif
			</div>
		@endif
	</footer>
</div>

@if (isset($showRelated) && $showRelated)
	@include('site._partials.related', [
		'related' => $post->getPreviousPosts(),
		'type' => 'previous',
	])
@endif