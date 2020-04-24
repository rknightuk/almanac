@if (isset($showRelated) && $showRelated)
	@include('site._partials.related', [
		'related' => $post->getFuturePosts(),
		'type' => 'future',
	])
@endif

<div class="almn-post">
	<a
			href="/?category={{ strtolower($post->type) }}"
			class="almn-post--icon"
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

    <div class="almn-post--content">
        @if ($post->html && !$post->isQuote())
            {!! $post->html !!}
        @endif
        @if (count($post->attachments) > 0)
            @foreach ($post->attachments as $index => $attachment)
                <img src="{{ $attachment->filename }}" />
            @endforeach
        @endif
    </div>

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
						<i class="fas fa-sync" data-fa-transform="shrink-2"></i>
					</span>
				@endif
			</a>
            @if ($post->link)
                <p class="almn-post--footer--link">
                    <a href="{{ $post->link }}" title="Post Source" target="_blank">
                        <i class="fas fa-link" data-fa-transform="shrink-2"></i> {{ str_replace('www.', '', parse_url($post->link)['host'] ?? $post->link) }}
                    </a>
                </p>
            @endif
		</div>
		@if (Auth::user())
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
