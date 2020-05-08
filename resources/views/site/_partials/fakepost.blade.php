<div class="almn-post almn-post__{{ $rating ?? 'default' }}">
	<a class="almn-post--icon almn-post--icon__{{ $rating ?? 'default' }}">
		<i class="fas fa-{{ $icon }}"></i>
	</a>
	<div class="almn-post--titles">
		<div class="almn-post--titles--main">
			{{ $title }}
		</div>
	</div>

	<div class="almn-post--content">
		@if ($content === 'includeTags')
			@include('site._partials.tags', [
				'tags' => $tags
			])
		@else
			{!! $content !!}
		@endif
	</div>
    <footer class="almn-post--footer">
        <div class="almn-post--footer--row"></div>
    </footer>
</div>
