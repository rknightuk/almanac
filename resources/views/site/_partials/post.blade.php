<div class="almn-post almn-post__{{ $post->rating_string }}">
	<a
			href="/category/{{ $post->type }}"
			class="almn-post--icon almn-post--icon__{{ $post->rating_string }}"
	>
		<i class="fas fa-{{ $post->icon }}"></i>
	</a>
	<div class="almn-post--titles">
		<div class="almn-post--titles--main">
			<a href="{{ $post->permalink }}">
				{{ $post->title }}
			</a>
			@if ($post->year || $post->platform)
				<span class="almn-post--titles--main__meta">
					@if ($post->year && $post->platform)
						{{ $post->year }} | <a href="/platform/{{ $post->platform }}">{{ $post->platform }}</a>
					@elseif ($post->year)
						{{ $post->year }}
					@else
						<a href="/platform/{{ $post->platform }}">{{ $post->platform }}</a>
					@endif
				</span>
			@endif
		</div>
		@if ($post->subtitle || $post->season)
			<div class="almn-post--titles--sub">
				@if ($post->season && $post->subtitle)
					{{ $post->season_string }} | {{ $post->subtitle }}
				@elseif ($post->season)
					{{ $post->season_string }}
				@else
					{{ $post->subtitle }}
				@endif
			</div>
		@endif
	</div>

	@if ($post->content)
		<div class="almn-post--content">
			{!! $post->html !!}
		</div>
	@endif

	@if ($post->hasTags())
		<div class="almn-post--tags">
			@foreach ($post->tags as $tag)
				<a class="almn-post--tags--tag" href="/tags/{{ $tag->name }}">{{ $tag->name }}</a>
			@endforeach
		</div>
	@endif

	<footer class="almn-post--footer">
		<div class="almn-post--footer--date">
			<a href="{{ $post->permalink }}">
				{{ $post->date_completed->format('l jS F') }}
			</a>
		</div>
		@if ($post->link)
			<div class="almn-post--footer--link">
				<a href="{{ $post->link }}">source</a>
			</div>
		@endif
	</footer>
</div>