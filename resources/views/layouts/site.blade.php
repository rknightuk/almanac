<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>@if (isset($singlePost)) {{ $singlePost->title }} - @endif{{ env('SITE_TITLE', 'Almanac') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/site.css') }}" rel="stylesheet">

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
            <nav class="almn-nav">
                <div class="almn-nav--link">
                    <a href="/?category=movie"><i class="fas fa-film"></i></a>
                </div>
                <div class="almn-nav--link">
                    <a href="/?category=tv"><i class="fas fa-tv" data-fa-transform="shrink-3"></i></a>
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
            </nav>
            <div class="alm-posts">
                @yield('content')
            </div>
            <div class="almn-footer">
                Powered by <a href="https://code.rknight.me/almanac">Almanac</a>@if (env('WEBSITE')) | <a href="{{ env('WEBSITE') }}">{{ env('WEBSITE_TITLE', env('WEBSITE')) }}</a> @endif
            </div>
        </div>

		<script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js"></script>
		<script>
			(function() {
				var spoilers = document.getElementsByClassName("almn-post--content__spoiler");

				for (var i = 0; i < spoilers.length; i++) {
					var spoiler = spoilers[i]
					spoiler.addEventListener('click', function(e) {
						e.currentTarget.className += ' almn-post--content__spoiler--show'
					}, false);
				}
			})();
		</script>
	</body>

</html>
