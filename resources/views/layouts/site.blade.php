<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://kit.fontawesome.com/4faa09972b.js" crossorigin="anonymous"></script>

		<title>@if (isset($singlePost)) {{ $singlePost->title }} - @endif{{ env('SITE_TITLE', 'Almanac') }}</title>

        @if(env('APP_ENV') === 'local')
            <link href="http://localhost:9000/site.css" rel="stylesheet">
        @else
            <link href="{{ asset('dist/site.css') }}" rel="stylesheet">
        @endif

		<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="{{ asset('apple-touch-icon.png') }}">

		@if (isset($singlePost))
			<meta name="twitter:card" content="summary">
			<meta name="twitter:site" content="@rknightuk">
			<meta name="twitter:title" content="{{ $singlePost->title }}">
			<meta name="twitter:description" content="{{ $singlePost->twitter_preview }}">
		@endif
	</head>
	<body>
        <div class="almn-page">
            <header class="almn-header">
                <h1 class="almn-header--main"><a href="/">{{ env('SITE_TITLE', 'Almanac') }}</a></h1>
                @if (env('SITE_SUBTITLE'))
                    @if (env('WEBSITE'))<a href="{{ env('WEBSITE') }}">@endif
                        <p class="almn-header--subtitle">{{ env('SITE_SUBTITLE') }}</p>
                    @if (env('WEBSITE'))</a>@endif
                @endif
            </header>
            <div class="almn-search">
                <form action="/">
                    <input
                        type="text"
                        class="almn-search--input"
                        name="search"
                        placeholder="search"
                        value="{{ isset($search) && $search ? $search : '' }}"
                    >
                </form>
            </div>
            <nav class="almn-nav">
                <div class="almn-nav--link">
                    <a href="/?category=movie"><i class="fas fa-film"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=tv"><i class="fas fa-tv-retro" data-fa-transform="shrink-3"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=game"><i class="fas fa-gamepad"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=music"><i class="fas fa-headphones"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=book"><i class="fas fa-book" data-fa-transform="shrink-3"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=podcast"><i class="fas fa-podcast"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=video"><i class="fas fa-video"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=quote"><i class="fas fa-quote-left"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/tags"><i class="fas fa-tags" data-fa-transform="shrink-2"></i></a>
                </div>
            </nav>
            <div class="alm-posts">
                @yield('content')
            </div>
            <div class="almn-footer">
                Powered by <a href="https://code.rknight.me/almanac">Almanac</a>
            </div>
        </div>

		<script>
			(function() {
				var spoilers = document.getElementsByClassName("almn-post--content__spoiler");

				for (var i = 0; i < spoilers.length; i++) {
					var spoiler = spoilers[i]
					spoiler.addEventListener('click', function(e) {
						e.currentTarget.className += ' almn-post--content__spoiler--show'
					}, false);
				}

				var images = document.getElementsByClassName('almn-post--attachments--grid--single--link');

				for (var i = 0; i < images.length; i++) {
					var image = images[i]
					image.addEventListener('click', function(e) {
						e.preventDefault()
						var postId = e.currentTarget.dataset.postId
						var imageLink = e.currentTarget.children[0].src
						document.getElementById('gallery-' + postId).href = imageLink
						document.getElementById('gallery-' + postId).children[0].src = imageLink
					}, false);
				}
			})();
		</script>
	</body>

</html>
