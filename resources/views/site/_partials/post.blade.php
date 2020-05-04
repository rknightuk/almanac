@if (isset($showRelated) && $showRelated)
	@include('site._partials.related', [
		'related' => $post->getFuturePosts(),
		'type' => 'future',
	])
@endif

<div class="almn-post almn-post--{{ strtolower($post->type) }}">
	<a
			href="/?category={{ strtolower($post->type) }}"
			class="almn-post--icon almn-post--icon--{{ strtolower($post->type) }}"
	>
		<i class="fas fa-{{ $post->icon }}" @if(in_array($post->icon, ['tv', 'book', 'video', 'quote'])) data-fa-transform="shrink-3" @endif></i>
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

    @if (($post->html && !$post->isQuote()) || count($post->attachments) > 0)
        <div class="almn-post--content">
            @if ($post->html && !$post->isQuote())
                {!! $post->html !!}
            @endif
                @if (count($post->attachments) > 0)
                    <div class="almn-post--attachments">
                        <div class="almn-post--attachments--main">
                            <a href="{{ $post->attachments[0]->real_path }}" target="_blank" id="gallery-{{ $post->id }}">
                                <img src="{{ $post->attachments[0]->real_path }}" />
                            </a>
                        </div>
                        @if (count($post->attachments) > 1)
                            <div class="almn-post--attachments--grid">
                                @foreach ($post->attachments as $index => $attachment)
                                    <div class="almn-post--attachments--grid--single">
                                        <a class="almn-post--attachments--grid--single--link" data-post-id="{{ $post->id }}" href="{{ $attachment->real_path }}" target="_blank">
                                            <img src="{{ $attachment->real_path }}" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
        </div>
    @endif

	<footer class="almn-post--footer">
        <div class="almn-post--footer--row">
            <div class="almn-post--footer--date">
                <a href="{{ $post->permalink }}">
                    {{ $post->date_completed->format('jS F Y') }}
                    @if ($post->related_count > 1 && $post->shouldShowCount())
                        <span class="almn-post--footer--date--rewatched">
						<i class="fas fa-sync" data-fa-transform="shrink-2"></i>
					</span>
                    @endif
                </a>
            </div>
            <div class="almn-post--footer--tags">
                @if ($post->link)
                    <a href="{{ $post->link }}" target="_blank">
                        {{ str_replace('www.', '', parse_url($post->link)['host'] ?? $post->link) }}
                    </a>
                @endif
                @foreach ($post->tags->sortBy('name') as $tag)
                    <a href="/?tags[]={{ $tag->name }}">#{{ str_replace(' ', '', $tag->name) }}</a>
                @endforeach
                @if (Auth::user())
                    <div class="almn-post--footer--tags--admin">
                        <a
                            href="/app/posts/{{$post->id}}"
                            target="_blank"
                            title="Edit Post"
                        >
                            <i class="fas fa-edit" data-fa-transform="shrink-2"></i>
                        </a>
                        <a
                            href="/app/new/{{$post->type}}/{{$post->id}}"
                            target="_blank"
                            title="Rewatch"
                        >
                            <i class="fas fa-sync" data-fa-transform="shrink-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
	</footer>
</div>

@if (isset($singlePost) && $singlePost)
	@include('site._partials.related', [
		'related' => $post->getPreviousPosts(),
		'type' => 'previous',
	])
@endif
