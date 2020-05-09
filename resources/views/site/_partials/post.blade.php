@if (isset($singlePost) && $singlePost)
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
		<i
            class="fas fa-{{ $post->icon }}"
            @if(in_array($post->icon, \Almanac\Posts\PostType::ICONS_SHRINK_POST)) data-fa-transform="shrink-3" @endif
        ></i>
	</a>
	<div class="almn-post--titles">
		<div class="almn-post--titles--main">
			<a
                href="{{ $post->link_post ? $post->link: $post->permalink }}"
                class="almn-post--titles--main--link"
                @if ($post->link_post) target="_blank" @endif
            >
                {{ $post->title }}
			</a>
			@if ($post->year || $post->link_post)
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

    @if ($post->html || count($post->getSortedAttachments()) > 0)
        <div class="almn-post--content">
            @if ($post->html)
                @if ($post->spoilers)
                    <p>
                        <em>Review contains spoilers. <a href="#" class="spoiler-reveal" data-post-id="{{ $post->id }}">Reveal your secrets</a>.</em>
                    </p>
                    <span id="content-{{ $post->id }}" style="display:none;">
                        {!! $post->html !!}
                    </span>
                @else
                    {!! $post->html !!}
                @endif
            @endif
                @if (count($post->getSortedAttachments()) > 0)
                    <div class="almn-post--attachments">
                        <div class="almn-post--attachments--main">
                            <a href="{{ $post->getSortedAttachments()[0]->real_path }}" target="_blank" id="gallery-{{ $post->id }}">
                                <img src="{{ $post->getSortedAttachments()[0]->real_path }}" />
                            </a>
                        </div>
                        @if (count($post->getSortedAttachments()) > 1)
                            <div class="almn-post--attachments--grid">
                                @foreach ($post->getSortedAttachments() as $index => $attachment)
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
                    @if ($post->link)
                        &bull; <a href="{{ $post->link }}" target="_blank">{{ $post->link_host  }}</a>
                    @endif
                </a>
            </div>
            @if ($post->hasTags())
                <div class="almn-post--footer--tags">
                    @foreach ($post->tags->sortBy('name') as $tag)
                        <a href="/?tags[]={{ $tag->name }}">#{{ str_replace(' ', '', $tag->name) }}</a>
                    @endforeach
                </div>
            @endif
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
	</footer>
</div>

@if (isset($singlePost) && $singlePost)
	@include('site._partials.related', [
		'related' => $post->getPreviousPosts(),
		'type' => 'previous',
	])
@endif
