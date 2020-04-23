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
			<div class="almn-sidebar-wrap">
				<div class="almn-sidebar">
					<h1><a href="/">{{ env('SITE_TITLE', 'Almanac') }}</a></h1>
					@if (env('SITE_SUBTITLE')) <h2>{{ env('SITE_SUBTITLE') }}</h2> @endif

					<div class="almn-sidebar--browse">
						<div class="almn-sidebar--browse__links">
							@if (env('TWITTER'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://twitter.com/{{ env('TWITTER') }}">
										<i class="fab fa-twitter" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('INSTAGRAM'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://instagram.com/{{ env('INSTAGRAM') }}">
										<i class="fab fa-instagram" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('SPOTIFY'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://open.spotify.com/user/{{ env('SPOTIFY') }}">
										<i class="fab fa-spotify" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('FACEBOOK'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://facebook.com/{{ env('FACEBOOK') }}">
										<i class="fab fa-facebook" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('WEBSITE'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="{{ env('WEBSITE') }}">
										<i class="fas fa-globe" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
						</div>

						@if (env('SITE_DESCRIPTION')) <p>{{ env('SITE_DESCRIPTION') }}</p> @endif

						<div class="almn-sidebar--search">
							<form action="/">
								<div class="almn-sidebar--search--icon"><i class="fas fa-search"></i></div>
								<input
									type="text"
									class="almn-sidebar--search--input"
									name="search"
									placeholder="search"
									value="{{ isset($search) && $search ? $search : '' }}"
								>
							</form>
						</div>

						<ul class="almn-sidebar--browse__list">
							<li><a href="/?category=movie">Movies</a></li>
							<li><a href="/?category=tv">TV</a></li>
							<li><a href="/?category=game">Games</a></li>
							<li><a href="/?category=music">Music</a></li>
							<li><a href="/?category=book">Books</a></li>
							<li><a href="/?category=podcast">Podcasts</a></li>
							<li><a href="/?category=video">Videos</a></li>
							<li><a href="/?category=quote">Quotes</a></li>
							<li><a href="/tags">Tags</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="almn-posts-wrap">
				<div class="almn-posts">
					@yield('content')
				</div>
				<div class="almn-footer">
					Powered by <a href="https://code.robblewis.me/almanac">Almanac</a>@if (env('WEBSITE')) | <a href="{{ env('WEBSITE') }}">{{ env('WEBSITE_TITLE', env('WEBSITE')) }}</a> @endif
				</div>
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
